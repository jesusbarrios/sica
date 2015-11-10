<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modificardatospersonal extends CI_Controller {

	function __construct(){

		parent::__construct();
		
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		$this->load->model('user', '', TRUE);

	}

	function index(){

		if(!$this->session->userdata('logged_in')){

			redirect('home', 'refresh');		

		}else{
 	
			$session_data = $this->session->userdata('logged_in');
			$id_persona = $session_data['id_persona'];
		
			$nombre = $this->user->get_nombre($id_persona);
			$apellido = $this->user->get_apellido($id_persona);
			$nombre_apellido = $nombre . " " . $apellido;
			$documento = $this->user->get_documento($id_persona);
			$alias = $this->user->get_alias($id_persona);
			$telefono_fijo = $this->user->get_phone($id_persona, 1);
			$telefono_movil = $this->user->get_phone($id_persona, 2);
			$email = $this->user->get_email($id_persona);

			$result = $this->user->get_domicilio($id_persona);
			if($result){
				foreach($result as $row){
					$direccion = $row->direccion;
					$localidad = $row->localidad;
				}
			}else{
				$direccion = NULL;
				$localidad = NULL;
			}

			$datos = array(
				'nombre_apellido'=>$nombre_apellido,
				'documento'=> $documento,
				'alias' => $alias,
				'telefono_fijo' => $telefono_fijo,
				'telefono_movil' => $telefono_movil,
				'email' => $email,
				'direccion' => $direccion,
				'localidad' => $localidad);

			$this->load->library('form_validation');
			$this->load->view('user/modificardatospersonal', $datos, FALSE);

		}
	}
	
	function guardar(){
		$documento = $this->input->post('txt_documento');
		$nombre_apellido = $this->input->post('txt_nombre_apellido');
		$alias = $this->input->post('txt_alias');
		$telefono_fijo = $this->input->post('txt_telefono_fijo');
		$telefono_movil = $this->input->post('txt_telefono_movil');
		$email = $this->input->post('txt_email');
		$direccion = $this->input->post('txt_direccion');
		$localidad = $this->input->post('txt_localidad');

		$datos = array(
				'documento' => $documento,
				'nombre_apellido' => $nombre_apellido,
				'alias' => $alias,
				'telefono_fijo' => $telefono_fijo,
				'telefono_movil' => $telefono_movil,
				'email' => $email,
				'direccion' => $direccion,
				'localidad' => $localidad,
				'mensaje' => NULL);

		$this->load->library('form_validation');

		$this->form_validation->set_rules('txt_alias','Alias', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_telefono_fijo', 'Número de telefono fijo', 'trim|integer|xss_clean');
		$this->form_validation->set_rules('txt_telefono_movil','Número de telefono movil', 'trim|integer|required|xss_clean');
		$this->form_validation->set_rules('txt_email','Email', 'valid_email|required|xss_clean');
		$this->form_validation->set_rules('txt_direccion','Dirección', 'required|xss_clean');
		$this->form_validation->set_rules('txt_localidad','Localidad', 'required|xss_clean');


		$this->form_validation->set_message('required', '<b>%s</b> es obligatorio');
		$this->form_validation->set_message('integer', '<b>%s</b> no es un número entero');
		$this->form_validation->set_message('valid_email', '<b>%s</b> no es correcto');
		$this->form_validation->set_message('min_length', '<b>%s</b> no tiene la cantidad requerida de caracteres');
		$this->form_validation->set_message('max_length', '<b>%s</b> no tiene la cantidad requerida de caracteres');

		if($this->form_validation->run()){
			
			$session_data = $this->session->userdata('logged_in');
			$id_persona = $session_data['id_persona'];
			
			$this->user->save_alias($id_persona, $alias);
			$this->user->save_phone($id_persona, 1, $telefono_fijo);
			$this->user->save_phone($id_persona, 2, $telefono_movil);
			$this->user->save_email($id_persona, $email);
			$this->user->save_domicilio($id_persona, $direccion, $localidad);
		
			$datos['mensaje'] = "Modificación exitosa";
		}

		$this->load->view('user/modificardatospersonal', $datos, FALSE);

	}
}