<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('Utilerias');
    }


    public function index()
    {
        if(Utilerias::verifica_sesion_redirige($this)){
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
          $data["usuario"] = $tipo.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];

          Utilerias::pagina_basica($this, "administrador/index", $data);
        }
    }//


}
