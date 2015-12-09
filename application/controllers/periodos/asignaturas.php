<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asignaturas extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->model('m_periodos', '', TRUE);
		$this->load->model('m_facultades', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);
		$this->load->model('m_cursos', '', TRUE);
		$this->load->model('m_asignaturas', '', TRUE);
		$this->load->model('m_inscripciones', '', TRUE);
		$this->load->model('user', '', TRUE);

		if($session = $this->session->userdata('logged_in')){
			if($session['id_rol'] != 1 && $session['id_rol'] != 3)
				redirect('', 'refresh');			
		}else
			redirect('', 'refresh');		
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$this->form_validation->set_rules('slc_periodo', '<b>periodo</b>', 'required');
		$this->form_validation->set_rules('slc_sede', '<b>sede</b>', 'required');
		$this->form_validation->set_rules('slc_carrera', '<b>carrera</b>', 'required');
		$this->form_validation->set_rules('slc_tipo_curso', '<b>tipo de curso</b>', 'required');
		$this->form_validation->set_rules('txt_apertura', '<b>apertura</b>', 'required');
		$this->form_validation->set_rules('txt_cierre', '<b>cierre</b>', 'required');

		$session_data 	= $this->session->userdata('logged_in');
		if($session_data["id_rol"] == 1){
			$this->form_validation->set_rules('slc_facultad', '<b>facultad</b>', 'required');
			$id_facultad 	= $this->input->post('slc_facultad');
			$facultades 	= $this->m_facultades->get_facultades();
		}else if($session_data["id_rol"] == 3){
			$id_facultad 	= $session_data['id_facultad'];
			$facultades		= false;
		}

		$id_periodo 	= $this->input->post('slc_periodo');
		$id_sede 		= $this->input->post('slc_sede');
	    $id_carrera 	= $this->input->post('slc_carrera');
	    $tipo_curso 	= $this->input->post('slc_tipo_curso');
	    $apertura 		= $this->input->post('txt_apertura');
	    $cierre 		= $this->input->post('txt_cierre');

        $this->form_validation->set_message('required', 'Campo %s es obligatorio');
        $this->form_validation->set_message('validate', 'El periodo ya existe!!');

        //Guarda
		if($this->form_validation->run()){
			$cursos = $this->m_cursos->get_cursos($id_facultad, $id_carrera, false, false, $tipo_curso, true);
			if($cursos){
				foreach ($cursos->result() as $cursos_) {
					$id_curso 	= $cursos_->id_curso;
					$asignaturas= $this->m_asignaturas->get_asignaturas($id_facultad, $id_carrera, $id_curso, false, false, false, true);
					foreach($asignaturas->result() as $asignaturas_){
						$id_asignatura = $asignaturas_->id_asignatura;
						$inscripciones = $this->m_inscripciones->get_inscripciones($id_periodo, $id_facultad, $id_sede, $id_carrera, $id_curso, $id_asignatura);
						if($inscripciones){
							$inscripciones_ = $inscripciones->row_array();
							if(!$inscripciones_['estado'])
								$this->m_inscripciones->update_inscripcion($id_periodo, $id_facultad, $id_sede, $id_carrera, $id_curso, $id_asignatura, false, $apertura, $cierre, true);
						}else
							$this->m_inscripciones->insert_inscripcion($id_periodo, $id_facultad, $id_sede, $id_carrera, $id_curso, $id_asignatura, date('Y-m-d'), $apertura, $cierre, true);
					}
				}
			}
			$mensaje 	= "Se inserto correctamente!";
		}else{
			$mensaje = false;
		}

		$periodos = $this->m_periodos->get_periodos();
		if($id_facultad)
			$sedes = $this->m_carreras->get_relacion_sede_carrera($id_facultad, false, false, false, true);
		else
			$sedes = false;
		if($id_facultad && $id_sede)
			$carreras = $this->m_carreras->get_relacion_sede_carrera($id_facultad, $id_sede, false, false, true);
		else
			$carreras = false;
		if($id_periodo && $id_facultad && $id_sede && $id_carrera)
			$inscripciones 	= $this->m_inscripciones->get_inscripciones($id_periodo, $id_facultad, $id_sede, $id_carrera, false, false, false, true);
		else
			$inscripciones 	= false;
		$datos = array(
			'inscripciones' => $inscripciones,
		);

		$detalles = $this->load->view('periodos/asignaturas_detalles', $datos, true);

		$datos 	= array(
			'periodos'		=> $periodos,
			'facultades' 	=> $facultades,
			'sedes'			=> $sedes,
			'carreras'		=> $carreras,
			'detalles'		=> $detalles,
			'mensaje'		=> $mensaje,
		);
		$this->load->view('periodos/asignaturas_cabecera', $datos, FALSE);
	}

	function actualizar_slc_sede(){
		$session_data 	= $this->session->userdata('logged_in');
		if($session_data["id_rol"] == 1)
			$id_facultad 	= $this->input->post('slc_facultad');
		else if($session_data["id_rol"] == 3)
			$id_facultad 	= $session_data['id_facultad'];

		$slc_sede = "<option value=''>-----</option>";
		if($id_facultad){
			$sedes = $this->m_carreras->get_relacion_sede_carrera($id_facultad, false, false, false, true);
			if($sedes)
				foreach($sedes->result() as $sedes_)
					$slc_sede .= "<option value=$sedes_->id_sede >$sedes_->sede </option>";
		}
		echo $slc_sede;
	}

	function actualizar_slc_carrera(){
		$session_data 	= $this->session->userdata('logged_in');
		if($session_data["id_rol"] == 1)
			$id_facultad 	= $this->input->post('slc_facultad');
		else if($session_data["id_rol"] == 3)
			$id_facultad 	= $session_data['id_facultad'];
		$id_sede 	= $this->input->post('slc_sede');

		$slc_carrera 	= "<option value=''>-----</option>";
		if($id_facultad && $id_sede){
			$carreras = $this->m_carreras->get_relacion_sede_carrera($id_facultad, $id_sede, false, false, true);
			if($carreras)
				foreach($carreras->result() as $carreras_)
					$slc_carrera .= "<option value=$carreras_->id_carrera >$carreras_->carrera </option>";
		}
		echo $slc_carrera;
	}

	function eliminar(){
		$cadena		= explode(" ", $this->input->post('txt_usuario'));
		$documento	= $cadena[count($cadena) - 1];

		$documentos	= $this->user->get_documentos(false, false, $documento);
		$documento 	= $documentos->row_array();
		$id_persona = $documento['id_persona'];

		$id_facultad 	= $this->input->post('slc_facultad');
		$id_sede		= $this->input->post('slc_sede');
		$id_rol			= $this->input->post('slc_rol');
		$estado 		= $this->input->post('estado');

		$this->user->delete_usuario($id_facultad, $id_sede, $id_persona, $id_rol, $estado);

		$this->actualizar_detalles();
	}
}