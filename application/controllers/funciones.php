<?php

class Funciones extends CI_controller{

	function __construct(){
	
		parent::__construct();
		$this->load->model('m_carrera', '', TRUE);
		$this->load->model('inscripcion', '', TRUE);

	}

	
	function cargar_slc_carrera(){
	
		$id_sede = $this->input->post('id_sede');
		
		
		$carreras = $this->m_carrera->get_carreras($id_sede);
		
		echo "<option value=->-----</option>";

		foreach($carreras as $row)
			echo "<option value= $row->id_carrera> $row->carrera </option>";
	}
	
	function cargar_lista_semestre(){
		$id_universidad = $this->input->post('id_universidad');
		$id_facultad = $this->input->post('id_facultad');
		$id_sede = $this->input->post('id_sede');
		$id_carrera = $this->input->post('id_carrera');
		$id_semestre = $this->input->post('is_semestre');
		$anho = $this->input->post('anho');
		
		$lista = $this->inscripcion->obtener_lista_cpi($id_universidad, $id_facultad, $id_sede, $id_carrera, $id_semestre, $anho);
		
		$datos = array('lista' => $lista);

		$this->load->view('inscripcion/lista_cpi', $datos, FALSE);

echo 'test';
	}
	
}

?>