<?php
namespace App\helpers\Pdf;
use Codedge\Fpdf\Fpdf\Fpdf;
use Exception;
use phpDocumentor\Reflection\Types\Self_;
use App\Models\Departament;

class HPDF{

    const INCREMENTE_PER_CREDENTIAL = 70;
    const CREDENTIALS_PER_PAGE = 4;
    const MAX_PAGE_SIZE = self::INCREMENTE_PER_CREDENTIAL * self::CREDENTIALS_PER_PAGE;
    const MAX_CREDENTIALS = 50;
    //font size
    const FONT_SIZE_FOR_TITLE = 10;
    const FONT_SIZE_FOR_CONTENT = 9;
    //index of front part 
    //X 
    const FRONT_DENOMINATION_X = 30;
    const FRONT_DESCRIPTION_X = 25;
    const FRONT_FOLIO_X = 79;
    //y
    const FRONT_DENOMINATION_Y = 20;
    const LAST_NAME_Y = 32;
    const NAME_Y = 37;
    const CURP_Y = 45;
    const NSS_Y = 54;
    const FRONT_FOLIO_Y = 25.3;
    //index of back part 
    const BACK_FOLIO_X = 172;
    const BACK_DESCRIPTION_X= 115;
    //y
    const BACK_FOLIO_AND_DEPARTAMENT_Y = 30;
    const BACK_ENTRY_Y = 43;
    //file name
    const FILE_NAME = "/credentials/designCredential.png";
    //credential width
    const CREDENTIAL_WIDTH = 215;
    private $fpdf;
    private $numberOfCredentials;
    private $workers;
    private $img;
    private $denominationName;
    private $departaments;
    public function __construct($workers, $denominationname)
    {
        $this->fpdf = new Fpdf();
        if($workers->count() > self::MAX_CREDENTIALS){
            throw new Exception("Solo puede imprimir 50 credenciales, máximo");
        }
        $this->workers = $workers;
        $this->numberOfCredentials = 0;
        $this->img = public_path().self::FILE_NAME;
        $this->denominationName = "{$denominationname} POPULAR, S.A. DE C.V.";
        $this->loadDepartaments();
        
    }
    private function loadDepartaments(){
    
        foreach(Departament::get() as $departament){
            $this->departaments[$departament->id] = strtoupper($departament->departamentName);
        }
    }
    private function splitName($name){

        $tempSplitName = explode(" ", $name);
        $sizeSplitName = count($tempSplitName);
        $startLastName = $sizeSplitName -2;
        $lastName = "";
        $name = "";
        for($i=$startLastName; $i<$sizeSplitName; $i++){
            $lastName .= " " . $tempSplitName[$i];
        }
        for($i=0; $i<$startLastName; $i++){
            $name .= " " . $tempSplitName[$i];
        }
        return array("NAME" => strtoupper($name), "LASTNAME" =>strtoupper($lastName));
    }
    private function writeTitle($i){
        $this->fpdf->SetFont('Arial', 'B', self::FONT_SIZE_FOR_TITLE);
        $this->fpdf->Text(self::FRONT_DENOMINATION_X,
        self::FRONT_DENOMINATION_Y+$i,strtoupper($this->denominationName));
    }
    private function writeFrontContent($worker, $i){
        $name = $this->splitName($worker->worker);
        $this->fpdf->SetFont('Arial', 'BI', self::FONT_SIZE_FOR_CONTENT);
        $this->fpdf->Text(self::FRONT_DESCRIPTION_X, self::LAST_NAME_Y+$i,  $name["LASTNAME"]);
        $this->fpdf->Text(self::FRONT_DESCRIPTION_X,  self::NAME_Y+$i, $name["NAME"]);
        $this->fpdf->Text(self::FRONT_DESCRIPTION_X, self::CURP_Y+$i,strtoupper($worker->curp));
        $this->fpdf->Text(self::FRONT_DESCRIPTION_X, self::NSS_Y+$i,$worker->nss);
        $this->fpdf->Text(self::FRONT_FOLIO_X,self::FRONT_FOLIO_Y+$i,$worker->id);

    }
    private function writeBackContent($worker, $i){
        $this->fpdf->Text(self::BACK_FOLIO_X, self::BACK_FOLIO_AND_DEPARTAMENT_Y+$i,
        $worker->id);
        $this->fpdf->Text(self::BACK_DESCRIPTION_X,  self::BACK_FOLIO_AND_DEPARTAMENT_Y+$i,
        $this->departaments[$worker->departamentId]);
        $this->fpdf->Text(self::BACK_DESCRIPTION_X, self::BACK_ENTRY_Y+$i,$worker->entry);
    }
    private function writeCredential($worker){
      
        $i = $this->numberOfCredentials * self::INCREMENTE_PER_CREDENTIAL; 
        $this->fpdf->Image($this->img, 0, $i,215,0);
        $this->writeTitle($i);
        $this->writeFrontContent($worker, $i);
        $this->writeBackContent($worker, $i);

    }
    public function writePdfCredential(){
        $this->fpdf->AddPage();
        foreach($this->workers as $worker){
            $this->writeCredential($worker);
            $this->numberOfCredentials++;
            if($this->numberOfCredentials >= self::CREDENTIALS_PER_PAGE){
                $this->fpdf->AddPage();
                $this->numberOfCredentials = 0;
            }
        }

    }
    public function getOutput($fileName){
        ob_end_clean();
        return $this->fpdf->Output("D", $fileName);
    }



    

}
