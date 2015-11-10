<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inscripcion extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('m_periodo', '', TRUE);
		$this->load->model('m_facultad', '', TRUE);
		$this->load->model('m_sedes', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);
		$this->load->model('m_inscripcion', '', TRUE);
		$this->load->model('m_evaluacion_final', '', TRUE);
		$this->id_actividad = 1;
		$this->id_semestre 	= 1;

		if(!$this->session->userdata('logged_in')){

			redirect('home', 'refresh');			
		}
	}

	function actualizar_slc_facultad(){
		$id_periodo		= $this->input->post('slc_periodo');

		$inscripciones 	= $this->m_inscripcion->get_inscripciones($id_periodo, false, false, false, false, false);

		$slc_facultad 	= '<option value=>-----</option>';
		foreach($inscripciones->result() as $row)
			$slc_facultad 	.= "<option value=$row->id_facultad>$row->facultad</option>";

		echo $slc_facultad;
	}

	function actualizar_slc_sede(){
		$id_periodo		= $this->input->post('slc_periodo');
		$id_facultad	= $this->input->post('slc_facultad');

		$inscripciones 	= $this->m_inscripcion->get_inscripciones($id_periodo, $id_facultad, false, false, false, false);

		$slc_sede 	= '<option value=>-----</option>';
		foreach($inscripciones->result() as $row)
			$slc_sede 	.= "<option value=$row->id_sede>$row->sede</option>";

		echo $slc_sede;
	}

	function actualizar_slc_carrera(){
		$id_periodo		= $this->input->post('slc_periodo');
		$id_facultad	= $this->input->post('slc_facultad');
		$id_sede		= $this->input->post('slc_sede');

		$inscripciones 	= $this->m_inscripcion->get_inscripciones($id_periodo, $id_facultad, $id_sede, false, false, false);

		$slc_carrera 	= '<option value=>-----</option>';
		foreach($inscripciones->result() as $row)
			$slc_carrera 	.= "<option value=$row->id_carrera>$row->carrera</option>";

		echo $slc_carrera;	
	}

	function actualizar_slc_semestre(){
		$id_periodo		= $this->input->post('slc_periodo');
		$id_facultad	= $this->input->post('slc_facultad');
		$id_sede		= $this->input->post('slc_sede');
		$id_carrera		= $this->input->post('slc_carrera');

		$inscripciones 	= $this->m_inscripcion->get_inscripciones($id_periodo, $id_facultad, $id_sede, $id_carrera, false, false);

		$slc_semestre 	= '<option value=>-----</option>';
		foreach($inscripciones->result() as $row)
			$slc_semestre 	.= "<option value=$row->id_semestre>$row->semestre</option>";

		echo $slc_semestre;		
	}

	function actualizar_slc_asignatura(){
		$id_periodo		= $this->input->post('slc_periodo');
		$id_facultad	= $this->input->post('slc_facultad');
		$id_sede		= $this->input->post('slc_sede');
		$id_carrera		= $this->input->post('slc_carrera');
		$id_semestre	= $this->input->post('slc_semestre');

		$inscripciones 	= $this->m_inscripcion->get_inscripciones($id_periodo, $id_facultad, $id_sede, $id_carrera, $id_semestre, false);

		$slc_asignatura 	= '<option value=>-----</option>';
		foreach($inscripciones->result() as $row)
			$slc_asignatura .= "<option value=$row->id_asignatura>$row->asignatura</option>";

		$detalles_inscripcion 	= $this->m_inscripcion->get_detalles_inscripcion($id_periodo, $id_facultad, $id_sede, $id_carrera, $id_semestre, false);		
		$detalle 				= $this->load->view('reportes/inscripcion_detalles', array('detalles_inscripcion' => $detalles_inscripcion), TRUE);
		$datos = array(
			'slc_asignatura'=> $slc_asignatura,
			'detalle'		=> $detalle,
		);
		echo json_encode($datos);		
		
	}
	
	function actualizar_detalle(){
		$id_periodo		= $this->input->post('slc_periodo');
		$id_facultad	= $this->input->post('slc_facultad');
		$id_sede		= $this->input->post('slc_sede');
		$id_carrera		= $this->input->post('slc_carrera');
		$id_semestre	= $this->input->post('slc_semestre');
		$id_asignatura	= $this->input->post('slc_asignatura');

		$detalles_inscripcion 	= $this->m_inscripcion->get_detalles_inscripcion($id_periodo, $id_facultad, $id_sede, $id_carrera, $id_semestre, false);		
		$this->load->view('reportes/inscripcion_detalles', array('detalles_inscripcion' => $detalles_inscripcion), FALSE);
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$periodos 		= $this->m_periodo->get_periodos();

		$datos = array(
			'periodos'		=> $periodos,
		);	
		$this->load->view('reportes/inscripcion_cabecera', $datos, FALSE);
	}
}