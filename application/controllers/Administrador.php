<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('appweb');
        $this->load->model('Administrador_model');
    }

    public function obtenerEncuestasUsuario(){
      $tabla = $this->Administrador_model->getTabla();
      return $tabla;
    }

    public function index(){
        if(verifica_sesion_redirige($this)){
          $data["titulo"] = "COORDINADOR";
          $usuario = $this->session->userdata[DATOSUSUARIO];
          // echo "<pre>"; print_r($usuario); die();
          switch ($usuario["idtipousuario"]) {
            // case U_VISITADOR:
            //   $tipo = "VISITADOR: ";
            // break;
            // case U_COORDINADOR:
            //   $tipo = "COORDINADOR: ";
            // break;
            case U_ADMINISTRADOR:
              $tipo = "ADMINISTRADOR: ";
            break;
          }
          $tabla = $this->obtenerEncuestasUsuario();
          // $tipo =
          // $data["usuario"] = $tipo.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
          $data["usuario"] = trae_datos_user($this,"");
          $data['tabla'] = $tabla;
          pagina_basica($this, "administrador/index", $data);
        }
    }// index()


}
