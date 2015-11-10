<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evaluacion_final extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('m_facultad', '', TRUE);
		$this->load->model('m_sedes', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);
		$this->load->model('m_asignaturas', '', TRUE);
		$this->load->model('user', '', TRUE);
		$this->load->model('m_inscripcion', '', TRUE);
		
		
		if(!$this->session->userdata('logged_in')){

			redirect('home', 'refresh');			


		}
	}
	
	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$this->form_validation->set_rules('txt_documento', '<b>Documento</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_apellido', '<b>Apellido</b>', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('txt_nombre', '<b>Nombre</b>', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('slc_sede', '<b>Sede</b>', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('slc_carrera', '<b>Carrera</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('slc_semestre', '<b>Semestre</b>', 'trim|required|xss_clean');

		$this->form_validation->set_message('required', 'Campo %s es obligatorio');
		
		
		
		
		
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$documento = $this->input->post('txt_documento');
		$persona = $this->user->get_persona($documento);
		
		$id_sede = $this->input->post('slc_sede');
		$id_carrera = $this->input->post('slc_carrera');
		$id_semestre = $this->input->post('slc_semestre');
		
		$estudiante = false;
		$sedes = false;
		$carreras = false;
		$semestres = false;
		$asignaturas = false;
		
		echo $documento;
		if($persona){
			$row = $persona->row_array();
			
			echo $row['id_persona'];
			echo 'ok';
			$sedes = $this->m_inscripcion->get_inscripcion_semestre($id_facultad, false, false, $row['id_persona']);
			
			if($sedes){
				if($sedes->num_rows() == 1){
					$carreras = $this->m_carreras->get_carrera($id_facultad, $id_sede, false, $row['id_persona']);
					
					if($carreras){
						if($carreras->num_rows() == 1)
							$semestres = $this->m_carreras->get_semestre($id_facultad, $id_carrera);
					}				
				}
			}
			
			
			$asignaturas = $this->m_asignaturas->get_asignatura($id_facultad, $id_carrera, $id_semestre);
		}
		
		

		if($this->form_validation->run()){

		}

		$datos = array(
			'sedes' => $sedes,
			'carreras' => $carreras,
			'semestres' => $semestres,
			'asignaturas' => $asignaturas,
		);

		$this->load->view('inscripcion/semestre', $datos, FALSE);



	}
	
	function autocompletar_campos(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];

		$documento = $this->input->post('documento');
		$persona = $this->user->get_persona($documento);
		if($persona){
			$row = $persona->row_array();	
			
			$datos = array(
				'apellido' => $row['apellido'],
				'nombre' => $row['nombre'],
			);
			
			$sedes = $this->m_inscripcion->get_inscripcion_semestre($id_facultad, false, false, $row['id_persona']);
			
			if($sedes){
				if($sedes->num_rows() > 1){
					$campo_sede = "<option value=NULL>-----</option>";
				}else{
					$campo_sede = "";
					$sede = $sedes->row_array();
					$carreras = $this->m_inscripcion->get_inscripcion_semestre($id_facultad, $sede['id_sede'], false, $row['id_persona']);	
					
					if($carreras){
						if($carreras->num_rows() > 1){
							$campo_carrera = "<option value=NULL>-----</option>";
						}else{
							$campo_carrera = "";
							$carrera = $carreras->row_array();
							$semestres = $this->m_carreras->get_semestre($id_facultad, $carrera['id_carrera']);
							if($semestres){
								$campo_semestre = "<option value=NULL>-----</option>";
								$campo_semestre .= "<option value=>Todos</option>";
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
	    echo json_encode($datos);
	}

	
	
	function guardar(){
	//	return NULL;
	}
	
	function actualizar_slc_carrera(){

		$id_facultad = $this->input->post('facultad');
		$id_sede = $this->input->post('sede');

		$carreras = $this->m_carreras->get_carrera($id_facultad, $id_sede);
		
		if($carreras){
			if($carreras->num_rows() > 1)
				$slc = "<option value=''>-----</option>";
			else
				$slc = '';
			
			foreach($carreras->result() as $row)
				$slc .= "<option value=$row->id_carrera>$row->carrera</option>";
		}else{
			$slc = "<option value=''>-----</option>";
		}
		
		echo $slc;
	}
	
	function actualizar_slc_sede($id_facultad){
		$sedes = $this->m_carreras->get_sede($id_facultad);
		
		$slc = "<option value=''>-----</option>";
		foreach($sedes->result() as $row){
			$slc .= "<option value=$row->id_sede>$row->ciudad</option>";
		}
		
		echo $slc;
		
	}
	
	function validar_inscripcion_cpi($documento){
		if($id_persona = $this->user->existe_documento($documento)){
			$id_facultad = $this->input->post('slc_facultad');
			$id_sede = $this->input->post('slc_sede');
			$id_carrera = $this->input->post('slc_carrera');
			$id_semestre = 0;
		
			if($this->m_inscripcion->get_inscripcion_semestre($id_facultad, $id_sede, $id_carrera, $id_semestre, $id_persona))
				return false;
		}
		
		return true;
	}
	
	function cargar_detalles(){
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
		
		$id_carrera = $this->input->post('carrera');
		$id_semestre = $this->input->post('semestre');
		
		$asignaturas = $this->m_asignaturas->get_asignatura($id_facultad, $id_carrera, $id_semestre);
		
		if($asignaturas){
			
			$slc_oportunidad = array('Ordinario', 'Extraordinario', 'Regularizació');
			$slc_calificacion = array(null => '-----', '0' => 'Cero', '1' => 'Uno', '2' => 'Dos', '3' => 'Tres', '4' => 'Cuatro', '5' => 'Cinco');
			
			foreach($asignaturas->result() as $row){
				$campo_calificacion = 'txt_calificacion_' . $row->id_semestre . '_' . $row->id_asignatura;
				$campo_oportunidad = 'slc_oportunidad_' . $row->id_semestre . '_' . $row->id_asignatura;
				$campo_fecha = 'txt_fecha_' . $row->id_semestre . '_' . $row->id_asignatura;
				
				$txt_fecha = array(
					'type' => 'date',
					'id' => $campo_fecha,
					'name' => $campo_fecha,
					'value' => set_value($campo_fecha),
				);
				$this->table->add_row(array(
					form_label($row->asignatura),
					form_dropdown($campo_calificacion, $slc_calificacion, set_value($campo_calificacion)),
					form_dropdown($campo_oportunidad, $slc_oportunidad, set_value($campo_oportunidad)),
					form_input($txt_fecha),
				));
			}
			$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="tbl_detalles">' ));
			$this->table->set_heading(array('Asignaturas', 'Calificacion', 'Oportunidad', 'Fecha'));
			echo $this->table->generate();
			
		}
		
	}
}