<?php
class M_sedes extends CI_Model{
	function get_sedes($id_sede = false, $sede = false){
		if($id_sede)
			$this->db->where('id_sede', $id_sede);
		if($sede)
			$this->db->where('sede', $sede);

		$sedes = $this->db->get('sedes');

		if($sedes->num_rows() > 0)
			return $sedes;
		return FALSE;
	}

	function guardar($sede, $estado){
		$this->db->select_max('id_sede');
		$sedes = $this->db->get('sedes');
		if($sedes->result()){
			$sedes_ = $sedes->row_array();
			$id_sede = $sedes_['id_sede'] + 1;
		}else
			$id_sede = 1;
		$datos = array(
			'id_sede' => $id_sede,
			'sede' => $sede,
			'estado' => $estado
		);

		$this->db->insert('sedes', $datos);
	}

	function eliminar($id){
		$result = $this->db->delete('sedes', array('id_sede' => $id));
		
		if($result)
			return true;
		
		return false;
	}
/*
	function get_ralacion_sede_carrera($id_facultad = false, $id_sede = false){
		
		if($id_facultad)
			$this->db->where('t1.id_facultad', $id_facultad);
		if($id_sede)
			$this->db->where('t1.id_sede', $id_sede);	

		$result = $this->db->get('relacion_sede_carrera as t1');
		
		if($result->result())
			return $result;
		return false;
	}
*/
}
?>