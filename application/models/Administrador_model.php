<?php 

/**
 * 
 */
class Administrador_model extends CI_Model
{
	
	function __construct(){
		parent::__construct();
        date_default_timezone_set(ZONAHORARIA);
	}

	public function getTabla(){
		$str_query = "SELECT count(r.url_comple) as total, a.idusuario, CONCAT(u.nombre, ' ' ,u.paterno, ' ', u.materno) as usuario, s.username, GROUP_CONCAT(r.url_comple) as archivos, a.fcreacion  from aplicar a 
						inner join usuario u on u.idusuario = a.idusuario
						inner join seguridad s on s.idusuario = a.idusuario
						inner join respuesta r on r.idaplicar = a.idaplicar
						where a.idusuario <>2
						group by idusuario;";
		/*$str_query = "SELECT  a.idusuario, CONCAT(u.nombre, ' ' ,u.paterno, ' ', u.materno) as usuario, s.username, r.url_comple, a.fcreacion, r.idaplicar  from aplicar a 
inner join usuario u on u.idusuario = a.idusuario
inner join seguridad s on s.idusuario = a.idusuario
inner join respuesta r on r.idaplicar = a.idaplicar
where a.idusuario <>2 and url_comple is not null;";*/
          // echo $str_query; die();
       return $this->db->query($str_query)->result_array();
	} //getTabla()
}

 ?>