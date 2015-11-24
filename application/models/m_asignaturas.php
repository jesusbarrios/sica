<?php

class M_asignaturas extends CI_Model{

	function get_asignaturas($id_facultad = false, $id_carrera = false, $id_curso = false, $id_asignatura = false){
	
	
		if($id_facultad)
			$this->db->where("id_facultad", $id_facultad);

		if($id_carrera)
			$this->db->where("id_carrera", $id_carrera);	
		if($id_curso)
			$this->db->where("id_curso", $id_curso);
		
		if($id_asignatura)
			$this->db->where("id_asignatura", $id_asignatura);



		$this->db->order_by('asignatura', 'ASC');
		
		$query = $this->db->get('asignaturas');

		if($query->result())
			return $query;

		return FALSE;
	}

	function get_carreras_no_incluido($id_sede  = 1){
		$this->db->select('t1.id_carrera');
		$this->db->order_by('t1.id_carrera', 'ASC');
		$this->db->where("t2.id_sede = $id_sede");
		$query = $this->db->get('carreras as t1, relacion_sede_carrera as t2');

		if($query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
	}

	function get_id_max($facultad, $carrera, $curso){

		$this->db->select('id_asignatura');
		$this->db->order_by('id_asignatura', 'desc');
		$this->db->where("id_facultad = $facultad");
		$this->db->where("id_carrera = $carrera");
		$this->db->where("id_curso = $curso");
		$this->db->limit(1);
		$result = $this->db->get_where('asignaturas');

		foreach($result->result() as $row){
			return $row->id_asignatura;
		}

		return 0;
	}

	function guardar($facultad, $carrera, $curso, $id, $asignatura, $estado){

		$datos = array(
			'id_facultad' => $facultad,
			'id_carrera' => $carrera,
			'id_curso' => $curso,
			'id_asignatura' => $id,
			'asignatura' => $asignatura,
			'estado' => $estado
		);

		$this->db->insert('asignaturas', $datos);
	}

	function eliminar($facultad, $carrera, $curso, $asignatura){
		$datos = array(
			'id_facultad' => $facultad,
			'id_carrera' => $carrera,
			'id_curso' => $curso,
			'id_asignatura' => $asignatura
		);
		return $this->db->delete('asignaturas', $datos);
	}

	function get_correlatividades($id_facultad, $id_carrera, $id_curso = false, $id_asignatura = false, $id_curso2 = false, $id_asignatura2 = false){
			$this->db->select('*'); 
			
			if($id_curso)
				$this->db->where("t1.id_curso1 = $id_curso");

			if($id_asignatura)	
				$this->db->where("t1.id_asignatura1 = $id_asignatura");

			if($id_curso2)
				$this->db->where("t1.id_curso2 = $id_curso2");

			if($id_asignatura2)	
				$this->db->where("t1.id_asignatura2 = $id_asignatura2");

			$this->db->where("t1.id_facultad = $id_facultad");
			$this->db->where("t1.id_carrera = $id_carrera");
//			$this->db->where("t1.id_semestre1 = $id_semestre");
//			$this->db->where("t1.id_asignatura1 = $id_asignatura");

			$this->db->join('asignaturas as t2', 't2.id_facultad = t1.id_facultad and t2.id_carrera = t1.id_carrera and t2.id_curso = t1.id_curso2 and t2.id_asignatura = t1.id_asignatura2');
			$this->db->join('cursos as t3', 't3.id_facultad = t1.id_facultad and t3.id_carrera = t1.id_carrera and t3.id_curso = t1.id_curso2');
			$query = $this->db->get('correlatividades as t1');

			if($query->result())
				return $query;

		return FALSE;
	}

	function guardar_correlatividad($facultad, $carrera, $curso1, $asignatura1, $curso2, $asignatura2, $estado){

		$datos = array(
			'id_facultad' => $facultad,
			'id_carrera' => $carrera,
			'id_curso1' => $curso1,
			'id_asignatura1' => $asignatura1,
			'id_curso2' => $curso2,
			'id_asignatura2' => $asignatura2,
			'estado' => $estado
		);

		if($this->db->insert('correlatividades', $datos))
			return true;

		return false;
	}
/*
	function existe_correlatividad($facultad, $carrera, $semestre1, $asignatura1, $semestre2, $asignatura2){
		$datos =  array(
			'id_facultad' => $facultad,
			'id_carrera' => $carrera,
			'id_semestre1' => $semestre1,
			'id_asignatura1' => $asignatura1,
			'id_semestre2' => $semestre2,
			'id_asignatura2' => $asignatura2
		);

		$result = $this->db->get_where('correlatividades', $datos);

		if($result->num_rows > 0)
			return true;

		return false;
	}
*/	
	function eliminar_correlatividad($facultad, $carrera, $curso1, $asignatura1, $curso2, $asignatura2){
		$datos = array(
			'id_facultad' => $facultad,
			'id_carrera' => $carrera,
			'id_curso1' => $curso1,
			'id_asignatura1' => $asignatura1,
			'id_curso2' => $curso2,
			'id_asignatura2' => $asignatura2,
		);

		return $this->db->delete('correlatividades', $datos);
	}
}
?>