<?php

class Seguridad_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

     function get_for_login($username,$clave) {
       $str_query = "SELECT se.username, se.clave, se.estatus, se.idusuario,
                            us.nombre, us.paterno, us.materno, us.idtipousuario, tu.tipo, us.area_departamento
                      FROM seguridad se
                      INNER JOIN usuario us ON us.idusuario = se.idusuario
                      INNER JOIN tipousuario tu ON tu.idtipousuario = us.idtipousuario

                      WHERE se.username = '{$username}' AND se.clave = md5('{$clave}')
          ";
          // echo $str_query; die();
       return $this->db->query($str_query)->result_array();
     }// get_all()


}
