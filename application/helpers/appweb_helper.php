<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    if(!function_exists('envia_datos_json')){
        function envia_datos_json($status, $data, $contexto) {
          return $contexto->output
                  ->set_status_header($status)
                  ->set_content_type('application/json', 'utf-8')
                  ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }// envia_datos_json()
    }

    if(!function_exists('hay_sesion_abierta')){
        function hay_sesion_abierta($contexto) {
      		return $contexto->session->has_userdata(DATOSUSUARIO);
      	}// hay_sesion_abierta()
    }

    if(!function_exists('verifica_sesion_redirige')){
        function verifica_sesion_redirige($contexto) {
          if (hay_sesion_abierta($contexto)) {
              return true;
          }else{
            redirect('login', 'refresh');
          }
      	}// verifica_sesion_redirige()
    }

    if(!function_exists('get_notification_alert')){
      function get_notification_alert($mensaje, $tipo, $cerrar = TRUE) {
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


      }// get_notification_alert
    }

    if(!function_exists('pagina_basica')){
      function pagina_basica($contexto, $vista = '', $data) {
          $contexto->load->view('templates/header',$data);
          $contexto->load->view($vista, $data);
          $contexto->load->view('templates/footer');
      }// pagina_basica()
    }

    if(!function_exists('trae_datos_user')){
      function trae_datos_user($contexto, $mensaje_extra="") {
        $usuario = $contexto->session->userdata[DATOSUSUARIO];
        $tipo = $usuario["tipo"];
        $area = $usuario["area_departamento"];
        return $mensaje_extra.' '.$area.' / '.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
      }// pagina_basica()
    }



?>
