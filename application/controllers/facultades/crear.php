<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crear extends CI_Controller {

	function __construct(){

		parent::__construct();

		$this->load->model('user');
		$this->load->model('m_facultades', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);
		if($session = $this->session->userdata('logged_in')){
			if($session['id_rol'] != 1)
				redirect('', 'refresh');			
		}else
			redirect('', 'refresh');			
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$this->form_validation->set_rules('txt_facultad', 'Facultad', 'required|min_length[10]|max_length[100]|callback_validar');
		$this->form_validation->set_rules('txt_creacion', 'Creacion', 'required|callback_validar_fecha');
		
		$this->form_validation->set_message('required', 'El campo es obligatorio');
		$this->form_validation->set_message('min_length', 'Debe contener un minimo de 10 caracteres');
		$this->form_validation->set_message('max_length', 'Debe contener un máximo de 100 caracteres');
		$this->form_validation->set_message('validar', 'Esta facultad ya existe');
		$this->form_validation->set_message('validar_fecha', 'La fecha no es válida, respetar el formato YYYY-mm-dd');
		
		if ($this->form_validation->run()){			
			$facultad 	= $this->input->post('txt_facultad');
			$creacion 	= $this->input->post('txt_creacion');
			$this->m_facultades->insert_facultades($facultad, $creacion);
			$msn = 'La facultad se agrego exitosamente';
		}else{
			$msn = false;
		}
		$facultades = $this->m_facultades->get_facultades();
		$datos = array(
			'facultades'=> $facultades,
			'msn'		=> false,
		);
		$detalle = $this->load->view('facultades/frm_crear_detalle', $datos, TRUE);
		$datos = array(
			'detalle' => $detalle,
			'msn' => $msn,
		);
		$this->load->view('facultades/frm_crear', $datos, FALSE);
	}
	
	function validar($facultad){
		if($this->m_facultades->get_facultades(false, $facultad))
			return false;
		return true;
	}	
	function validar_fecha($date) {
		$ddmmyyy='(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])';
		return (bool) preg_match("/$ddmmyyy$/", $date);
	}

	function obtener_nombre(){
		$id_facultad = $this->input->post('id');
		$facultades = $this->m_facultades->get_facultades($id_facultad);
		if($facultades){
			$facultades_ = $facultades->row_array();
			echo $facultades_['facultad'];
		}
	}

	function eliminar(){
		$id_facultad = $this->input->post('id');
		$this->m_facultades->delete_facultades($id_facultad);
		$facultades = $this->m_facultades->get_facultades();
		$datos = array(
			'facultades'=> $facultades,
			'msn'		=> 'La facultad se elimino exitosamente',
		);
		$this->load->view('facultades/frm_crear_detalle', $datos, FALSE);
	}
}