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
//		$this->load->model('m_inscripcion', '', TRUE);

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
		$this->form_validation->set_rules('txt_curso', 'Curso', 'required|max_length[100]|callback_name_validate');
		$this->form_validation->set_rules('slc_tipo', 'Tipo', 'required');
		
		$this->form_validation->set_message('required', 'El campo es obligatorio');
		$this->form_validation->set_message('max_length', 'Debe contener un máximo de 100 caracteres');
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
		
		if ($this->form_validation->run()){
			$curso 		= $this->input->post('txt_curso');
			$tipo 		= $this->input->post('slc_tipo');
			$estado 	= '1';
			
			$this->m_cursos->insert_cursos($id_facultad, $id_carrera, $curso, $tipo, $estado);
			
			$msn = 'El curso se insertó exitosamente';
			
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
		
		
		$datos = array(
			'cursos' 	=> $cursos,
			'msn' 		=> false,
		);
		$detalle = $this->load->view('cursos/frm_crear_detalle', $datos, TRUE);

		$datos = array(
			'facultades'=> $facultades,
			'carreras'=> $carreras,
			'detalle' 	=> $detalle,
			'msn' 		=> $msn,
		);

		$this->load->view('cursos/frm_crear', $datos, FALSE);
	}
	
	function name_validate($curso){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3)
				$id_facultad = $session_data["id_facultad"];

			$id_carrera = $this->input->post('slc_carrera');
			$cursos = $this->m_cursos->get_cursos($id_facultad, $id_carrera, false, $curso);
			if($cursos)
				return false;
			return true;
		}
	}

	function actualizar_slc_carrera(){
		$opciones = '<option value="">-----</option>';
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data['id_rol'] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else
				$id_facultad = $session_data["id_facultad"];		
			if($id_facultad){
				$carreras 	= $this->m_carreras->get_carreras($id_facultad);
				if($carreras){
					foreach($carreras->result() as $row)
						$opciones .= "<option value=$row->id_carrera>$row->carrera</option>";
				}
			}
		}
		echo $opciones;
	}

	function actualizar_detalle($retorno = false){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data['id_rol'] == 1){
				$id_facultad = $this->input->post('slc_facultad');
			}else{
				$id_facultad = $session_data["id_facultad"];		
			}
			$id_carrera = $this->input->post('slc_carrera');
		}
		if($id_facultad && $id_carrera)
			$cursos = $this->m_cursos->get_cursos($id_facultad, $id_carrera);
		else
			$cursos = false;
		$datos = array(
			'cursos' => $cursos,
			'msn' => false,
		);
		$this->load->view('cursos/frm_crear_detalle', $datos, FALSE);
	}
	
	function obtener_nombre(){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data['id_rol'] == 1){
				$id_facultad = $this->input->post('slc_facultad');
			}else{
				$id_facultad = $session_data["id_facultad"];		
			}
		}
		$id_carrera = $this->input->post('slc_carrera');
		$id_curso 	= $this->input->post('id');
		$cursos 	= $this->m_cursos->get_cursos($id_facultad, $id_carrera, $id_curso);
		if($cursos){
			$cursos_ = $cursos->row_array();
			echo $cursos_['curso'];
		}
	}
	
	function eliminar(){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data['id_rol'] == 1){
				$id_facultad = $this->input->post('slc_facultad');
			}else{
				$id_facultad = $session_data["id_facultad"];		
			}
		}
		$id_carrera = $this->input->post('slc_carrera');
		$id_curso 	= $this->input->post('id');
		$this->m_cursos->delete_cursos($id_facultad, $id_carrera, $id_curso);
		$cursos 	= $this->m_cursos->get_cursos($id_facultad, $id_carrera);
		$datos = array(
			'cursos' => $cursos,
			'msn' => 'Se elimino exitosamente',
		);
		$this->load->view('cursos/frm_crear_detalle', $datos, FALSE);
	}
}