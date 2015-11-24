<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crear extends CI_Controller {

	function __construct(){

		parent::__construct();

		$this->load->model('m_facultades', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);
		$this->load->model('m_asignaturas', '', TRUE);
		$this->load->model('m_inscripciones_curso', '', TRUE);
//		$this->load->model('m_inscripcion', '', TRUE);

		if(!$this->session->userdata('logged_in')){

			redirect('', 'refresh');			

		}

	}
	
	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$this->form_validation->set_rules('txt_carrera', 'Carrera', 'required|min_length[10]|max_length[100]|callback_es_unico');
		$this->form_validation->set_rules('txt_cursos', 'Cursos', 'required|min_length[0]|max_length[3]|is_natural');
		
		$this->form_validation->set_message('required', 'El campo es obligatorio');
		$this->form_validation->set_message('min_length', 'Debe contener un minimo de 10 caracteres');
		$this->form_validation->set_message('max_length', 'Debe contener un máximo de 100 caracteres');
		$this->form_validation->set_message('es_unico', 'Esta carrera ya existe');
		$this->form_validation->set_message('is_natural', 'Debe contener un número positivo');

		$carrera = $this->input->post('txt_carrera');
		
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1){
				$this->form_validation->set_rules('slc_facultad', 'Facultad', 'required');
				$id_facultad = $this->input->post('slc_facultad');
			}else{
				$id_facultad = $session_data["id_facultad"];
			}
		}
		
		if ($this->form_validation->run()){
			$cantidad_curso = $this->input->post('txt_cursos');
			$estado = '1';
			
			$this->m_carreras->guardar($id_facultad, $carrera, $estado, $cantidad_curso);
			
			$msn = 'La carrera se agrego exitosamente';
			
		}else{
			$msn = false;
		}
		
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1){
				$facultades = $this->m_facultades->get_facultades();
				if($facultades && $facultades->num_rows() == 1){
					$facultades_ = $facultades->row_array();
					$carreras = $this->m_carreras->get_carreras($facultades_['id_facultad']);	
				}else if($facultades && $id_facultad){
					$carreras = $this->m_carreras->get_carreras($id_facultad);	
				}else{
					$carreras = false;
				}
			}else{
				$facultades = false;
				$carreras = $this->m_carreras->get_carreras($session_data["id_facultad"]);	
			}
		}
		
		
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
	
	function es_unico($carrera){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1){
				$id_facultad = $this->input->post('slc_facultad');
				$carreras = $this->m_carreras->get_carreras($id_facultad, false, $carrera);
			}else{
				$carreras = $this->m_carreras->get_carrera($session_data["id_facultad"], false, $carrera);
			}
		}
		if($carreras)
			return false;
		return true;
	}	
	
	function actualizar_detalle($retorno = false){
		$id_facultad = $this->input->post('id');
		$carreras = $this->m_carreras->get_carreras($id_facultad);
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
		$this->m_carreras->eliminar($id_facultad, $id_carrera);
		$carreras = $this->m_carreras->get_carreras($id_facultad);
		$datos = array(
			'carreras' => $carreras,
			'msn' => 'Se elimino exitosamente',
		);
		$this->load->view('carreras/frm_crear_detalle', $datos, FALSE);
	}
}