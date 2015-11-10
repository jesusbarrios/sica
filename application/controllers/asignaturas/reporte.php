<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte extends CI_Controller {

	function __construct(){

		parent::__construct();

		$this->load->model('m_carreras', 'carreras', TRUE);
		$this->load->model('m_sedes', 'sedes', TRUE);
		$this->load->model('m_asignaturas', 'asignaturas', TRUE);

		if(!$this->session->userdata('logged_in')){

			redirect('', 'refresh');			

		}

	}
	/*
	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		

		$this->form_validation->set_rules('slc_carrera', 'Carrera', 'required');
		$this->form_validation->set_rules('slc_semestre', 'Semestre', 'required');
		$this->form_validation->set_rules('txt_asignatura', 'Asignatura', 'required|min_length[5]|max_length[100]|callback_es_unico');
		
		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
		$this->form_validation->set_message('min_length', 'Debe contener un minimo de 10 caracteres');
		$this->form_validation->set_message('max_length', 'Debe contener un máximo de 100 caracteres');
		$this->form_validation->set_message('es_unico', 'Esta asignatura ya existe');

		$carrera = $this->input->post('slc_carrera');
		$semestre = $this->input->post('slc_semestre'); 
		
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		 
		$frm_msn = $frm_msn_class = false;
		
		if ($this->form_validation->run()){
			$id =  $this->asignaturas->get_id_max($id_facultad, $carrera, $semestre) + 1;
			$asignatura = $this->input->post('txt_asignatura');
			$estado = '1';

			$this->asignaturas->guardar($id_facultad, $carrera, $semestre, $id, $asignatura, $estado);

			$frm_msn = 'Se cargo exitosamente';
			$frm_msn_class = 'ok';
		}
		
		$carreras = $this->carreras->get_carrera($id_facultad);

		$semestres = ($carrera)? $this->carreras->get_semestre($id_facultad, $carrera) : false;

		$datos = array(
			'carreras' => $carreras,
			'semestres' => $semestres,
			'frm_msn' => $frm_msn,
			'frm_msn_class' => $frm_msn_class,
		);

		$this->load->view('asignaturas/formulario_crear', $datos, FALSE);
	}
	*/

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		
		$carreras 	= $this->carreras->get_carrera($id_facultad);
		$this->load->view('asignaturas/reporte', array('carreras' => $carreras), FALSE);

	}
/*	
	function es_unico($asignatura){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$carrera = $this->input->post('slc_carrera');
		$semestre = $this->input->post('slc_semestre'); 
		
		if($this->asignaturas->existe_asignatura($id_facultad, $carrera, $semestre, $asignatura))
			return false;
			
		return true;
	}
*/	

	function actualizar_lista($list_msn = false, $list_msn_class = false){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$carrera = $this->input->post('slc_carrera');
		$semestre = $this->input->post('slc_semestre');
		
		$asignaturas = $this->asignaturas->get_asignatura($id_facultad, $carrera, $semestre);
		
		$datos = array(
			'asignaturas' => $asignaturas,
			'list_msn' => $list_msn,
			'list_msn_class' => $list_msn_class
		);
		
		echo $this->load->view('asignaturas/lista', $datos, FALSE);
	}

	function actualizar_slc_semestre(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$carrera = $this->input->post('slc_carrera');

		$semestres = $this->carreras->get_semestre($id_facultad, $carrera);

		$opciones = "<option value=null>-----</option>";

		if($semestres){
			foreach($semestres->result() as $row)
				$opciones .= "<option value=$row->id_semestre>$row->semestre</option>";	
		}

		echo $opciones;
	}
/*	
	function eliminar($carrera, $semestre, $asignatura){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		
		$asignaturas = $this->asignaturas->get_asignatura($id_facultad, $carrera, $semestre, $asignatura);		
		$this->asignaturas->eliminar($id_facultad, $carrera, $semestre, $asignatura);
		
		foreach($asignaturas->result() as $row)
			$nombre_asignatura = $row->asignatura;
			
		$list_msn = "La asignatura <b> $nombre_asignatura </b> fue eliminada";
		$list_msn_class = "ok";
		$this->actualizar_lista($carrera, $semestre, $list_msn, $list_msn_class);
	}
	
	function obtener_nombre_asignatura($carrera, $semestre, $asignatura){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$asignatura = $this->asignaturas->get_asignatura($id_facultad, $carrera, $semestre, $asignatura);
		foreach($asignatura->result() as $row)
			echo $row->asignatura;
	}

	

	function correlatividad(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$this->form_validation->set_rules('slc_carrera', 'Carrera', 'required');
		$this->form_validation->set_rules('slc_semestre', 'Semestre', 'required');
		$this->form_validation->set_rules('slc_asignatura', 'Asignatura', 'required');
		$this->form_validation->set_rules('slc_semestre_correlativo', 'Semestre correlativo', 'required');
		$this->form_validation->set_rules('slc_asignatura_correlativa', 'Asignatura correlativa', 'required');
		
//		$this->form_validation->set_rules('txt_asignatura', 'Asignatura', 'required|min_length[5]|max_length[100]|callback_es_unico');
		
		$this->form_validation->set_message('required', 'El campo %s es obligatorio');

		$carrera = $this->input->post('slc_carrera');
		$semestre1 = $this->input->post('slc_semestre');
		$asignatura1 = $this->input->post('slc_asignatura');

		$semestre2 = $this->input->post('slc_semestre_correlativo');
		$asignatura2 = $this->input->post('slc_asignatura_correlativa');

		$frm_msn = $frm_msn_class = $lista = false;

		if ($this->form_validation->run()){
			$session_data = $this->session->userdata('logged_in');
			$id_facultad = $session_data["id_facultad"];
			$estado = '1';
			
			
			$result = $this->asignaturas->existe_correlatividad($id_facultad, $carrera, $semestre1, $asignatura1, $semestre2, $asignatura2);

			if($result){
				$frm_msn = 'No se pudo cargar la correlatividad por que ya existe';
				$frm_msn_class = 'error';
			}else{
				$this->asignaturas->guardar_correlatividad($id_facultad, $carrera, $semestre1, $asignatura1, $semestre2, $asignatura2, $estado);
				$frm_msn = 'Se cargo exitosamente';
				$frm_msn_class = "ok";
			}
		}

		$carreras = $this->carreras->get_carrera($id_facultad);
		$semestres = $this->carreras->get_cantidad_semestre($id_facultad, $carrera);
		$asignaturas = $this->asignaturas->get_asignatura($id_facultad, $carrera, $semestre1);
		$asignaturas_anteriores = $this->asignaturas->get_asignatura($id_facultad, $carrera, $semestre2);
		
		
		
		$asignaturas_correlativas = $this->asignaturas->get_correlatividad($id_facultad, $carrera, $semestre1, $asignatura1);
		
		$datos = array(
			'correlatividades' => $asignaturas_correlativas,
			'list_msn' => false,
			'list_msn_class' => false
		);
		
		$lista = $this->load->view('asignaturas/lista_correlatividad', $datos, TRUE);

		$datos = array(
				'lista' => $lista,
				'carreras' => $carreras,
				'semestres' => $semestres,
				'asignaturas' => $asignaturas,
				'asignaturas_anteriores' => $asignaturas_anteriores,
				'frm_msn' => $frm_msn,
				'frm_msn_class' => $frm_msn_class
			);

			$this->load->view('asignaturas/correlatividad', $datos, FALSE);
	}


	function actualizar_campo_slc_asignatura($carrera, $semestre){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$asignaturas = $this->asignaturas->get_asignatura($id_facultad, $carrera, $semestre);
		$tag = "<option value=''>-----</option>";
		foreach($asignaturas as $row){
			$tag .= "<option value=" . $row->id_asignatura . ">" . $row->asignatura . "</option>";
		}
		echo $tag;
	}

	function actualizar_lista_correlatividad($carrera, $semestre, $asignatura, $list_msn = false, $list_msn_class = false){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$correlatividades = $this->asignaturas->get_correlatividad($id_facultad, $carrera, $semestre, $asignatura);

		$datos = array(
			'correlatividades' => $correlatividades,
			'list_msn' => $list_msn,
			'list_msn_class' => $list_msn_class
		);
		$this->load->view('asignaturas/lista_correlatividad', $datos, FALSE);
	}
 
	function eliminar_correlatividad($carrera, $semestre1, $asignatura1, $semestre2, $asignatura2){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$asignaturas = $this->asignaturas->get_asignatura($id_facultad, $carrera, $semestre2, $asignatura2);		
		$this->asignaturas->eliminar_correlatividad($id_facultad, $carrera, $semestre1, $asignatura1, $semestre2, $asignatura2);

		foreach($asignaturas as $row)
			$nombre_asignatura = $row->asignatura;

		$semestres = array('primer', 'segundo', 'tercer', 'cuarto', 'quinto', 'sexto', 'septimo', 'octavo', 'noveno', 'decimo');
		$list_msn = "La correlatividad con la asignatura <b>$nombre_asignatura del $semestres[$semestre2] semestre</b> fue eliminada!";
		$list_msn_class = "ok";	

		$this->actualizar_lista_correlatividad($carrera, $semestre1, $asignatura1, $list_msn, $list_msn_class);
	}
	*/
}