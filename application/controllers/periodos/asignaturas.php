<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asignaturas extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('m_periodo', '', TRUE);
		$this->load->model('m_facultad', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);
		$this->load->model('m_asignaturas', '', TRUE);
		$this->load->model('user', '', TRUE);

		if(!$this->session->userdata('logged_in'))
			redirect('home', 'refresh');			
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$id_periodo 	= $this->input->post('slc_periodo');
        $id_sede 		= $this->input->post('slc_sede');
        $id_carrera 	= $this->input->post('slc_carrera');
        $id_semestre 	= $this->input->post('slc_semestre');
        $id_asignatura 	= $this->input->post('slc_asignatura');

//		$this->form_validation->set_rules('txt_usuario', '<b>usuario</b>', 'required|callback_validar_persona');
		$this->form_validation->set_rules('slc_periodo', '<b>periodo</b>', 'required');
		$this->form_validation->set_rules('slc_carrera', '<b>carrera</b>', 'required');
		$this->form_validation->set_rules('slc_semestre', '<b>semestre</b>', 'required');
		$this->form_validation->set_rules('slc_asignatura', '<b>asignatura</b>', 'required');
		if($id_asignatura && $id_asignatura != 'todas'){
			$this->form_validation->set_rules('txt_persona', '<b>persona</b>', 'required');
			$this->form_validation->set_rules('slc_dia', '<b>dia</b>', 'required');
			$this->form_validation->set_rules('slc_sala', '<b>sala</b>', 'required');
			$this->form_validation->set_rules('txt_desde', '<b>desde</b>', 'required');
			$this->form_validation->set_rules('txt_hasta', '<b>hasta</b>', 'required');
		}

		$this->form_validation->set_rules('txt_cierre', '<b>cierre</b>', 'required');

		$slc_periodo 	= $this->cargar_slc_periodo(true);
		$session_data 	= $this->session->userdata('logged_in');
		if($session_data["id_rol"] == 1){
			$this->form_validation->set_rules('slc_facultad', '<b>facultad</b>', 'required');
			$this->form_validation->set_rules('slc_sede', '<b>sede</b>', 'required');
			$id_facultad 	= $this->input->post('slc_facultad');
			$slc_facultad	= $this->cargar_slc_facultad(true);
			$slc_sede		= $this->cargar_slc_sede($id_facultad, true);
		}else if($session_data["id_rol"] == 3){
			$this->form_validation->set_rules('slc_sede', '<b>sede</b>', 'required');
			$id_facultad 	= $session_data['id_facultad'];
			$slc_facultad 	= false;
			$slc_sede	= $this->cargar_slc_sede($id_facultad, true);
		}else{
			$id_facultad 	= $session_data['id_facultad'];
			$id_sede 		= $session_data['id_sede'];
			$slc_facultad 	= false;
			$slc_sede 		= false;
		}

		$slc_carrera 		= $this->cargar_slc_carrera($id_facultad, $id_sede, true);
		$slc_semestre 		= $this->cargar_slc_semestre($id_facultad, $id_carrera, true);
		$slc_asignatura 	= $this->cargar_slc_asignatura($id_facultad, $id_carrera, $id_semestre, true);
		

        $this->form_validation->set_message('required', 'Campo %s es obligatorio');
        $this->form_validation->set_message('validar_persona', 'La personas no esta registrada');
        $this->form_validation->set_message('validar_usuario', 'Esta persona ya tiene este rol');

        

        //Guarda usuario
		if($this->form_validation->run()){
			$this->user->save_usuarios($id_facultad, $id_sede, $id_persona, $id_rol);
			$mensaje 	= "Asignacion de rol exitosa!";
		}else{
			$mensaje = false;
		}

		$id_rol = 4; //Rol del docente.
		$docentes 	= $this->user->get_usuarios(false, false, false, $id_rol);

		//$detalles 	= $this->cargar_detalle();
		$detalles 	= false;
		

		$datos 		= array(
			'slc_periodo'	=> $slc_periodo,
			'slc_facultad' 	=> $slc_facultad,
			'slc_sede'		=> $slc_sede,
			'slc_carrera'	=> $slc_carrera,
			'slc_semestre'	=> $slc_semestre,
			'slc_asignatura'=> $slc_asignatura,
			'docentes'		=> $docentes,
			'detalles'		=> $detalles,
			'mensaje'		=> $mensaje,
		);
		$this->load->view('periodos/asignaturas_cabecera', $datos, FALSE);

	}

	function validar_persona($usuario){
		$cadena		= explode(" ", $usuario);
		$documento	= $cadena[count($cadena) - 1];

		$documentos	= $this->user->get_documentos(false, false, $documento);
		if($documentos){
			$documento 	= $documentos->row_array();
			$personas 	= $this->user->get_personas($documento['id_persona']);
			if($personas)
				return true;
			return false;
		}
		return false;
	}

	function validar_usuario($rol){
		$usuario 	= $this->input->post('txt_usuario');
		$cadena		= explode(" ", $usuario);
		$documento	= $cadena[count($cadena) - 1];
		$documentos	= $this->user->get_documentos(false, false, $documento);
		if($documentos){
			$documento 	= $documentos->row_array();
			$id_facultad= $this->input->post('slc_facultad');
			$id_sede	= $this->input->post('slc_sede');
			$usuarios 	= $this->user->get_usuarios($id_facultad, $id_sede, $documento['id_persona'], $rol);

			if($usuarios)
				return false;
			return true;
		}
		return false;
	}

	function cargar_slc_periodo($retornar = false){
		$periodos		= $this->m_periodo->get_periodos(false, true);

		if($retornar){
			$slc_periodo 	= array('' => '-----');
			if($periodos)
				foreach($periodos->result() as $row)
					$slc_periodo[$row->id_periodo] =  $row->id_periodo;
			
			return $slc_periodo;
		}else{
			$slc_periodo 	= "<option value=>-----</option>";
			if($periodos)
				foreach($periodos->result() as $row)
					$slc_periodo .= "<option value=$row->id_periodo >$row->id_periodo </option>";
			echo $cargar_slc_periodo;
		}
	}

	function cargar_slc_facultad($retornar = false){
		$facultades		= $this->m_carreras->get_relacion_sede_carrera();

		if($retornar){
			$slc_facultad 	= array('' => '-----');
			if($facultades)
				foreach($facultades->result() as $row)
					$slc_facultad[$row->id_facultad] = $row->facultad;
			return $slc_facultad;
		}else{
			$slc_facultad .= "<option value= >-----</option>";
			if($facultades)
				foreach($facultades->result() as $row)
					$slc_facultad .= "<option value=$row->id_facultad >$row->facultad </option>";
			echo $slc_facultad;
		}
	}

	function cargar_slc_sede($id_facultad = false, $retornar = false){
		if(!$id_facultad)
			$id_facultad 	= $this->input->post('slc_facultad');
		if($retornar){
			$slc_sede = array('' => '-----');
			if($id_facultad){
				$slc_sede['todas'] = 'Todas';
				$sedes 			= $this->m_carreras->get_relacion_sede_carrera($id_facultad);
				if($sedes)
					foreach($sedes->result() as $row)
						$slc_sede[$row->id_sede]  = $row->sede;	
			}
			return $slc_sede;
		}else{
			$slc_sede = "<option value=>-----</option>";
			if($id_facultad){
				$sedes 			= $this->m_carreras->get_relacion_sede_carrera($id_facultad);
				$slc_sede .= "<option value=todas>Todas</option>";
				if($sedes)
					foreach($sedes->result() as $row)
						$slc_sede .= "<option value=$row->id_sede >$row->sede </option>";
			}
			echo $slc_sede;
		}
	}

	function cargar_slc_carrera($id_facultad = false, $id_sede = false, $retornar = false){

		$session_data = $this->session->userdata('logged_in');
		if($session_data["id_rol"] == 1){
			if(!$id_facultad)
				$id_facultad 	= $this->input->post('slc_facultad');
			if(!$id_sede)
				$id_sede 		= $this->input->post('slc_sede');
		}else if($session_data["id_rol"] == 3){
			if(!$id_sede)
				$id_sede 		= $this->input->post('slc_sede');
		}else if($session_data["id_rol"] == 2){
			$id_facultad 	= $session_data['id_facultad'];
			$id_sede 		= $session_data['id_sede'];
		}

		

		if($retornar){
			$slc_carrera = array('' => '-----');

			if($id_facultad && $id_sede){
				$slc_carrera['todas'] = 'Todas';

				$carreras		= $this->m_carreras->get_relacion_sede_carrera($id_facultad, $id_sede);
				if($carreras)
					foreach($carreras->result() as $row)
						$slc_carrera[$row->id_carrera] = $row->carrera;
			}
			return $slc_carrera;
		}else{
			$slc_carrera = "<option value=''>-----</option>";

			if($id_facultad && $id_sede){
				$slc_carrera .= "<option value=todas>Todas</option>";
				$carreras		= $this->m_carreras->get_relacion_sede_carrera($id_facultad, $id_sede);
				if($carreras)
					foreach($carreras->result() as $row)
						$slc_carrera .= "<option value=$row->id_carrera >$row->carrera </option>";
			}
			echo $slc_carrera;
		}
	}

	function cargar_slc_semestre($id_facultad = false, $id_carrera = false, $retornar = false){
		$session_data = $this->session->userdata('logged_in');
		if($session_data["id_rol"] == 1){
			if(!$id_facultad)
				$id_facultad 	= $this->input->post('slc_facultad');
			if(!$id_carrera)
				$id_carrera		= $this->input->post('slc_carrera');
		}else if($session_data["id_rol"] == 3){
			$id_facultad 	= $session_data['id_facultad'];
			if(!$id_carrera)
				$id_carrera		= $this->input->post('slc_carrera');
		}else if($session_data["id_rol"] == 2){
			$id_facultad 	= $session_data['id_facultad'];
			if(!$id_carrera)
				$id_carrera		= $this->input->post('slc_carrera');
		}

		if($retornar){
			$slc_semestre = array('' => '-----');
			if($id_facultad && $id_carrera){
				$slc_semestre['todos'] = 'Todos';
				$semestres		= $this->m_carreras->get_semestres($id_facultad, $id_carrera);
				if($semestres)
					foreach($semestres->result() as $row)
						$slc_semestre[$row->id_semestre] =  $row->semestre;
			}
			return $slc_semestre;
		}else{
			$slc_semestre = "<option value=>-----</option>";
			if($id_facultad && $id_carrera){
				$slc_semestre .= "<option value=todos>Todos</option>";
				$semestres		= $this->m_carreras->get_semestres($id_facultad, $id_carrera);
				if($semestres)
					foreach($semestres->result() as $row)
						$slc_semestre .= "<option value=$row->id_semestre >$row->semestre </option>";
			}
			echo $slc_semestre;
		}
	}

	function cargar_slc_asignatura($id_facultad = false, $id_carrera = false, $id_semestre = false, $retornar = false){
		$session_data = $this->session->userdata('logged_in');
		if($session_data["id_rol"] == 1){
			if(!$id_facultad)
				$id_facultad 	= $this->input->post('slc_facultad');
			if(!$id_carrera)
				$id_carrera		= $this->input->post('slc_carrera');
			if(!$id_semestre)
				$id_semestre	= $this->input->post('slc_semestre');
		}else if($session_data["id_rol"] == 3){
			$id_facultad 	= $session_data['id_facultad'];
			if(!$id_carrera)
				$id_carrera		= $this->input->post('slc_carrera');
			if(!$id_semestre)
				$id_semestre	= $this->input->post('slc_semestre');
		}else if($session_data["id_rol"] == 2){
			$id_facultad 	= $session_data['id_facultad'];
			if(!$id_carrera)
				$id_carrera		= $this->input->post('slc_carrera');
			if(!$id_semestre)
				$id_semestre	= $this->input->post('slc_semestre');
		}
		

		if($retornar){
			$slc_asignatura = array('' => '-----');
			if($id_facultad && $id_carrera && $id_semestre){
				$slc_asignatura['todas'] = 'Todas';
				$asignaturas	= $this->m_asignaturas->get_asignaturas($id_facultad, $id_carrera, $id_semestre);
				if($asignaturas)
					foreach($asignaturas->result() as $row)
						$slc_asignatura[$row->id_asignatura] =  $row->asignatura;
			}
			return $slc_asignatura;
		}else{
			$slc_asignatura = "<option value=>-----</option>";

			if($id_facultad && $id_carrera && $id_semestre){
				$slc_asignatura .= "<option value=todas>Todas</option>";
				$asignaturas	= $this->m_asignaturas->get_asignaturas($id_facultad, $id_carrera, $id_semestre);
				if($asignaturas)
					foreach($asignaturas->result() as $row)
						$slc_asignatura .= "<option value=$row->id_asignatura >$row->asignatura </option>";
			}
			echo $slc_asignatura;
		}
	}

	function cargar_detalle($id_facultad = false, $id_sede = false, $id_carrera = false, $id_semestre = false, $id_asignatura = false, $retornar = false){
		if(!$id_facultad)
			$id_facultad 	= $this->input->post('slc_facultad');
		if(!$id_sede)
			$id_sede		= $this->input->post('slc_sede');
		if(!$id_carrera)
			$id_carrera		= $this->input->post('slc_carrera');
		if(!$id_semestre)
			$id_semestre 	= $this->input->post('slc_semestre');
		if(!$id_asignatura)
			$id_asignatura 	= $this->input->post('slc_asignatura');

		$datos = array(

		);

		if($retornar)
			return $this->load->view('periodos/inscripcion_asignatura_detalles', $datos, TRUE);
		else
			$this->load->view('periodos/inscripcion_asignatura_detalles', $datos, FALSE);
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