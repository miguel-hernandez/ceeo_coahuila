<?php

class Encuesta_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }


  function get_xidusuario($idvisitador){
    $str_query = " SELECT ap.idaplicar AS id, fcreacion
    FROM aplicar ap
    WHERE ap.idusuario = {$idvisitador}
    ";
    // echo $str_query; die();
    return $this->db->query($str_query)->result_array();
  }// get_asignadas()

  function get_cuestions(){
    $query = "SELECT *, '' AS array_complemento FROM pregunta WHERE idencuesta = 1";
    return $this->db->query($query)->result_array();
  }

  function get_complemento_xidpregunta($idpregunta){
    $query = " SELECT *
               FROM pregunta_complemento
               WHERE idpregunta = {$idpregunta}
               ORDER BY orden ASC ";
    return $this->db->query($query)->result_array();
  }

  function get_cuestions_edita($tipo, $idaplicar){
    $query = " SELECT * FROM pregunta p
    INNER JOIN respuesta r ON r.idpregunta = p.idpregunta
    WHERE r.idaplicar = {$idaplicar} and p.idencuesta = {$tipo}";
    // echo $query; die();
    return $this->db->query($query)->result_array();
  }

}
