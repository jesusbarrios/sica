<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte extends CI_Controller {

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
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$sedes = $this->sedes->get_sede($id_facultad);

		$datos = array(
			'sedes' => $sedes
		);

		$this->load->view('sedes/reporte', $datos, FALSE);
	}
/*	
	function obtener_nombre($id){
		echo $this->sedes->obtener_nombre($id);
	}
	
	function eliminar($id){
		echo $this->sedes->eliminar($id);
	}
	
	function actualizar_lista($sede){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		
		$sedes = $this->sedes->get_sede($id_facultad);
		
		$this->load->view('sedes/lista', array('sedes' => $sedes, 'mensaje' => 'La sede ' . $sede . ' fue eliminada'), FALSE);
	}
	*/
}