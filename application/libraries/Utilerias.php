<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Utilerias{
		public function __construct() {
	        //  require_once APPPATH.'third_party/Utils.php';
	    }

	    /**
     * Carga la vista básica de una página: header, vista y footer.
     *
     * @param CONTROLLER $contexto   Desde dónde se llamará a la vista
     * @param VISTA $vista      El nombre de la vista que se cargará después del header
     * @param DATA  $data       Arreglo con los campos que usará templates/header y $vista
     */
	    public static function pagina_basica($contexto, $vista = '', $data) {
	        $contexto->load->view('templates/header',$data);
	        $contexto->load->view($vista, $data);
	        $contexto->load->view('templates/footer');
	    }// pagina_basica()

			/*
	    Función para retornar datos a peticiones ajax
	     */
	    public static function enviaDataJson($status, $data, $contexto){
	        return $contexto->output
	                    ->set_status_header($status)
	                    ->set_content_type('application/json', 'utf-8')
	                    ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
	                    ->_display();
	    }// enviaDataJson()


			/**
	     * Comprueba si en la sesión existe valor para la clave 'nombre_usuario'
	     * @param CI_Controller $contexto  Controlador en donde se desea verificar si existe sesión abierta.
	     * @return boolean TRUE si existe valor para la clave 'nombre_usuario'
	     */
	    public static function is_session_open($contexto) {
	        return $contexto->session->has_userdata(DATOSUSUARIO);
	    }// is_session_open()

			public static function verifica_sesion_redirige($contexto) {
	        if (!Utilerias::is_session_open($contexto)) {
	            redirect('login');
	        }
	        return true;
	    }// verifica_sesion_redirige()

	    public static function get_notification_alert($mensaje, $tipo, $cerrar = TRUE) {
	            $type = "alert-info";

              switch ($tipo) {
                  case SUCCESMESSAGE:
                      $type = "alert-success ";
                      break;
                  case ERRORMESSAGE:
                      $type = "alert-danger ";
                      break;
              }

							return "
									<div class='alert ".$type." alert-dismissable'>
										<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
										<center><strong>".$mensaje."</strong></center>
									</div>
							";


	    }// crea_html_mensaje

	}
?>
