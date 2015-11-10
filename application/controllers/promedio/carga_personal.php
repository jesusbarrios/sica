<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Carga_personal extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
//		$this->load->model('m_sedes', '', TRUE);
//		$this->load->model('m_carreras', '', TRUE);
//		$this->load->model('m_asignaturas', '', TRUE);
		$this->load->model('user', '', TRUE);
//		$this->load->model('m_inscripcion', '', TRUE);
//		$this->load->model('m_calificacion', '', TRUE);
		$this->load->model('m_promedio', '', TRUE);

		if(!$this->session->userdata('logged_in')){
			redirect('home', 'refresh');			
		}
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
		
		if(isset($_POST['btn_cancelar'])){
			$url_actual = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
			header("location: $url_actual");	
		}

		$this->form_validation->set_rules('txt_documento', '<b>Documento</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_apellido', '<b>Apellido</b>', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('txt_nombre', '<b>Nombre</b>', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('slc_sede', '<b>Sede</b>', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('slc_carrera', '<b>Carrera</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('slc_semestre', '<b>Semestre</b>', 'trim|required|xss_clean');

		$this->form_validation->set_message('required', 'Campo %s es obligatorio');
		
		$apellido = false;
		$nombre = false;
		$sedes = false;
		$carreras = false;
		$semestres = false;
		$detalles = false;
		$mensaje = false;
		
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
	
		$documento = $this->input->post('txt_documento');
		$persona = $this->user->get_persona($documento);
		if($persona){
			$row = $persona->row_array();
				
			$id_persona = $row['id_persona'];
			
			$sedes = $this->m_promedio->get_sede($id_facultad, $id_persona);
		}
		
		if($this->input->post('slc_sede')){
			$id_sede = $this->input->post('slc_sede');
			$carreras = $this->m_promedio->get_carrera($id_facultad, $id_sede, $row['id_persona']);
		}
		
		if($this->input->post('slc_carrera')){
			$id_carrera = $this->input->post('slc_carrera');
			$semestres = $this->m_promedio->get_semestre($id_facultad, $id_sede, $id_carrera, $id_persona);	
		}

		if($this->form_validation->run()){
			$mensaje = 'sin_cambio';
			$id_sede = $this->input->post('slc_sede');
			$id_carrera = $this->input->post('slc_carrera');
			$id_semestre = $this->input->post('slc_semestre');
			$periodo = '2015';
			
			$asignaturas = $this->m_promedio->get_asignatura($id_facultad, $id_sede, $id_carrera, $id_semestre, $periodo, $id_persona);
			
			$periodo = date('Y');

			if($asignaturas){
				
				foreach($asignaturas->result() as $row){
					$campo_parcial = 'slc_parcial' . $row->id_semestre . '_' . $row->id_asignatura;
					$campo_asistencia = 'slc_asistencia' . $row->id_semestre . '_' . $row->id_asignatura;

					if($this->input->post($campo_parcial) != ''){
						$fecha = date('Y-m-d H:i:s');

						
						$parcial = $this->input->post($campo_parcial);
						$asistencia = $this->input->post($campo_asistencia);
//						if($asistencia == '')
//							$asistencia = '-';
						
						$this->m_promedio->actualizar_detalles_inscripcion_semestre($id_facultad, $id_sede, $id_carrera, $id_semestre, $periodo, $id_persona, $row->id_asignatura, $parcial, $asistencia, false, false);
						
						$mensaje = 'exitoso';					
					}
				}
			}
		}

		if($this->input->post('slc_semestre')){
			$id_semestre = $this->input->post('slc_semestre');
			$detalles = $this->cargar_detalles(TRUE);
		}

		$datos = array(
			'apellido' => $apellido,
			'nombre' => $nombre,
			'sedes' => $sedes,
			'carreras' => $carreras,
			'semestres' => $semestres,
			'detalles' => $detalles,
			'mensaje' => $mensaje,
		);

		$this->load->view('promedio/carga_personal', $datos, FALSE);
	}
	
	function autocompletar_campos($retornar  = false){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$documento = $this->input->post('txt_documento');
		$persona = $this->user->get_persona($documento);
		if($persona){
			$row = $persona->row_array();	
			$datos = array(
				'apellido' => $row['apellido'],
				'nombre' => $row['nombre'],
			);
			$sedes = $this->m_promedio->get_sede($id_facultad, $row['id_persona']);

			
			//SEDES
			if($sedes){
				if($sedes->num_rows() > 1){
					$campo_sede = "<option value=NULL>-----</option>";
					$campo_carrera = "<option value=NULL>-----</option>";
					$campo_semestre = "<option value=NULL>-----</option>";
				}else{
				
					$campo_sede = "";
					$sede = $sedes->row_array();
					$carreras = $this->m_promedio->get_carrera($id_facultad, $sede['id_sede'], $row['id_persona']);	
					
					//CARRERAS
					if($carreras){
						if($carreras->num_rows() > 1){
							$campo_carrera = "<option value=NULL>-----</option>";
							$campo_semestre = "<option value=NULL>-----</option>";
						
						}else{
							$campo_carrera = "";
							$carrera = $carreras->row_array();
							$semestres = $this->m_promedio->get_semestre($id_facultad, $sede['id_sede'], $carrera['id_carrera'], $row['id_persona']);
							
							//SEMESTRES
							if($semestres){
								$campo_semestre = "<option value=NULL>-----</option>";
								foreach($semestres->result() as $row)
									if($row->id_semestre > 0)
										$campo_semestre .= "<option value=" . $row->id_semestre . ">" . $row->semestre . "</option>";	
							}else{
								$campo_semestre = "<option value=NULL>-----</option>";
							}
						}
						foreach($carreras->result() as $row)
								$campo_carrera .= "<option value=" . $row->id_carrera . ">" . $row->carrera . "</option>";
					}else{
						$campo_carrera = "<option value=NULL>-----</option>";
					}
				}
				foreach($sedes->result() as $row)
					$campo_sede .= "<option value=" . $row->id_sede . ">" . $row->ciudad . "</option>";
			}else{
				$campo_sede = "<option value=NULL>-----</option>";
			}	
		}else{
			$campo_sede = "<option value=NULL>-----</option>";
			$campo_carrera = "<option value=NULL>-----</option>";
			$campo_semestre = "<option value=NULL>-----</option>";
		}

		$datos['sedes'] = $campo_sede;
		$datos['carreras'] = $campo_carrera;
		$datos['semestres'] = $campo_semestre;

		if($retornar)
	    	return $datos;
	    else	
	    	echo json_encode($datos);
	}


	function actualizar_slc_semestre(){

		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_sede = $this->input->post('slc_sede');
		$id_carrera = $this->input->post('slc_carrera');
		$documento = $this->input->post('txt_documento');
		$persona = $this->user->get_persona($documento);

		$slc = "<option value=''>-----</option>";

		if($persona){
			$row = $persona->row_array();
			$id_persona = $row['id_persona'];

			$semestres = $this->m_promedio->get_semestre($id_facultad, $id_sede, $id_carrera, $id_persona);	

			if($semestres){

				foreach($semestres->result() as $row){
					if($row->id_semestre > 0)
						$slc .= "<option value=$row->id_semestre>$row->semestre</option>";
				}
			}
		}
		echo $slc;
	}

	function actualizar_slc_carrera(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_sede = $this->input->post('slc_sede');
		$documento = $this->input->post('txt_documento');
		$persona = $this->user->get_persona($documento);
		if($persona){
			$row = $persona->row_array();
			$id_persona = $row['id_persona'];
			$carreras = $this->m_promedio->get_carrera($id_facultad, $id_sede, $id_persona);
			if($carreras){
				if($carreras->num_rows() > 1){
					$campo_carrera = "<option value=NULL>-----</option>";
					$campo_semestre = "<option value=NULL>-----</option>";
				}else{
					$campo_carrera = "";
					$carrera = $carreras->row_array();
					$semestres = $this->m_promedio->get_semestre($id_facultad, $id_sede, $carrera['id_carrera'], $id_persona);
					//SEMESTRES
					if($semestres){
						$campo_semestre = "<option value=NULL>-----</option>";
						foreach($semestres->result() as $row)
							if($row->id_semestre > 0)
								$campo_semestre .= "<option value=" . $row->id_semestre . ">" . $row->semestre . "</option>";	
					}else{
						$campo_semestre = "<option value=NULL>-----</option>";
					}
				}
				foreach($carreras->result() as $row)
					$campo_carrera .= "<option value=" . $row->id_carrera . ">" . $row->carrera . "</option>";
			}else{
				$campo_carrera = "<option value=NULL>-----</option>";
				$campo_semestre = "<option value=NULL>-----</option>";
			}
		}else{
			$campo_carrera = "<option value=NULL>-----</option>";
			$campo_semestre = "<option value=NULL>-----</option>";
		}

		$datos['carreras'] = $campo_carrera;
		$datos['semestres'] = $campo_semestre;
		echo json_encode($datos);
	}
/*	
	function actualizar_slc_sede($id_facultad){
		$sedes = $this->m_carreras->get_sede($id_facultad);

		$slc = "<option value=''>-----</option>";
		foreach($sedes->result() as $row){
			$slc .= "<option value=$row->id_sede>$row->ciudad</option>";
		}

		echo $slc;
	}
*/	
	function validar_inscripcion_cpi($documento){
		if($id_persona = $this->user->existe_documento($documento)){
			$id_facultad = $this->input->post('slc_facultad');
			$id_sede = $this->input->post('slc_sede');
			$id_carrera = $this->input->post('slc_carrera');
			$id_semestre = 0;

			if($this->m_promedio->get_inscripcion_semestre($id_facultad, $id_sede, $id_carrera, $id_semestre, false, $id_persona))
				return false;
		}

		return true;
	}

	function cargar_detalles($retornar = false){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		$id_sede = $this->input->post('slc_sede');
		$id_carrera = $this->input->post('slc_carrera');
		$id_semestre = $this->input->post('slc_semestre');
		$documento = $this->input->post('txt_documento');
		$persona = $this->user->get_persona($documento);		
		$row = $persona->row_array();
		$periodo = '2015';
		$id_persona = $row['id_persona'];		

		$asignaturas = $this->m_promedio->get_detalle_inscripcion_semestre($id_facultad, $id_sede, $id_carrera, $id_semestre, $periodo, $id_persona);
		

		if($asignaturas){
//			echo $periodo;
			$contador = 0;
			foreach($asignaturas->result() as $row){
				$periodo = date('Y');
//				$detalles_inscripcion = $this->m_inscripcion->get_asignatura($id_facultad, $id_sede, $id_carrera, $id_semestre, $periodo, $id_persona, $row->id_asignatura);

				if($row->parcial != '-'){
					$this->table->add_row(array(
						form_label($row->asignatura),
						$row->parcial,
						$row->asistencia,
					));
				}else{
					$campo_parcial = 'slc_parcial' . $row->id_semestre . '_' . $row->id_asignatura;
					$campo_asistencia = 'slc_asistencia' . $row->id_semestre . '_' . $row->id_asignatura;

					$promedios = array(null => '---');
					for($i = 0; $i <= 100; $i++)
						$promedios[$i] = $i;
						
					$promedios['--'] = 'Ignorar';

					$this->table->add_row(array(
						form_label($row->asignatura),
						form_dropdown($campo_parcial, $promedios),
						form_dropdown($campo_asistencia, $promedios),
					));
					
				}
				$contador += 1;
			}
			$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="tbl_detalles">' ));

			if($contador > 1)
				$this->table->set_heading(array('Asignaturas', 'Parciales', 'Asistencias'));
			else
				$this->table->set_heading(array('Asignatura', 'Parcial', 'Asistencia'));
			
			if($retornar)
				return $this->table->generate();
			else
				echo $this->table->generate();
		
		}
	}
}