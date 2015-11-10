<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calificacion extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('user', '', TRUE);
		$this->load->model('m_inscripcion', '', TRUE);
		$this->load->model('m_sedes', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);
		$this->load->model('m_asignaturas', '', TRUE);
		
		if(!$this->session->userdata('logged_in')){

			redirect('', 'refresh');			


		}

	}

	function cargar_por_persona(){

		$this->form_validation->set_rules('txt_documento', '<b>Documento</b>', 'trim|required|xss_clean');
		
		$this->form_validation->set_message('required', 'Campo %s es obligatorio');

		if($this->form_validation->run()){
			$documento = $this->input->post('txt_documento');
			$persona = $this->user->get_persona($documento);

		}else{
			$persona = false;
		}
		
		$datos = array(
			'persona' => $persona,
		);

		$this->load->view('calificacion/cargar_por_persona', $datos, FALSE);
		
	}
	
	

	function guardar(){
		$this->load->model('user', '', TRUE);

		$this->form_validation->set_rules('txt_clave_actual', '<b>clave actual</b>', 'trim|required|xss_clean|callback_check_pass');
		$this->form_validation->set_rules('txt_clave1', '<b>clave nueva</b>', 'trim|required|xss_clean|min_length[5]|maxlength]15]');
		$this->form_validation->set_rules('txt_clave2', '<b>confirmacion de clave</b>', 'trim|required|xss_clean|matches[txt_clave1]|min_length[5]|maxlength]15]');

        $this->form_validation->set_message('required', 'Campo %s es obligatorio');
        $this->form_validation->set_message('matches', 'La %s no coincide con la %s');
        $this->form_validation->set_message('check_pass', 'La %s no es válida');
        $this->form_validation->set_message('min_length', '%s debe tener 5 a 15 caracteres');
        $this->form_validation->set_message('max_length', '%s debe tener 5 a 15 caracteres');

		if($this->form_validation->run()){

			$session_data = $this->session->userdata('logged_in');
			$id_persona = $session_data["id_persona"];	
			$clave = $this->input->post('txt_clave1');

			$this->user->save_new_pass($id_persona, $clave);

			$datos = array(
				'mensaje' => "Modificación de clave exitosa!");

			$this->load->view('usuario/cambiar_clave', $datos, FALSE);

		}else{
			$this->load->view('usuario/cambiar_clave', FALSE);	
		}
	}

	function check_pass(){

		$session_data = $this->session->userdata('logged_in');
		$id_persona = $session_data["id_persona"];

		$clave = $this->input->post('txt_clave_actual');

		return $this->user->check_pass($id_persona, $clave);

	}
	
	function validar_documento($documento){
		if($this->user->get_persona($documento))
			return true;
		return false;
	}
	
	function inscribir_calificar(){
		
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$this->form_validation->set_rules('txt_documento', '<b>Documento</b>', 'trim|required|xss_clean|callback_validar_documento');
		$this->form_validation->set_rules('slc_sede', '<b>Sede</b>', '');
		$this->form_validation->set_rules('slc_carrera', '<b>Carrera</b>', '');
		$this->form_validation->set_rules('slc_asignatura', '<b>Asignatura</b>', '');
		
		$this->form_validation->set_message('required', 'Campo %s es obligatorio');
		$this->form_validation->set_message('validar_documento', 'El documento no esta registrado');

		$persona = false;
		$sedes = false;
		$carreras = false;
		$semestres = false;
		$mensaje_aviso = false;
		$mensaje_ok = false;

		if($this->form_validation->run()){
			$session_data = $this->session->userdata('logged_in');
			$id_facultad = $session_data["id_facultad"];

			$documento = $this->input->post('txt_documento');
			$persona = $this->user->get_persona($documento);

			if($persona){
				$row = $persona->row_array();
				$id_persona = $row['id_persona'];
				$sedes = $this->m_inscripcion->get_inscripcion($id_facultad, false, false, $id_persona);
				
				if($sedes){
					if($sedes->num_rows() == 1){
						$row = $sedes->row_array();
						$id_sede = $row['id_sede'];
						$carreras = $this->m_inscripcion->get_carrera($id_facultad, $id_sede, false, $id_persona);
						
						if($carreras){
							if($carreras->num_rows() == 1){
								$row = $carreras->row_array();
								$id_carrera = $row['id_carrera'];
								$semestres = $this->m_inscripcion->get_inscripcion($id_facultad, $id_sede, $id_carrera, $id_persona);
							}else{
								$semestres = false;
							}
							
						}else{
							$carreras = $this->m_carreras->get_carrera($id_facultad, $id_sede);
							$semestres = false;
							$mensaje_aviso = 'No esta inscripto a ninguna carrera';
						}
					}else{
						$carreras = false;
						$semestres = false;
					}
				}else{
					$sedes = $this->m_sedes->get_sede($id_facultad);
					$carreras = false;
					$semestres = false;
					$mensaje_aviso = 'No esta inscripto a ninguna carrera';
				}
			}
		}
		
		$datos = array(
			'persona' => $persona,
			'sedes' => $sedes,
			'carreras' => $carreras,
			'semestres' => $semestres,
			'mensaje_aviso' => $mensaje_aviso,
			'mensaje_ok' => $mensaje_ok,
		);

		$this->load->view('calificacion/inscribir_calificar', $datos, FALSE);
		
	}
	
	function actualizar_slc_carrera(){

		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_sede = $this->input->post('sede');
		$carreras = $this->m_carreras->get_carrera($id_facultad, $id_sede);

		$slc_carreras = "<option value=''>-----</option>";

		if($carreras){
			foreach($carreras->result() as $row)
				$slc_carreras .= "<option value=$row->id_carrera>$row->carrera</option>";
		}
		
		echo $slc_carreras;
	}

	function actualizar_slc_semestre(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$id_carrera = $this->input->post('carrera');
		$semestres = $this->m_carreras->get_cantidad_semestre($id_facultad, $id_carrera);

		$slc = "<option value=''>-----</option>";

		foreach($semestres->result() as $row){
			if($row->id_semestre != 0)
				$slc .= "<option value=$row->id_semestre>$row->semestre</option>";
		}

		echo $slc;
	}
	
	function actualizar_inscribir_calificar_detalles(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$id_carrera = $this->input->post('carrera');
		$id_semestre = $this->input->post('semestre');
		$asignaturas = $this->m_asignaturas->get_asignatura($id_facultad, $id_carrera, $id_semestre);
		
		$detalles = $this->load->view('calificacion/inscribir_calificar_detalles', array('asignaturas' => $asignaturas), true);

		echo $detalles;
	}
}