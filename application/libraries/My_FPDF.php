<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('fpdf181/fpdf.php');

class My_FPDF extends FPDF{
  function __construct() {
    // require_once('fpdf181/fpdf.php');
     // parent::FPDF();
     parent::__construct();
  }

  // Pie de página
  function Footer()
  {
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(0,0,0);
    // Número de página
    $this->Cell(0,10,''.$this->PageNo().'/{nb}',0,0,'R');
  }// Footer()

}
?>
