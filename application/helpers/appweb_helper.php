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
          if (!hay_sesion_abierta($contexto)) {
              redirect('login', 'refresh');
          }
      	}// verifica_sesion_redirige()
    }
?>
