<?php

/*

	1 - super usuario
	10 - rector
	20 - decano
	30 - direccion academica
	40 - auxiliar academico
	50 - secretaria general
	60 - direccion administrativa
	70 - auxiliar administrativo
	100 - alumnos

*/

class User extends CI_Model{

	function get_personas($id_persona = false, $nombre = false, $apellido = false, $nacionalidad = false, $lugar_nac = false, $fecha_nac = false, $grupo_sang = false, $genero = false, $estado_civil = false, $clave = false){
		$this->db->select('*');
		if($id_persona)
			$this->db->where('t1.id_persona', $id_persona);
		if($nombre)
			$this->db->where('t1.nombre', $nombre);
		if($apellido)
			$this->db->where('t1.apellido', $apellido);
		if($nacionalidad)
			$this->db->where('t1.nacionalidad', $nacionalidad);
		if($lugar_nac)
			$this->db->where('t1.lugar_nacimiento', $lugar_nac);
		if($fecha_nac)
			$this->db->where('t1.fecha_nacimiento', $fecha_nac);
		if($grupo_sang)
			$this->db->where('t1.grupo_sanguineo', $grupo_sang);
		if($genero)
			$this->db->where('t1.genero', $genero);
		if($estado_civil)
			$this->db->where('t1.estado_civil', $estado_civil);
		if($clave){
			$this->db->where('t1.clave', $clave);
		}
//		$this->db->where('documentos.documento', $documento);
		$this->db->join('documentos as t2', 't2.id_persona = t1.id_persona');
//		$this->db->join('nacionalidades', 'nacionalidades.id_nacionalidad = t1.id_nacionalidad');
//		$this->db->join('telefonos', 'telefonos.id_persona = t1.id_persona AND telefonos.predeterminado =  1', 'left');
//		$this->db->join('correos', 't1.id_persona = correos.id_persona AND correos.predeterminado = 1', 'left');
//		$this->db->join('domicilios', 't1.id_persona = domicilios.id_persona AND domicilios.predeterminado = 1', 'left');
//		$this->db->join('ciudades', 'domicilios.id_ciudad = ciudades.id_ciudad', 'left');

		$personas = $this->db->get('personas as t1');

		if($personas->result())
			return $personas;
		return false;
	}
	/*
	*CAMBIAR CLAVE
	*/
	function recuperar_clave($documento){
		
		$this->db->where('documento', $documento);
		$documentos = $this->db->get('documentos');
		if($documentos->result()){
			$documentos_ = $documentos->row_array();
			$id_persona = $documentos_['id_persona'];
			
			$datos = array(
				'clave' => '12345',
			);
			$this->db->where('id_persona', $id_persona);
			$this->db->update('personas', $datos);
		}
		
		/*
		*
		*/
	}

	function save_new_pass($id_persona, $clave){
		$datos = array(
			'clave'=>$clave,
		);

		$this->db->where('id_persona', $id_persona);
		$this->db->update('personas', $datos);

		return TRUE;
	}

	/*
	*
	*NOMBRE
	*
	*/
	function get_nombre($id_persona){
		$this->db->select('nombre');
		$this->db->from('personas');
		$this->db->where('id_persona', $id_persona);
		$this->db->limit('1');

		$query = $this->db->get();

		if($query->num_rows() == 1){
			$row = $query->row_array();
			return $row['nombre'];
		}else{
			return FALSE;
		}
	}

	/*
	*
	*APELLIDO
	*
	*/
	function get_apellido($id_persona){
		$this->db->select('apellido');
		$this->db->from('personas');
		$this->db->where('id_persona', $id_persona);
		$this->db->limit('1');

		$query = $this->db->get();

		if($query->num_rows() == 1){
			$row = $query->row_array();
			return $row['apellido'];
		}else{
			return FALSE;
		}
	}

	/*
	*
	*DOCUMENTOS
	*
	*/
	function get_documentos($id_persona = false, $tipo = false, $documento = false){
		if($id_persona)
			$this->db->where('id_persona', $id_persona);

		if($tipo)
			$this->db->where('id_tipo_documento', $tipo);

		if($documento)
			$this->db->where('documento', $documento);

		$documentos = $this->db->get('documentos');

		if($documentos->result())
			return $documentos;
		return FALSE;
	}
	
	function existe_documento($documento){
		$result = $this->db->get_where('documentos', array('documento' => $documento));
		
		if($result->num_rows > 0){
			foreach($result->result() as $row)
				return $row->id_persona;
		}else{
			return false;
		}
	}

	function get_alias($id_persona){
		$this->db->select('alias');
		$this->db->from('personas');
		$this->db->where('id_persona', $id_persona);
		$this->db->limit('1');
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1){
			$row = $query->row_array();
			return $row['alias'];
		}else{
			return FALSE;
		}
	}

	function get_phone($id_persona, $id_tipo_telefono){
		$this->db->select('telefono');
		$this->db->from('telefonos');
		$this->db->where('id_persona', $id_persona);
		$this->db->where('id_tipo_telefono', $id_tipo_telefono);
		$this->db->where('predeterminado', '1');
		$this->db->limit('1');
		
		$query = $this->db->get();
		
		
		if($query->num_rows() == 1){
			$row = $query->row_array();
			
			return $row['telefono'];
		}else{
			return FALSE;
		}
	}

	function get_email($id_persona){
		$this->db->select('correo');
		$this->db->from('correos');
		$this->db->where('id_persona', $id_persona);
		$this->db->where('predeterminado', '1');
		$this->db->limit('1');

		$query = $this->db->get();

		if($query->num_rows() == 1){
			$row = $query->row_array();
			return $row['correo'];
		}else{
			return FALSE;	
		}
	}
	
	function guardar_persona($documento, $id_tipo_documento, $nombre, $apellido, $nacionalidad, $lugar_nacimiento, $fecha_nacimiento, $grupo_sanguineo, $sexo, $estado_civil){
		
		//VERIFICA SI YA EXISTE LA PERSONA
		if($id_persona = $this->existe_documento($documento)){
			$this->cambiar_estado_civil($id_persona, $estado_civil);

			if($grupo_sanguineo != ''){
				if(!$this->tiene_grupo_sanguineo($id_persona))
					$this->guardar_grupo_sanguineo($id_persona, $grupo_sanguineo);
			}
		}else{
			$id_nacionalidad = $this->guardar_nacionalidad($nacionalidad);
			$nombres = explode(" ", $nombre);
			$apellidos = explode(" ", $apellido);
			$alias =  $nombres[0] . " " . $apellidos[0];

			$this->db->select_max('id_persona');
			$personas = $this->db->get('personas');
			if($personas->result()){
				$personas_ = $personas->row_array();
				$id_persona = $personas_['id_persona'] + 1;
			}else{
				$id_persona = 1;
			}
			$datos = array(
				'id_persona' => $id_persona,
				'nombre' => $nombre,
				'apellido' => $apellido,
				'alias' => $alias,
				'id_nacionalidad' => $id_nacionalidad,
				'lugar_nacimiento' => $lugar_nacimiento,
				'fecha_nacimiento' => $fecha_nacimiento,
				'grupo_sanguineo' => $grupo_sanguineo,
				'genero' => $sexo,
				'estado_civil' => $estado_civil
			);
			$this->db->insert('personas', $datos);

			$this->guardar_documento($id_persona, $id_tipo_documento, $documento);
		}
		return $id_persona;
	}
	
	function guardar_documento($id_persona, $id_tipo_documento, $documento){
		$datos = array(
			'id_persona' 		=> $id_persona,
			'id_tipo_documento' => $id_tipo_documento,
			'documento' 		=> $documento,
		);
			
		$this->db->insert('documentos', $datos);
	}

	function save_alias($id_persona, $alias){

		$datos = array('alias' => $alias);

		$this->db->where('id_persona', $id_persona);
		$this->db->update('personas', $datos);

		return TRUE;
	}
	
	function cambiar_estado_civil($id_persona, $estado_civil){
		$this->db->set('estado_civil', $estado_civil);
		$this->db->where('id_persona', $id_persona);
		$this->db->update('personas');
		return true;
	}
	
	function tiene_grupo_sanguineo($id_persona){
		$result = $this->db->get_where('personas', array('id_persona'=> $id_persona));
		
		foreach($result->result() as $row){
			if($row->grupo_sanguineo == '')
				return false;
			else
				return true;
		}
	}
	
	function guardar_grupo_sanguineo($id_persona, $grupo_sanguineo){
		$this->db->set('grupo_sanguineo', $grupo_sanguineo);
		$this->db->where('id_persona', $id_persona);
		$this->db->update('personas');
		return true;
	}
	
	

	function save_phone($id_persona,$phone){
		//BUSCA EXISTENCIA DEL TELEFONO EN ESA PERSONA CON ESE TIPO DE TELEFONO
		$this->db->select('id_telefono');
		$this->db->from('telefonos');
		$this->db->where('id_persona', $id_persona);
		$this->db->where('telefono', $phone);
		
		$query = $this->db->get();
		
		
		//PONE EL VALOR CERO A PREDETERMINADO A TODOS LOS TELEFONOS DE ESA PERSONA DE ESE TIPO DE TELEFONO
		$datos = array(
			'predeterminado'=>'0');
				
		$this->db->where('id_persona', $id_persona);
		$this->db->update('telefonos', $datos);
		
		
		//SI EXISTE YA UN TELEFONO EN LA BASE DE DATOS, LO HACE PREDETERMINADO
		if($query->num_rows() == 1){
		
			$row = $query->row_array();
			
			$id_telefono = $row['id_telefono'];
			
			//PONE EL VALOR UNO A PREDETERMINADO A ESE TELEFONO DE ESA PERSONA DE ESE TIPO DE TELEFONO
			$datos = array(
				'predeterminado'=>'1');

			$this->db->where('id_persona', $id_persona);
			$this->db->where('id_telefono', $id_telefono);
			$this->db->update('telefonos', $datos);

		//SINO EXISTE EL TELEFONO AGREGA UNO NUEVO.
		}else{

			$this->db->select_max('id_telefono');
			$this->db->where('id_persona', $id_persona);
			$query = $this->db->get('telefonos');


			if($query->num_rows >= 1){
				$row = $query->row_array();
				$id_telefono =  $row['id_telefono'] + 1;
			}else{
				$id_telefono = 1;
			}
			
			$datos = array(
				'id_persona' => $id_persona,
				'id_telefono' => $id_telefono,
//				'id_tipo_telefono' => $id_tipo_telefono,
				'telefono' => $phone,
				'predeterminado' => '1');
			
			$this->db->insert('telefonos', $datos);

		}
		return TRUE;
	}

	function save_email($id_persona, $email){
		//PONE CERO A LOS PREDETERMINADOS DE TODOS LOS CORREOS DE ESA PERSONA
		$datos = array('predeterminado' => '0');

		$this->db->where('id_persona', $id_persona);
		$this->db->update('correos', $datos);

		//VERIFICAR EXISTENCIA DE EMAIL
		$this->db->select('id_correo');
		$this->db->where('id_persona', $id_persona);
		$this->db->where('correo', $email);
		$query = $this->db->get('correos');		

		//SI EL CORREO EXISTE LE ASIGNA UNO AL PREDETERMINADO Y CERO A TODOS LOS DEMAS CORREOS DE ESA PERSONA
		if($query->num_rows() >= 1){
			$row = $query->row_array();
			$id_email = $row['id_correo'];
			$datos = array('predeterminado' => '1');

			$this->db->where('id_persona', $id_persona);
			$this->db->where('id_correo', $id_email);
			$this->db->update('correos', $datos);	

		//SINO EXISTE AGREGA UNO NUEVO
		}else{
			$this->db->select_max('id_correo');
			$this->db->where('id_persona', $id_persona);

			$query = $this->db->get('correos');

			if($query->num_rows() >= 1){
				$row = $query->row_array();
				$id_email = $row['id_correo'] + 1;
			}else{
				$id_email = 1;
			}

			$datos = array(
				'id_persona' => $id_persona,
				'id_correo' => $id_email,
				'correo' => $email,
				'predeterminado' => '1');
			
			$this->db->insert('correos', $datos);
		}
		return TRUE;
	}
		
	function guardar_nacionalidad($nacionalidad){

		$datos = array('nacionalidad' => $nacionalidad);
		$result = $this->db->get_where('nacionalidades', $datos);
		
		if($result->num_rows() > 0){
			foreach($result->result() as $row)
				return $row->id_nacionalidad;
		}else{
			$this->db->select_max('id_nacionalidad');
			$result = $this->db->get('nacionalidades');
			if($result->num_rows() > 0){
				foreach($result->result() as $row)
					$id_nacionalidad = $row->id_nacionalidad + 1;
			}else{
				$id_nacionalidad = 1;
			}
			$datos['id_nacionalidad'] = $id_nacionalidad;
			$this->db->insert('nacionalidades', $datos);
			return $id_nacionalidad;
		}
	}
	
	/*
	*
	*COLEGIOS
	*
	*/
	function relacionar_colegio_persona($id_persona, $pais, $departamento, $ciudad, $colegio, $bachillerato, $anho_egreso){
		$this->db->where('id_persona', $id_persona);
		$relaciones = $this->db->get('relaciones_colegio_persona');
		if($relaciones->result())
			return false;
		
		$id_pais = $this->guardar_pais($pais);
		$id_departamento = $this->guardar_departamento($id_pais, $departamento);
		$id_ciudad = $this->guardar_ciudad($id_pais, $id_departamento, $ciudad);
		$id_colegio = $this->guardar_colegio($id_pais, $id_departamento, $id_ciudad, $colegio);
		$id_bachillerato = $this->guardar_bachillerato($bachillerato);

		$datos = array(
			'id_persona' 		=> $id_persona,
			'id_pais' 			=> $id_pais,
			'id_departamento'	=> $id_departamento,
			'id_ciudad'			=> $id_ciudad,
			'id_colegio' 		=> $id_colegio,
			'id_bachillerato'	=> $id_bachillerato,
			'anho_egreso' 		=> $anho_egreso,
		);
			
		$this->db->insert('relaciones_colegio_persona', $datos);
	}
	function get_relacion_colegio_persona($id_persona){
		$this->db->select('*');
		$this->db->where('t1.id_persona', $id_persona);
		$this->db->join('colegios as t2', 't1.id_colegio = t2.id_colegio', 'left');
		$this->db->join('bachilleratos as t3', 't1.id_bachillerato = t3.id_bachillerato', 'left');
		$this->db->join('paises as t4', 't1.id_pais = t4.id_pais', 'left');
		$this->db->join('departamentos as t5', 't1.id_pais = t5.id_pais AND t1.id_departamento = t5.id_departamento', 'left');
		$this->db->join('ciudades as t6', 't1.id_pais = t6.id_pais AND t1.id_departamento = t6.id_departamento AND t1.id_ciudad = t6.id_ciudad', 'left');
		$this->db->from('relaciones_colegio_persona as t1');

		$relaciones = $this->db->get();

		if($relaciones->result())
			return $relaciones;
		return false;
	}
	
	function guardar_colegio($id_pais, $id_departamento, $id_ciudad, $colegio){
		$this->db->where('id_pais', $id_pais);
		$this->db->where('id_departamento', $id_departamento);
		$this->db->where('id_ciudad', $id_ciudad);
		$this->db->where('colegio', $colegio);
		$colegios = $this->db->get('colegios');
		
		if($colegios->result()){
			$colegios_ = $colegios->row_array();
			return $colegios_['id_colegio'];
		}else{
			$this->db->where('id_pais', $id_pais);
			$this->db->where('id_departamento', $id_departamento);
			$this->db->where('id_ciudad', $id_ciudad);
			$this->db->select_max('id_colegio');
			$colegios = $this->db->get('colegios');	
			
			if($colegios->result()){
				$colegios_ = $colegios->row_array();
				$id_colegio = $colegios_['id_colegio'] + 1;
			}else
				$id_colegio = 1;
				
			$datos = array(
				'id_pais'			=> $id_pais,
				'id_departamento'	=> $id_departamento,
				'id_ciudad'			=> $id_ciudad,
				'id_colegio' 		=> $id_colegio,
				'colegio' 			=> $colegio,
				'direccion'			=> '',
				'telefono'			=> '',
			);
				
			$this->db->insert('colegios', $datos);
			return $id_colegio;
		}
		
	}
	function get_colegio($id_colegio){
		$this->db->where('id_colegio', $id_colegio);
		$colegios = $this->db->get('colegios');

		if($colegios->result())
			return $colegios;
		return false;
	}
	
	function guardar_bachillerato($bachillerato){
		$this->db->where('bachillerato', $bachillerato);
		$bachilleratos = $this->db->get('bachilleratos');
		
		if($bachilleratos->result()){
			$bachilleratos_ = $bachilleratos->row_array();
			return $bachilleratos_['id_bachillerato'];
		}else{
			$this->db->select_max('id_bachillerato');
			$bachilleratos = $this->db->get('bachilleratos');
			
			if($bachilleratos->result()){
				$bachilleratos_ = $bachilleratos->row_array();
				$id_bachillerato = $bachilleratos_['id_bachillerato'] + 1;
			}else
				$id_bachillerato = 1;
		}
		
		$datos = array(
			'id_bachillerato' 	=> $id_bachillerato,
			'bachillerato'		=> $bachillerato,
		);
		$this->db->insert('bachilleratos', $datos);
		return $id_bachillerato;

	}
	
	function get_tipo_documento($id_tipo_documento = FALSE){
		if($id_tipo_documento)
			$query = $this->db->get_where('tipos_documento', array('id_tipo_documento'=>$id_tipo_documento));
		else
			$query = $this->db->get('tipos_documento');

		if($query->result())
			return $query;
		
		return FALSE;
	}
	
	/*
	*
	* DOMICILIOS
	*
	*/
	function get_domicilio($id_persona){
		$this->db->select('*');
		$this->db->where('t1.id_persona', $id_persona);
		$this->db->order_by('t1.predeterminado', 'desc');
		$this->db->join('paises as t2', 't1.id_pais = t2.id_pais');
		$this->db->join('departamentos as t3', 't1.id_pais = t3.id_pais AND t1.id_departamento = t3.id_departamento');
		$this->db->join('ciudades as t4', 't1.id_pais = t4.id_pais AND t1.id_departamento = t4.id_departamento AND t1.id_ciudad = t4.id_ciudad');
		$this->db->from('domicilios as t1');
		$query = $this->db->get('domicilios');

		if($query->result())
			return $query;
		return FALSE;
	}
	
	function save_domicilio($id_persona, $pais, $departamento, $ciudad, $direccion, $telefono){
	
		$id_pais = $this->guardar_pais($pais);
		$id_departamento = $this->guardar_departamento($id_pais, $departamento);
		$id_ciudad = $this->guardar_ciudad($id_pais, $id_departamento, $ciudad);
		
		$this->db->where('id_persona', $id_persona);
		$this->db->where('id_pais', $id_pais);
		$this->db->where('id_departamento', $id_departamento);
		$this->db->where('id_ciudad', $id_ciudad);
		$this->db->where('direccion', $direccion);
		if($telefono)
			$this->db->where('telefono_fijo', $telefono);
		$domicilios = $this->db->get('domicilios');
		
		$datos = array(
			'predeterminado' => '0',
		);
		$this->db->where('id_persona', $id_persona);
		$this->db->update('domicilios', $datos);
			
		
		if($domicilios->result()){
			$datos = array(
				'predeterminado' => '1',
			);
			$domicilios_ = $domicilios->row_array();
			
			$this->db->where('id_persona', $id_persona);
			$this->db->where('id_domicilio', $domicilios_['id_domicilio']);
			$this->db->update('domicilios', $datos);
		}else{
			$this->db->select_max('id_domicilio');
			$this->db->where('id_persona', $id_persona);
			$domicilios = $this->db->get('domicilios');
			
			if($domicilios->result()){
				$domicilios_ = $domicilios->row_array();
				$id_domicilio = $domicilios_['id_domicilio'] + 1;
			}else
				$id_domicilio = 1;
				
			$datos = array(
				'id_persona' => $id_persona,
				'id_pais' 	=> $id_pais,
				'id_departamento' => $id_departamento,
				'id_ciudad' => $id_ciudad,
				'id_domicilio' => $id_domicilio,
				'direccion' => $direccion,
				'telefono_fijo' => $telefono,
				'predeterminado' => '1',
				'fecha' => 	date('Y-m-d'),
			);
			$this->db->insert('domicilios', $datos);
		}
	}
	
	/*
	*
	*PAISES
	*
	*/
	function guardar_pais($pais){
		$this->db->where('pais', $pais);
		$paises = $this->db->get('paises');
		
		if($paises->result()){
			$paises_ = $paises->row_array();
			return $paises_['id_pais'];
		}else{
			$this->db->select_max('id_pais');
			$paises = $this->db->get('paises');
			
			if($paises->result()){
				$paises_ = $paises->row_array();
				$id_pais = $paises_['id_pais'] + 1;
			}else
				$id_pais = 1;
			
			$datos = array(
				'id_pais' => $id_pais,
				'pais' => $pais,
			);
			$this->db->insert('paises', $datos);
			return $id_pais;
		}
	}
	function get_pais($id_pais){
		$this->db->where('id_pais', $id_pais);
		$paises = $this->db->get('paises');
		
		if($paises->result())
			return $paises;
		
		return false;
	}
	
	/*
	*
	*DEPARTAMENTOS
	*
	*/
	function guardar_departamento($id_pais, $departamento){
		$this->db->where('id_pais', $id_pais);
		$this->db->where('departamento', $departamento);
		$departamentos = $this->db->get('departamentos');
		
		if($departamentos->result()){
			$departamentos_ = $departamentos->row_array();
			return $departamentos_['id_departamento'];
		}else{	
			$this->db->where('id_pais', $id_pais);
			$this->db->select_max('id_departamento');
			$departamentos = $this->db->get('departamentos');
			
			if($departamentos->result()){
				$departamentos_ = $departamentos->row_array();
				$id_departamento = $departamentos_['id_departamento'] + 1;
			}else
				$id_departamento = 1;
			
			$datos = array(
				'id_pais' => $id_pais,
				'id_departamento' => $id_departamento,
				'departamento' => $departamento,
			);
			
			$this->db->insert('departamentos', $datos);
			return $id_departamento;
		}	
	}
	function get_departamento($id_pais, $id_departamento){
		
		$this->db->where('id_pais', $id_pais);
		$this->db->where('id_departamento', $id_departamento);
		
		$departamentos = $this->db->get('departamentos');
		
		if($departamentos->result())
			return $departamentos;
		return false;
	}
	
	/*
	*
	*CIUDADES
	*
	*/
	function guardar_ciudad($id_pais, $id_departamento, $ciudad){
		$this->db->where('id_pais', $id_pais);
		$this->db->where('id_departamento', $id_departamento);
		$this->db->where('ciudad', $ciudad);
		$ciudades = $this->db->get('ciudades');
		
		if($ciudades->result()){
			$ciudades_ = $ciudades->row_array();
			return $ciudades_['id_ciudad'];
		}else{	
			$this->db->where('id_pais', $id_pais);
			$this->db->where('id_departamento', $id_departamento);
			$this->db->select_max('id_ciudad');
			$ciudades = $this->db->get('ciudades');
			
			if($ciudades->result()){
				$ciudades_ = $ciudades->row_array();
				$id_ciudad = $ciudades_['id_ciudad'] + 1;
			}else
				$id_ciudad = 1;
			
			$datos = array(
				'id_pais' 			=> $id_pais,
				'id_departamento' 	=> $id_departamento,
				'id_ciudad' 		=> $id_ciudad,
				'ciudad' 			=> $ciudad,
			);
			$this->db->insert('ciudades', $datos);
			return $id_ciudad;
		}	
	}
	function get_ciudad($id_pais, $id_departamento, $id_ciudad){
		$this->db->where('id_pais', $id_pais);
		$this->db->where('id_departamento', $id_departamento);
		$this->db->where('id_ciudad', $id_ciudad);
		
		$ciudades = $this->db->get('ciudades');
		
		if($ciudades->result())
			return $ciudades;
		return false;
	}
	
	/*
	*
	*TRABAJOS
	*
	*/
	function guardar_trabajo($id_persona, $empresa, $cargo, $telefono){
		$this->db->where('id_persona', $id_persona);
		$this->db->where('empresa', $empresa);
		$this->db->where('cargo', $cargo);
		$trabajos = $this->db->get('trabajos');
		
		if($trabajos->result()){
			$trabajos_ = $trabajos->row_array();
			return $trabajos_['id_trabajo'];
		}else{
			$this->db->where('id_persona', $id_persona);
			$this->db->select_max('id_trabajo');
			$trabajos = $this->db->get('trabajos');
			
			if($trabajos->result()){
				$trabajos_ = $trabajos->row_array();
				$id_trabajo = $trabajos_['id_trabajo'] + 1;
			}else
				$id_trabajo = 1;
			
			$datos = array(
				'predeterminado'	=> '0',
			);
			$this->db->where('id_persona', $id_persona);
			$this->db->update('trabajos', $datos);

			$datos = array(
				'id_persona' 		=> $id_persona,
				'id_trabajo' 		=> $id_trabajo,
				'empresa' 			=> $empresa,
				'cargo' 			=> $cargo,
				'telefono' 			=> $telefono,
				'predeterminado'	=> '1',
			);
			$this->db->insert('trabajos', $datos);
			return $id_trabajo;
		}
	}
	function get_trabajo($id_persona){
		$this->db->where('id_persona', $id_persona);
		$this->db->order_by('predeterminado', 'desc');
		$trabajos = $this->db->get('trabajos');
		
		if($trabajos->result())
			return $trabajos;
		return false;
	}
	
	/*
	*ROLES
	*/
	function get_roles($id_rol = false, $rol = false, $estado = false, $orden = false){
		
		if($id_rol)
			$this->db->where('t1.id_rol', $id_rol);
		if($rol)
			$this->db->where('rol', $rol);
		if($estado)
			$this->db->where('estado', $estado);
		if($orden)
			$this->db->where('t1.orden >=', $orden);

		$this->db->order_by('t1.orden', 'asc');
		$roles = $this->db->get('roles as t1');
		
		if($roles->result())
			return $roles;
		return false;
	}
	
	/*
	*USUARIOS
	*/
	function get_usuarios($id_facultad = false, $id_sede = false, $id_persona = false, $id_rol = false, $predeterminado = false, $estado = false) {
		$this->db->select('*');
		if($id_facultad)
			$this->db->where('t1.id_facultad', $id_facultad);
		if($id_sede)
			$this->db->where('t1.id_sede', $id_sede);
		if($id_persona)
			$this->db->where('t1.id_persona', $id_persona);
		if($id_rol)
			$this->db->where('t1.id_rol', $id_rol);
		if($predeterminado)
			$this->db->where('t1.predeterminado', $predeterminado);
		if($estado)
			$this->db->where('t1.usuario_estado', $estado);

		$this->db->join('roles as t2', 't2.id_rol = t1.id_rol');
		$this->db->join('personas as t3', 't3.id_persona = t1.id_persona');
		$this->db->join('documentos as t4', 't4.id_persona = t1.id_persona');
		$this->db->join('facultades as t5', 't5.id_facultad = t1.id_facultad');
		$this->db->join('sedes as t6', 't6.id_sede = t1.id_sede');
		$usuarios = $this->db->get('usuarios as t1');
		
		if($usuarios->result())
			return $usuarios;
		return false;
	}

	function save_usuarios($id_facultad, $id_sede, $id_persona, $id_rol, $predeterminado = false){

		$datos = array(
			'id_facultad'	=> $id_facultad,
			'id_sede'		=> $id_sede,
			'id_persona'	=> $id_persona,
			'id_rol'		=> $id_rol,
			'predeterminado'=> $predeterminado,
			'usuario_estado'		=> true,
		);

		$this->db->insert('usuarios', $datos);
	}

	function delete_usuario($id_facultad, $id_sede, $id_persona, $id_rol){

		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_sede', $id_sede);
		$this->db->where('id_persona', $id_persona);
		$this->db->where('id_rol', $id_rol);

		$this->db->delete('usuarios');
	}

	function predeterminar_usuario($id_facultad = false, $id_sede = false, $id_persona = false, $id_rol = false, $predeterminado = false, $estado = false){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_sede', $id_sede);
		$this->db->where('id_persona', $id_persona);
		$datos = array(
			'predeterminado'	=> false,
		);
		$this->db->update('usuarios', $datos);

		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_sede', $id_sede);
		$this->db->where('id_persona', $id_persona);
		$this->db->where('id_rol', $id_rol);
		$datos = array(
			'predeterminado'	=> true,
		);
		$this->db->update('usuarios', $datos);
	}

	/*
	*
	*desde (asignar_rol)
	*/
	function cambiar_estado($id_facultad, $id_sede, $id_persona, $id_rol, $estado){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_sede', $id_sede);
		$this->db->where('id_persona', $id_persona);
		$this->db->where('id_rol', $id_rol);

		$datos = array(
			'usuario_estado' => $estado,
		);
		$this->db->update('usuarios', $datos);
	}
}
?>