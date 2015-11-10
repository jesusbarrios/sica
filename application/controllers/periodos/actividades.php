<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Actividades extends CI_Controller {

	function __construct(){

		parent::__construct();

		$this->load->model('m_periodo', '', TRUE);
		if(!$this->session->userdata('logged_in'))
			redirect('', 'refresh');			
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$this->form_validation->set_rules('txt_actividad', 'Actividad', 'required|callback_validar');
		$this->form_validation->set_message('required', 'El campo es obligatorio');
		$this->form_validation->set_message('validar', 'Ya existe');
		
		if ($this->form_validation->run()){
			$actividad = $this->input->post('txt_actividad');
			$this->m_periodo->save_actividad($actividad);	
			$msn = "Se cargo exitosamente";
		}else{
			$msn = false;
		}

		$actividades = $this->m_periodo->get_actividad();
		$detalle = $this->load->view('periodos/frm_actividad_detalle', array('actividades' => $actividades), TRUE);

		$datos = array(
			'detalle'	=> $detalle,
			'msn'		=> $msn,
		);

		$this->load->view('periodos/frm_actividad', $datos, FALSE);
	}
	
	function validar($actividad){
		$actividades = $this->m_periodo->get_actividad(false, $actividad);
		if($actividades)
			return false;
		return true;
	}
	
	function eliminar(){
		$id = $this->input->post('id');
		$this->m_periodo->eliminar_actividad($id);

		$actividades = $this->m_periodo->get_actividad();
		$detalle = $this->load->view('periodos/frm_actividad_detalle', array('actividades' => $actividades), FALSE);
	}
/*
	function actualizar_slc_sede(){
		$id_facultad = $this->input->post('slc_facultad');
		$sedes = $this->m_periodo->get_sede($id_facultad);
		$opciones = '';
		if($sedes){
			if($sedes->num_rows() > 1)
				$opciones .= "<option value=''>-----</option>";
			foreach($sedes->result() as $row){
				$opciones .= "<option value=$row->id_sede>$row->sede</option>";
			}
		}else{
			$opciones .= "<option value=''>-----</option>";
		}
		echo $opciones;
	}

	function actualizar_slc_carrera(){
		$id_facultad 	= $this->input->post('slc_facultad');
		$id_sede 	= $this->input->post('slc_sede');
		$carreras = $this->m_periodo->get_carrera($id_facultad, $id_sede);
		$opciones = '';
		if($carreras){
			if($sedes->num_rows() > 1){
				$opciones .= "<option value=''>-----</option>";
				$opciones .= "<option value='todas'>Todas</option>";
			}
			foreach($carreras->result() as $row){
				$opciones .= "<option value=$row->id_carrera>$row->carrera</option>";
			}
		}else{
			$opciones .= "<option value=''>-----</option>";
		}
		echo $opciones;
	}

	function actualizar_slc_semestre(){
		$id_facultad 	= $this->input->post('slc_facultad');
		$id_carrera 	= $this->input->post('slc_carrera');
		$semestres = $this->m_periodo->get_semestre($id_facultad, $id_carrera);
		$opciones = '';
		if($semestres){
			if($semestres->num_rows() > 1){
				$opciones .= "<option value=''>-----</option>";
				$opciones .= "<option value='todos'>Todos</option>";
			}
			foreach($semestres->result() as $row){
				if($row->id_semestre > 1)
					$opciones .= "<option value=$row->id_semestre>$row->semestre</option>";
			}
		}else{
			$opciones .= "<option value=''>-----</option>";
		}
		echo $opciones;
	}

	function actualizar_slc_asignatura(){
		$id_facultad 	= $this->input->post('slc_facultad');
		$id_carrera 	= $this->input->post('slc_carrera');
		$id_semestre	= $this->input->post('slc_semestre');
		$asignaturas 	= $this->m_periodo->get_asignatura($id_facultad, $id_carrera, $id_semestre);
//		echo $asignaturas->num_rows();
		$opciones = '';
		if($asignaturas){
			if($asignaturas->num_rows() > 1){
				$opciones .= "<option value=''>-----</option>";
				$opciones .= "<option value='todas'>Todas</option>";
			}
			foreach($asignaturas->result() as $row){
				$opciones .= "<option value=$row->id_asignatura>$row->asignatura</option>";
			}
		}else{
			$opciones .= "<option value=''>-----</option>";
		}
		echo $opciones;
	}
	
/*
	function es_unico($carrera){
		if($this->carreras->existe_carrera($carrera))
			return false;
			
		return true;
	}	

	function actualizar_detalle($retorno = false){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$carreras = $this->carreras->get_carrera($id_facultad);

		$msn = false;
		$carrera = $this->input->post('carrera');
		if($carrera)
			$msn = "La carrera<b> $carrera </b>se elimino exitosamente";

		$datos = array(
			'carreras' => $carreras,
			'msn' => $msn,
		);
		if($retorno)
			return $this->load->view('carreras/frm_crear_detalle', $datos, TRUE);
		$this->load->view('carreras/frm_crear_detalle', $datos, FALSE);
	}
	
	function obtener_nombre(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_carrera = $this->input->post('id');
		$carreras = $this->carreras->get_carrera($id_facultad, false, $id_carrera);
		if($carreras){
			$row = $carreras->row_array();
			echo $row['carrera'];
		}
	}

	function eliminar(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_carrera = $this->input->post('id');

		$this->carreras->eliminar($id_facultad, $id_carrera);
	}
	*/
}