<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
//		$this->load->model('m_facultad', '', TRUE);
//		$this->load->model('m_sedes', '', TRUE);
//		$this->load->model('m_carreras', '', TRUE);
//		$this->load->model('m_asignaturas', '', TRUE);
		$this->load->model('user', '', TRUE);
		$this->load->model('m_inscripcion', '', TRUE);
//		$this->load->model('m_calificacion', '', TRUE);
//		$this->load->model('m_oportunidad', '', TRUE);
//		$this->load->model('m_configuracion', '', TRUE);

		if(!$this->session->userdata('logged_in')){
			redirect('home', 'refresh');			
		}
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		if(isset($_POST['btn_cancelar'])){
			$url_actual = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			header("location: $url_actual");	
		}
		
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		
		$sedes = $this->m_inscripcion->get_sede($id_facultad);
		$oportunidades = $this->m_inscripcion->get_oportunidad($id_facultad);
		
		$datos = array(
			'sedes' => $sedes,
			'carreras' => false,
			'semestres' => false,
			'asignaturas' => false,
			'detalles' => false,
			'oportunidades' => $oportunidades,
		);

		$this->load->view('inscripcion/reporte', $datos, FALSE);	
	}

	function actualizar_slc_carrera(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_sede = $this->input->post('slc_sede');

		$carreras = $this->m_inscripcion->get_carrera($id_facultad, $id_sede);

		if($carreras){
			if($carreras->num_rows() > 1){
				$campo_carrera = "<option value=NULL>-----</option>";
				$campo_semestre = "<option value=NULL>-----</option>";
			}else{
				$campo_carrera = "";
				$carrera = $carreras->row_array();
				$semestres = $this->m_inscripcion->get_semestre($id_facultad, $id_sede, $carrera['id_carrera']);
				//SEMESTRES
				if($semestres){
					$campo_semestre = "<option value=NULL>-----</option>";
					foreach($semestres->result() as $row)
						if($row->id_semestre > 0)
							$campo_semestre .= "<option value=" . $row->id_semestre . ">" . $row->semestre . "</option>";	
				}else{
					$campo_semestre = "<option value=NULL>-----</option>";
				}
			}
			foreach($carreras->result() as $row)
				$campo_carrera .= "<option value=" . $row->id_carrera . ">" . $row->carrera . "</option>";
		}else{
			$campo_carrera = "<option value=NULL>-----</option>";
			$campo_semestre = "<option value=NULL>-----</option>";
		}
		$datos['carreras'] = $campo_carrera;
		$datos['semestres'] = $campo_semestre;
		$datos['asignaturas'] = "<option value=NULL>-----</option>";
		echo json_encode($datos);
	}

	function actualizar_slc_semestre(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_sede = $this->input->post('slc_sede');
		$id_carrera = $this->input->post('slc_carrera');

		$slc = "<option value=''>-----</option>";
		$semestres = $this->m_inscripcion->get_semestre($id_facultad, $id_sede, $id_carrera);	
		if($semestres){
			foreach($semestres->result() as $row){
				if($row->id_semestre > 0)
					$slc .= "<option value=$row->id_semestre>$row->semestre</option>";
			}
		}
		$datos['semestres'] = $slc;
		$datos['asignaturas'] = "<option value=NULL>-----</option>";
		echo json_encode($datos);
//		echo $slc;
	}
	
	function actualizar_slc_asignatura(){

		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_sede = $this->input->post('slc_sede');
		$id_carrera = $this->input->post('slc_carrera');
		$id_semestre = $this->input->post('slc_semestre');

		$slc = "<option value=''>-----</option>";

		$asignaturas = $this->m_inscripcion->get_asignatura($id_facultad, $id_sede, $id_carrera, $id_semestre);	
		if($asignaturas){
			foreach($asignaturas->result() as $row){
				$slc .= "<option value=$row->id_asignatura>$row->asignatura</option>";
			}
		}
		echo $slc;
	}

	/*	
	function actualizar_slc_sede($id_facultad){
		$sedes = $this->m_carreras->get_sede($id_facultad);

		$slc = "<option value=''>-----</option>";
		foreach($sedes->result() as $row){
			$slc .= "<option value=$row->id_sede>$row->ciudad</option>";
		}

		echo $slc;
	}
*/	
/*	function validar_inscripcion_cpi($documento){
		if($id_persona = $this->user->existe_documento($documento)){
			$id_facultad = $this->input->post('slc_facultad');
			$id_sede = $this->input->post('slc_sede');
			$id_carrera = $this->input->post('slc_carrera');
			$id_semestre = 0;

			if($this->m_calificacion->get_inscripcion_semestre($id_facultad, $id_sede, $id_carrera, $id_semestre, false, $id_persona))
				return false;
		}

		return true;
	}
*/
	function cargar_detalles($retornar = false){

		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_sede = $this->input->post('slc_sede');
		$id_carrera = $this->input->post('slc_carrera');
		$id_semestre = $this->input->post('slc_semestre');
		$periodo = 2015;
		$id_persona = false;
		$id_asignatura = $this->input->post('slc_asignatura');
		$oportunidad = $this->input->post('slc_oportunidad');
		$inscripciones = $this->m_inscripcion->get_inscripcion_evaluacion_final($id_facultad, $id_sede, $id_carrera, $id_semestre, $periodo, $id_persona, $id_asignatura, $oportunidad);
		
		$datos = array(
			'inscripciones' => $inscripciones,
		);

//		if($retornar)
//			return $this->load->view('inscripcion/reporte_detalles', $datos, TRUE);
//		else
			$this->load->view('inscripcion/reporte_detalles', $datos, FALSE);
//echo date('s');
	}
}