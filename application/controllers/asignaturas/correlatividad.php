<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Correlatividad extends CI_Controller {

	function __construct(){

		parent::__construct();

		$this->load->model('m_facultades', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);
		$this->load->model('m_cursos', '', TRUE);
		$this->load->model('m_asignaturas', '', TRUE);

		if(!$this->session->userdata('logged_in')){
			redirect('', 'refresh');			
		}

	}

	function validate($id_asignatura2){
		$session_data = $this->session->userdata('logged_in');
		if($session_data['id_rol'] == 1)
			$id_facultad 	= $this->input->post('slc_facultad');
		else if($session_data['id_rol'] == 3)
			$id_facultad 	= $session_data["id_facultad"];
		$id_carrera 	= $this->input->post('slc_carrera');
		$id_curso1 		= $this->input->post('slc_curso1');
		$id_asignatura1 = $this->input->post('slc_asignatura1');
		$id_curso2 		= $this->input->post('slc_curso2');
		$id_asignatura2 = $this->input->post('slc_asignatura2');

		$correlatividades = $this->m_asignaturas->get_correlatividades($id_facultad, $id_carrera, $id_curso1, $id_asignatura1, $id_curso2, $id_asignatura2);
		if($correlatividades)
			return false;
		return true;
	}

	

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$this->form_validation->set_rules('slc_carrera', 'Carrera', 'required');
		$this->form_validation->set_rules('slc_curso1', 'Semestre', 'required');
		$this->form_validation->set_rules('slc_asignatura1', 'Asignatura', 'required');
		$this->form_validation->set_rules('slc_curso2', 'Semestre correlativo', 'required');
		$this->form_validation->set_rules('slc_asignatura2', 'Asignatura correlativa', 'required|callback_validate');
		
//		$this->form_validation->set_rules('txt_asignatura', 'Asignatura', 'required|min_length[5]|max_length[100]|callback_es_unico');
		
		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
		$this->form_validation->set_message('validate', 'La correlatividad ya existe');

		$session_data = $this->session->userdata('logged_in');
		if($session_data['id_rol'] == 1){
			$facultades 	= $this->m_facultades->get_facultades();
			$this->form_validation->set_rules('slc_facultad', 'Facultad', 'required');
			$id_facultad 	= $this->input->post('slc_facultad');
		}else if($session_data['id_rol'] == 3){
			$facultades 	= false;
			$id_facultad 	= $session_data["id_facultad"];
		}
		$id_carrera 	= $this->input->post('slc_carrera');
		$id_curso1 		= $this->input->post('slc_curso1');
		$id_asignatura1 = $this->input->post('slc_asignatura1');

		$id_curso2 		= $this->input->post('slc_curso2');
		$id_asignatura2 = $this->input->post('slc_asignatura2');

		if ($this->form_validation->run()){
			$estado = '1';
			$this->m_asignaturas->insert_correlatividad($id_facultad, $id_carrera, $id_curso1, $id_asignatura1, $id_curso2, $id_asignatura2, $estado);
			$msn 	= 'Se inserto exitosamente';
		}else{
			$msn 	= false;
		}

		if($id_facultad)
			$carreras 	= $this->m_carreras->get_carreras($id_facultad);
		else
			$carreras 	= false;

		if($id_facultad && $id_carrera)
			$cursos 	= $this->m_cursos->get_cursos($id_facultad, $id_carrera);
		else
			$cursos 	= false;
		
		if($id_facultad && $id_carrera && $id_curso1)
			$asignaturas1 = $this->m_asignaturas->get_asignaturas($id_facultad, $id_carrera, $id_curso1);
		else
			$asignaturas1 = false;
		
		if($id_facultad && $id_carrera && $id_curso1 && $id_curso2)
			$asignaturas2 = $this->m_asignaturas->get_asignaturas($id_facultad, $id_carrera, $id_curso2);
		else
			$asignaturas2 = false;
		
		if($id_facultad && $id_carrera && $id_curso1 && $id_asignatura1)	
			$correlatividades = $this->m_asignaturas->get_correlatividades($id_facultad, $id_carrera, $id_curso1, $id_asignatura1);
		else
			$correlatividades = false;
		
		$datos = array(
			'correlatividades' 	=> $correlatividades,
			'msn' 			=> false,
		);
		
		$detalle = $this->load->view('asignaturas/frm_correlatividad_detalle', $datos, TRUE);

		$datos = array(
			'facultades' 	=> $facultades,
			'carreras' 		=> $carreras,
			'cursos' 		=> $cursos,
			'asignaturas1' 	=> $asignaturas1,
			'asignaturas2' 	=> $asignaturas2,
			'msn' 			=> $msn,
			'detalle' 		=> $detalle,
			);

		$this->load->view('asignaturas/frm_correlatividad', $datos, FALSE);
			
	}
	
	function actualizar_slc_carrera(){
		$opciones = '<option value="">-----</option>';
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3)
				$id_facultad = $session_data["id_facultad"];

			if($id_facultad){
				$carreras 	= $this->m_carreras->get_carreras($id_facultad);
				if($carreras)
					foreach($carreras->result() as $row)
						$opciones .= "<option value=$row->id_carrera>$row->carrera</option>";
			}
		}
		echo $opciones;
	}

	function actualizar_slc_curso(){
		$opciones = '<option value="">-----</option>';
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3)
				$id_facultad = $session_data["id_facultad"];
			$id_carrera = $this->input->post('slc_carrera');
			if($id_facultad && $id_carrera){
				$cursos 	= $this->m_cursos->get_cursos($id_facultad, $id_carrera);
				if($cursos)
					foreach($cursos->result() as $row)
						if(isset($_POST['slc_curso']) && $row->id_curso < $this->input->post('slc_curso'))
							$opciones .= "<option value=$row->id_curso>$row->curso</option>";
						else if(!isset($_POST['slc_curso']))
							$opciones .= "<option value=$row->id_curso>$row->curso</option>";
			}
		}
		echo $opciones;
	}

	function actualizar_slc_asignatura(){
		$opciones = '<option value="">-----</option>';
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3)
				$id_facultad = $session_data["id_facultad"];
			$id_carrera = $this->input->post('slc_carrera');
			$id_curso = $this->input->post('slc_curso');

			if($id_facultad && $id_carrera && $id_curso){
				$asignaturas = $this->m_asignaturas->get_asignaturas($id_facultad, $id_carrera, $id_curso);
				if($asignaturas)
					foreach($asignaturas->result() as $row)
						$opciones .= "<option value=$row->id_asignatura>$row->asignatura</option>";
			}
		}
		echo $opciones;
	}

	function actualizar_detalles(){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3)
				$id_facultad = $session_data["id_facultad"];
			$id_carrera = $this->input->post('slc_carrera');
			$id_asignatura = $this->input->post('slc_asignatura');
			if($id_facultad && $id_carrera && $id_asignatura)
				$correlatividades = $this->m_asignaturas->get_correlatividades($id_facultad, $id_carrera, false, $id_asignatura);
			else
				$correlatividades = false;
			$datos = array(
			'correlatividades' 	=> $correlatividades,
			'msn'				=> false,
		);
		$this->load->view('asignaturas/frm_correlatividad_detalle', $datos, FALSE);
		}
	}
		
	function obtener_nombre(){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3)
				$id_facultad = $session_data["id_facultad"];
			$id_carrera 	= $this->input->post('slc_carrera');
			$id_asignatura 	= $this->input->post('slc_asignatura');
			if($id_facultad && $id_carrera && $id_asignatura){
				$asignaturas 	= $this->m_asignaturas->get_asignaturas($id_facultad, $id_carrera, false, $id_asignatura);
				$asignaturas_ 	= $asignaturas->row_array();
				echo $asignaturas_['asignatura'];
			}
		}
	}
 
	function eliminar(){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3)
				$id_facultad = $session_data["id_facultad"];

			$id_carrera 	= $this->input->post('slc_carrera');
			$id_asignatura1 = $this->input->post('slc_asignatura1');
			$id_asignatura2 = $this->input->post('slc_asignatura2');

			if($id_facultad && $id_carrera && $id_asignatura1){
				$this->m_asignaturas->delete_correlatividades($id_facultad, $id_carrera, false, $id_asignatura1, false, $id_asignatura2);
				$correlatividades = $this->m_asignaturas->get_correlatividades($id_facultad, $id_carrera, false, $id_asignatura1);
			}
			else
				$correlatividades = false;
			$datos = array(
				'correlatividades' 	=> $correlatividades,
				'msn'				=> false,
			);
			$this->load->view('asignaturas/frm_correlatividad_detalle', $datos, FALSE);
		}
	}
}