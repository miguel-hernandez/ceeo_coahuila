<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('appweb');
    }

    public function index(){
        if(verifica_sesion_redirige($this)){
          $data["titulo"] = "COORDINADOR";
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
          // $data["usuario"] = $tipo.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
          $data["usuario"] = trae_datos_user($this,"");
          pagina_basica($this, "administrador/index", $data);
        }
    }// index()


}
