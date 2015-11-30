<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ingresar extends CI_Controller {

	function __construct(){

		parent::__construct();
		
		$this->mantenimiento = false;
		
		$this->load->model('user', '', TRUE);

	}

	function index(){
			$this->load->view('header', FALSE);
			
			if($this->mantenimiento){
				$this->load->view('mantenimiento', FALSE);	
			}else{
				$this->form_validation->set_rules('txt_usuario', '<b>Usuario</b>', 'trim|required|xss_clean');
				$this->form_validation->set_rules('txt_clave', '<b>Clave</b>', 'trim|required|xss_clean|callback_check_database');
	
	            $this->form_validation->set_message('required', 'Campo %s es obligatorio');
	            $this->form_validation->set_message('check_database', 'Usuario o clave incorrecto');
	
				if($this->form_validation->run()){
			     	redirect('home', 'refresh');
			   	}else{
				   	$usuario = $this->input->post('txt_usuario');
			   		$datos = array('usuario' => $usuario);
			   		$this->load->view('usuario/ingresar', $datos);
			    }
		}
	}


	function check_database($clave){
		$id_facultad= 1; //cyt
//		$id_facultad= 2; //facea

		$documento 	= $this->input->post('txt_usuario');
		$documentos	= $this->user->get_documentos(false, false, $documento);
		if($documentos){
			$documento 	= $documentos->row_array();
			$id_persona	= $documento['id_persona'];
			$personas 	= $this->user->get_personas($id_persona, false, false, false, false, false, false, false, false, $clave);
			if($personas){
				$persona 	= $personas->row_array();
				$usuarios 	= $this->user->get_usuarios($id_facultad, false, $id_persona, false, true, true);
				if($usuarios){
					$usuario = $usuarios->row_array();
					$sess_array = array(
//						'id_facultad' 	=> $usuario['id_facultad'],
						'id_facultad' 	=> $id_facultad,
						'id_sede' 		=> $usuario['id_sede'],
						'id_persona' 	=> $persona['id_persona'],
						'alias' 		=> $persona['alias'],
						'id_rol'		=> $usuario['id_rol'],
					);
					$this->session->set_userdata('logged_in', $sess_array);
					return TRUE;
				}
			}
		}
		return FALSE;
	}
}
?>