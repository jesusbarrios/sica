<?php

class M_cursos extends CI_Model{

	function get_cursos($id_facultad = false, $id_carrera = false, $id_curso = false, $curso = false, $tipo_curso = false, $estado = false){
		if($id_facultad)
			$this->db->where('id_facultad', $id_facultad);
		if($id_carrera)
			$this->db->where('id_carrera', $id_carrera);
		if($id_curso)
			$this->db->where('id_curso', $id_curso);
		if($curso)
			$this->db->where('curso', $curso);
		if($tipo_curso)
			$this->db->where('tipo_curso', $tipo_curso);
		if($estado)
			$this->db->where('estado', $estado);
		$this->db->order_by('cursos.id_curso', 'asc');
		$cursos = $this->db->get('cursos');

		if($cursos->result())
			return $cursos;
		return FALSE;
	}

	function insert_cursos($id_facultad, $id_carrera, $curso, $tipo, $estado){
		$this->db->select_max('t1.id_curso');
		$this->db->where('t1.id_facultad', $id_facultad);
		$this->db->where('t1.id_carrera', $id_carrera);
		$cursos = $this->db->get('cursos as t1');
		if($cursos){
			$cursos_ = $cursos->row_array();
			$id_curso = $cursos_['id_curso'] + 1;
		}else
			$id_curso = 1;

		$datos = array(
			'id_facultad' 	=> $id_facultad,
			'id_carrera' 	=> $id_carrera,
			'id_curso' 		=> $id_curso,
			'curso' 		=> $curso,
			'tipo_curso'	=> $tipo,
			'estado' 		=> $estado,
		);

		$this->db->insert('cursos', $datos);
	}

	function delete_cursos($id_facultad, $id_carrera, $id_curso){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_carrera', $id_carrera);
		$this->db->where('id_curso', $id_curso);
		$cursos = $this->db->delete('cursos');
		if($cursos)
			return true;
		return false;
	}
}
?>