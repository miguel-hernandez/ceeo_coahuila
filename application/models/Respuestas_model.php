<?php

class Respuestas_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insert_respuestas($respuestas, $nombre_archivo, $idusuario){
      $fecha = date("Y-m-d H:i:s");
      $band= FALSE;
      // echo "<pre>";print_r($respuestas['array_datos']);die();
      $this->db->trans_start();
      $data = array(
        'idusuario' => $idusuario,
        'fcreacion' => $fecha
      );
      $this->db->insert('aplicar', $data);
      $id_aplica = $this->db->insert_id();

      // echo "<pre>";print_r($id_aplica);die();
      if ($id_aplica > 0) {
        if ($nombre_archivo!='') {
          $ruta_archivos_save = "evidencias/{$idusuario}/{$id_aplica}/$nombre_archivo";
          $inserto = $this->insert_response("NULL", $ruta_archivos_save, $id_aplica, 4);
          if ($inserto) {
            $band= TRUE;
          }
          else {
            $this->db->trans_rollback();
            return FALSE;
          }
        }

        foreach ($respuestas['array_datos'] as $key => $value) {
          if ($value["tipo"]==1) {
            $inserto = $this->insert_response($value["idpregunta"], $value["valores"], $id_aplica, $value["tipo"]);
            if ($inserto) {
              $band= TRUE;
            }
            else {
              $this->db->trans_rollback();
              return FALSE;
            }
          }
          elseif ($value["tipo"]==2) {
            $arr_opciones_resp = explode("/",$value["valores_string"]);
            foreach ($arr_opciones_resp as $key1 => $value1) {
              $inserto = $this->insert_response($value["idpregunta"], $value1, $id_aplica, $value["tipo"]);
              if ($inserto) {
                $band= TRUE;
              }
              else {
                $this->db->trans_rollback();
                return FALSE;
              }
            }
          }

        }
      }
      if ($band==TRUE) {
        $this->db->trans_commit();
        // $this->db->trans_rollback();
        return $id_aplica;
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
        case 4:
          $data = array(
            // 'idpregunta' => $idpregunta,
            'url_comple' => $value,
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

    function get_response($idaplica){
      $str_query = " SELECT
                  r.idrespuesta, r.idaplicar, r.idpregunta, p.idtipopregunta, r.respuesta, r.complemento, r.url_comple
                  FROM respuesta as r
                  LEFT JOIN pregunta p ON r.idpregunta= p.idpregunta
                  WHERE r.idaplicar={$idaplica}
      ";
                    // echo $str_query ; die();
       return $this->db->query($str_query)->result_array();
    }

    function get_response_xidpregunta($idpregunta, $idaplica){
      $str_query = " SELECT
                  r.idrespuesta, r.idaplicar, r.idpregunta, p.idtipopregunta, r.respuesta, r.complemento, r.url_comple
                  FROM respuesta as r
                  LEFT JOIN pregunta p ON r.idpregunta= p.idpregunta
                  WHERE r.idaplicar={$idaplica} AND p.idpregunta={$idpregunta}
      ";
                    // echo $str_query ; die();
       return $this->db->query($str_query)->result_array();
    }


    function update_respuestas($respuestas, $nombre_archivo, $id_aplica,$idusuario){
      $fecha = date("Y-m-d H:i:s");
      $band= FALSE;
      // echo "<pre>";print_r($respuestas['array_datos']);die();
      $this->db->trans_start();


      // echo "<pre>";print_r($id_aplica);die();
      if ($id_aplica > 0) {
        if ($nombre_archivo!='') {
          $str_query = " DELETE FROM respuesta
            WHERE idaplicar = {$id_aplica}
          ";
           $estatus_elim = $this->db->query($str_query);
           if ($estatus_elim) {
             $ruta_archivos_save = "evidencias/{$idusuario}/{$id_aplica}/$nombre_archivo";
             $inserto = $this->insert_response("NULL", $ruta_archivos_save, $id_aplica, 4);
             if ($inserto) {
               $band= TRUE;
             }
             else {
               $this->db->trans_rollback();
               return FALSE;
             }
           }
           else {
             $this->db->trans_rollback();
             return FALSE;
           }


        }
        else {
          $str_query = " DELETE FROM respuesta
            WHERE idaplicar = {$id_aplica} AND !ISNULL(idpregunta)
          ";
           $estatus_elim = $this->db->query($str_query);
           if ($estatus_elim) {
             $band= TRUE;
           }
           else {
             $this->db->trans_rollback();
             return FALSE;
           }
        }

        foreach ($respuestas['array_datos'] as $key => $value) {
          if ($value["tipo"]==1) {
            $inserto = $this->insert_response($value["idpregunta"], $value["valores"], $id_aplica, $value["tipo"]);
            if ($inserto) {
              $band= TRUE;
            }
            else {
              $this->db->trans_rollback();
              return FALSE;
            }
          }
          elseif ($value["tipo"]==2) {
            $arr_opciones_resp = explode("/",$value["valores_string"]);
            foreach ($arr_opciones_resp as $key1 => $value1) {
              $inserto = $this->insert_response($value["idpregunta"], $value1, $id_aplica, $value["tipo"]);
              if ($inserto) {
                $band= TRUE;
              }
              else {
                $this->db->trans_rollback();
                return FALSE;
              }
            }
          }

        }
      }
      if ($band==TRUE) {
        $this->db->trans_commit();
        // $this->db->trans_rollback();
        return $id_aplica;
      }
      else {
        $this->db->trans_rollback();
        return FALSE;
      }
    }

}
