<?php

class M_carreras extends CI_Model{

	function get_carreras($id_facultad = false, $id_carrera = false, $codigo = false, $carrera = false){
		if($id_facultad)
			$this->db->where('id_facultad', $id_facultad);
		if($id_carrera)
			$this->db->where('id_carrera', $id_carrera);
		if($codigo)
			$this->db->where('codigo', $codigo);
		if($carrera)
			$this->db->where('carrera', $carrera);

		$this->db->order_by('carreras.carrera', 'asc');
		$carreras = $this->db->get('carreras');

		if($carreras->result())
			return $carreras;
		return FALSE;
	}

	function insert_carreras($id_facultad, $codigo, $carrera, $tipo, $estado){
		$this->db->select_max('t1.id_carrera');
		$this->db->where('t1.id_facultad', $id_facultad);
		$carreras = $this->db->get('carreras as t1');
		if($carreras){
			$carreras_ = $carreras->row_array();
			$id_carrera = $carreras_['id_carrera'] + 1;
		}else
			$id_carrera = 1;

		$datos = array(
			'id_facultad' 	=> $id_facultad,
			'id_carrera' 	=> $id_carrera,
			'codigo' 		=> $codigo,
			'carrera' 		=> $carrera,
			'tipo'			=> $tipo,
			'estado' 		=> $estado,
		);

		$this->db->insert('carreras', $datos);
	}
	
	function delete_carreras($id_facultad, $id_carrera){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_carrera', $id_carrera);
		$carreras = $this->db->delete('carreras');
		if($carreras)
			return true;
		return false;
	}
	
	function eliminar_relacion_sede_carrera($id_facultad, $id_sede, $id_carrera){
		$datos = array(
			'id_facultad' => $id_facultad,
			'id_sede' => $id_sede,
			'id_carrera' => $id_carrera,
		);
		$result = $this->db->delete('relacion_sede_carrera', $datos);
	}


	/*
	*
	*RELACIONES SEDE CARRERA
	*
	*/
	function save_relacion_sede_carrera($id_facultad, $id_sede, $id_carrera, $fecha, $estado){
		$datos = array(
			'id_facultad'		=> $id_facultad,
			'id_sede' 			=> $id_sede,
			'id_carrera' 		=> $id_carrera,
			'creacion'	=> $fecha,
			'estado'			=> $estado,
		);
		
		$this->db->insert('relacion_sede_carrera', $datos);

	}

	function get_relacion_sede_carrera($id_facultad = false, $id_sede = false, $id_carrera = false, $estado = false){
		$this->db->select('t1.*, t2.facultad, t3.sede, t4.carrera');
		if($id_facultad)
			$this->db->where('t1.id_facultad', $id_facultad);
		else
			$this->db->group_by('t1.id_facultad');
		if($id_sede)
			$this->db->where('t1.id_sede', $id_sede);
		else if($id_facultad)
			$this->db->group_by('t1.id_sede');
		if($id_carrera)
			$this->db->where('t1.id_carrera', $id_carrera);
		else if($id_sede && $id_facultad)
			$this->db->group_by('t1.id_carrera');
		if($estado)
			$this->db->where('t1.estado', $estado);

		$this->db->join('facultades as t2', 't2.id_facultad = t1.id_facultad');
		$this->db->join('sedes as t3', 't3.id_sede = t1.id_sede');
		$this->db->join('carreras as t4', 't4.id_facultad = t1.id_facultad AND t4.id_carrera = t1.id_carrera');
		
		$this->db->order_by('t1.id_facultad', 'asc');
		$carreras = $this->db->get('relacion_sede_carrera as t1');
		
		if($carreras->result())
			return $carreras;
		return false;
	}
	
	function actualizar_relacion_sede_carrera($id_facultad, $id_sede, $id_carrera, $fecha, $estado){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_sede', $id_sede);
		$this->db->where('id_carrera', $id_carrera);
		$datos = array(
			'estado'	=> $estado,
		);
		$this->db->update('relacion_sede_carrera', $datos);
	}
}
?>