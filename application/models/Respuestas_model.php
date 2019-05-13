<?php

class Respuestas_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insert_response($idpregunta, $value, $idaplica, $tipopregunta){
      switch ($tipopregunta) {
        case 1:
          $data = array(
            'idpregunta' => $idpregunta,
            'respuesta' => $value,
            'idaplicar' => $idaplica
          );
          break;

        case 2:
          $data = array(
            'idpregunta' => $idpregunta,
            'complemento' => $value,
            'idaplicar' => $idaplica
          );
          break;

        case 3:
        $respuesta = ($value != 'no')?"si":"no";
          $data = array(
            'idpregunta' => $idpregunta,
            'respuesta' => $respuesta,
            'complemento' => $value,
            'idaplicar' => $idaplica
          );
          break;
      }
      return $this->db->insert('respuesta', $data);
    }

    function update_response($idpregunta, $value, $idaplica, $tipopregunta){
      switch ($tipopregunta) {
        case 1:
          $data = array(
            // 'idpregunta' => $idpregunta,
            'respuesta' => $value
            // 'idaplicar' => $idaplica
          );
          break;

        case 2:
          $data = array(
            // 'idpregunta' => $idpregunta,
            'complemento' => $value
            // 'idaplicar' => $idaplica
          );
          break;

        case 3:
        $respuesta = ($value != 'no')?"si":"no";
          $data = array(
            // 'idpregunta' => $idpregunta,
            'respuesta' => $respuesta,
            'complemento' => $value
            // 'idaplicar' => $idaplica
          );
          break;
      }
      $where = array(
            'idaplicar' => $idaplica,
            'idpregunta' => $idpregunta,
          );
      $this->db->where($where);
      return $this->db->update('respuesta', $data);
    }
}
