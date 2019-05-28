<?php

class Reporte_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }


    function get_xidusuario($idvisitador){
      $str_query = " SELECT
        ap.idaplicar AS idaplicar, fcreacion,
        r.respuesta as n_documento,
        r.idaplicar as a_adjunto
        FROM aplicar ap
        LEFT JOIN respuesta r ON ap.idaplicar=r.idaplicar
        WHERE ap.idusuario = ? AND r.idpregunta=1
        ORDER BY fcreacion DESC
      ";

      return $this->db->query($str_query, array($idvisitador))->result_array();
    }// get_xidusuario()

  function get_respuestas($idaplicar, $idpregunta){
    $str_query = "  SELECT GROUP_CONCAT(tabla1.complemento SEPARATOR ', ') AS respuestas_seleccionadas
                  FROM
                  (
                  SELECT respuesta, complemento
                  FROM respuesta
                  WHERE idaplicar = ? AND idpregunta=?
                  GROUP BY complemento
                  ) AS tabla1
    ";

    // echo $str_query; die();
    return $this->db->query($str_query, array($idaplicar,$idpregunta))->result_array();
  }// get_xidusuario()


}
