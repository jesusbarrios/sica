<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lista_cpi extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('m_sede', '', TRUE);
		$this->load->model('m_carrera', '', TRUE);		
		$this->load->model('m_tipo_documento', '', TRUE);
		$this->load->model('user', '', TRUE);
		$this->load->model('inscripcion', '', TRUE);
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$id_universidad = 1;
		$id_facultad = 1;
		$id_sede = 1;
		$id_carrera = 1;
		$id_semestre = 0;
		$anho = 2013;
			
		$sedes = $this->m_sede->get_sedes();
		$carreras = $this->m_carrera->get_carreras();
		
		$lista = $this->inscripcion->obtener_lista_cpi($id_universidad, $id_facultad, $id_sede, $id_carrera, $id_semestre, $anho);
		
		$datos = array(
			'sedes' => $sedes,
			'carreras' => $carreras,
			'lista' => $lista);

		$this->load->view('inscripcion/lista_cpi', $datos, FALSE);

	}
	
	function guardar(){
		
				
	}
	
	function eliminar(){
		
	}
}