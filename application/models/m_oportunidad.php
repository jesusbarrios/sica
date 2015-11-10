<?php

class M_oportunidad extends CI_Model{

	function get_oportunidad($id_facultad, $id_oportunidad = false){
	
		if($id_oportunidad)
			$this->db->where('id_oportunidad', $id_oportunidad);	

		$this->db->where('id_facultad', $id_facultad);

		$result = $this->db->get('oportunidades');

		if($result->result())
			return $result;

		return false;
	}
}

?>