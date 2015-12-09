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
		
		$this->form_validation->set_rules('txt_carrera', 'Carrera', 'required|max_length[100]|callback_name_validate');
		$this->form_validation->set_rules('txt_codigo', 'Código', 'required|callback_code_validate');
		$this->form_validation->set_rules('slc_tipo', 'Tipo', 'required');
		
		$this->form_validation->set_message('required', 'El campo es obligatorio');
		$this->form_validation->set_message('min_length', 'Debe contener un minimo de 10 caracteres');
		$this->form_validation->set_message('max_length', 'Debe contener un máximo de 100 caracteres');
		$this->form_validation->set_message('code_validate', 'El código ya existe!');
		$this->form_validation->set_message('name_validate', 'El nombre ya existe!');
		$this->form_validation->set_message('is_natural', 'Debe contener un número positivo');

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
		
		if ($this->form_validation->run()){
			$codigo	= $this->input->post('txt_codigo');
			$carrera= $this->input->post('txt_carrera');
			$tipo 	= $this->input->post('slc_tipo');
			$estado = '1';
			$this->m_carreras->insert_carreras($id_facultad, $codigo, $carrera, $tipo, $estado);
			$msn = 'La carrera se insertó exitosamente';
			
		}else
			$msn = false;
		
		if($id_facultad)
			$carreras = $this->m_carreras->get_carreras($id_facultad);	
		else
			$carreras = false;

		$datos = array(
			'carreras' 	=> $carreras,
			'msn' 		=> false,
		);
		$detalle = $this->load->view('carreras/frm_crear_detalle', $datos, TRUE);

		$datos = array(
			'facultades'=> $facultades,
			'detalle' 	=> $detalle,
			'msn' 		=> $msn,
		);

		$this->load->view('carreras/frm_crear', $datos, FALSE);
	}
	
	function name_validate($carrera){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3)
				$id_facultad = $session_data["id_facultad"];

			$carreras = $this->m_carreras->get_carreras($id_facultad, false, false, $carrera);
			if($carreras)
				return false;
			return true;
		}
	}

	function code_validate($codigo){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3)
				$id_facultad = $session_data["id_facultad"];

			$carreras = $this->m_carreras->get_carreras($id_facultad, false, $codigo);
			if($carreras)
				return false;
			return true;
		}
	}	
	
	function actualizar_detalle($retorno = false){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data['id_rol'] == 1){
				$id_facultad = $this->input->post('slc_facultad');
			}else{
				$id_facultad = $session_data["id_facultad"];		
			}
		}
		if($id_facultad)
			$carreras = $this->m_carreras->get_carreras($id_facultad);
		else
			$carreras = false;
		$datos = array(
			'carreras' => $carreras,
			'msn' => false,
		);
		$this->load->view('carreras/frm_crear_detalle', $datos, FALSE);
	}
	
	function obtener_nombre(){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data['id_rol'] == 1){
				$id_facultad = $this->input->post('slc_facultad');
			}else{
				$id_facultad = $session_data["id_facultad"];		
			}
		}
		$id_carrera = $this->input->post('id');
		$carreras = $this->m_carreras->get_carreras($id_facultad, $id_carrera);
		if($carreras){
			$row = $carreras->row_array();
			echo $row['carrera'];
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
		$id_carrera = $this->input->post('id');
		$this->m_carreras->delete_carreras($id_facultad, $id_carrera);
		$carreras = $this->m_carreras->get_carreras($id_facultad);
		$datos = array(
			'carreras' => $carreras,
			'msn' => 'Se elimino exitosamente',
		);
		$this->load->view('carreras/frm_crear_detalle', $datos, FALSE);
	}
}