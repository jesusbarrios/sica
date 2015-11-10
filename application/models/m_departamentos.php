<?php

class M_departamentos extends CI_Model{

	function obtener_departamento($id_pais = 1, $id_departamento  = false){
	
		$this->db->where('id_pais', $id_pais);
		if($id_departamento)
			$this->db->where('id_departamento', $id_departamento);
		
		$this->db->order_by('departamento', 'ASC');
		$query = $this->db->get('departamentos');
		
		echo $query->num_rows();	

		if($query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
	}
}
?>