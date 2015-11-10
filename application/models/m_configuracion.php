<?php

class M_configuracion extends CI_Model{

	function get_configuracion($id_facultad){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->order_by('fecha', 'desc');
		$result = $this->db->get('configuraciones');
		
		if($result->result())
			return $result;
		return false;
	}
}