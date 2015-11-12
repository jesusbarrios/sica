<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Periodos extends CI_Controller {

	function __construct(){

		parent::__construct();

		$this->load->model('m_periodo', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);

		if(!$this->session->userdata('logged_in')){

			redirect('', 'refresh');			
		}
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$this->form_validation->set_rules('txt_periodo', 'Periodo', 'required|callback_validar_periodo');
		$this->form_validation->set_message('required', 'El campo es obligatorio');
		$this->form_validation->set_message('validar_periodo', 'El periodo ya existe');
		
		if ($this->form_validation->run()){
			$periodo 	= $this->input->post('txt_periodo');
			$estado 	= true;
			$this->m_periodo->insert_periodos($periodo, $estado);
			$mensaje 	= 'Se creo exitosamente';
		}else{
			$mensaje 	= false;
		}

		$periodos 	= $this->m_periodo->get_periodos();
		$detalles	= $this->load->view('periodos/periodos_detalles', array('periodos' => $periodos), true);

		$datos = array(
			'mensaje'	=> $mensaje,
			'detalles'	=> $detalles,
		);

		$this->load->view('periodos/periodos_cabecera', $datos, FALSE);
	}

	function validar_periodo($periodo){
		$periodos = $this->m_periodo->get_periodos($periodo);
		if($periodos)
			return false;
		return true;
	}

	function eliminar(){
		$id_periodo = $this->input->post('txt_periodo');
		$this->m_periodo->delete_periodos($id_periodo);
		$periodos 	= $this->m_periodo->get_periodos();
		$this->load->view('periodos/periodos_detalles', array('periodos' => $periodos), false);
	}

	function cambiar_estado(){
		$id_periodo = $this->input->post('txt_periodo');
		$estado 	= $this->input->post('slc_estado');
		$this->m_periodo->update_periodos($id_periodo, $estado);
		$periodos 	= $this->m_periodo->get_periodos();
		$this->load->view('periodos/periodos_detalles', array('periodos' => $periodos), false);
	}
}