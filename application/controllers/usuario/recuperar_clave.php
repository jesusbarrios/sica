<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recuperar_clave extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('user', '', TRUE);

		if(!$this->session->userdata('logged_in')){
			redirect('home', 'refresh');			
		}else{
			$this->load->view('header', FALSE);
			$this->load->view('menu', FALSE);
		}
	}

	function index(){
		$this->load->model('user', '', TRUE);

		$this->form_validation->set_rules('txt_usuario', '<b>usuario</b>', 'trim|required|xss_clean|callback_validar_usuario');
		$this->form_validation->set_rules('txt_clave1', '<b>clave nueva</b>', 'trim|required|xss_clean|min_length[5]|maxlength]15]');
		$this->form_validation->set_rules('txt_clave2', '<b>confirmacion de clave</b>', 'trim|required|xss_clean|matches[txt_clave1]|min_length[5]|maxlength]15]');

        $this->form_validation->set_message('required', 'Campo %s es obligatorio');
        $this->form_validation->set_message('matches', 'La %s no coincide con la %s');
        $this->form_validation->set_message('validar_usuario', 'El %s no está registrado');
        $this->form_validation->set_message('min_length', '%s debe tener 5 a 15 caracteres');
        $this->form_validation->set_message('max_length', '%s debe tener 5 a 15 caracteres');

		if($this->form_validation->run()){
			$usuario 	= $this->input->post('txt_usuario');
			$cadena		= explode(" ", $usuario);
			$documento	= $cadena[count($cadena) - 1];

			$documentos	= $this->user->get_documentos(false, false, $documento);
			if($documentos){
				$documento 	= $documentos->row_array();
//				$personas 	= $this->user->get_personas($documento['id_persona']);
//				$persona 	= $personas->row_array();
//				$id_persona	= $persona['id_persona'];

				$clave 		= $this->input->post('txt_clave1');

				$this->user->save_new_pass($documento['id_persona'], $clave);
			}

			$datos = array(
				'mensaje' => "Modificación de clave exitosa!" . $clave,
			);

			$this->load->view('usuario/restablecer_clave', $datos, FALSE);

		}else{
			$personas = $this->user->get_personas();
			$datos 	= array(
				'personas'	=> $personas,
			);
			$this->load->view('usuario/recuperar_clave', $datos, FALSE);	
		}
	}

	function validar_usuario($usuario){
		$cadena		= explode(" ", $usuario);
		$documento	= $cadena[count($cadena) - 1];

		$documentos	= $this->user->get_documentos(false, false, $documento);
		if($documentos){
			$documento 	= $documentos->row_array();
//			$personas 	= $this->user->get_personas($documento['id_persona']);
//			$persona 	= $personas->row_array();
			$usuarios 	= $this->user->get_usuarios(false, false, $documento['id_persona']);

			if($usuarios)
				return true;
			return false;
		}
		return false;
	}
}