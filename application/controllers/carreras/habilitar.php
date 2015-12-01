<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Habilitar extends CI_Controller {

	function __construct(){

		parent::__construct();

		$this->load->model('m_facultades', '', TRUE);
		$this->load->model('m_sedes', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);
		$this->load->model('m_inscripciones', '', TRUE);
		$this->load->model('user', '', TRUE);

		if(!$this->session->userdata('logged_in')){

			redirect('', 'refresh');			

		}
	}

	function validar($id_carrera){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_facultad"] == 1)
				$id_facultad = $this->input->post('slc_facultad');
			else
				$id_facultad = $session_data["id_facultad"];
		}
		$id_sede = $this->input->post('slc_sede');
		$result = $this->m_carreras->get_relacion_sede_carrera($id_facultad, $id_sede, $id_carrera);
		if($result)
			return false;
		return true;
	}

	function validar_fecha($date) {
		$ddmmyyy='(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])';
		return (bool) preg_match("/$ddmmyyy$/", $date);
	}
	
	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$this->form_validation->set_rules('slc_sede', 'Sede', 'required');
		$this->form_validation->set_rules('slc_carrera', 'Carrera', 'required|callback_validar');
//		$this->form_validation->set_rules('txt_creacion', 'Fecha', 'required|callback_validar_fecha');

		$this->form_validation->set_message('required', 'El campo es obligatorio');
		$this->form_validation->set_message('validar', 'Esta relacion ya existe');
		$this->form_validation->set_message('validar_fecha', 'La fecha es invalida, respetar el formato YYYY-mm-dd');

		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1){
				$this->form_validation->set_rules('slc_facultad', 'Facultad', 'required');
				$id_facultad = $this->input->post('slc_facultad');
				$facultades = $this->m_facultades->get_facultades();
			}else if($session_data["id_rol"] == 3){
				$id_facultad = $session_data["id_facultad"];
				$facultades = false;
			}
		}
		$id_sede = $this->input->post('slc_sede');
		$id_carrera = $this->input->post('slc_carrera');

		if ($this->form_validation->run()){
			$creacion 	= $this->input->post('txt_creacion');
			$this->m_carreras->save_relacion_sede_carrera($id_facultad, $id_sede, $id_carrera, $creacion, true);
			$msn = 'Se guardo exitosamente';
		}else{
			$msn = false;
		}

		$sedes 	= $this->m_sedes->get_sedes();

		if($id_facultad){
			$carreras = $this->m_carreras->get_carreras($id_facultad, false);
			if($id_sede)
				$relaciones = $this->m_carreras->get_relacion_sede_carrera($id_facultad, $id_sede);
			else
				$relaciones = false;
		}else{
			$relaciones = false;
			$carreras = false;
		}
		
		$datos = array(
			'relaciones'	=> $relaciones,
		);
		$detalles = $this->load->view('carreras/frm_habilitar_detalle', $datos, TRUE);
		
		$datos = array(
			'sedes' => $sedes,
			'facultades'	=> $facultades,
			'carreras' => $carreras,
			'msn' => $msn,
			'detalles' => $detalles,
		);

		$lista = $this->load->view('carreras/frm_habilitar', $datos, FALSE);
	}
	
	function obtener_nombre(){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1) //Desarrollo
				$id_facultad = $this->input->post('scl_facultad');
			else if($session_data["id_rol"] == 3) //Direccion acdemica
				$id_facultad = $session_data["id_facultad"];
		}

		$id_sede = $this->input->post('slc_sede');
		$id_carrera = $this->input->post('slc_carrera');
		
		$sedes = $this->m_sedes->get_sedes($id_sede);
		$sedes_ = $sedes->row_array();
		
		$carreras = $this->m_carreras->get_carreras($id_facultad, $id_carrera);
		$carreras_ = $carreras->row_array();

		$datos = array(
			'sede' => $sedes_['sede'],
			'carrera' => $carreras_['carrera'],
		);

		echo json_encode($datos);

	}
	
	function eliminar(){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1) //Desarrollo
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3) //Direccion acdemica
				$id_facultad = $session_data["id_facultad"];
		}
		$id_sede = $this->input->post('slc_sede');
		$id_carrera = $this->input->post('slc_carrera');
		
		$this->m_carreras->eliminar_relacion_sede_carrera($id_facultad, $id_sede, $id_carrera);
		
		$relaciones = $this->m_carreras->get_relacion_sede_carrera($id_facultad, $id_sede);
		$datos = array(
			'relaciones'	=> $relaciones,
		);
		$this->load->view('carreras/frm_habilitar_detalle', $datos, FALSE);
	}
	
	function cambiar_estado(){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1) //Desarrollo
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data["id_rol"] == 3) //Direccion acdemica
				$id_facultad = $session_data["id_facultad"];
		}
		$id_sede 	= $this->input->post('slc_sede');
		$id_carrera = $this->input->post('slc_carrera');
		$estado 	= $this->input->post('estado');
		
		$this->m_carreras->actualizar_relacion_sede_carrera($id_facultad, $id_sede, $id_carrera, false, $estado);
		
		$relaciones = $this->m_carreras->get_relacion_sede_carrera($id_facultad, $id_sede);
		$datos = array(
			'relaciones'	=> $relaciones,
		);
		$this->load->view('carreras/frm_habilitar_detalle', $datos, FALSE);
	}

	
	function actualizar_slc_carrera(){
		$id_facultad= $this->input->post('slc_facultad');
		if($id_facultad){
			$carreras 	= $this->m_carreras->get_carreras($id_facultad);
			$opciones 	= '';
			if($carreras){
				if($carreras->num_rows() > 1)
					$opciones .= '<option value="">-----</option>';
				foreach($carreras->result() as $row)
					$opciones .= "<option value=$row->id_carrera>$row->carrera</option>";
			}else
				$opciones .= '<option value="">-----</option>';
		}else
			$opciones .= '<option value="">-----</option>';
		
		echo $opciones;
	}
	
	function actualizar_detalle(){
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1) //Desarrollo
				$id_facultad = $this->input->post('slc_facultad');
			else if($session_data['id_rol'] == 3) //Direccion academica
				$id_facultad = $session_data["id_facultad"];	
		}
		$id_sede = $this->input->post('slc_sede');
		if($id_facultad && $id_sede){
			$relaciones = $this->m_carreras->get_relacion_sede_carrera($id_facultad, $id_sede);
			$datos = array(
				'relaciones' => $relaciones,
			);	
			$this->load->view('carreras/frm_habilitar_detalle', $datos, FALSE);
		}else{
			echo '';
		}


	}
}