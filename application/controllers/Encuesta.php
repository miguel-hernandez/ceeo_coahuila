<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encuesta extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->helper('appweb');
    $this->load->model('Encuesta_model');
    $this->load->model('Respuestas_model');
    $this->load->model('Aplicar_model');
  }

  function get_xidusuario(){
    if(verifica_sesion_redirige($this)){

      $usuario = $this->session->userdata[DATOSUSUARIO];
      $result = $this->Encuesta_model->get_xidusuario($usuario["idusuario"]);
      // $result2 = $result;
      // $arr_columnas = array("id","nvisitas","cct","nombre_ct","turno", "nombre_nivel","nombre_modalidad","domicilio");
      $arr_columnas = array(
        "id"=>array("type"=>"text", "header"=>"id"),
        "fcreacion"=>array("type"=>"text", "header"=>"Fecha de aplicación")
      );


      $response = array(
        "result" => $result,
        "array_columnas" => $arr_columnas,
        "total" => count($result)

      );

      envia_datos_json(200, $response, $this);
    }// verifica_sesion_redirige()
  }// get_xidusuario()


  public function aplicar(){
    if(verifica_sesion_redirige($this)){
      $usuario = $this->session->userdata[DATOSUSUARIO];
      $tipo = $usuario["tipo"];
      $data["titulo"] = "";
      $data["usuario"] = $tipo.' '.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];

      $array_preguntas = $this->Encuesta_model->get_cuestions();
      $array_preguntas_ok = array();
      // echo "<pre>"; print_r($array_preguntas); die();
      foreach ($array_preguntas as $key => $pregunta) {
        $pregunta['array_complemento'] = $this->Encuesta_model->get_complemento_xidpregunta($pregunta['idpregunta']);
        array_push($array_preguntas_ok, $pregunta);
      }

      // echo "despues";
      // echo "<pre>"; print_r($array_preguntas_ok); die();
      $data['array_preguntas'] = $array_preguntas_ok;
      pagina_basica($this, "encuesta/aplicar", $data);
    }// verifica_sesion_redirige()
  }// aplicar()

  public function get_cuestions(){
    if(verifica_sesion_redirige($this)){
      $preguntas = $this->Encuesta_model->get_cuestions();
      $data['array_preguntas'] = $preguntas;
      pagina_basica($this, "encuesta/aplicar", $data);
    }
  }// get_cuestions()



  public function guardar(){
     // echo "<pre>";print_r($_POST);die();
     // $nombre_archivo = str_replace(" ", "_", $_FILES['ifile_aplicar']['name']);
     // echo "<pre>";print_r($_FILES);die();
     if(verifica_sesion_redirige($this)){
      $band = TRUE;
      $estatus_arch = TRUE;
      $usuario = $this->session->userdata[DATOSUSUARIO];
      $array_respuestas = array('array_datos' => array());
      foreach ($_POST as $key => $value) {
        if (is_int($key)) {
          if ($band==TRUE) {
            array_push($array_respuestas['array_datos'],array('tipo' => '1','idpregunta' => $key,'valores' => $value,'valores_string' => ''));
          }
          else {
            $band=TRUE;
          }
        }
        else {
          if ($band==TRUE) {
            $arr_cand =explode('_', $key);
            array_push($array_respuestas['array_datos'],array('tipo' => '2','idpregunta' => end($arr_cand),'valores_string' => $value));
            $band=FALSE;
          }
          else {
            $band=TRUE;
          }
        }
      }
      // echo "<pre>";print_r($array_respuestas);die();

      $nombre_archivo = str_replace(" ", "_", $_FILES['ifile_aplicar']['name']);

      // $id_aplica = $this->Aplicar_model->insert_aplica($usuario['idusuario']);
      // $estatus_insert = $this->Respuestas_model->insert_respuestas($array_respuestas,$id_aplica,$ruta_archivos_save);
      $id_aplica = $this->Respuestas_model->insert_respuestas($array_respuestas,$nombre_archivo,$usuario['idusuario']);

      if ($id_aplica > 0) {
        if ($nombre_archivo!='') {
              $ruta_archivos = "evidencias/{$usuario['idusuario']}/{$id_aplica}/";
              // $ruta_archivos_save = "evidencias/{$usuario['idusuario']}/{$id_aplica}/$nombre_archivo";

              if(!is_dir($ruta_archivos)){
                mkdir($ruta_archivos, 0777, true);}
                $_FILES['userFile']['name']     = $_FILES['ifile_aplicar']['name'];
                $_FILES['userFile']['type']     = $_FILES['ifile_aplicar']['type'];
                $_FILES['userFile']['tmp_name'] = $_FILES['ifile_aplicar']['tmp_name'];
                $_FILES['userFile']['error']    = $_FILES['ifile_aplicar']['error'];
                $_FILES['userFile']['size']     = $_FILES['ifile_aplicar']['size'];

                $uploadPath              = $ruta_archivos;
                $config['upload_path']   = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('userFile')) {
                    $fileData = $this->upload->data();
                    $estatus_arch = TRUE;
                }
                else {
                  $estatus_arch = FALSE;
                }
            }
        if ($estatus_arch) {
          $data = array('estatus' => $estatus_arch, 'respuesta' => "La encuesta se guardó correctamente.");
          envia_datos_json(200,$data, $this);
        }
        else {
            $data = array('estatus' => $estatus_arch, 'respuesta' => "Falló al insertar archivo.");
            envia_datos_json(200,$data, $this );
        }
      }
      else {
        $data = array('estatus' => $id_aplica, 'respuesta' => "Falló al insertar idaplica.");
        envia_datos_json(200,$data, $this );
      }
    }
  }// guardar()


}// class
