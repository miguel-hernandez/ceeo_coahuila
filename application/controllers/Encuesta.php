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
        "id"=>array("type"=>"text", "width"=>"5", "header"=>"Folio"),
        "fcreacion"=>array("type"=>"hidden", "width"=>"0", "header"=>"Fecha de aplicación"),
        "n_documento"=>array("type"=>"text", "width"=>"85", "header"=>"Nombre del documento"),
        "a_adjunto"=>array("type"=>"button", "width"=>"10", "header"=>"Evidencia")
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
      // $data["usuario"] = $tipo.' '.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
      $data["usuario"] = trae_datos_user($this,"");

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

  public function editar($id_aplica){
    if(verifica_sesion_redirige($this)){
      $usuario = $this->session->userdata[DATOSUSUARIO];
      $tipo = $usuario["tipo"];
      // $id_aplica = $this->input->post('id_aplicar');
      // echo "<pre>";print_r($this->input->post('id_aplicar'));die();
      $data["id_aplicar"] = $id_aplica;
      $data["titulo"] = "";
      // $data["usuario"] = $tipo.' '.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
      $data["usuario"] = trae_datos_user($this,"");

      $array_preguntas = $this->Encuesta_model->get_cuestions();
      $array_preguntas_ok = array();
      // echo "<pre>"; print_r($array_preguntas); die();
      foreach ($array_preguntas as $key => $pregunta) {
        $pregunta['array_complemento'] = $this->Encuesta_model->get_complemento_xidpregunta_resp($pregunta['idpregunta']);
        array_push($array_preguntas_ok, $pregunta);
        // $pregunta['array_respuesta'] = $this->Respuestas_model->get_response_xidpregunta($pregunta['idpregunta'],$id_aplica);
        // array_push($array_preguntas_ok, $pregunta);
      }

      // echo "despues";
      // echo "<pre>"; print_r($array_preguntas_ok); die();
      $data['array_preguntas'] = $array_preguntas_ok;
      $data['array_respuetas'] = $this->Respuestas_model->get_response($id_aplica);
      // echo "<pre>";print_r($data);die();
      // $str_view_edit = $this->load->view("encuesta/editar", $data, TRUE);
      pagina_basica($this, "encuesta/editar", $data);
      // $response = array(
      //   "str_view_edit" => $str_view_edit
      // );
      // envia_datos_json(200, $response, $this);
    }// verifica_sesion_redirige()
  }// editar()

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
        if ($key == 4) {
        echo "<pre>";print_r($value);
        array_push($array_respuestas['array_datos'],array('tipo' => '1','idpregunta' => $key,'valores' => $value,'valores_string' => ''));
        }
         if ($value == 'Otro <input type="text" name="otro_input">') {
             unset($array_respuestas['array_datos'][2]);
        }
        
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
            if ($key=='otro_input') {
             array_push($array_respuestas['array_datos'],array('tipo' => '2','idpregunta' => 3,'valores_string' => $value));
            }
            array_push($array_respuestas['array_datos'],array('tipo' => '2','idpregunta' => end($arr_cand),'valores_string' => $value));
           unset($array_respuestas['array_datos'][4]);
            $band=FALSE;
          }
          else {
            $band=TRUE;
          }
        }
      }
       echo "<pre>";print_r($array_respuestas['array_datos']);
        //die();

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
                $config['allowed_types'] = 'gif|bmp|jpg|png|jpeg|pdf|docx|xlsx|pptx|doc|xls|ppt|txt';

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
          $data = array('estatus' => $estatus_arch, 'respuesta' => "El requerimiento se guardó correctamente.");
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

  public function editar_insert(){
     // echo "<pre>";print_r($_POST);die();
     // $nombre_archivo = str_replace(" ", "_", $_FILES['ifile_aplicar']['name']);
     // echo "<pre>";print_r($_FILES);die();
     if(verifica_sesion_redirige($this)){
      $band = TRUE;
      $estatus_arch = TRUE;
      $usuario = $this->session->userdata[DATOSUSUARIO];
      $array_respuestas = array('array_datos' => array());
      foreach ($_POST as $key => $value) {
          if ($value == 'Otro <input type="text" name="otro_input">') {
             unset($array_respuestas['array_datos'][2]);
        }
        if (is_int($key)) {
          if ($band==TRUE) {
            array_push($array_respuestas['array_datos'],array('tipo' => '1','idpregunta' => $key,'valores' => $value,'valores_string' => ''));
          }
          else {
            $band=TRUE;
          }
        }
        else {
          if ($key=='id_aplicar') {
            $id_aplica =$value;
          }
          else {
            if ($band==TRUE) {
              $arr_cand =explode('_', $key);
             if ($key=='otro_input') {
             array_push($array_respuestas['array_datos'],array('tipo' => '2','idpregunta' => 3,'valores_string' => $value));
            }
              array_push($array_respuestas['array_datos'],array('tipo' => '2','idpregunta' => end($arr_cand),'valores_string' => $value));
               unset($array_respuestas['array_datos'][4]);
              $band=FALSE;
            }
            else {
              $band=TRUE;
            }
          }

        }
      }
      // echo "<pre>";print_r($array_respuestas);die();

      $nombre_archivo = str_replace(" ", "_", $_FILES['ifile_aplicar']['name']);
// echo "<pre>";print_r($nombre_archivo);die();
      // $id_aplica = $this->Aplicar_model->insert_aplica($usuario['idusuario']);
      // $estatus_insert = $this->Respuestas_model->insert_respuestas($array_respuestas,$id_aplica,$ruta_archivos_save);
      $respuesta_estatus = $this->Respuestas_model->update_respuestas($array_respuestas,$nombre_archivo,$id_aplica,$usuario['idusuario']);

      if ($id_aplica > 0) {
        if ($nombre_archivo!='') {

          $files = glob("evidencias/{$usuario['idusuario']}/{$id_aplica}/*"); //obtenemos todos los nombres de los ficheros
          foreach($files as $file){
            if(is_file($file))
            unlink($file); //elimino el fichero
            }
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
                $config['allowed_types'] = 'gif|bmp|jpg|png|jpeg|pdf|docx|xlsx|pptx|doc|xls|ppt|txt';

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
          $data = array('estatus' => $estatus_arch, 'respuesta' => "El requerimiento se editó correctamente.");
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
  }// editar_insert()

  public function mostrar($idaplicar){
    if(verifica_sesion_redirige($this)){
      $usuario = $this->session->userdata[DATOSUSUARIO];
      $tipo = $usuario["tipo"];
      $data["titulo"] = "";
      // $data["usuario"] = $tipo.' '.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
      $data["usuario"] = trae_datos_user($this,"");

      // $idaplicar = $this->input->post('idaplicar');
      // echo $idaplicar; die();

      $array_preguntas = $this->Encuesta_model->get_cuestions_mostrar();
      $array_preguntas_ok = array();
      foreach ($array_preguntas as $key => $pregunta) {
        $pregunta['array_complemento'] = $this->Encuesta_model->get_complemento_xidpregunta_mostrar($pregunta['idpregunta']);
        $pregunta['array_contesto'] = $this->Encuesta_model->get_encuestaxidusuario($idaplicar, $pregunta['idpregunta']);
        array_push($array_preguntas_ok, $pregunta);
      }

      // echo "<pre>"; print_r($array_preguntas_ok); die();
      $array_final = array();

      foreach ($array_preguntas_ok as $key => $pregunta_ok) {
        $array_final_aux['idpregunta'] = $pregunta_ok['idpregunta'];
        $array_final_aux['pregunta'] = $pregunta_ok['pregunta'];
        $array_final_aux['idtipopregunta'] = $pregunta_ok['idtipopregunta'];
        $array_final_aux['npregunta'] = $pregunta_ok['npregunta'];
        $array_final_aux['instructivo'] = $pregunta_ok['instructivo'];
        // $array_final_aux['respuesta'] = $pregunta_ok['respuesta'];
        $array_final_aux['respuesta'] = $pregunta_ok['respuesta'];

        if($pregunta_ok['idtipopregunta'] == PREGUNTA_OPCIONMULTIPLE){
          // $array_opciones = $pregunta_ok['array_complemento'];
          $array_final_aux['array_final'] = $this->verifica_sicontesto($pregunta_ok['array_complemento'], $pregunta_ok['array_contesto']);
        }elseif ($pregunta_ok['idtipopregunta'] == PREGUNTA_UNAOPCION) {
          $array_final_aux['array_final'] = $this->verifica_sicontesto($pregunta_ok['array_complemento'], $pregunta_ok['array_contesto']);
        }elseif ($pregunta_ok['idtipopregunta'] == PREGUNTA_ABIERTA) {
          $array_final_aux['respuesta'] = (isset($pregunta_ok['array_contesto'][0]['respuesta']))?$pregunta_ok['array_contesto'][0]['respuesta']:'';
        }
        array_push($array_final, $array_final_aux);
      }

      $data['array_datos'] = $array_final;
      $array_file = $this->Encuesta_model->get_file_path($idaplicar);
      $data['file_path'] = (count($array_file)>0)?$array_file[0]['url_comple']:'';
      // echo "<pre>"; print_r($array_final); die();
      pagina_basica($this, "encuesta/mostrar", $data);
    }// verifica_sesion_redirige()
  }// mostrar()

  private function verifica_sicontesto($array_opciones, $array_opciones_contesto){
    $array_complementos_contesto = array();

    foreach ($array_opciones_contesto as $key => $opcion_contesto) {
      array_push($array_complementos_contesto, $opcion_contesto['complemento']);
    }

    $array_final = array();
    foreach ($array_opciones as $key => $opcion_catalogo) {
      $array_aux = array();
      $array_aux['idpregunta'] = $opcion_catalogo['idpregunta'];
      $array_aux['complemento'] = $opcion_catalogo['complemento'];
      $array_aux['orden'] = $opcion_catalogo['orden'];
      $array_aux['checked'] = '';

      if (in_array($opcion_catalogo['complemento'], $array_complementos_contesto)) {
          $array_aux['checked'] = 'checked';
      }
      array_push($array_final, $array_aux);
    }
    return $array_final;
  }// verifica_sicontesto()

  public function eliminar(){
      $idaplicar = $this->input->post('idaplicar');
      $result = $this->Encuesta_model->eliminar($idaplicar);
      // echo $idaplicar; die();
      $response = array(
        "result" => $result
      );

      envia_datos_json(200, $response, $this);
  }// mostrar()


  public function get_arch_evidencia(){
      $idaplicar = $this->input->post('id_aplica');
      $result = $this->Encuesta_model->get_url_evidencia($idaplicar);
      $nombre = $this->Encuesta_model->get_nombre_evidencia($idaplicar);
      // echo $idaplicar; die();
      $response = array(
        "result" => $result,
        "nombre" => $nombre
      );

      envia_datos_json(200, $response, $this);
  }// mostrar()

}// class
