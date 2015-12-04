<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crear extends CI_Controller {

	function __construct(){

		parent::__construct();

		$this->load->model('m_facultades', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);
		$this->load->model('m_cursos', '', TRUE);
		$this->load->model('m_asignaturas', '', TRUE);
		$this->load->model('m_inscripciones', '', TRUE);

		if($session = $this->session->userdata('logged_in')){
			if($session['id_rol'] != 1 && $session['id_rol'] != 3)
				redirect('', 'refresh');			
		}else
			redirect('', 'refresh');
	}
	
	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$this->form_validation->set_rules('slc_carrera', 'Carrera', 'required');
		$this->form_validation->set_rules('slc_curso', 'Curso', 'required');
		$this->form_validation->set_rules('txt_codigo', 'Código', 'required|max_length[15]|callback_code_validate');
		$this->form_validation->set_rules('txt_asignatura', 'Asignatura', 'required|max_length[100]|callback_name_validate');
	
		$this->form_validation->set_message('required', 'El campo es obligatorio');
		$this->form_validation->set_message('max_length', 'Debe contener un máximo de 100 caracteres');
		$this->form_validation->set_message('code_validate', 'El codigo ya existe!');
		$this->form_validation->set_message('name_validate', 'El nombre ya existe!');

		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1){
				$facultades = $this->m_facultades->get_facultades();
				$this->form_validation->set_rules('slc_facultad', 'Facultad', 'required');
				$id_facultad = $this->input->post('slc_facultad');
			}else{
				$facultades = false;
				$id_facultad = $session_data["id_facultad"];
			}
		}

		$id_carrera = $this->input->post('slc_carrera');
		$id_curso = $this->input->post('slc_curso');
		
		if ($this->form_validation->run()){
			$codigo 	= $this->input->post('txt_codigo');
			$asignatura = $this->input->post('txt_asignatura');
			$estado 	= '1';
			
			$this->m_asignaturas->insert_asignaturas($id_facultad, $id_carrera, $id_curso, $codigo, $asignatura, $estado);
			
			$msn = 'La asignatura se insertó exitosamente';
			
		}else
			$msn = false;
		
		if($id_facultad)
			$carreras = $this->m_carreras->get_carreras($id_facultad);	
		else
			$carreras = false;

		if($id_facultad && $id_carrera)
			$cursos = $this->m_cursos->get_cursos($id_facultad, $id_carrera);
		else
			$cursos = false;

		if($id_facultad && $id_carrera && $id_curso)
			$asignaturas = $this->m_asignaturas->get_asignaturas($id_facultad, $id_carrera, $id_curso);
		else
			$asignaturas = false;
		
		
		$datos = array(
			'asignaturas' 	=> $asignaturas,
			'msn' 			=> false,
		);
		$detalle = $this->load->view('asignaturas/frm_crear_detalle', $datos, TRUE);

		$datos = array(
			'facultades'=> $facultades,
			'carreras'	=> $carreras,
			'cursos'	=> $cursos,
			'detalle' 	=> $detalle,
			'msn' 		=> $msn,
		);

		$this->load->view('asignaturas/frm_crear', $datos, FALSE);
	}

	function code_validate($codigo){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3)
				$id_facultad = $session_data["id_facultad"];
			$asignaturas 	= $this->m_asignaturas->get_asignaturas($id_facultad, false, false, false, $codigo);
			if($asignaturas)
				return false;
			return true;
		}
	}
	
	function name_validate($nombre){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3)
				$id_facultad = $session_data["id_facultad"];

			$id_carrera 	= $this->input->post('slc_carrera');
			$asignaturas 	= $this->m_asignaturas->get_asignaturas($id_facultad, $id_carrera, false, false, false, $nombre);
			if($asignaturas)
				return false;
			return true;
		}
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
						$opciones .= "<option value=$row->id_curso>$row->curso</option>";
			}
		}
		echo $opciones;
	}

	function actualizar_detalle($retorno = false){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data['id_rol'] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else
				$id_facultad = $session_data["id_facultad"];		
			$id_carrera = $this->input->post('slc_carrera');
			$id_curso 	= $this->input->post('slc_curso');
			if($id_facultad && $id_carrera && $id_curso)
				$asignaturas= $this->m_asignaturas->get_asignaturas($id_facultad, $id_carrera, $id_curso);
			else
				$asignaturas = false;

			$datos = array(
				'asignaturas' => $asignaturas,
				'msn' => false,
			);
			$this->load->view('asignaturas/frm_crear_detalle', $datos, FALSE);
		}
	}
	
	function obtener_nombre(){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data['id_rol'] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else
				$id_facultad = $session_data["id_facultad"];		
			$id_carrera 	= $this->input->post('slc_carrera');
			$id_curso 		= $this->input->post('slc_curso');
			$id_asignatura 	= $this->input->post('id');
			$asignaturas 	= $this->m_asignaturas->get_asignaturas($id_facultad, $id_carrera, $id_curso, $id_asignatura);
			if($asignaturas){
				$asignaturas_ = $asignaturas->row_array();
				echo $asignaturas_['asignatura'];
			}
		}
	}
	
	function eliminar(){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data['id_rol'] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else
				$id_facultad = $session_data["id_facultad"];		
			$id_carrera 	= $this->input->post('slc_carrera');
			$id_curso 		= $this->input->post('slc_curso');
			$id_asignatura 	= $this->input->post('id');
			$this->m_asignaturas->delete_asignaturas($id_facultad, $id_carrera, $id_curso, $id_asignatura);
			$asignaturas 	= $this->m_asignaturas->get_asignaturas($id_facultad, $id_carrera, $id_curso);
			$datos = array(
				'asignaturas' => $asignaturas,
				'msn' => 'Se elimino exitosamente',
			);
			$this->load->view('asignaturas/frm_crear_detalle', $datos, FALSE);
		}
	}
}