<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crear extends CI_Controller {

	function __construct(){

		parent::__construct();

		$this->load->model('m_carreras', 'carreras', TRUE);
		$this->load->model('m_sedes', 'sedes', TRUE);
		$this->load->model('m_asignaturas', 'asignaturas', TRUE);

		if(!$this->session->userdata('logged_in')){
			redirect('', 'refresh');			
		}
	}
	
	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$this->form_validation->set_rules('slc_carrera', 'Carrera', 'required');
		$this->form_validation->set_rules('slc_semestre', 'Semestre', 'required');
		$this->form_validation->set_rules('txt_asignatura', 'Asignatura', 'required|min_length[5]|max_length[100]|callback_es_unico');

		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
		$this->form_validation->set_message('min_length', 'Debe contener un minimo de 10 caracteres');
		$this->form_validation->set_message('max_length', 'Debe contener un máximo de 100 caracteres');
		$this->form_validation->set_message('es_unico', 'Esta asignatura ya existe');

		$carrera = $this->input->post('slc_carrera');
		$semestre = $this->input->post('slc_semestre'); 

		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$frm_msn = $frm_msn_class = false;

		if ($this->form_validation->run()){
			$id =  $this->asignaturas->get_id_max($id_facultad, $carrera, $semestre) + 1;
			$asignatura = $this->input->post('txt_asignatura');
			$estado = '1';

			$this->asignaturas->guardar($id_facultad, $carrera, $semestre, $id, $asignatura, $estado);

		}
		if($semestre >= 0){
			$detalle = $this->actualizar_detalle(true); //Parametro: retorno = true;
//			echo 'uno';
		}else
			$detalle = false;
					
		$carreras = $this->carreras->get_carrera($id_facultad);

		$semestres = ($carrera)? $this->carreras->get_semestre($id_facultad, $carrera) : false;

		$datos = array(
			'carreras' => $carreras,
			'semestres' => $semestres,
			'detalle' => $detalle
		);

		$this->load->view('asignaturas/frm_crear', $datos, FALSE);
	}
	
	function es_unico($asignatura){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$carrera = $this->input->post('slc_carrera');
		$semestre = $this->input->post('slc_semestre'); 
		
		if($this->asignaturas->existe_asignatura($id_facultad, $carrera, $semestre, $asignatura))
			return false;
			
		return true;
	}

	function actualizar_detalle($retornar = false){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$carrera = $this->input->post('slc_carrera');
		$semestre = $this->input->post('slc_semestre');
		
		$asignaturas = $this->asignaturas->get_asignatura($id_facultad, $carrera, $semestre);
		
		$datos = array(
			'asignaturas' => $asignaturas,
			'mostrar_eliminar' => true,
		);
		
		if($retornar)
			return $this->load->view('asignaturas/frm_crear_detalle', $datos, true);
		else
			$this->load->view('asignaturas/frm_crear_detalle', $datos, false);
	}
	
	function actualizar_slc_semestre(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$carrera = $this->input->post('slc_carrera');

		$semestres = $this->carreras->get_semestre($id_facultad, $carrera);

		$opciones = "<option value=null>-----</option>";

		if($semestres){
			foreach($semestres->result() as $row)
				$opciones .= "<option value=$row->id_semestre>$row->semestre</option>";	
		}

		echo $opciones;
	}

	function eliminar(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$carrera = $this->input->post('slc_carrera');
		$semestre = $this->input->post('slc_semestre');
		$asignatura = $this->input->post('asignatura');
		
		$asignaturas = $this->asignaturas->get_asignatura($id_facultad, $carrera, $semestre, $asignatura);		
		$this->asignaturas->eliminar($id_facultad, $carrera, $semestre, $asignatura);
		
		foreach($asignaturas->result() as $row)
			$nombre_asignatura = $row->asignatura;
			
		$mensaje_ok = "La asignatura <b> $nombre_asignatura </b> fue eliminada";

		$this->actualizar_detalle(false, $mensaje_ok);
	}

	function obtener_nombre_asignatura(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$carrera = $this->input->post('slc_carrera');
		$semestre = $this->input->post('slc_semestre');
		$asignatura = $this->input->post('asignatura');

		$asignatura = $this->asignaturas->get_asignatura($id_facultad, $carrera, $semestre, $asignatura);
		foreach($asignatura->result() as $row)
			echo $row->asignatura;
	}
}