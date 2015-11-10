<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registrar_usuario extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('m_facultad', '', TRUE);
		$this->load->model('m_sedes', '', TRUE);
		$this->load->model('m_carreras', '', TRUE);
		$this->load->model('m_asignaturas', '', TRUE);
		$this->load->model('user', '', TRUE);
		$this->load->model('m_inscripcion', '', TRUE);
		$this->load->model('m_periodo', '', TRUE);
		
		$this->id_actividad = 1;
		$this->id_semestre 	= 1;
//		$this->fecha = date('Y-m-d');
		$this->fecha = false;
		
		if(!$this->session->userdata('logged_in')){

			redirect('home', 'refresh');			
		}
	}
	
	function autocompletar_campos(){
		$documento = $this->input->post('documento');
		$persona = $this->user->get_persona($documento);
		
		if(!$persona)
			echo 'no-registrado';

		$row = $persona->row_array();

		$datos = array(
			'tipo_documento' => $row['id_tipo_documento'],
			'nombre' => $row['nombre'],
			'apellido' => $row['apellido'],
			'nacionalidad' => $row['nacionalidad'],
			'lugar_nacimiento' => ($row['lugar_nacimiento'])? $row['lugar_nacimiento'] : ' ',
			'fecha_nacimiento' => $row['fecha_nacimiento'],
			'grupo_sanguineo' => $row['grupo_sanguineo'],
			'genero' => $row['genero'],
			'estado_civil' => $row['estado_civil'],
			'correo' => $row['correo'],
			'telefono' => $row['telefono'],
		);
		
		$domicilios = $this->user->get_domicilio($row['id_persona']);
		if($domicilios){
			$domicilios_ = $domicilios->row_array();
			$datos['pais_domicilio'] = $domicilios_['pais'];
			$datos['departamento_domicilio'] = $domicilios_['departamento'];
			$datos['ciudad_domicilio'] = $domicilios_['ciudad'];
			$datos['direccion_domicilio'] = $domicilios_['direccion'];
			$datos['telefono_domicilio'] = $domicilios_['telefono_fijo'];

		}else{
			$datos['pais_domicilio'] = '';
			$datos['departamento_domicilio'] = '';
			$datos['ciudad_domicilio'] = '';
		}
		
		$trabajos = $this->user->get_trabajo($row['id_persona']);
		if($trabajos){
			$trabajos_ = $trabajos->row_array();
			$datos['empresa_trabajo'] = $trabajos_['empresa'];
			$datos['cargo_trabajo'] = $trabajos_['cargo'];
			$datos['telefono_trabajo'] = $trabajos_['telefono'];
		}else{
			$datos['empresa_trabajo'] = '';
			$datos['cargo_trabajo.'] = '';
			$datos['telefono_trabajo'] = '';
		}

		$colegios = $this->user->get_relacion_colegio_persona($row['id_persona']);
		if($colegios){
			$colegios_ = $colegios->row_array();
			$datos['colegio'] = $colegios_['colegio'];
			$datos['bachillerato'] = $colegios_['bachillerato'];
			$datos['anho_egreso'] = $colegios_['anho_egreso'];
			$datos['pais_colegio'] = $colegios_['pais'];
			$datos['departamento_colegio'] = $colegios_['departamento'];
			$datos['ciudad_colegio'] = $colegios_['ciudad'];
		}else{
			$datos['colegio'] = '';
			$datos['bachillerato'] = '';
			$datos['anho_egreso'] = '';
			$datos['pais_colegio'] = '';
			$datos['departamento_colegio'] = '';
			$datos['ciudad_colegio'] = '';
		}
	    echo json_encode($datos);
	}

	function actualizar_slc_sede($id_facultad){
		$sedes = $this->m_inscripcion->get_sede($id_facultad, $this->id_actividad);
		
		$slc = "<option value=''>-----</option>";
		foreach($sedes->result() as $row){
			$slc .= "<option value=$row->id_sede>$row->ciudad</option>";
		}
		
		echo $slc;
		
	}

	function date_check($date) {
		$ddmmyyy='(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])';
		return (bool) preg_match("/$ddmmyyy$/", $date);
	}

	function index(){
		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);
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
		$this->form_validation->set_rules('txt_email', '<b>Email</b>', 'trim|xss_clean');
		$this->form_validation->set_rules('txt_telefono_movil', '<b>Télefono movil</b>', 'trim|required|xss_clean');

		$documento = $this->input->post('txt_documento');
		$id_tipo_documento = $this->input->post('slc_tipo_documento');
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
		$this->form_validation->set_rules('txt_pais_domicilio', '<b>País</b>', '');
		$this->form_validation->set_rules('txt_departamento_domicilio', '<b>Departamento</b>', '');
		$this->form_validation->set_rules('txt_localidad_domicilio', '<b>Localidad</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_direccion_domicilio', '<b>Dirección de domicilio</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_telefono_fijo', '<b>Télefono fijo</b>', '');

		$pais_domicilio = $this->input->post('txt_pais_domicilio');
		$departamento_domicilio = $this->input->post('txt_departamento_domicilio');
		$localidad_domicilio = $this->input->post('txt_localidad_domicilio');
		$direccion_domicilio = $this->input->post('txt_direccion_domicilio');
		$telefono_fijo = $this->input->post('txt_telefono_fijo');

		/*
		*
		*TRABAJO
		*
		*/
		$this->form_validation->set_rules('txt_empresa_trabajo', '<b>Trabajo</b>', '');
		$this->form_validation->set_rules('txt_cargo_trabajo', '<b>Cargo</b>', '');
//		$this->form_validation->set_rules('txt_telefono_trabajo', '<b>Telefono</b>', '');

		$empresa_trabajo = $this->input->post('txt_empresa_trabajo');
		$cargo_trabajo = $this->input->post('txt_cargo_trabajo');
		$telefono_trabajo = $this->input->post('txt_telefono_trabajo');

		/*
		*
		*MENSAJES DE VALIDACION
		*
		*/
		$this->form_validation->set_message('required', 'Campo %s es obligatorio');
		$this->form_validation->set_message('validar_inscripcion_cpi', 'Ya esta inscripto');
		$this->form_validation->set_message('date_check', 'La fecha no es valida, respetar el formato dd/mm/aaaa');
		$this->form_validation->set_message('validar_periodo', 'La carrera no esta habilitada para este periodo');
		$this->form_validation->set_message('matches', 'Las claves no son iguales');

		if($this->form_validation->run()){
			//PERSONA
			$id_persona = $this->user->guardar_persona($documento, $id_tipo_documento, $nombre, $apellido, $nacionalidad, $lugar_nacimiento, $fecha_nacimiento, $grupo_sanguineo, $sexo, $estado_civil);
			//EMAIL
			if($email)
				$this->user->save_email($id_persona, $email);
			//TELEFONO MOVIL
			$this->user->save_phone($id_persona, $telefono_movil);
			//DOMICILIO
			$this->user->save_domicilio($id_persona, $pais_domicilio, $departamento_domicilio, $localidad_domicilio, $direccion_domicilio, $telefono_fijo);
			//COLEGIO
			$this->user->relacionar_colegio_persona($id_persona, $pais_colegio, $departamento_colegio, $localidad_colegio, $colegio, $bachillerato, $anho_egreso);
			//TRABAJO
			if($empresa_trabajo && $cargo_trabajo)
				$this->user->guardar_trabajo($id_persona, $empresa_trabajo, $cargo_trabajo, $telefono_trabajo);
			$tipos_documento 	= $this->user->get_tipo_documento($id_tipo_documento);
			$facultades 		= $this->m_facultad->get_facultad($id_facultad);
			$sedes 				= $this->m_sedes->get_sede($id_facultad, $id_sede);
			$carreras 			= $this->m_carreras->get_carrera($id_facultad, false, $id_carrera);
			$datos = array(
				'facultades' => $facultades,
				'sedes' => $sedes,
				'carreras' => $carreras,
				'tipos_documento' => $tipos_documento,
			);	
			$this->load->view('inscripcion/cpi_resumen', $datos, FALSE);
		/*
		*FORMULARIO NO VALIDADO
		*/
		}else{
/*			$facultades = $this->m_facultad->get_facultad();
			if($id_facultad){
				$sedes = $this->user->get_sedesXfacultad($id_facultad);
			}else
				$sedes = false;
*/
			$tipos_documento = $this->user->get_tipo_documento();

			$datos = array(
//				'facultades' => $facultades,
//				'sedes' => $sedes,
				'tipos_documento' => $tipos_documento,
			);
			$this->load->view('usuario/frm_registrar', $datos, FALSE);
		}
	}
}