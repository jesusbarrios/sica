<?php

class M_facultades extends CI_Model{

	function get_facultades($id_facultad = false, $facultad = false){
		if($id_facultad)
			$this->db->where('id_facultad', $id_facultad);
		if($facultad)
			$this->db->where('facultad', $facultad);
		$facultades = $this->db->get('facultades');
		if($facultades->num_rows() > 0)
			return $facultades;
		return FALSE;
	}
	
	function insert_facultades($facultad, $creacion){
		$this->db->select_max('t1.id_facultad');
		$facultades = $this->db->get('facultades as t1');
		if($facultades->result()){
			$facultades_ = $facultades->row_array();
			$id_facultad = $facultades_['id_facultad'] + 1;
		}else
			$id_facultad = 1;
		
		$datos = array(
			'id_facultad'	=> $id_facultad,
			'facultad'		=> $facultad,
			'creacion'		=> $creacion,
		);
		$this->db->insert('facultades', $datos);
	}
	
	function delete_facultades($id_facultad){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->delete('facultades');
	}
}
?>