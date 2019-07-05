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
                  <button class='btn btn-link' onclick='traerArchivos(".$value['idusuario'].")' type='button' data-toggle='collapse' data-target='#collapse".$value['idusuario']."' aria-expanded='true' aria-controls='collapse".$value['idusuario']."'>
                    <p>".$value['Usuario']." Usuario: <i>  ".$value['username']."</i> Total: <b>  ".$value['total']."</b></p>
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
              <th scope='col'>Mostrar</th>
              <th scope='col'>Evidencia</th>
            </thead>
            <tbody>";
    foreach ($archivos as $key => $value) {
      $archivo = substr($value['archivo'],18);
      echo "<tr>
              <td scope='row'>".$value['idaplicar']."</td>
              <td>".$archivo."</td>
              <td>".$value['fcreacion']."</td>
              <td> <button onclick='mostrar_encuesta(".$value['idaplicar'].")' type='button' class='btn btn-primary btn-block'>
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
      $subsecretaria = $this->getSubsecretaria();
          // $tipo =
          // $data["usuario"] = $tipo.$usuario["nombre"]." ".$usuario["paterno"]." ".$usuario["materno"];
      $data = array('usuario' => trae_datos_user($this,"") , 'subsecretaria' => $subsecretaria, 'usuarios' => $usuario);
      pagina_basica($this, "administrador/index", $data);
    }
    }// index()


  }
