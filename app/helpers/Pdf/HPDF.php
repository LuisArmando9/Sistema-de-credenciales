<?php
namespace App\helpers\Pdf;
use Codedge\Fpdf\Fpdf\Fpdf;
use Exception;
use App\helpers\_Date;
use App\helpers\Csv\Constants\Table;
use App\helpers\HDate;
use App\Models\Departament;

class HPDF{

    
    const FILE_NAME = "/credentials/template_for_credential.jpg";
    //credential width
    const CREDENTIAL_WIDTH = 210;
    const CREDENTIAL_HEIGHT = 84;
    const WITDH_FOR_TEMPLATE = 185;
    const FONT_SIZE_FOR_TITLE = 12;
    const FONT_SIZE_NORMAL = 10;
    const FONT_SIZE_MIN = 8;
    const FONT_SIZE_FOR_SUBTITLE = 10;
    const MAX_CHARACTERS_PER_NAME = 30;
    private $pdf;
    private $img;
    private $denomination;
    private $departaments;
    private $worker;
    public function __construct($worker, $denomination)
    {
        $this->worker = $worker;
        if(is_null($this->worker)){
            throw new Exception("El trabajador ingresado es incorrecto");
        }
        $this->pdf =new Fpdf('l', 'mm', array(self::CREDENTIAL_HEIGHT,self::CREDENTIAL_WIDTH));
        $this->img = public_path().self::FILE_NAME;
        $this->denomination = Table::getFullDenominatioName($denomination);
        $this->loadDepartaments();
        
    }
    private function loadDepartaments(){
    
        foreach(Departament::get() as $departament){
            $this->departaments[$departament->id] = utf8_decode(strtoupper($departament->departamentName));
        }
    }
    
    private function writeTitle(){
        $this->pdf->Image($this->img, 10, 7, self::WITDH_FOR_TEMPLATE);
        $this->pdf->SetFont('Arial', 'B',self::FONT_SIZE_FOR_TITLE);
        $this->pdf->Text(18, 20, $this->denomination);
       
    }
    private function writeFrontContent(){
        if(strlen($this->worker->worker) <= self::MAX_CHARACTERS_PER_NAME){
            $this->pdf->SetFont('Arial', 'BI',self::FONT_SIZE_MIN);
        }else{
            $this->pdf->SetFont('Arial', 'BI',self::FONT_SIZE_MIN-1);
        }
        $this->pdf->Text(20, 30, utf8_decode(strtoupper($this->worker->worker)));
        $this->pdf->SetFont('Arial', 'BI', self::FONT_SIZE_NORMAL);
        $this->pdf->Text(20, 45, $this->worker->curp);
        $this->pdf->Text(20, 55, $this->worker->nss);
        $this->pdf->Text(76, 25, $this->worker->id);
        

    }
    private function writeBackContent(){
        $this->pdf->Text(174, 30,  $this->worker->id);
        $this->pdf->Text(112, 30,  $this->departaments[$this->worker->departamentId]);
        $this->pdf->Text(112, 42, HDate::parse($this->worker->entry));
       
    }

    public function writePdfCredential(){
        $this->pdf->AddPage();
        $this->writeTitle();
        $this->writeFrontContent();
        $this->writeBackContent();
       

    }
    public function getOutput($fileName){
        ob_end_clean();
        return $this->pdf->Output("D", $fileName);
    }



    

}
