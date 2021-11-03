<?php
namespace App\helpers\Pdf;
use setasign\Fpdi\Tfpdf;
use App\helpers\Csv\Constants\Table;
use App\helpers\HDate;
use App\helpers\Name;
use App\Models\Departament;
use Exception;

class HPDF
{

    const CREDENTIAL_HEIGHT = 84;
    const FONT_SIZE = 10;
    const MAX_CHARACTERS_PER_NAME = 22;
    private $pdf;
    private $img;
    private $denomination;
    private $departaments;
    private $worker;
    public function __construct($worker, $denomination)
    {

        $this->worker = $worker;
        if (is_null($this->worker)) {
            throw new Exception("El trabajador ingresado es incorrecto");
        }

        $this->initPdf();
        $this->denomination = Table::getFullDenominatioName($denomination);
        $this->loadDepartaments();

    }
    private function initPdf()
    {

        $this->pdf = new Tfpdf\Fpdi();
        $this->pdf->AddPage();
        $this->pdf->SetFont('Arial', 'B', self::FONT_SIZE);
        $path = public_path() . "/credentials/template.pdf";
        $this->pdf->setSourceFile($path);
        $tplId = $this->pdf->importPage(1);
        $this->pdf->useTemplate($tplId, null, null, null, self::CREDENTIAL_HEIGHT, true);
        $this->pdf->importPage(1);

    }
    private function splitName($fullName)
    {

        $lastNames = strtok($fullName, ' ') . ' ' . strtok(' ');
        if (str_word_count($fullName) == 4) {
            $names = strtok(' ') . ' ' . strtok(' ');
        } else {
            $names = strtok(' ');
        }
        return array("LASTNAMES" => utf8_decode(strtoupper($lastNames)), "NAMES" =>(strtoupper($names)));
    }
    private function loadDepartaments()
    {

        foreach (Departament::get() as $departament) {
            $this->departaments[$departament->id] = utf8_decode(strtoupper($departament->departamentName));
        }
    }
    private function writeName()
    {
        $name = strtoupper($this->worker->worker);
        if (strlen($name) <= self::MAX_CHARACTERS_PER_NAME) {
            $this->pdf->SetXY(24, 30);
            $this->pdf->write(0, $name);
        } else {
            $start = self::MAX_CHARACTERS_PER_NAME;
            while(mb_substr($name, $start,1) !== ' '){
                $start--;
            } 
            $offset = strlen($name) - $start;
            $this->pdf->SetXY(24, 30);
            $this->pdf->write(0, mb_substr($this->worker->worker, 0, $start));
            $this->pdf->SetXY(24, 35);
            $this->pdf->write(0,  mb_substr($this->worker->worker, ++$start, $offset));
        }
    }
    private function isRangeValid($min, $max)
    {
        return $this->worker->id >= $min && $this->worker->id <= $max;
    }
    private function getFolioPosition()
    {
        $basePosition = 169; //this position is valid only to numbers >= 1000 or <= 9999
        if ($this->isRangeValid(0, 9)) {
            return $basePosition + 3;
        } elseif ($this->isRangeValid(10, 99)) {
            return $basePosition + 2;
        } elseif ($this->isRangeValid(100, 999)) {
            return $basePosition + 2;
        } else {
            return $basePosition;
        }

    }
    private function writeFolio()
    {
        $this->pdf->SetFont('Arial', 'BI', self::FONT_SIZE);
        $this->pdf->SetXY(77, 24);
        $this->pdf->write(0, $this->worker->id);
        $this->pdf->SetXY($this->getFolioPosition(), 30);
        $this->pdf->write(0, $this->worker->id);

    }
    private function writeTitle()
    {
        $this->pdf->SetXY(26, 20);
        $this->pdf->Write(0, $this->denomination);
    }
    private function writeFrontContent()
    {

        $this->pdf->SetXY(24, 44);
        $this->pdf->write(0, $this->worker->curp);
        $this->pdf->SetXY(24, 54);
        $this->pdf->write(0, $this->worker->nss);
        $this->writeTitle();
        $this->writeName();
        $this->writeFolio();

    }
    private function writeBackContent()
    {
        $this->pdf->SetFont('Arial', 'B', self::FONT_SIZE);
        $this->pdf->SetXY(114, 30);
        $this->pdf->write(0, $this->departaments[$this->worker->departamentId]);
        $this->pdf->SetXY(114, 40);
        $this->pdf->write(0, HDate::parse($this->worker->entry));
    }

    public function writePdfCredential()
    {
        $this->writeFrontContent();
        $this->writeBackContent();

    }
    public function getOutput($fileName)
    {
        ob_end_clean();
        return $this->pdf->Output('D', $fileName, true);

    }

}
