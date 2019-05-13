<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->helper('form');
			$this->load->library('Utilerias');
			$this->load->model('Seguridad_model');
		}

		public function index(){
			if (Utilerias::is_session_open($this)) {
				$usuario = $this->session->userdata['datos_usuario_ceeo'];
				$this->direcciona_user($usuario['idtipousuario']);
			} else {
				$data = array();
				$this->load->view("login/index",$data);
			}
		}// index()


		public function validar_login(){
			if (Utilerias::is_session_open($this)) {
				$usuario = $this->session->userdata['datos_usuario_ceeo'];
				// echo "<pre>";
				// print_r($usuario);
				// die();
				$this->direcciona_user($usuario['idtipousuario']);
			} else {
				$username = $this->input->post('username');
				$clave = $this->input->post('clave');

				$result = $this->Seguridad_model->get_for_login($username, $clave);

				if(count($result)>0){
					$arr = $result[0];
					// echo "<pre>"; print_r($arr); die();
					// LLenamos la session
					$this->session->set_userdata(DATOSUSUARIO,$arr);
					$usuario = $this->session->userdata['datos_usuario_ceeo'];
					$this->direcciona_user($usuario['idtipousuario']);
				}else{

					$mensaje = "¡Datos incorrectos!";

					$tipo = ERRORMESSAGE;

					$this->session->set_flashdata(MESSAGEREQUEST, Utilerias::get_notification_alert($mensaje, $tipo));

					redirect('login', 'refresh');

				}

			}

		}// validar_login()

		function direcciona_user($tipo_usuario){
		switch ($tipo_usuario) {
			case U_ADMINISTRADOR:
				redirect('Adminsitrador', 'refresh');
			break;
			case U_ENCUESTADOR:
				redirect('Encuestador', 'refresh');
			break;


			default:
				# code...
				$data = $this->data;
            	$data['login_failed'] = TRUE;
            	$this->load->view('login',$data);
				break;
		}
	}


		public function logout(){
				$this->session->sess_destroy();
				$this->session->unset_userdata(DATOSUSUARIO);
				$data = array();
				redirect('login', 'refresh');
		}// logout()

}
