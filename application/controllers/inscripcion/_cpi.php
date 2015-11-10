<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpi extends CI_Controller {

	function __construct(){

		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('m_facultad', 'facultad', TRUE);
		$this->load->model('m_sedes', 'sedes', TRUE);
		$this->load->model('m_carreras', 'carreras', TRUE);
		$this->load->model('user', 'usuarios', TRUE);
		$this->load->model('inscripcion', 'inscripciones', TRUE);
		$this->load->model('m_departamentos', 'departamentos', TRUE);
	}
	
	function date_check($date) {
		$ddmmyyy='(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])';
		return (bool) preg_match("/$ddmmyyy$/", $date);
	}

	function index(){

		$this->load->view('header', FALSE);
		$this->load->view('menu', FALSE);

		$this->form_validation->set_rules('slc_sede', '<b>Sede</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('slc_carrera', '<b>Carrera</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_documento', '<b>Documento</b>', 'trim|required|xss_clean|callback_validar_inscripcion');
		$this->form_validation->set_rules('slc_tipo_documento', '<b>Tipo de documento</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_nombre', '<b>Nombre</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_apellido', '<b>Apellido</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_nacionalidad', '<b>Nacionalidad</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_lugar_nacimiento', '<b>Lugar de nacimiento</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_fecha_nacimiento', '<b>Fecha de nacimiento</b>', 'trim|required|xss_clean|callback_date_check');
		$this->form_validation->set_rules('txt_grupo_sanguineo', '<b>Grupo sanguineo</b>', '');
		$this->form_validation->set_rules('slc_sexo', '<b>Genero</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('slc_estado_civil', '<b>Estado civil</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_email', '<b>Email</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_telefono_movil', '<b>Télefono movil</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_telefono_fijo', '<b>Télefono fijo</b>', '');
		$this->form_validation->set_rules('txt_direccion_domicilio', '<b>Dirección de domicilio</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_localidad_domicilio', '<b>Localidad de domicilio</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_colegio', '<b>Colegio</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_localidad_colegio', '<b>Localidad colegio</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_departamento_colegio', '<b>Departamento colegio</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_bachillerato', '<b>Bachillerato</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_anho_egreso', '<b>Año de egreso</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_empresa_trabajo', '<b>Trabajo</b>', '');
		$this->form_validation->set_rules('txt_cargo_trabajo', '<b>Cargo</b>', '');
		$this->form_validation->set_rules('txt_telefono_trabajo', '<b>Telefono</b>', '');
		$this->form_validation->set_rules('txt_clave', '<b>Clave</b>', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txt_confirmar_clave', '<b>Confirmar clave</b>', 'trim|required|matches[txt_clave]|xss_clean');

		$this->form_validation->set_message('required', 'Campo %s es obligatorio');
		$this->form_validation->set_message('validar_inscripcion', 'Ya esta inscripto');
		$this->form_validation->set_message('date_check', 'La fecha no es valida, respetar el formato dd/mm/aaaa');
		$this->form_validation->set_message('matches', 'Las claves no son iguales');

		$id_facultad = $this->input->post('slc_facultad');
		$sede = $this->input->post('slc_sede');
		$carrera = $this->input->post('slc_carrera');
		$id_semestre = 0;
		$anho = date('Y');
		$fecha = date("Y-m-d h:i:s");
		$documento = $this->input->post('txt_documento');
		$tipo_documento = $this->input->post('slc_tipo_documento');
		$nombre = $this->input->post('txt_nombre');
		$apellido = $this->input->post('txt_apellido');
		$nacionalidad = $this->input->post('txt_nacionalidad');
		$lugar_nacimiento = $this->input->post('txt_lugar_nacimiento');
		$dia_nacimiento = $this->input->post('slc_dia_nacimiento');
		$mes_nacimiento = $this->input->post('slc_mes_nacimiento');
		$anho_nacimiento = $this->input->post('txt_anho_nacimiento');
		$grupo_sanguineo = $this->input->post('txt_grupo_sanguineo');
		$sexo = $this->input->post('slc_sexo');
		$estado_civil = $this->input->post('slc_estado_civil');
		$email = $this->input->post('txt_email');
		$telefono_movil = $this->input->post('txt_telefono_movil');
		$telefono_fijo = $this->input->post('txt_telefono_fijo');
		$direccion_domicilio = $this->input->post('txt_direccion_domicilio');
		$localidad_domicilio = $this->input->post('txt_localidad_domicilio');
		$colegio = $this->input->post('txt_colegio');
		$localidad_colegio = $this->input->post('txt_localidad_colegio');
		$departamento_colegio = $this->input->post('txt_departamento_colegio');
		$bachillerato = $this->input->post('txt_bachillerato');
		$anho_egreso = $this->input->post('txt_anho_egreso');
		$empresa_trabajo = $this->input->post('txt_empresa_trabajo');
		$cargo_trabajo = $this->input->post('txt_cargo_trabajo');
		$telefono_trabajo = $this->input->post('txt_telefono_trabajo');
		
		$frm_msn = $frm_msn_class = false;
		
		$facultades = $this->facultad->get_facultad();
		
		if(!$id_facultad && $facultades->num_rows() > 1)
			$sedes = false;			
		else
			$sedes = $this->sedes->get_sede($id_facultad);


		if($this->form_validation->run()){
			
			$id_nacionalidad = $this->usuarios->guardar_nacionalidad($nacionalidad);
			if($id_persona = $this->usuarios->existe_documento($documento)){
				$this->usuarios->cambiar_estado_civil($id_persona, $estado_civil);
				if($grupo_sanguineo != ''){
					if(!$this->usuarios->tiene_grupo_sanguineo($id_persona))
						$this->usuarios->guardar_grupo_sanguineo($id_persona, $grupo_sanguineo);
				}
			}else{
				$nombres = explode(" ", $nombre);
				$apellidos = explode(" ", $apellido);
				$alias =  $nombres[0] . " " . $apellidos[0];
				$fecha_nacimiento = $anho_nacimiento . "-" . $mes_nacimiento . "-" . $dia_nacimiento;
				$id_persona = $this->usuarios->guardar_persona($nombre, $apellido, $alias, $id_nacionalidad, $lugar_nacimiento, $fecha_nacimiento, $grupo_sanguineo, $sexo, $estado_civil);
				$this->usuarios->guardar_documento($id_persona, 1, $tipo_documento, $documento);
				$this->usuarios->guardar_colegio($id_persona, 1, $colegio, $localidad_colegio, $departamento_colegio, $bachillerato, $anho_egreso);
			}
			
			$this->usuarios->save_email($id_persona, $email);
			$this->usuarios->save_phone($id_persona, 1, $telefono_fijo);
			$this->usuarios->save_phone($id_persona, 2, $telefono_movil);
			$this->usuarios->save_domicilio($id_persona, $direccion_domicilio, $localidad_domicilio);

			if($empresa_trabajo != '')
				$this->usuarios->guardar_trabajo($id_persona, $empresa_trabajo, $cargo_trabajo, $telefono_trabajo);
			
			$this->inscripcion->guardar_inscripcion_semestre($id_universidad, $id_facultad, $sede, $carrera, $id_semestre, $anho, $id_persona, $fecha);
			
			$this->load->view('inscripcion/cpi_detalle');

		}else{
			
			
			if($sede)
				$carreras = $this->carreras->get_carrera($id_facultad, $sede);
			else
				$carreras = false;

			$tipos_documento = $this->usuarios->get_tipo_documento();
		
			$datos = array(
				'facultades' => $facultades,
				'sedes' => $sedes,
				'carreras' => $carreras,
				'tipos_documento' => $tipos_documento,
				'sede' => $sede,
				'carrera' => $carrera,
//				'documento' => $documento,
//				'tipo_documento' => $tipo_documento,
//				'nombre' => $nombre,
//				'apellido' => $apellido,
//				'nacionalidad' => $nacionalidad,
//				'lugar_nacimiento' => $lugar_nacimiento,
//				'dia_nacimiento' => $dia_nacimiento,
//				'mes_nacimiento' => $mes_nacimiento,
//				'anho_nacimiento' => $anho_nacimiento,
//				'grupo_sanguineo' => $grupo_sanguineo,
//				'sexo' => $sexo,
//				'estado_civil' => $estado_civil,
//				'email' => $email,
//				'telefono_movil' => $telefono_movil,
//				'telefono_fijo' => $telefono_fijo,
//				'direccion_domicilio' => $direccion_domicilio,
//				'localidad_domicilio' => $localidad_domicilio,
//				'colegio' => $colegio,
//				'localidad_colegio' => $localidad_colegio,
//				'departamento_colegio' => $departamento_colegio,
//				'bachillerato' => $bachillerato,
//				'anho_egreso' => $anho_egreso,
//				'empresa_trabajo' => $empresa_trabajo,
//				'cargo_trabajo' => $cargo_trabajo,
//				'telefono_trabajo' => $telefono_trabajo,
				'frm_msn' => $frm_msn,
				'frm_msn_class' => $frm_msn_class,
			);
			$this->load->view('inscripcion/cpi', $datos, FALSE);
		}
		
	}
	
	function validar_inscripcion(){
		$documento = $this->input->post('txt_documento');
		if($id_persona = $this->usuarios->existe_documento($documento)){
			$id_universidad = 1;
			$id_facultad = 1;
			$sede = $this->input->post('slc_sede');
			$carrera = $this->input->post('slc_carrera');
			$id_semestre = 0;
			if($this->inscripciones->controlar_existencia($id_universidad, $id_facultad, $carrera, $id_semestre, $id_persona))
				return false;

		}
		return true;
	}
	
	function validar_fecha(){
		
	}
	
	function actualizar_slc_carrera(){
		$id_facultad = $this->input->post('facultad');
		$id_sede = $this->input->post('sede');

		$carreras = $this->carreras->get_carrera($id_facultad, $id_sede);
/*		
		if($carreras)
			echo $carreras->num_rows();
		else 
			echo 'no';
*/		
		$slc = "<option value=''>-----</option>";
		foreach($carreras->result() as $row){
			$slc .= "<option value=$row->id_carrera>$row->carrera</option>";
		}
		
		echo $slc;

	}
	
	function actualizar_slc_sede($id_facultad){
		$sedes = $this->carreras->get_sede($id_facultad);
		
		$slc = "<option value=''>-----</option>";
		foreach($sedes->result() as $row){
			$slc .= "<option value=$row->id_sede>$row->ciudad</option>";
		}
		
		echo $slc;
		
	}
}