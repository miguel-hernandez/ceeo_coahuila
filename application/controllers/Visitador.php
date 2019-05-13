<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitador extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('Utilerias');
        $this->load->model('Visit_cct_model');
        $this->load->model('Aplicar_model');
        $this->load->model('Respuestas_model');
        $this->load->library('My_FPDF');

    }


	public function index()
	{
      if(Utilerias::verifica_sesion_redirige($this)){
        $data["titulo"] = "VISITADOR";
        $usuario = $this->session->userdata[DATOSUSUARIO];
        // echo "<pre>"; print_r($usuario); die();
        switch ($usuario["idtipousuario"]) {
          case UVISITADOR:
            $tipo = "VISITADOR: ";
          break;
          case UCOORDINADOR:
            $tipo = "COORDINADOR: ";
          break;
          case UADMINISTRADOR:
            $tipo = "ADMINISTRADOR: ";
          break;
        }
        // $tipo =
        $data["usuario"] = $tipo.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];



        Utilerias::pagina_basica($this, "visitador/index", $data);
      }
	}//

  public function re_arma($array){
    $arr = array();
    foreach ($array as $item) {
      array_push($arr, $item);
    }
    return $arr;
  }

  function read(){
    if(Utilerias::verifica_sesion_redirige($this)){

      $usuario = $this->session->userdata[DATOSUSUARIO];
      $result = $this->Visit_cct_model->get_datos($usuario["idusuario"]);
      $result2 = $result;
      // $arr_columnas = array("id","nvisitas","cct","nombre_ct","turno", "nombre_nivel","nombre_modalidad","domicilio");
      $arr_columnas = array(
       "id"=>array("type"=>"hidden", "header"=>"id"),
       "nvisitas"=>array("type"=>"text", "header"=>"No. visitas"),
       "cct"=>array("type"=>"text", "header"=>"CCT"),
       "nombre_ct"=>array("type"=>"text", "header"=>"Nombre"),
       "nombre_nivel"=>array("type"=>"text", "header"=>"Nivel"),
       "nombre_modalidad"=>array("type"=>"text", "header"=>"Modalidad"),
       "domicilio"=>array("type"=>"text", "header"=>"Domicilio")
     );

      $array_aux = array();
      $array_pd = array();
      for($i=0;$i<count($result); $i++) {
          $item = $result[$i];
          $numero = 0;
          $cct = $item["cct"];
          for($j=0;$j<count($result2); $j++) {
            $item2 = $result2[$j];
            $cct2 = $item2["cct"];
            if($cct==$cct2){
              $numero = $numero+$item2["nvisitas"];
            }
          }
          $item["nvisitas"] = $numero;
         array_push($array_aux, $item);
      }

      $sin_duplicados = array_unique($array_aux, SORT_REGULAR);
      $result_final = $this->re_arma($sin_duplicados);

      $result = $this->Visit_cct_model->get_asignadas($usuario["idusuario"]);

      $result2 = $this->Aplicar_model->get_visitadas($usuario["idusuario"]);
      $result3 = $this->Aplicar_model->get_total_visitadas($usuario["idusuario"]);


      $data["asignadas"] = $result[0]["asignadas"];
      $data["visitadas"] = $result2[0]["visitadas"];
      $data["sin_visitar"] = $result[0]["asignadas"] - $result2[0]["visitadas"];
      $data["total_visitas"] = $result3[0]["total_visitadas"];
      $data["total_visitas"] = $result3[0]["total_visitadas"];

      $response = array(
        "result" => $result_final,
        "columnas" => $arr_columnas,
        "asignadas" => $result[0]["asignadas"],
        "visitadas" => $result2[0]["visitadas"],
        "sin_visitar" => $result[0]["asignadas"] - $result2[0]["visitadas"],
        "total_visitas" => $result3[0]["total_visitadas"],
        "total_visitas" => $result3[0]["total_visitadas"]

      );

      Utilerias::enviaDataJson(200, $response, $this);
      exit;
    }
  }// read()

  function reportevisitas(){
    if(Utilerias::verifica_sesion_redirige($this)){
      $idcct = $this->input->post('idcct');

      // $arr_columnas = array("id", "folio","fecha","atendio");
      $arr_columnas = array(
         "id"=>array("type"=>"hidden", "header"=>"id"),
         "folio"=>array("type"=>"text", "header"=>"Folio"),
         "fecha"=>array("type"=>"text", "header"=>"Fecha"),
         "atendio"=>array("type"=>"text", "header"=>"Atendió")
       );

      $usuario = $this->session->userdata[DATOSUSUARIO];
      $result = $this->Aplicar_model->get_datos_visitadas($idcct,$usuario["idusuario"]);

      $response = array(
        "result" => $result,
        "columnas" => $arr_columnas
      );

      Utilerias::enviaDataJson(200, $response, $this);
      exit;
    }
  }// read()

  function get_cuestions(){
    // echo "<pre>";
    // print_r($_POST);
    // die();
    if(Utilerias::verifica_sesion_redirige($this)){
      $tipo = $this->input->post('tipo');
      $idcct = $this->input->post('idcct');
      $ideditando = $this->input->post('ideditando');
      $editando = false;
      if($ideditando == 0 || $ideditando == '0'){
        if($tipo == 2){
          $preguntas = $this->Visit_cct_model->get_cuestions($tipo);
        }elseif ($tipo == 1) {
          $preguntas = $this->Visit_cct_model->get_cuestions($tipo);
        }
      }else{
        if($tipo == 2){
          $preguntas = $this->Visit_cct_model->get_cuestions_edita($tipo, $ideditando);
        }elseif ($tipo == 1) {
          $preguntas = $this->Visit_cct_model->get_cuestions_edita($tipo, $ideditando);
        }
        $editando = true;
      }
      $response = array(
          "editando" => $editando,
          "result" => $preguntas,
          "idcct" => $idcct,
          "atendio" => $tipo
        );
      Utilerias::enviaDataJson(200, $response, $this);
      exit;
    }
  }

  function savecuestionario(){
    // echo "<pre>";
    // print_r($_POST);
    // die();
    if(Utilerias::verifica_sesion_redirige($this)){
      $usuario = $this->session->userdata[DATOSUSUARIO];
      $atendio = $this->input->post('atendio');
      $idcct = $this->input->post('idcct');
    $idaplica = $this->Aplicar_model->insert_aplica($usuario['idusuario'], $idcct, $atendio);
    foreach ($_POST as $key => $value) {
      if($key != 'atendio' && $key != 'idcct'){
        $porciones = explode("-", $key);
        $idpregunta = $porciones[0];
        $tipopregunta = $porciones[1];
        $inserto = $this->Respuestas_model->insert_response($idpregunta, $value, $idaplica, $tipopregunta);
      }
    }
    redirect('login/index');
    }
  }

  function updatequestion(){
    // echo "<pre>";
    // print_r($_POST);
    // die();
    if(Utilerias::verifica_sesion_redirige($this)){
      $usuario = $this->session->userdata[DATOSUSUARIO];
      $atendio = $this->input->post('atendio');
      $idaplica = $this->input->post('idcct');
    // $idaplica = $this->Aplicar_model->insert_aplica($usuario['idusuario'], $idcct, $atendio);
    foreach ($_POST as $key => $value) {
      if($key != 'atendio' && $key != 'idcct'){
        $porciones = explode("-", $key);
        $idpregunta = $porciones[0];
        $tipopregunta = $porciones[1];
        $inserto = $this->Respuestas_model->update_response($idpregunta, $value, $idaplica, $tipopregunta);
      }
    }
    redirect('login/index');
    }
  }

  function get_pdf_encuesta(){
    // error_reporting(0);
    if(Utilerias::verifica_sesion_redirige($this)){
      $idaplicar = $this->input->post('idaplicar');
      $result = $this->Aplicar_model->get_pdf_encuesta($idaplicar);
      $datos = $result[0]; // Datos de la escuela

      // $obj_pdf = new FPDF; // Creación de la instancia
      $obj_pdf = new My_FPDF; // Creación de la instancia

      $obj_pdf->AliasNbPages();
      $obj_pdf->AddPage();

      // Arial bold 16
      $obj_pdf->SetFont('Arial','B',16);
      // Logo
      $obj_pdf->Image(base_url().'assets/img/escudo_puebla.png',10,8,15);

      // Movernos a la derecha, 85cm
      $obj_pdf->Cell(85);
      // Título
      $obj_pdf->SetTextColor(28,85,172);
      $obj_pdf->Cell(20,10,'Sistema de seguimiento CEEO',0,1,'C');
      $obj_pdf->Image(base_url().'assets/img/logosep.png',168,8,33);

      // Salto de línea
      $obj_pdf->Ln(5);
      $obj_pdf->SetFont('Arial','B',11);
      $obj_pdf->Cell(40,10, utf8_decode('Atendió: '.$datos['atendio']),0,0,"L");

      $obj_pdf->Cell(40);

      $obj_pdf->Cell(20,10,'Folio: '.$datos["folio"],0,0,'C');

      $obj_pdf->MultiCell(0,10,utf8_decode("Fecha: ".$datos["fecha"]),0,"R");

      $obj_pdf->SetY(40); // Inicio
      $obj_pdf->MultiCell(0,5,utf8_decode('CCT: '.$datos['cct']."     Turno: " . $datos['turno'] ."     Escuela: ". $datos['nombre_ct']. " (".$datos['domicilio'].")"),0,"L");

      $obj_pdf->Line(5, 51 , 205, 51);  //Horizontal

      $obj_pdf->Ln();
      $tema_actual = $datos["idtema"];
      $var = FALSE;
      $cont = 0;
      foreach ($result as $item) {

        $obj_pdf->SetFont('Arial','B',12);
        $obj_pdf->SetTextColor(0,0,0);
        if($cont==0){
          $obj_pdf->MultiCell(0,5,utf8_decode(strtoupper($item["descripcion_tema"])),0);
          $cont++;
        }

        if(($item["idtema"]!=$tema_actual) && !$var){
          $var = TRUE;
          $tema_actual = trim($item["idtema"]);
          $obj_pdf->MultiCell(0,5,utf8_decode(strtoupper($item["descripcion_tema"])),0);
        }else{
          $var = FALSE;
        }

        switch ($item["idtipopregunta"]) {
          case 1:

            $obj_pdf->SetFont('Arial','',12);
            $obj_pdf->MultiCell(0,5,utf8_decode($item["npregunta"].".- ".$item["pregunta"]),0);
            $obj_pdf->SetTextColor(0,26,255);
            $obj_pdf->Ln(1);
            $obj_pdf->MultiCell(0,5,utf8_decode("   ".$item["respuesta"]),0);

          break;
          case 2:
            $obj_pdf->SetFont('Arial','',12);
            $obj_pdf->MultiCell(0,5,utf8_decode($item["npregunta"].".- ".$item["pregunta"]),0);
            $obj_pdf->SetTextColor(0,26,255);
            $obj_pdf->Ln(1);
            $obj_pdf->MultiCell(0,5,utf8_decode("   ".$item["complemento_respuesta"]),0);

          break;
          case 3:
            $obj_pdf->SetFont('Arial','',12);
            $obj_pdf->MultiCell(0,5,utf8_decode($item["npregunta"].".- ".$item["pregunta"]),0);
            $obj_pdf->SetTextColor(0,26,255);
            $obj_pdf->Ln(2);
            $obj_pdf->MultiCell(0,5,utf8_decode("   ".$item["respuesta"].", ".$item["complemento_respuesta"]),0);

          break;
        }
        $obj_pdf->Ln(5);

      }

      $obj_pdf->SetY(-40);
      // $obj_pdf->Ln(40);
      $obj_pdf->SetFont('Arial','B',12);
      $obj_pdf->SetTextColor(0,0,0);
      $obj_pdf->MultiCell(0,5,utf8_decode('Nombre y firma'),0,"C");

      $usuario = $this->session->userdata[DATOSUSUARIO];

      // echo "<pre>"; print_r($usuario); die();
      $obj_pdf->MultiCell(0,5,utf8_decode('['.$usuario["nombre"].' '.$usuario["paterno"].' '.$usuario["materno"].']'),0,"C");


      $obj_pdf->Output();

    }
  }// get_pdf_encuesta()


}
