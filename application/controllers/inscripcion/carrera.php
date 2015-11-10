<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carrera extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('m_carrera', '', TRUE);
		$this->load->model('m_sede', '', TRUE);
		
		if(!$this->session->userdata('logged_in')){

			redirect('home', 'refresh');			


		}else{
		
			$this->load->view('header', FALSE);
			$this->load->view('menu', FALSE);
			
		}
	}

	function index(){
	
		$sedes = $this->m_sede->get_sedes();
		$carreras = $this->m_carrera->get_carreras();
		
		$datos = array(
			'sedes' => $sedes,
			'carreras' => $carreras);

		$this->load->view('inscripcion/v_carrera', $datos, FALSE);

	}
	
	function guardar(){
		return NULL;
	}
}