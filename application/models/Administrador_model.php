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
		$str_query = "SELECT count(r.url_comple) as total, a.idusuario, CONCAT(u.nombre, ' ' ,u.paterno, ' ', u.materno) as usuario, s.username, GROUP_CONCAT(r.url_comple) as archivos, a.fcreacion, u.idsubsecretaria, GROUP_CONCAT(a.idaplicar) AS idaplicar  from aplicar a 
		Left join usuario u on u.idusuario = a.idusuario
		inner join seguridad s on s.idusuario = a.idusuario
		inner join respuesta r on r.idaplicar = a.idaplicar
		where a.idusuario <>2
		group by idusuario;";
		return $this->db->query($str_query)->result_array();
	} //getTabla()

	public function getSubsecretaria(){
		$str_query = "SELECT * FROM cat_subsecretaria;";
		return $this->db->query($str_query)->result_array();
	}

	public function getUsuarios($idsub){
		$str_query = "SELECT s.username, CONCAT(u.nombre, ' ' ,u.paterno, ' ', u.materno) as Usuario, count(a.idaplicar) as total, u.idusuario FROM seguridad s
		INNER JOIN usuario u on u.idusuario = s.idusuario
		LEFT JOIN aplicar a on a.idusuario = u.idusuario
		WHERE u.idsubsecretaria = {$idsub}
		AND s.estatus <> 2
		GROUP BY u.idusuario;";
		return $this->db->query($str_query)->result_array();
	}

	public function getArchivos($iduser){
		$str_query = "SELECT r.idaplicar, r.url_comple as archivo, a.fcreacion FROM respuesta r
		INNER JOIN aplicar a on a.idaplicar = r.idaplicar
		where a.idusuario = {$iduser} and url_comple IS NOT NULL;";
		return $this->db->query($str_query)->result_array();
	}

	public function guardarNotas($accion, $especificacion, $justificacion, $notas, $encuestado, $encuestadoOtro, $tema, $sostenimiento, $idaplicar) {	
			

          $data = array(
            'accionMejora' => $accion,
            'especificarMejora' => $especificacion,
            'justificarMejora' => $justificacion,
            'notasAdicionales' => $notas, 
            'responsableDocumento' => $encuestado,
            'otroResponsable' => $encuestadoOtro,
            'tema'=> $tema,
            'sostenimiento'=> $sostenimiento
          );
         
      $where = array(
            'idaplicar' => $idaplicar
          );
      $this->db->where($where);
      return $this->db->update('aplicar', $data);

	}

	public function getObservaciones($idaplicar){
		$str_query = "SELECT accionMejora, especificarMejora, justificarMejora, notasAdicionales, responsableDocumento, otroResponsable,tema, sostenimiento FROM aplicar WHERE idaplicar = {$idaplicar};";
		return $this->db->query($str_query)->result_array();
	}
	
}

?>