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
		
//		$this->form_validation->set_rules('slc_actividad', 'Actividad', 'required');
//		$this->form_validation->set_rules('slc_periodo', 'Periodo', 'required');
//		$this->form_validation->set_rules('slc_facultad', 'Facultad', 'required');
//		$this->form_validation->set_rules('slc_sede', 'Sede', 'required');
//		$this->form_validation->set_rules('slc_carrera', 'Carrera', 'required');
//		$this->form_validation->set_rules('slc_semestre', 'Semestre', 'required');
//		$this->form_validation->set_rules('slc_periodo', 'Periodo', 'required');
//		$this->form_validation->set_rules('txt_inicio', 'Inicio', 'required');
//		$this->form_validation->set_rules('txt_periodo', 'Periodo', 'required');

		$this->form_validation->set_message('required', 'El campo es obligatorio');
		
		$id_actividad	= $this->input->post('slc_actividad');
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1){
				$this->form_validation->set_rules('slc_facultad', 'Facultad', 'required');
				$id_facultad = $this->input->post('slc_facultad');
			}else{
				$id_facultad = $session_data["id_facultad"];
			}
		}
		$id_sede 		= $this->input->post('slc_sede');
		$id_carrera 	= $this->input->post('slc_carrera');
		$id_semestre 	= $this->input->post('slc_semestre');
		$id_periodo		= $this->input->post('slc_periodo');
		$fecha_inicio	= $this->input->post('txt_inicio');
		if($this->input->post('txt_fin')){
			$this->form_validation->set_rules('txt_fin', 'Fin', 'required');
			$fecha_fin	= $this->input->post('txt_fin');
		}
		if ($this->form_validation->run()){
			$periodo_actualizado = 0;
			$periodo_nuevo = 0;
			if($id_carrera == 'todas'){
				$carreras = $this->m_periodo->get_relacion_sede_carrera($id_facultad, $id_sede, false, true);
				if($carreras){
					foreach($carreras->result() as $row_carrera){
						echo $row_carrera->carrera . "<br>";
						if($id_semestre == 'cpi'|| $id_semestre == 'impar' || $id_semestre == 'par'){
							$semestres = $this->m_periodo->get_semestre($id_facultad, $row_carrera->id_carrera, false, $id_semestre);
						}else if($id_semestre){
							$semestres = $this->m_periodo->get_semestre($id_facultad, $row_carrera->id_carrera, $id_semestre, false);
						}else{
							$semestres = false;
						}

						if($semestres){

							foreach($semestres->result() as $row_semestre){
								$asignaturas = $this->m_periodo->get_asignatura($id_facultad, $row_carrera->id_carrera, $row_semestre->id_semestre);
								
								if($asignaturas){
									foreach($asignaturas->result() as $row_asignatura){
										$resultado = $this->m_periodo->guardar_periodo($id_facultad, $id_sede, $row_carrera->id_carrera, $row_semestre->id_semestre, $row_asignatura->id_asignatura, $id_periodo, $id_actividad, $fecha_inicio, $fecha_fin, true);
										($resultado)? $periodo_nuevo ++ : $periodo_actualizado ++;
									}
								}
							}
						}
					}
				}
			}else if($id_carrera){
				if($id_semestre == 'cpi' || $id_semestre == 'par' || $id_semestre == 'impar'){
					$semestres = $this->m_periodo->get_semestre($id_facultad, $id_carrera, false, $id_semestre);
				}else if($id_semestre){
					$semestres = $this->m_periodo->get_semestre($id_facultad, $id_carrera, $id_semestre, false);
				}else{
					$semestres = false;
				}

				if($semestres){
					foreach($semestres->result() as $row_semestre){
						$asignaturas = $this->m_periodo->get_asignatura($id_facultad, $id_carrera, $row_semestre->id_semestre);
						
						if($asignaturas){
							foreach($asignaturas->result() as $row_asignatura){
							$resultado = $this->m_periodo->guardar_periodo($id_facultad, $id_sede, $id_carrera, $row_semestre->id_semestre, $row_asignatura->id_asignatura, $id_periodo, $id_actividad, $fecha_inicio, $fecha_fin, true);
								($resultado)? $periodo_nuevo ++ : $periodo_actualizado ++;
							}
						}
					}
				}
			}
			$msn = "Se cargo exitosamente: $periodo_nuevo nuevos y $periodo_actualizado modificado";
		}else{
			$msn = false;
		}		

		//Obtencion de las actividades
		$actividades = $this->m_periodo->get_actividad();
		//Obtencion de facultades si fuera el programador
		if($session_data = $this->session->userdata('logged_in')){
			if($session_data["id_rol"] == 1){
				$facultades = $this->m_carreras->get_relacion_sede_carrera(false, false, false, true);
				if($facultades && $facultades->num_rows() == 1 && !$id_facultad){
					$facultades_ 	= $facultades->row_array();
					$id_facultad	= $facultades_['id_facultad'];
				}
			}
		}

		//Obtencion de sedes relacionadas a la facultad
		if($id_facultad){
			$creacion 	= $this->m_carreras->get_creacion($id_facultad, false, false);
			$sedes 		= $this->m_carreras->get_relacion_sede_carrera($id_facultad, false, false, true);
			if($sedes && $sedes->num_rows() == 1 && !$id_sede){
				$sedes_ 	= $sedes->row_array();
				$id_sede 	= $sedes_['id_sede'];
			}
		}else{
			$sedes 		= false;
			$creacion 	= false;
		}

		//Obtencion de carreras
		if($id_facultad && $id_sede){
			$creacion 	= $this->m_carreras->get_creacion($id_facultad, $id_sede, false);
			$carreras 	= $this->m_carreras->get_relacion_sede_carrera($id_facultad, $id_sede, false, true);
			if($carreras && $carreras->num_rows() == 1 && !$id_carrera){
				$carreras_ 	= $carreras->row_array();
				$id_carrera = $carreras_['id_carrera'];
			}
		}else{
			$carreras 	= false;
		}

		//Obtenecion de semestres
		if($id_carrera && $id_carrera != 'todas'){
			$creacion 	= $this->m_carreras->get_creacion($id_facultad, $id_sede, $id_carrera);
			$semestres 	= $this->m_carreras->get_semestre($id_facultad, $id_carrera);
		}else
			$semestres 	= false;

		//Obtencion de detalle
		if($id_facultad && $id_sede && $id_carrera == 'todas' && $id_semestre && $id_periodo && $id_actividad){
			$periodos 	= $this->m_periodo->get_periodo($id_facultad, $id_sede, false, $id_semestre, false, $id_periodo, $id_actividad, false, false);
			$motrar_carreras 	= true;
		}else if($id_facultad && $id_sede && $id_carrera && $id_semestre && $id_periodo && $id_actividad){
			$periodos 	= $this->m_periodo->get_periodo($id_facultad, $id_sede, $id_carrera, $id_semestre, false, $id_periodo, $id_actividad, false, false);
			$mostrar_carreras 	= false;
		}else{
			$periodos 			= false;
			$mostrar_carreras 	= false;
		}
		$datos = array(
			'mostrar_carreras' 	=> $mostrar_carreras,
			'periodos' 			=> $periodos,
			'msn'				=> false,
		);
		$detalle = $this->load->view('periodos/frm_crear_detalle', $datos, true);

		$datos = array(
			'actividades'	=> $actividades,
			'facultades'	=> $facultades,
			'sedes'			=> $sedes,
			'carreras'		=> $carreras,
//			'semestres'		=> $semestres,
//			'asignaturas'	=> $asignaturas,
			'creacion'		=> $creacion,
			'detalle' 		=> $detalle,
			'msn'			=> $msn,
		);

		$this->load->view('periodos/frm_crear', $datos, FALSE);
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