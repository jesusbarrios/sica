<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('m_menu', 'menu', TRUE);

		if(!$this->session->userdata('logged_in')){

			redirect('home', 'refresh');			

		}
	}


	function index(){

		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$menus = $this->menu->get_menu();
		$this->load->view('menu/menu_frm.php', array('menus' => $menus), FALSE);

	}
	
	function guardar(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$this->form_validation->set_rules('txt_menu', '<b>menu</b>', 'trim|required|xss_clean|callback_controlar_unico');
		
		$this->form_validation->set_message('required', 'El campo %s es obligatorio.');
		$this->form_validation->set_message('controlar_unico', 'Ya existe.');
		
		$menu = $this->input->post('txt_menu');
		$posicion = $this->input->post('txt_posicion');
		$estado = $this->input->post('slc_estado');
	
		$datos = array(
			'menu' => $menu,
			'posicion' => $posicion,
			'estado' => $estado);
		
		if($this->form_validation->run()){
			$menus = $this->menu->agregar_menu($datos);
			$datos['ok_message'] = "Se agrego exitosamente";
		}
		
		$menus = $this->menu->get_menu();
		$datos['menus'] = $menus;
		$this->load->view('menu/menu_frm.php', $datos, FALSE);
	}
	
	function delete($id_menu){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		$menu = $this->menu->get_menu($id_menu);

		foreach($menu as $row)
			$menu = $row->menu;

		if($this->menu->borrar_menu($id_menu)){
			$datos =  array(
				'list_ok_message' => 'El menu "' . $menu . '" se elimino exitosamente');

		}else{
			$datos = array(
				'list_error_message' => 'El menu "' . $menu . '" no se puede eliminar porque se esta utilizando');
		}
				
		$menus = $this->menu->get_menu();
		
		$datos['menus'] = $menus;
		
		$this->load->view('menu/menu_frm.php', $datos, FALSE);
				
	}
	
	function controlar_unico(){

		$menu = $this->input->post('txt_menu');
		
		if ($this->menu->verificar_existencia_menu($menu))
			return false;
		else
			return true;
	}
	
}