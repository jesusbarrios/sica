<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inscripcion extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('m_facultad', '', TRUE);
		$this->load->model('m_sedes', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);
		$this->load->model('m_asignaturas', '', TRUE);
		$this->load->model('user', '', TRUE);
		$this->load->model('m_inscripcion', '', TRUE);
		
		
//		if(!$this->session->userdata('logged_in')){

//			redirect('home', 'refresh');			


//		}
	}
	
	function autocompletar_campos(){
		$documento = $this->input->post('documento');
		$persona = $this->user->get_persona($documento);
		$row = $persona->row_array();

		$datos = array(
			'tipo_documento' => $row['id_tipo_documento'],
			'nombre' => $row['nombre'],
			'apellido' => $row['apellido'],
			'nacionalidad' => $row['nacionalidad'],
			'lugar_nacimiento' => $row['lugar_nacimiento'],
			'fecha_nacimiento' => $row['fecha_nacimiento'],
			'grupo_sanguineo' => $row['grupo_sanguineo'],
			'genero' => $row['genero'],
			'estado_civil' => $row['estado_civil'],
			'correo' => $row['correo'],
			'telefono' => $row['telefono'],
		);
		
//		$domicilio = $this->user->get_domicilio($row['id_persona']);
/*		
		if($domicilio){
			$row = $domicilio->row_array();
			$datos['pais'] = $row['pais'];
			$datos['departamento'] = $row['departamento'];
		}
*/		
/*		$colegio = $this->user->get_colegio($row['id_persona']);
		
		if($colegio){
			$row = $colegio->row_array();
			$datos['colegio'] = $row['colegio'];
			$datos['bachillerato'] = $row['bachillerato'];
			$datos['anho_egreso'] = $row['anho_egreso'];
			$datos['pais_colegio'] = $row['pais'];
			$datos['departamento_colegio'] = $row['departamento'];
			$datos['localidad_colegio'] = $row['ciudad'];
		}else{
			$datos['colegio'] = '';
			$datos['bachillerato'] = '';
			$datos['anho_egreso'] = '';	
			$datos['pais_colegio'] = '';
			$datos['departamento_colegio'] = '';
			$datos['localidad_colegio'] = '';
		}
*/
	    echo json_encode($datos);

	}

	function semestre(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$this->form_validation->set_rules('txt_documento', '<b>Documento</b>', 'trim|required|xss_clean');

		$this->form_validation->set_rules('slc_sede', '<b>Sede</b>', 'trim|required|xss_clean');	
		$this->form_validation->set_rules('slc_carrera', '<b>Carrera</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('slc_semestre', '<b>Semestre</b>', 'trim|required|xss_clean');

		$this->form_validation->set_message('required', 'Campo %s es obligatorio');

		$documento = $this->input->post('txt_documento');
		$persona = $this->user->get_persona($documento);

		if($this->form_validation->run()){
			$session_data = $this->session->userdata('logged_in');
			$id_facultad = $session_data["id_facultad"];

			$row = $persona->row_array();
			$id_sede = $this->input->post('slc_sede');
			$id_carrera = $this->input->post('slc_carrera');
			$id_semestre = $this->input->post('slc_semestre');

			$sedes = $this->m_inscripcion->get_inscripcion_semestre($id_facultad, false, false, $row['id_persona']);
			$carreras = $this->m_carreras->get_carrera($id_facultad, $id_sede);
			$semestres = $this->m_carreras->get_semestre($id_facultad, $id_carrera);
			$asignaturas = $this->m_asignaturas->get_asignatura($id_facultad, $id_carrera, $id_semestre);

		}else{
			$estudiante = false;
			$sedes = false;
			$carreras = false;
			$semestres = false;
			$asignaturas = false;
		}

		$datos = array(
			'estudiante' => $estudiante,
			'sedes' => $sedes,
			'carreras' => $carreras,
			'semestres' => $semestres,
			'asignaturas' => $asignaturas,
		);

		$this->load->view('inscripcion/semestre', $datos, FALSE);



/*	
		$sedes = $this->m_sede->get_sedes();
		$carreras = $this->m_carrera->get_carreras();
		
		$datos = array(
			'sedes' => $sedes,
			'carreras' => $carreras);

		$this->load->view('inscripcion/v_semestre', $datos, FALSE);
*/

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

	function date_check($date) {
		$ddmmyyy='(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])';
		return (bool) preg_match("/$ddmmyyy$/", $date);
	}
	
	function cpi(){

		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		
		/*
		*
		*CARRERA
		*
		*/
//		$this->form_validation->set_rules('slc_facultad', '<b>Facultad</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('slc_sede', '<b>Sede</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('slc_carrera', '<b>Carrera</b>', 'trim|required|xss_clean');
		
		$session_data = $this->session->userdata('logged_in');
		$id_facultad = $session_data["id_facultad"];
//		$id_facultad = $this->input->post('slc_facultad');
		$id_sede = $this->input->post('slc_sede');
		$id_carrera = $this->input->post('slc_carrera');
		
		/*
		*
		*DATOS PERSONAL
		*
		*/
		$this->form_validation->set_rules('txt_documento', '<b>Documento</b>', 'trim|required|xss_clean|callback_validar_inscripcion_cpi');
		$this->form_validation->set_rules('slc_tipo_documento', '<b>Tipo de documento</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_nombre', '<b>Nombre</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_apellido', '<b>Apellido</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_nacionalidad', '<b>Nacionalidad</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_lugar_nacimiento', '<b>Lugar de nacimiento</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_fecha_nacimiento', '<b>Fecha de nacimiento</b>', 'trim|required|xss_clean|callback_date_check');
		$this->form_validation->set_rules('txt_grupo_sanguineo', '<b>Grupo sanguineo</b>', '');
		$this->form_validation->set_rules('slc_genero', '<b>Genero</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('slc_estado_civil', '<b>Estado civil</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_email', '<b>Email</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_telefono_movil', '<b>Télefono movil</b>', 'trim|required|xss_clean');
		
		$documento = $this->input->post('txt_documento');
		$tipo_documento = $this->input->post('slc_tipo_documento');
		$nombre = $this->input->post('txt_nombre');
		$apellido = $this->input->post('txt_apellido');
		$nacionalidad = $this->input->post('txt_nacionalidad');
		$lugar_nacimiento = $this->input->post('txt_lugar_nacimiento');
		$fecha_nacimiento = $this->input->post('txt_fecha_nacimiento');
		$grupo_sanguineo = $this->input->post('txt_grupo_sanguineo');
		$sexo = $this->input->post('slc_sexo');
		$estado_civil = $this->input->post('slc_estado_civil');
		$email = $this->input->post('txt_email');
		$telefono_movil = $this->input->post('txt_telefono_movil');


		/*
		*
		*DOMICILIO
		*
		*/
/*		
		$this->form_validation->set_rules('txt_pais_domicilio', '<b>País</b>', '');
		$this->form_validation->set_rules('txt_departamento_domicilio', '<b>Departamento</b>', '');
		$this->form_validation->set_rules('txt_localidad_domicilio', '<b>Localidad</b>', '');
		$this->form_validation->set_rules('txt_direccion_domicilio', '<b>Dirección de domicilio</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_telefono_fijo', '<b>Télefono fijo</b>', '');
		
		$pais_domicilio = $this->input->post('txt_pais_domicilio');
		$departamento_domicilio = $this->input->post('txt_departamento_domicilio');
		$localidad_domicilio = $this->input->post('txt_localidad_domicilio');
		$direccion_domicilio = $this->input->post('txt_direccion_domicilio');
		$telefono_fijo = $this->input->post('txt_telefono_fijo');

		
		/*
		*
		*COLEGIO
		*
		*/
/*		$this->form_validation->set_rules('txt_pais_colegio', '<b>País</b>', '');
		$this->form_validation->set_rules('txt_departamento_colegio', '<b>Departamento</b>', '');
		$this->form_validation->set_rules('txt_localidad_colegio', '<b>Localidad colegio</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_colegio', '<b>Colegio</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_bachillerato', '<b>Bachillerato</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_anho_egreso', '<b>Año de egreso</b>', 'trim|required|xss_clean');
		
		$pais_colegio = $this->input->post('txt_pais_colegio');
		$departamento_colegio = $this->input->post('txt_departamento_colegio');
		$localidad_colegio = $this->input->post('txt_localidad_colegio');
		$colegio = $this->input->post('txt_colegio');
		$bachillerato = $this->input->post('txt_bachillerato');
		$anho_egreso = $this->input->post('txt_anho_egreso');
		
		/*
		*
		*TRABAJO
		*
		*/
/*		$this->form_validation->set_rules('txt_empresa_trabajo', '<b>Trabajo</b>', '');
		$this->form_validation->set_rules('txt_cargo_trabajo', '<b>Cargo</b>', '');
		$this->form_validation->set_rules('txt_telefono_trabajo', '<b>Telefono</b>', '');
		
		$empresa_trabajo = $this->input->post('txt_empresa_trabajo');
		$cargo_trabajo = $this->input->post('txt_cargo_trabajo');
		$telefono_trabajo = $this->input->post('txt_telefono_trabajo');
		
		/*
		*
		*DATOS DEL USUARIO
		*
		*/
/*		$this->form_validation->set_rules('txt_clave', '<b>Clave</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_confirmar_clave', '<b>Confirmar clave</b>', 'trim|required|matches[txt_clave]|xss_clean');
		
		/*
		*
		*OTROS DATOS
		*
		*/
		$id_semestre = 0;
		$anho = date('Y');
		$fecha = date("Y-m-d h:i:s");
		$mensaje = false;
		
		
		/*
		*
		*MENSAJES DE VALIDACION
		*
		*/
		$this->form_validation->set_message('required', 'Campo %s es obligatorio');
		$this->form_validation->set_message('validar_inscripcion_cpi', 'Ya esta inscripto');
		$this->form_validation->set_message('date_check', 'La fecha no es valida, respetar el formato dd/mm/aaaa');
		$this->form_validation->set_message('matches', 'Las claves no son iguales');

		if($this->form_validation->run()){
			
			/*
			*DATOS PERSONAL
			*/
			$id_nacionalidad = $this->user->guardar_nacionalidad($nacionalidad);
			if($id_persona = $this->user->existe_documento($documento)){
				$this->user->cambiar_estado_civil($id_persona, $estado_civil);
				if($grupo_sanguineo != ''){
					if(!$this->user->tiene_grupo_sanguineo($id_persona))
						$this->user->guardar_grupo_sanguineo($id_persona, $grupo_sanguineo);
				}
			}else{
				$nombres = explode(" ", $nombre);
				$apellidos = explode(" ", $apellido);
				$alias =  $nombres[0] . " " . $apellidos[0];
				$fecha_nacimiento = $anho_nacimiento . "-" . $mes_nacimiento . "-" . $dia_nacimiento;
				$id_persona = $this->usuarios->guardar_persona($nombre, $apellido, $alias, $id_nacionalidad, $lugar_nacimiento, $fecha_nacimiento, $grupo_sanguineo, $sexo, $estado_civil);
				$this->usuarios->guardar_documento($id_persona, 1, $tipo_documento, $documento);
			}
			
			$this->user->save_email($id_persona, $email);
			$this->user->save_phone($id_persona, $telefono_movil);
			
			/*
			*DOMICILIO
			*/
/*			$id_domicilio = NULL;
			$predeterminado = NULL;
			$this->usuarios->save_domicilio($id_persona, $pais_domicilio, $departamento_domicilio, $localidad_domicilio, $id_domicilio, $direccion_domicilio, $telefono_fijo, $predeterminado_fijo);
			
			/*
			*COLEGIO
			*/
/*			$this->usuarios->guardar_colegio($id_persona, $pais_colegio, $departamento_colegio, $localidad_colegio, $colegio, $bachillerato, $anho_egreso);

			/*
			*TRABAJO
			*/
/*			if($empresa_trabajo != '')
				$this->usuarios->guardar_trabajo($id_persona, $empresa_trabajo, $cargo_trabajo, $telefono_trabajo);

			/*
			*INSCRIPCION
			*/
			$estado = 'Inscripto';
			
			$this->m_inscripcion->guardar_inscripcion_semestre($id_facultad, $id_sede, $id_carrera, $id_semestre, $anho, $id_persona, $fecha, $estado);
			
			$asignaturas = $this->m_asignaturas->get_asignatura($id_facultad, $id_carrera, $id_semestre);
			
			if($asignaturas){
			foreach($asignaturas->result() as $row){
				$id_asignatura = $row->id_asignatura;
				$this->m_inscripcion->guardar_detalles_inscripcion_semestre($id_facultad, $id_sede, $id_carrera, $id_semestre, $anho, $id_persona, $id_asignatura, false, false, $estado, $fecha);
			}
			}
			$mensaje = "Inscripción exitosa";

		}
		
		$facultades = $this->m_facultad->get_facultad();
		
		if(!$id_facultad && $facultades->num_rows() > 1)
			$sedes = false;			
		else
			$sedes = $this->m_sedes->get_sede($id_facultad);

		if($id_sede)
			$carreras = $this->m_carreras->get_carrera($id_facultad, $id_sede);
		else
			$carreras = false;
				

		$tipos_documento = $this->user->get_tipo_documento();
		
		$datos = array(
			'facultades' => $facultades,
			'sedes' => $sedes,
			'carreras' => $carreras,
			'tipos_documento' => $tipos_documento,
			'mensaje' => $mensaje,
		);
		$this->load->view('inscripcion/cpi', $datos, FALSE);
	}
}