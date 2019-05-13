<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encuestador extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('Utilerias');
        $this->load->model('Encuesta_model');
        // $this->load->model('Aplicar_model');||
        // $this->load->model('Respuestas_model');
        // $this->load->library('My_FPDF');

    }


	public function index()
	{
      if(Utilerias::verifica_sesion_redirige($this)){
        $usuario = $this->session->userdata[DATOSUSUARIO];
        $tipo = $usuario["tipo"];
        $data["titulo"] = "";
        $data["usuario"] = $tipo.' '.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
        // echo "<pre>"; print_r($data); die();
        Utilerias::pagina_basica($this, "encuestador/index", $data);
      }
	}// index();


}// class
