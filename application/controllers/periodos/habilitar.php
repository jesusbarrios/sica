<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Habilitar extends CI_Controller {

	function __construct(){

		parent::__construct();

		$this->load->model('m_carreras', 'carreras', TRUE);
		$this->load->model('m_sedes', 'sedes', TRUE);

		if(!$this->session->userdata('logged_in')){

			redirect('', 'refresh');			

		}
	}

	function actualizar_detalle($retornar = false){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_sede = $this->input->post('slc_sede');
		$sede = $this->input->post('sede');
		$carrera = $this->input->post('carrera');

		$relaciones = $this->carreras->get_carrera($id_facultad, $id_sede);
		
		$msn = false;
		if($sede)
			$msn = "La relación entre <b>$sede</b> y <b>$carrera</b> se elimino exitosamente";
		
		$datos = array(
			'relaciones' => $relaciones,
			'msn' => $msn,
		);

		if($retornar)
			return $this->load->view('carreras/frm_habilitar_detalle', $datos, TRUE);

		$this->load->view('carreras/frm_habilitar_detalle', $datos, FALSE);

	}

	function validar_relacion_sede_carrera($id_carrera){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_sede = $this->input->post('slc_sede');
		
		$result = $this->carreras->get_carrera($id_facultad, $id_sede, $id_carrera);

		if($result)
			return false;

		return true;
	}
	
	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$this->form_validation->set_rules('slc_sede', 'Sede', 'required');
		$this->form_validation->set_rules('slc_carrera', 'Carrera', 'required|callback_validar_relacion_sede_carrera');
		
		$this->form_validation->set_message('required', 'El campo es obligatorio');
		$this->form_validation->set_message('validar_relacion_sede_carrera', 'Esta relacion ya existe');
		$mensaje = false;
		
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		
		$sedes 	= $this->sedes->get_sede($id_facultad);
		$carreras = $this->carreras->get_carrera($id_facultad);
		$id_sede = $this->input->post('slc_sede');
		$msn = false;

		if ($this->form_validation->run()){
			
			$id_carrera = $this->input->post('slc_carrera');

			$this->carreras->save_relacion_sede_carrera($id_facultad, $id_sede, $id_carrera);
			
			$msn = 'Se guardo exitosamente';
			
		}
		$detalles = '';
		if($id_sede)
			$detalles = $this->actualizar_detalle(TRUE);
		
		$datos = array(
			'sedes' => $sedes,
			'carreras' => $carreras,
			'msn' => $msn,
			'detalles' => $detalles,
		);

		$lista = $this->load->view('carreras/frm_habilitar', $datos, FALSE);
	}
	
	function obtener_nombre(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_sede = $this->input->post('id_sede');
		$id_carrera = $this->input->post('id_carrera');
		
		$sedes = $this->carreras->get_sede($id_facultad, $id_sede);
		$row = $sedes->row_array();
		$sede = $row['ciudad'];
		
		$carreras = $this->carreras->get_carrera($id_facultad, false, $id_sede);
//		$row = $carreras->row_array();
//		$carrera = $row['carrera'];

		$sede = 'si';
		$carrera = 'si2';
		$datos = array(
			'sede' => $sede,
			'carrera' => $carrera,
		);
		echo json_encode($datos);
	}
	
	function eliminar(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_sede = $this->input->post('id_sede');
		$id_carrera = $this->input->post('id_carrera');
		
		$this->carreras->eliminar_relacion_sede_carrera($id_facultad, $id_sede, $id_carrera);
	}
	
	
}