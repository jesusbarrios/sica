<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cambiar_clave extends CI_Controller {

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

	function check_pass($clave){

		$session_data 	= $this->session->userdata('logged_in');
		$id_persona 	= $session_data["id_persona"];
		$personas 		= $this->user->get_personas($id_persona, false, false, false, false, false, false, false, false, $clave);
		if($personas)
			return true;
		return false;
	}
}