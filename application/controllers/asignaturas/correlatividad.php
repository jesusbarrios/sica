<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Correlatividad extends CI_Controller {

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
	function reporte(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		
		$carreras 	= $this->carreras->get_carrera($id_facultad);
		$this->load->view('asignaturas/reporte', array('carreras' => $carreras), FALSE);

	}
*/	
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
	
/*	function actualizar_lista($carrera, $semestre, $list_msn = false, $list_msn_class = false){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$asignaturas = $this->asignaturas->get_asignatura($id_facultad, $carrera, $semestre);
		
		$datos = array(
			'asignaturas' => $asignaturas,
			'list_msn' => $list_msn,
			'list_msn_class' => $list_msn_class
		);
		
		echo $this->load->view('asignaturas/lista', $datos, FALSE);
		
	}
*/	

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
*/	
	
	
	function validar_existencia($id_asignatura2){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_carrera = $this->input->post('slc_carrera');
		$id_semestre1 = $this->input->post('slc_semestre');
		$id_asignatura1 = $this->input->post('slc_asignatura');
		$id_semestre2 = $this->input->post('slc_semestre_correlativo');
		$id_asignatura2 = $this->input->post('slc_asignatura_correlativa');
	
		$asignaturas_correlativas = $this->asignaturas->get_correlatividad($id_facultad, $id_carrera, $id_semestre1, $id_asignatura1, $id_semestre2, $id_asignatura2);
		
		if($asignaturas_correlativas)
			return false;
		return true;
	}

	

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$this->form_validation->set_rules('slc_carrera', 'Carrera', 'required');
		$this->form_validation->set_rules('slc_semestre', 'Semestre', 'required');
		$this->form_validation->set_rules('slc_asignatura', 'Asignatura', 'required');
		$this->form_validation->set_rules('slc_semestre_correlativo', 'Semestre correlativo', 'required');
		$this->form_validation->set_rules('slc_asignatura_correlativa', 'Asignatura correlativa', 'required|callback_validar_existencia');
		
//		$this->form_validation->set_rules('txt_asignatura', 'Asignatura', 'required|min_length[5]|max_length[100]|callback_es_unico');
		
		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
		$this->form_validation->set_message('validar_existencia', 'La correlatividad ya existe');

		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_carrera = $this->input->post('slc_carrera');
		$id_semestre1 = $this->input->post('slc_semestre');
		$id_asignatura1 = $this->input->post('slc_asignatura');

		$id_semestre2 = $this->input->post('slc_semestre_correlativo');
		$id_asignatura2 = $this->input->post('slc_asignatura_correlativa');

		$msn = false;

		if ($this->form_validation->run()){
			
			$estado = '1';
			
			
//			$result = $this->asignaturas->existe_correlatividad($id_facultad, $id_carrera, $id_semestre1, $id_asignatura1, $id_semestre2, $id_asignatura2);

//			if($result){
//				$frm_msn = 'No se pudo cargar la correlatividad por que ya existe';
//			}else{
				$this->asignaturas->guardar_correlatividad($id_facultad, $id_carrera, $id_semestre1, $id_asignatura1, $id_semestre2, $id_asignatura2, $estado);
				$msn = 'Se cargo exitosamente';
//			}
		}

		$carreras = $this->carreras->get_carrera($id_facultad);
		if($id_carrera)
			$semestres = $this->carreras->get_semestre($id_facultad, $id_carrera);
		else
			$semestres = false;
		
		if($id_semestre1)
			$asignaturas = $this->asignaturas->get_asignatura($id_facultad, $id_carrera, $id_semestre1);
		else
			$asignaturas = false;
		
		if($id_semestre2)
			$asignaturas_anteriores = $this->asignaturas->get_asignatura($id_facultad, $id_carrera, $id_semestre2);
		else
			$asignaturas_anteriores = false;
		
		if($asignaturas_anteriores)	
			$asignaturas_correlativas = $this->asignaturas->get_correlatividad($id_facultad, $id_carrera, $id_semestre1, $id_asignatura1);
		else
			$asignaturas_correlativas = false;
		
		$datos = array(
			'correlatividades' => $asignaturas_correlativas,
			'list_msn' => false,
			'list_msn_class' => false
		);
		
		$detalle = $this->load->view('asignaturas/frm_correlatividad_detalle', $datos, TRUE);

		$datos = array(
				'detalle' => $detalle,
				'carreras' => $carreras,
				'semestres' => $semestres,
				'asignaturas' => $asignaturas,
				'asignaturas_anteriores' => $asignaturas_anteriores,
				'msn' => $msn,
			);

			$this->load->view('asignaturas/frm_correlatividad', $datos, FALSE);
			
	}
	
	function actualizar_slc_semestre(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$carrera = $this->input->post('slc_carrera');
		$semestre = $this->input->post('slc_semestre');

		$semestres = $this->carreras->get_semestre($id_facultad, $carrera);

		$opciones = "<option value=null>-----</option>";

		if($semestres){
			foreach($semestres->result() as $row){
				if($semestre){
					if($row->id_semestre > 0 && $row->id_semestre < $semestre)
						$opciones .= "<option value=$row->id_semestre>$row->semestre</option>";	
				}else{
					if($row->id_semestre > 1)
						$opciones .= "<option value=$row->id_semestre>$row->semestre</option>";	
				}
			}
		}
		echo $opciones;
	}


	function actualizar_slc_asignatura(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_carrera = $this->input->post('slc_carrera');
		$id_semestre = $this->input->post('slc_semestre');
		$asignaturas = $this->asignaturas->get_asignatura($id_facultad, $id_carrera, $id_semestre);
		$tag = "<option value=''>-----</option>";
		if($asignaturas){
			foreach($asignaturas->result() as $row){
				$tag .= "<option value=" . $row->id_asignatura . ">" . $row->asignatura . "</option>";
			}
		}
		echo $tag;
	}

	function actualizar_detalle_correlatividad(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_carrera = $this->input->post('slc_carrera');
		$id_semestre = $this->input->post('slc_semestre');
		$id_asignatura = $this->input->post('slc_asignatura');
		$asignatura2 = $this->input->post('asignatura2');

		$correlatividades = $this->asignaturas->get_correlatividad($id_facultad, $id_carrera, $id_semestre, $id_asignatura);

		$datos = array(
			'correlatividades' => $correlatividades,
		);
		$this->load->view('asignaturas/frm_correlatividad_detalle', $datos, FALSE);
	}
		
	function obtener_nombre_asignatura($id_semestre2, $id_asignatura2){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_carrera = $this->input->post('slc_carrera');
		$asignaturas = $this->asignaturas->get_asignatura($id_facultad, $id_carrera, $id_semestre2, $id_asignatura2);
		$row = $asignaturas->row_array();
		echo $row['asignatura'];
	}
 
	function eliminar_correlatividad($id_semestre2, $id_asignatura2){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_carrera = $this->input->post('slc_carrera');
		$id_semestre1 = $this->input->post('slc_semestre1');
		$id_asignatura1 = $this->input->post('slc_asignatura1');

		$asignaturas = $this->asignaturas->get_asignatura($id_facultad, $id_carrera, $id_semestre2, $id_asignatura2);		

		$this->asignaturas->eliminar_correlatividad($id_facultad, $id_carrera, $id_semestre1, $id_asignatura1, $id_semestre2, $id_asignatura2);
	}
}