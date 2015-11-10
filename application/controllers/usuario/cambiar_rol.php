<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cambiar_rol extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('user', '', TRUE);
		if(!$this->session->userdata('logged_in'))
			redirect('home', 'refresh');

	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		$this->form_validation->set_rules('radio_predeterminado', 'Rol', 'required');

		$id_rol = $this->input->post('radio_predeterminado');

		$usuario 	= $this->session->userdata('logged_in');

		if($this->form_validation->run()){
			$id_facultad 	= $usuario['id_facultad'];
			$id_sede		= $usuario['id_sede'];
			$id_persona 	= $usuario['id_persona'];
			$this->user->predeterminar_usuario($id_facultad, $id_sede, $id_persona, $id_rol);

			$sess_array = array(
				'id_facultad' 	=> $id_facultad,
				'id_sede' 		=> $id_sede,
				'id_persona' 	=> $id_persona,
				'alias' 		=> $usuario['alias'],
				'id_rol'		=> $id_rol,
			);
			$this->session->set_userdata('logged_in', $sess_array);
			redirect(base_url() . 'index.php/usuario/cambiar_rol', 'refresh');

		}

		$rol_actual	= $this->user->get_roles($usuario['id_rol'], false, false, false);
		$usuarios 	= $this->user->get_usuarios(false, false, $usuario['id_persona'], false, false, true);

		$datos = array(
			'rol_actual'=> $rol_actual,
			'usuarios'	=> $usuarios,
		);

		$this->load->view('usuario/frm_cambiar_rol', $datos, FALSE);
	}
}