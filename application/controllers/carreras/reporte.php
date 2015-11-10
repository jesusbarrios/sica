<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte extends CI_Controller {

	function __construct(){

		parent::__construct();

		$this->load->model('m_carreras', 'carreras', TRUE);
		$this->load->model('m_sedes', 'sedes', TRUE);

		if(!$this->session->userdata('logged_in'))
			redirect('', 'refresh');
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$carreras = $this->carreras->get_carrera($id_facultad);

		$lista = $this->load->view('carreras/reporte_detalle', array('carreras' => $carreras), TRUE);
		$this->load->view('carreras/reporte', array('lista' => $lista), FALSE);
	}
}