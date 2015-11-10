<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crear extends CI_Controller {

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

		$this->form_validation->set_rules('txt_periodo', 'Periodo', 'required');
		$this->form_validation->set_message('required', 'El campo es obligatorio');
		
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1){
				$this->form_validation->set_rules('slc_facultad', 'Facultad', 'required');
				$id_facultad = $this->input->post('slc_facultad');
			}else{
				$id_facultad = $session_data["id_facultad"];
			}
		}


		if ($this->form_validation->run()){
			
			$mensaje 	= 'Se creo exitosamente';
		}else{
			$mensaje 	= false;
		}

		$periodos 	= $this->m_periodo->get_periodos($id_facultad, false);
		$detalles	= $this->load->view('periodos/crear_detalles', array('periodos' => $periodos), true);

		$datos = array(
			'mensaje'	=> $mensaje,
			'detalles'	=> $detalles,
		);

		$this->load->view('periodos/crear_cabecera', $datos, FALSE);
	}

	function actualizar_slc_sede(){
//		$actividad 		= $this->input->post('slc_actividad');
		$session_data 	= $this->session->userdata('logged_in');
		if($session_data['id_rol'] == 1)
			$id_facultad 	= $this->input->post('slc_facultad');
		else
			$id_facultad	= $session_data['id_facultad'];
		$slc_sede 		= $slc_carrera = $slc_periodo = '';
		$sedes 			= $this->m_carreras->get_relacion_sede_carrera($id_facultad, false, false, true);
		if($sedes){
			if($sedes->num_rows() == 1){
				$sedes_ 	= $sedes->row_array();
				$carreras 	= $this->m_carreras->get_relacion_sede_carrera($id_facultad, $sedes_['id_sede'], false, true);
				if($carreras){
					if($carreras->num_rows() == 1){
						$carreras_ 		= $carreras->row_array();
						$creacion = $this->m_periodo->get_creacion($carreras_['id_facultad'], $carreras_['id_sede'], $carreras_['id_carrera']);
					}else{
						$slc_carrera .= "<option value='todas'>Todas</option>";
						$creacion = $this->m_periodo->get_creacion($sedes_['id_facultad'], $sedes_['id_sede'], false);
					}
					foreach($carreras->result() as $row)
						$slc_carrera .= "<option value=$row->id_carrera>$row->carrera</option>";
				}else{
					$slc_carrera 	= "<option value=''>-----</option>";
					$creacion = $this->m_periodo->get_creacion($sedes_['id_facultad'], $sedes_['id_sede'], false);
				}
			}else{
				$slc_sede 		.= "<option value=''>-----</option>";
				$slc_carrera 	.= "<option value=''>-----</option>";
				$creacion 		= $this->m_periodo->get_creacion($id_facultad, false, false);
			}
			foreach($sedes->result() as $row)
				$slc_sede 	.= "<option value=$row->id_sede>$row->sede</option>";
		}else{
			$slc_sede 		= "<option value=''>-----</option>";
			$slc_carrera 	= "<option value=''>-----</option>";
			$creacion 		= false;
		}
		$slc_periodo	.= "<option value=>-----</option>";
		if($creacion)
			for($x = date('Y'); $x >= date('Y', strtotime($creacion)); $x --)
				$slc_periodo	.= "<option value=$x>$x</option>";
		$datos = array(
			'slc_sede'		=> $slc_sede,
			'slc_carrera'	=> $slc_carrera,
			'slc_periodo'	=> $slc_periodo,
			'detalle'		=> '',
		);
		echo json_encode($datos);
	}

	function actualizar_slc_carrera(){
		$session_data = $this->session->userdata('logged_in');
		if($session_data['id_rol'] == 1)
			$id_facultad 	= $this->input->post('slc_facultad');
		else
			$id_facultad	= $session_data['id_facultad'];

		$id_sede		= $this->input->post('slc_sede');
		$id_semestre 	= $this->input->post('slc_semestre');
		$id_periodo 	= $this->input->post('slc_periodo');
		$slc_carrera 	= $slc_semestre = $slc_periodo = '';
		$relaciones		= $this->m_carreras->get_relacion_sede_carrera($id_facultad, $id_sede, false, true);
 		if($relaciones){
			if($relaciones->num_rows() == 1){
				$relaciones_	= $relaciones->row_array();
				$creacion 		= $this->m_periodo->get_creacion($relaciones_['id_facultad'], $relaciones_['id_sede'], $relaciones_['id_carrera']);
			}else{
				$slc_carrera .= "<option value='todas'>Todas</option>";
				$creacion = $this->m_periodo->get_creacion($id_facultad, $id_sede, false);
			}
			foreach($relaciones->result() as $row)
				$slc_carrera .= "<option value=$row->id_carrera>$row->carrera</option>";

			//Campo semestre
			$semestres = array('CPI', 'Impar', 'Par');
			for($x = 0; $x < 3; $x++){
				if($semestres[$x] == $id_semestre)
					$slc_semestre .= "<option value=$semestres[$x] selected=selected>$semestres[$x]</option>";
				else
					$slc_semestre .= "<option value=$semestres[$x]>$semestres[$x]</option>";
			}

			//Campo periodo
			$slc_periodo	.= "<option value=>-----</option>";
			if($creacion)
				for($x = date('Y'); $x >= date('Y', strtotime($creacion)); $x --){
					if($id_periodo == $x)
						$slc_periodo	.= "<option value=$x selected=selected>$x</option>";
					else
						$slc_periodo	.= "<option value=$x>$x</option>";
			}
		}else{
			$slc_carrera 	= "<option value=''>-----</option>";
			$slc_semestre 	= "<option value=''>-----</option>";
			$slc_periodo 	= "<option value=''>-----</option>";
		}

		$datos = array(
			'slc_carrera'	=> $slc_carrera,
			'slc_semestre'	=> $slc_semestre,
			'slc_periodo'	=> $slc_periodo,
		);
		echo json_encode($datos);
	}

	function actualizar_slc_semestre(){
		$session_data = $this->session->userdata('logged_in');
		if($session_data['id_rol'] == 1)
			$id_facultad 	= $this->input->post('slc_facultad');
		else
			$id_facultad	= $session_data['id_facultad'];
		$id_sede 		= $this->input->post('slc_sede');
		$id_carrera 	= $this->input->post('slc_carrera');
		$semestres 		= $this->m_periodo->get_semestre($id_facultad, $id_carrera);
		$slc_semestre	= '';
		$slc_periodo 	= "<option value=>-----</option>";
		if($semestres){
			if($semestres->num_rows() > 1){
				$slc_semestre .= "<option value=''>-----</option>";
				$slc_semestre .= "<option value='todos'>Todos</option>";
			}
			foreach($semestres->result() as $row){
				if($row->id_semestre > 1)
					$slc_semestre .= "<option value=$row->id_semestre>$row->semestre</option>";
			}
		}else{
			$slc_semestre .= "<option value=''>-----</option>";
		}

		if($id_carrera == 'todas')
			$creacion = $this->m_periodo->get_creacion($id_facultad, $id_sede, false);
		else
			$creacion = $this->m_periodo->get_creacion($id_facultad, $id_sede, $id_carrera);
		for($i = date('Y'); $i >= date('Y', strtotime($creacion)); $i --)
			$slc_periodo .= "<option value=$i>$i</option>";

		$datos = array(
			'semestres'	=> $slc_semestre,
			'periodos'	=> $slc_periodo,
		);
		echo json_encode($datos);
	}

	function actualizar_detalle(){
		$id_actividad	= $this->input->post('slc_actividad');
		$session_data = $this->session->userdata('logged_in');
		if($session_data['id_rol'] == 1)
			$id_facultad 	= $this->input->post('slc_facultad');
		else
			$id_facultad	= $session_data['id_facultad'];
		$id_sede 		= $this->input->post('slc_sede');
		$id_carrera 	= $this->input->post('slc_carrera');
		$id_semestre	= $this->input->post('slc_semestre');
		$id_periodo 	= $this->input->post('slc_periodo');

		if($id_carrera == 'todas'){
			$periodos 	= $this->m_periodo->get_periodo($id_facultad, $id_sede, false, $id_semestre, false, $id_periodo, $id_actividad, false, false);
		}else{
			$periodos 	= $this->m_periodo->get_periodo($id_facultad, $id_sede, $id_carrera, $id_semestre, false, $id_periodo, $id_actividad, false, false);
		}

		if($id_carrera == 'todas')
			$mostrar_carrera = true;
		else
			$mostrar_carrera = false;
		if($id_semestre == 'Impar' || $id_semestre == 'Par')
			$mostrar_semestre = true;
		else
			$mostrar_semestre = false;
		$datos = array(
			'periodos' 			=> $periodos,
			'msn'				=> false,
			'mostrar_carrera'	=> $mostrar_carrera,
			'mostrar_semestre' 	=> $mostrar_semestre,
		);
		$this->load->view('periodos/frm_crear_detalle', $datos, false);
	}

	function obtener_nombre_carrera(){
		$session_data = $this->session->userdata('logged_in');
		if($session_data['id_rol'] == 1)
			$id_facultad = $this->input->post('slc_facultad');
		else
			$id_facultad = $session_data["id_facultad"];
		$id_carrera = $this->input->post('carrera');
		$carreras = $this->m_carreras->get_carrera($id_facultad, $id_carrera);

		if($carreras){
			$row = $carreras->row_array();
			echo $row['carrera'];
		}
	}

	function eliminar(){
		$session_data = $this->session->userdata('logged_in');
		if($session_data['id_rol'] == 1)
			$id_facultad = $this->input->post('slc_facultad');
		else
			$id_facultad = $session_data["id_facultad"];
		$id_sede 		= $this->input->post('slc_sede');
		$id_carrera 	= $this->input->post('slc_carrera');
		$id_semestre 	= $this->input->post('slc_semestre');
		$id_periodo 	= $this->input->post('slc_periodo');
		$id_actividad 	= $this->input->post('slc_actividad');
		$carrera 		= $this->input->post('carrera');

		$this->m_periodo->eliminar_periodo($id_facultad, $id_sede, $carrera, $id_semestre, false, $id_periodo, $id_actividad);
		$periodos 	= $this->m_periodo->get_periodo($id_facultad, $id_sede, $id_carrera, $id_semestre, false, $id_periodo, $id_actividad, false, false);
		$carreras = $this->m_carreras->get_carrera($id_facultad, $carrera);

		if($carreras){
			$carreras_ = $carreras->row_array();
			$nombre_carrere = $carreras_['carrera'];
		}else{
			$nombre_carrere = '';
		}
		$datos = array(
			'carreras' 	=> true,
			'periodos' 	=> $periodos,
			'msn'		=> "Se elimino exitosamente el periodo de la carrera $nombre_carrere",
		);
		$this->load->view('periodos/frm_crear_detalle', $datos, false);
	}
	
}