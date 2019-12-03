<?php

class Encuesta_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }


  function get_xidusuario($idvisitador){
    // $str_query = " SELECT ap.idaplicar AS id, fcreacion
    // FROM aplicar ap
    // WHERE ap.idusuario = {$idvisitador}
    // ";
    $str_query = " SELECT
      ap.idaplicar AS id, fcreacion,
      r.respuesta as n_documento,
      r.idaplicar as a_adjunto
      FROM aplicar ap
      LEFT JOIN respuesta r ON ap.idaplicar=r.idaplicar
      WHERE ap.idusuario = {$idvisitador} AND r.idpregunta=1
      ORDER BY fcreacion DESC
    ";

    // echo $str_query; die();
    return $this->db->query($str_query)->result_array();
  }// get_asignadas()

  function get_cuestions(){
    $query = "SELECT *, '' AS array_complemento FROM pregunta WHERE idencuesta = 1 ORDER BY npregunta";//limit 3
    return $this->db->query($query)->result_array();
  }

  function get_complemento_xidpregunta($idpregunta){
    $query = " SELECT *
    FROM pregunta_complemento
    WHERE idpregunta = {$idpregunta}
    ORDER BY orden ASC ";
    return $this->db->query($query)->result_array();
  }

  function get_complemento_xidpregunta_resp($idpregunta){
    $query = " SELECT *
    FROM pregunta_complemento
    WHERE idpregunta = {$idpregunta}
    ORDER BY orden ASC ";
    // echo "<pre>";print_r($query);die();
    return $this->db->query($query)->result_array();
  }


  function get_cuestions_edita($tipo, $idaplicar){
    $query = " SELECT * FROM pregunta p
    INNER JOIN respuesta r ON r.idpregunta = p.idpregunta
    WHERE r.idaplicar = {$idaplicar} and p.idencuesta = {$tipo}";
    // echo $query; die();
    return $this->db->query($query)->result_array();
  }// get_cuestions_edita()

  function get_cuestions_mostrar(){
    $query = "SELECT *,  '' AS respuesta, '' AS array_complemento, '' AS array_contesto, '' AS array_final
    FROM pregunta
    WHERE idencuesta = 1
    ORDER BY npregunta";//limit 3
    return $this->db->query($query)->result_array();
  }

  function get_complemento_xidpregunta_mostrar($idpregunta){
    $query = " SELECT *, '' AS checked
    FROM pregunta_complemento
    WHERE idpregunta = {$idpregunta}
    ORDER BY orden ASC ";
    return $this->db->query($query)->result_array();
  }

  function get_encuestaxidusuario($idaplicar, $idpregunta){
    // $str_query = " SELECT res.idrespuesta, res.respuesta, res.complemento, res.idpregunta
    // FROM respuesta res
    // WHERE res.idaplicar = ? AND res.idpregunta = ?
    // ";
    $str_query = "SELECT res.idrespuesta, res.respuesta, res.complemento, res.idpregunta,  CONCAT_WS(' ', u.nombre, u.paterno, u.materno) as Usuario
FROM respuesta res
INNER JOIN aplicar ap on ap.idaplicar = res.idaplicar
INNER JOIN usuario u on u.idusuario = ap.idusuario
WHERE res.idaplicar = {$idaplicar} AND res.idpregunta = {$idpregunta};";
    // echo $str_query; die();
    return $this->db->query($str_query)->result_array();
  }// get_encuestaxidusuario()

  function get_file_path($idaplicar){
    $str_query = " SELECT res.url_comple
    FROM respuesta res
    WHERE res.idaplicar = ? AND res.idpregunta IS NULL
    ";
    // echo $str_query; die();
    return $this->db->query($str_query, array($idaplicar))->result_array();
  }// get_file_path()

  function eliminar($idaplicar){
    $this->db->trans_start();

    $str_query_1 = " DELETE
    FROM respuesta
    WHERE idaplicar = ?
    ";
    $this->db->query($str_query_1, array($idaplicar));

    $str_query_2 = " DELETE
    FROM aplicar
    WHERE idaplicar = ?
    ";
    $this->db->query($str_query_2, array($idaplicar));

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE){
      return FALSE;
    }
    else{
      return TRUE;
    }
  }// eliminar()


  function get_url_evidencia($idaplicar){
    $str_query = " SELECT res.url_comple as url_comple
    FROM respuesta res
    WHERE res.idaplicar = {$idaplicar} AND res.idpregunta IS NULL
    ";
    // echo $str_query; die();
    return $this->db->query($str_query)->row('url_comple');
  }// get_url_evidencia()


function get_nombre_evidencia($idaplicar){
  $str_query = " SELECT res.respuesta as respuesta
  FROM respuesta res
  WHERE res.idaplicar = {$idaplicar} AND res.idpregunta = 1
  ";
  // echo $str_query; die();
  return $this->db->query($str_query)->row('respuesta');
}// get_nombre_evidencia()




}
