<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encuesta extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->library('Utilerias');
    $this->load->model('Encuesta_model');
  }

  function get_xidusuario(){
    if(Utilerias::verifica_sesion_redirige($this)){

      $usuario = $this->session->userdata[DATOSUSUARIO];
      $result = $this->Encuesta_model->get_xidusuario($usuario["idusuario"]);
      // $result2 = $result;
      // $arr_columnas = array("id","nvisitas","cct","nombre_ct","turno", "nombre_nivel","nombre_modalidad","domicilio");
      $arr_columnas = array(
        "id"=>array("type"=>"text", "header"=>"id"),
        "fcreacion"=>array("type"=>"text", "header"=>"Fecha de aplicación")
      );


      $response = array(
        "result" => $result,
        "array_columnas" => $arr_columnas,
        "total" => count($result)

      );

      Utilerias::enviaDataJson(200, $response, $this);
      exit;
    }
  }// get_xidusuario()


  public function aplicar(){
    if(Utilerias::verifica_sesion_redirige($this)){
      $usuario = $this->session->userdata[DATOSUSUARIO];
      $tipo = $usuario["tipo"];
      $data["titulo"] = "";
      $data["usuario"] = $tipo.' '.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];

      $array_preguntas = $this->Encuesta_model->get_cuestions();
      $array_preguntas_ok = array();
      // echo "<pre>"; print_r($array_preguntas); die();
      foreach ($array_preguntas as $key => $pregunta) {
        $pregunta['array_complemento'] = $this->Encuesta_model->get_complemento_xidpregunta($pregunta['idpregunta']);
        array_push($array_preguntas_ok, $pregunta);
      }

      // echo "despues";
      // echo "<pre>"; print_r($array_preguntas_ok); die();
      $data['array_preguntas'] = $array_preguntas_ok;
      Utilerias::pagina_basica($this, "encuesta/aplicar", $data);
    }// verifica_sesion_redirige()
  }// aplicar()

  public function get_cuestions(){
    if(Utilerias::verifica_sesion_redirige($this)){
      $preguntas = $this->Encuesta_model->get_cuestions();
      $data['array_preguntas'] = $preguntas;
      Utilerias::pagina_basica($this, "encuesta/aplicar", $data);
    }
  }// get_cuestions()

  public function guardar(){
    echo "<pre>";
    print_r($_POST);
    die();
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
      redirect("encuestador", "refresh");
    }
  }// guardar()


}// class
