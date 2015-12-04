<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mantenimiento extends CI_Controller {

	function index(){
		$this->load->model('m_carreras');
		$this->load->model('m_cursos');
		$this->load->model('m_asignaturas');
		$id_facultad = 1;
		$contador2 = 0;
		$carreras = $this->m_carreras->get_carreras($id_facultad);
		if($carreras){
			foreach ($carreras->result() as $row) {
				$id_carrera = $row->id_carrera;
				$cursos = $this->m_cursos->get_cursos($id_facultad, $id_carrera);
				$id_asignatura = 1;
				if($cursos){
					foreach ($cursos->result() as $row) {
						$id_curso = $row->id_curso;
						$this->db->where('id_facultad', $id_facultad);
						$this->db->where('id_carrera', $id_carrera);
						$this->db->where('id_semestre', $id_curso);
						$asignaturas = $this->db->get('asignaturas2');
						if($asignaturas){
							foreach ($asignaturas->result() as $row) {
//								$codigo 	= $row->codigo;
								$datos = array(
									'id_facultad' 	=> $id_facultad,
									'id_carrera' 	=> $id_carrera,
									'id_curso'		=> $id_curso,
									'id_asignatura'	=> $id_asignatura,
									'asignatura' => $row->asignatura,
									'codigo'	=> $id_asignatura,
									'estado' 	=> $row->estado,
								);
								$this->db->insert('asignaturas', $datos);
								$id_asignatura ++;
								$contador2 ++;
							}
						}
					}

				}
				echo $id_asignatura . '<br>';
			}
		}
		echo $contador2;
	}
}	
?>