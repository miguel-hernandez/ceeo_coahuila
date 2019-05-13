<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encuestador extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->helper('appweb');
    $this->load->library('Utilerias');
  }


  public function index(){
    if(verifica_sesion_redirige($this)){
      $usuario = $this->session->userdata[DATOSUSUARIO];
      $tipo = $usuario["tipo"];
      $data["titulo"] = "";
      $data["usuario"] = $tipo.' '.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
      Utilerias::pagina_basica($this, "encuestador/index", $data);
    }
  }// index();


}// class
