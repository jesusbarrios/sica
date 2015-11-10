<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crear extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('m_sedes', 'sedes', TRUE);
		
		if(!$this->session->userdata('logged_in'))
			redirect('', 'refresh');
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$this->form_validation->set_rules('txt_sede', 'Sedes', 'required|min_length[10]|max_length[45]|callback_validar');
		
		$this->form_validation->set_message('required', 'El campo es obligatorio');
		$this->form_validation->set_message('min_length', 'Debe contener un minimo de 10 caracteres');
		$this->form_validation->set_message('max_length', 'Debe contener un máximo de 45 caracteres');
		$this->form_validation->set_message('validar', 'Esta sede ya existe');
		
		if($this->form_validation->run()){

/*			$session_data = $this->session->userdata('logged_in');
			$id_facultad = $session_data["id_facultad"];
			$id =  $this->sedes->get_id_max() + 1;
*/
			$estado = '1';
			$sede = $this->input->post('txt_sede');
			$this->sedes->guardar($sede, $estado);
			$mensaje = 'Se cargo exitosamente';
		}else{
			$mensaje = false;
		}
		$sedes = $this->sedes->get_sede();
		$datos = array(
			'sedes' 	=> $sedes,
			'msn'		=> false,
		);
		$detalle = $this->load->view('sedes/frm_detalle', $datos, TRUE);
		$datos = array(
			'msn' => $mensaje,
			'detalle' => $detalle,
		);
		$this->load->view('sedes/frm_crear', $datos, FALSE);
	}
	
	function actualizar_detalle($retorna = false){
/*		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
*/		$sedes = $this->sedes->get_sede();
		$datos = array(
			'sedes' => $sedes,
			'msn' => $msn,
		);
		if($retorna)
			return $this->load->view('sedes/frm_detalle', $datos, TRUE);
		else
			$this->load->view('sedes/frm_detalle', $datos, FALSE);
	}
	
	function validar($sede){
		if($this->sedes->get_sede(false, $sede))
			return false;
		return true;
	}
	
	function obtener_nombre(){
		$id_sede = $this->input->post('slc_sede');
		$sedes = $this->sedes->get_sede($id_sede);
		
		if($sedes){
			$sedes_ = $sedes->row_array();
			echo $sedes_['sede'];
		}else{
			echo '';
		}
	}
	
	function eliminar(){
		$id = $this->input->post('id_sede');
		$sedes = $this->sedes->get_sede($id);
		if($sedes){
			$sedes_ = $sedes->row_array();
			$sede 	=  $sedes_['sede'];
		}else{
			echo '';
		}
		$this->sedes->eliminar($id);
		$sedes = $this->sedes->get_sede();
		$datos = array(
			'sedes' 	=> $sedes,
			'msn'		=> $sede . ' se elimino exitosamente',
		);
		$this->load->view('sedes/frm_detalle', $datos, FALSE);
	}
}