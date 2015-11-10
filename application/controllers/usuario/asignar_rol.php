<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asignar_rol extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('user', '', TRUE);
		$this->load->model('m_facultad', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);

		if(!$this->session->userdata('logged_in'))
			redirect('home', 'refresh');			
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$this->form_validation->set_rules('txt_usuario', '<b>usuario</b>', 'required|callback_validar_persona');
		$this->form_validation->set_rules('slc_facultad', '<b>rol</b>', 'required');
		$this->form_validation->set_rules('slc_sede', '<b>rol</b>', 'required');
		

        $this->form_validation->set_message('required', 'Campo %s es obligatorio');
        $this->form_validation->set_message('validar_persona', 'La personas no esta registrada');
        $this->form_validation->set_message('validar_usuario', 'Esta persona ya tiene este rol');

        $cadena		= explode(" ", $this->input->post('txt_usuario'));
		$documento	= $cadena[count($cadena) - 1];
		$documentos 	= $this->user->get_documentos(false, false, $documento);

		if($documento && $documentos){
			$documento 	= $documentos->row_array();
			$id_persona	= $documento['id_persona'];
		}else
			$id_persona = false;

        $id_facultad 	= $this->input->post('slc_facultad');
        $id_sede 		= $this->input->post('slc_sede');
        $id_rol 	= $this->input->post('slc_rol');

        if($id_persona && $id_facultad && $id_sede)
        	$this->form_validation->set_rules('slc_rol', '<b>rol</b>', 'required|callback_validar_usuario');

        $personas 	= $this->user->get_personas();
        $facultades = $this->m_facultad->get_facultades();
        $roles 	= $this->user->get_roles();
        if($id_facultad)
        	$sedes 	= $this->m_carreras->get_relacion_sede_carrera($id_facultad);
        else
        	$sedes 	= false;

        //Guarda usuario
		if($this->form_validation->run()){
			$this->user->save_usuarios($id_facultad, $id_sede, $id_persona, $id_rol);
			$mensaje 	= "Asignacion de rol exitosa!";
		}else{
			$mensaje = false;
		}

		$detalles 	= $this->actualizar_detalles(true);
		

		$datos 		= array(
			'personas'	=> $personas,
			'facultades'=> $facultades,
			'sedes'		=> $sedes,
			'roles'		=> $roles,
			'detalles'	=> $detalles,
			'mensaje'	=> $mensaje,
		);
		$this->load->view('usuario/asignar_rol', $datos, FALSE);
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

	function actualizar_slc_sede(){
		$id_facultad 	= $this->input->post('slc_facultad');
		$sedes 			= $this->m_carreras->get_relacion_sede_carrera($id_facultad);
		$slc_sede = "<option value=>-----</option>";
		if($sedes)
			foreach($sedes->result() as $row)
				$slc_sede .= "<option value=$row->id_sede >$row->sede </option>";

		echo $slc_sede;
	}

	function cambiar_estado(){
		$cadena		= explode(" ", $this->input->post('txt_usuario'));
		$documento	= $cadena[count($cadena) - 1];

		$documentos	= $this->user->get_documentos(false, false, $documento);
		$documento 	= $documentos->row_array();
		$id_persona = $documento['id_persona'];

		$id_facultad 	= $this->input->post('slc_facultad');
		$id_sede		= $this->input->post('slc_sede');
		$id_rol			= $this->input->post('slc_rol');
		$estado 		= $this->input->post('estado');

		$this->user->cambiar_estado($id_facultad, $id_sede, $id_persona, $id_rol, $estado);


		$this->actualizar_detalles();
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

	function actualizar_detalles($retornar = false){

		$cadena		= explode(" ", $this->input->post('txt_usuario'));
		$documento	= $cadena[count($cadena) - 1];
		$documentos	= $this->user->get_documentos(false, false, $documento);

		if($documento && $documentos){
			$documento 	= $documentos->row_array();
			$id_persona = $documento['id_persona'];

			$usuarios 	= $this->user->get_usuarios(false, false, $id_persona);
		}else{
			$usuarios = false;
		}
		
		$datos 	= array(
			'usuarios'	=> $usuarios,
		);

		if($retornar)
			return $this->load->view('usuario/asignar_rol_detalles', $datos, TRUE);
		else
			$this->load->view('usuario/asignar_rol_detalles', $datos, FALSE);
	}
}