<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrador extends CI_Controller {

  function __construct(){
    parent::__construct();
    $this->load->helper('appweb');
    $this->load->model('Administrador_model');
  }

  public function getSubsecretaria(){
    $result = $this->Administrador_model->getSubsecretaria();
    return $result;
  }

  public function getUsuario(){
    $id = $_POST['id'];
    $usuario = $this->Administrador_model->getUsuarios($id);
    foreach ($usuario as $key => $value) {
      
      echo"<div class='accordion' id='accordionExample'>
            <div class='card'>
              <div class='card-header' id='headingOne'>
                <h5 class='mb-0'>
                  <button  class='btn btn-link' onclick='traerArchivos(".$value['idusuario'].")' type='button' data-toggle='collapse' data-target='#collapse".$value['idusuario']."' aria-expanded='true' aria-controls='collapse".$value['idusuario']."'>
                    <p id='p".$id."'>".$value['Usuario']." Usuario: <i>  ".$value['username']."</i> Total: <b>  ".$value['total']."</b></p>
                  </button>
                </h5>
              </div>

              <div id='collapse".$value['idusuario']."' class='collapse' aria-labelledby='headingOne' data-parent='#accordionExample'>
                <div id='archivos".$value['idusuario']."' class='card-body'>
                  
                </div>
              </div>
            </div>
          </div>";
    }
    return $usuario;
  }

  public function getArchivos(){
    $iduser = $_POST['id'];
    $archivos = $this->Administrador_model->getArchivos($iduser);

    echo "<table class='table table-hover'>
            <thead>
              <th scope='col'>ID Encuesta</th>
              <th scope='col'>Archivo</th>
              <th scope='col'>Fecha</th>
              <th scope='col'>Editar</th>
              <th scope='col'>Eliminar</th>
              <th scope='col'>Mostrar</th>
              <th scope='col'>Evidencia</th>
            </thead>
            <tbody>";
    foreach ($archivos as $key => $value) {
      $archivo = substr($value['archivo'],16);
      echo "<tr>
              <td scope='row'>".$value['idaplicar']."</td>
              <td>".$archivo."</td>
              <td>".$value['fcreacion']."</td>
              <td> <button onclick='editar_ev(".$value['idaplicar'].")' type='button' class='btn btn-primary btn-block'> <i class='fa fa-edit'></i> Editar</button> 
              <td> <button onclick='eliminar_ev(".$value['idaplicar'].",".$iduser.")' type='button' class='btn btn-primary btn-block'> <i class='fa fa-trash'></i> Eliminar</button> 
              <td> <button onclick='mostrar_encuesta(".$value['idaplicar'].",".$iduser.")' type='button' class='btn btn-primary btn-block'>
                      <i class='fa fa-eye'></i> Mostrar
                   </button>
              </td>
              <td> <button onclick='ver_ev(".$value['idaplicar'].")' type='button' class='btn btn-primary btn-block'> <i class='fa fa-eye'></i></button>
              </td>
            </tr>";
    }
    echo "  </tbody>
          </table>";
    return $archivos;
  }

  public function guardarNotas(){
    $accion = $this->input->post('accion');
    $encuestado = $this->input->post('encuestado');
    $especificacion = $this->input->post('especificacion');
    $justificacion = $this->input->post('justificacion');
    $notas = $this->input->post('notas');
    $idaplicar = $this->input->post('idaplicar');
    $encuestadoOtro = $this->input->post('encuestadoOtro');
    $tema = $this->input->post('tema');
    $sostenimiento = $this->input->post('sostenimiento');

    $result = $this->Administrador_model->guardarNotas($accion, $especificacion, $justificacion, $notas, $encuestado, $encuestadoOtro, $tema, $sostenimiento, $idaplicar);
    return $result;
  }

  public function eliminar_req() {
    $idaplicar = $this->input->post('id');

    $result = $this->Administrador_model->eliminar_req($idaplicar);
    $response = ($result != 0) ? true : false;
    envia_datos_json(200, $response, $this);
  }

  public function index(){
    if(verifica_sesion_redirige($this)){
      $data["titulo"] = "COORDINADOR";
      $usuario = $this->session->userdata[DATOSUSUARIO];
          // echo "<pre>"; print_r($usuario); die();
      switch ($usuario["idtipousuario"]) {
          
        case U_ADMINISTRADOR:
        $tipo = "ADMINISTRADOR: ";
        break;
      }
      $subsecretaria = $this->getSubsecretaria();
          // $tipo =
          // $data["usuario"] = $tipo.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
      $data = array('usuario' => trae_datos_user($this,"") , 'subsecretaria' => $subsecretaria, 'usuarios' => $usuario);
      pagina_basica($this, "administrador/index", $data);
    }
    }// index()


  }
