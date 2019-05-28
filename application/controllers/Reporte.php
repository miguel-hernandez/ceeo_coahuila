<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('appweb');
		$this->load->library('PDF_MC_Table');
		$this->load->model('Encuesta_model');
		$this->load->model('Reporte_model');
	}// __construct()


	function area(){
		if(verifica_sesion_redirige($this)){
			$usuario = $this->session->userdata[DATOSUSUARIO];
			// echo "<pre>"; print_r($usuario); die();

			$pdf = new PDF_MC_Table();
			$pdf->AliasNbPages();
			$pdf->AddPage();

			// Arial bold 16
			$pdf->SetFont('Arial','B',14);
			// Logo
			$pdf->Image(base_url('assets/img/logotipo1.png'),10,8,15);

			// Movernos a la derecha, 85cm
			$pdf->Cell(85);

			$pdf->SetTextColor(0,0,0);
			$pdf->Cell(20,10,utf8_decode('Secretaría de Educación del Estado de Coahuila'),0,1,'C');

			// $pdf->Ln(1);
			$pdf->Cell(85);
			$pdf->SetFont('Arial','B',13);
			$pdf->Cell(20,2,utf8_decode('Programa de Simplificación Administrativa (Ciclo Escolar: 2018-2019)'),0,1,'C');

			$pdf->Cell(85);
			$pdf->SetFont('Arial','B',13);
			$pdf->Cell(20,10,utf8_decode('Catálogo Autorizado de Documentos'),0,1,'C');

			$pdf->Ln(1);
			$pdf->SetFont('Arial','B',10);
			$pdf->MultiCell(0,5,utf8_decode('Área o Dirección: '.$usuario['area_departamento']),0,"");
			$pdf->Ln(2);

			$pdf->SetFont('Arial','B',10);

			//Table with 6 columns
			$pdf->SetWidths(array(10,42,35,35,35,35)); // ancho de primer columna, segunda, tercera y cuarta


			$pdf->SetFillColor(215,215,215);

			$pdf->SetAligns(array("C","C","C","C","C", "C"));
			$pdf->SetColors(array(TRUE,TRUE,TRUE,TRUE, TRUE, TRUE));
			$pdf->SetLineW(array(0.02,0.02,0.02,0.02, 0.02, 0.02));

			$pdf->SetTextColor(0, 0, 0);
			$pdf->Row(array(
				utf8_decode("No."),
				utf8_decode("Descripción"),
				utf8_decode("Área que solicita"),
				utf8_decode("Nivel educativo"),
				utf8_decode("Forma de entrega"),
				utf8_decode("Periodicidad"),
			));

			$pdf->SetTextColor(006,057,057);
			$pdf->SetFont('Arial','',10);
			$pdf->SetAligns(array("L","L","L","L", "L","L"));
			$pdf->SetColors(array(FALSE,FALSE,FALSE,FALSE,FALSE,FALSE));

			$pdf->SetLineW(array(0.002,0.002,0.002,0.002,0.002,0.002));
			$cont=0;

			$usuario = $this->session->userdata[DATOSUSUARIO];
			// echo "<pre>"; print_r($usuario); die();
			$idusuario = $usuario['idusuario'];

			$result_aplicar = $this->Reporte_model->get_xidusuario($idusuario);

			foreach($result_aplicar as $item){
				$idaplicar =  $item['idaplicar'];
				$result3 = $this->Reporte_model->get_respuestas($idaplicar, 3);
				$respuestas_3 = $result3[0]['respuestas_seleccionadas'];

				$result8 = $this->Reporte_model->get_respuestas($idaplicar, 8);
				$respuestas_8 = $result8[0]['respuestas_seleccionadas'];

				$result9 = $this->Reporte_model->get_respuestas($idaplicar, 9);
				$respuestas_9 = $result9[0]['respuestas_seleccionadas'];

				$result12 = $this->Reporte_model->get_respuestas($idaplicar, 12);
				$respuestas_12 = $result12[0]['respuestas_seleccionadas'];

				$cont++;
				$pdf->Row(array(
					utf8_decode($cont),
					utf8_decode($item["n_documento"]),
					utf8_decode($respuestas_3),
					utf8_decode($respuestas_8),
					utf8_decode($respuestas_9),
					utf8_decode($respuestas_12)
				));
			}

			$pdf->Output();

		}
	}// area()

}// class
