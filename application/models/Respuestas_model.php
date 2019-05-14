<?php

class Respuestas_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }


    function insert_respuestas($respuestas, $idusuario){
      $fecha = date("Y-m-d H:i:s");
      $band= FALSE;

      $this->db->trans_start();
      $data = array(
        'idusuario' => $idusuario,
        'fcreacion' => $fecha
      );
      $this->db->insert('aplicar', $data);
      $id_aplica = $this->db->insert_id();

      // echo "<pre>";print_r($id_aplica);die();
      if ($id_aplica > 0) {
        foreach ($respuestas as $key => $value) {
            $inserto = $this->insert_response($value["idpregunta"], $value["valor"], $id_aplica, $value["tipo"]);
            if ($inserto) {
              $band= TRUE;
            }
            else {
              $this->db->trans_rollback();
              $band= FALSE;
            }
        }
      }
      if ($band==TRUE) {
        // $this->db->trans_commit();
        $this->db->trans_rollback();
        return TRUE;
      }
      else {
        $this->db->trans_rollback();
        return FALSE;
      }
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
