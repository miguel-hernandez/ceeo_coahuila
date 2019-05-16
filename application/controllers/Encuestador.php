<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encuestador extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->helper('appweb');
  }


  public function index(){
    if(verifica_sesion_redirige($this)){

      $data["titulo"] = "";
      $data["usuario"] = trae_datos_user($this,"");
      pagina_basica($this, "encuestador/index", $data);
    }
  }// index();


}// class
