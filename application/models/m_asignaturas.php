<?php

class M_asignaturas extends CI_Model{

	function get_asignaturas($id_facultad = false, $id_carrera = false, $id_curso = false, $id_asignatura = false, $codigo = false, $asignatura = false){
	
	
		if($id_facultad)
			$this->db->where("id_facultad", $id_facultad);

		if($id_carrera)
			$this->db->where("id_carrera", $id_carrera);	
		if($id_curso)
			$this->db->where("id_curso", $id_curso);
		if($id_asignatura)
			$this->db->where("id_asignatura", $id_asignatura);
		if($codigo)
			$this->db->where("codigo", $codigo);
		if($asignatura)
			$this->db->where("asignatura", $asignatura);
		$this->db->order_by('asignatura', 'ASC');
		$query = $this->db->get('asignaturas');
		if($query->result())
			return $query;
		return FALSE;
	}

	function insert_asignaturas($id_facultad, $id_carrera, $id_curso, $codigo, $asignatura, $estado){
		$this->db->select_max('t1.id_asignatura');
		$this->db->where('t1.id_facultad', $id_facultad);
		$this->db->where('t1.id_carrera', $id_carrera);
		$asignaturas = $this->db->get('asignaturas as t1');
		if($asignaturas){
			$asignaturas_ 	= $asignaturas->row_array();
			$id_asignatura 	= $asignaturas_['id_asignatura'] + 1;
		}else
			$id_asignatura = 1;
		$datos = array(
			'id_facultad' 	=> $id_facultad,
			'id_carrera' 	=> $id_carrera,
			'id_curso' 		=> $id_curso,
			'codigo'		=> $codigo,
			'id_asignatura' => $id_asignatura,
			'asignatura' 	=> $asignatura,
			'estado'	 	=> $estado,
		);
		$this->db->insert('asignaturas', $datos);
	}

	function delete_asignaturas($facultad, $carrera, $curso, $asignatura){
		$datos = array(
			'id_facultad' 	=> $facultad,
			'id_carrera' 	=> $carrera,
			'id_curso' 		=> $curso,
			'id_asignatura' => $asignatura
		);
		return $this->db->delete('asignaturas', $datos);
	}

	function get_correlatividades($id_facultad, $id_carrera, $id_curso = false, $id_asignatura = false, $id_curso2 = false, $id_asignatura2 = false){
			$this->db->select('*'); 
			if($id_facultad)
				$this->db->where("t1.id_facultad = $id_facultad");
			if($id_carrera)
				$this->db->where("t1.id_carrera = $id_carrera");
			if($id_curso)
				$this->db->where("t1.id_curso1 = $id_curso");
			if($id_asignatura)	
				$this->db->where("t1.id_asignatura1 = $id_asignatura");
			if($id_curso2)
				$this->db->where("t1.id_curso2 = $id_curso2");
			if($id_asignatura2)	
				$this->db->where("t1.id_asignatura2 = $id_asignatura2");

			$this->db->join('asignaturas as t2', 't2.id_facultad = t1.id_facultad and t2.id_carrera = t1.id_carrera and t2.id_curso = t1.id_curso2 and t2.id_asignatura = t1.id_asignatura2');
			$this->db->join('cursos as t3', 't3.id_facultad = t1.id_facultad and t3.id_carrera = t1.id_carrera and t3.id_curso = t1.id_curso2');
			$query = $this->db->get('correlatividades as t1');

			if($query->result())
				return $query;
		return FALSE;
	}

	function insert_correlatividad($facultad, $carrera, $curso1, $asignatura1, $curso2, $asignatura2, $estado){

		$datos = array(
			'id_facultad' 	=> $facultad,
			'id_carrera' 	=> $carrera,
			'id_curso1' 	=> $curso1,
			'id_asignatura1'=> $asignatura1,
			'id_curso2' 	=> $curso2,
			'id_asignatura2'=> $asignatura2,
			'estado' 		=> $estado
		);

		if($this->db->insert('correlatividades', $datos))
			return true;
		return false;
	}

	function delete_correlatividades($id_facultad = false, $id_carrera = false, $id_curso1 = false, $id_asignatura1 = false, $id_curso2, $id_asignatura2 = false){
		if($id_facultad)
			$this->db->where('id_facultad', $id_facultad);
		if($id_carrera)
			$this->db->where('id_carrera', $id_carrera);
		if($id_curso1)
			$this->db->where('id_curso1', $id_curso1);
		if($id_asignatura1)
			$this->db->where('id_asignatura1', $id_asignatura1);
		if($id_curso2)
			$this->db->where('id_curso2', $id_curso2);
		if($id_asignatura2)
			$this->db->where('id_asignatura2', $id_asignatura2);

		return $this->db->delete('correlatividades');
	}
}
?>