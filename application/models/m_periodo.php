<?php
class M_periodo extends CI_Model{

	function insert_periodos($id_periodo, $estado){
		$datos = array(
			'id_periodo'		=> $id_periodo,
			'estado'		=> $estado,
		);
		$this->db->insert('periodos', $datos);
	}

	function get_periodos($id_periodo = false, $estado = false){
		if($id_periodo)
			$this->db->where('t1.id_periodo', $id_periodo);
		if($estado)
			$this->db->where('t1.estado', $estado);
		$this->db->order_by('t1.id_periodo', 'desc');
		$periodos = $this->db->get('periodos as t1');
		if($periodos->result())
			return $periodos;
		return false;
	}

	function delete_periodos($id_periodo){
		$this->db->where('id_periodo', $id_periodo);
		$this->db->delete('periodos');
	}

	function update_periodos($id_periodo, $estado){
		$this->db->where('id_periodo', $id_periodo);
		$this->db->update('periodos', array('estado'=> $estado));
	}
}