<?php

class M_inscripciones extends CI_Model{

	/*
	*INSCRIPCIONES SEMESTRAL
	*
	*/
	function insert_inscripcion($id_periodo, $id_facultad, $id_sede, $id_carrera, $id_curso, $id_asignatura, $fecha, $apertura, $cierre, $estado){
		$datos = array(
			'id_periodo' => $id_periodo,
			'id_facultad' => $id_facultad,
			'id_sede' => $id_sede,
			'id_carrera' => $id_carrera,
			'id_curso' => $id_curso,
			'id_asignatura' => $id_asignatura,
			'fecha' => $fecha,
			'apertura' => $apertura, 
			'cierre' => $cierre,
			'estado' => $estado,
		);
		$this->db->insert('inscripciones', $datos);
	}

	function update_inscripcion($id_periodo, $id_facultad, $id_sede, $id_carrera, $id_curso, $id_asignatura, $fecha, $apertura, $cierre, $estado){
		if($periodo)
			$this->db->where('id_periodo', $periodo);
		if($facultad)
			$this->db->where('id_facultad', $facultad);
		if($sede)
			$this->db->where('id_sede', $sede);
		if($carrera)
			$this->db->where('id_carrera', $carrera);
		if($curso)
			$this->db->where('id_curso', $curso);
		if($asignatura)
			$this->db->where('id_asignatura', $asignatura);

		if($apertura)
			$datos['apertura'] 	= $apertura;
		if($cierre)
			$datos['cierre'] 	= $cierre;
		$datos['estado'] = $estado;

		$this->db->update('inscripciones', $datos);
	}

	function get_inscripciones($periodo = false, $facultad = false, $sede = false, $carrera = false, $curso = false, $asignatura = false){
		
		$this->db->select('*');
		
		if($periodo)
			$this->db->where('t1.id_periodo', $periodo);
		if($facultad)
			$this->db->where('t1.id_facultad', $facultad);
		if($sede)
			$this->db->where('t1.id_sede', $sede);
		if($carrera)
			$this->db->where('t1.id_carrera', $carrera);
		if($curso)
			$this->db->where('t1.id_curso', $curso);
		if($asignatura)
			$this->db->where('t1.id_asignatura', $asignatura);

		if(!$periodo){
			$this->db->group_by('t1.id_periodo');
			$this->db->order_by('t1.id_periodo', 'desc');
		}else if($periodo && !$facultad){
			$this->db->group_by('t1.id_facultad');
			$this->db->order_by('t1.id_facultad', 'asc');
		}else if($periodo && $facultad && !$sede){
			$this->db->group_by('t1.id_sede');
			$this->db->order_by('t1.id_sede', 'asc');
		}else if($periodo && $facultad && $sede && !$carrera){
			$this->db->group_by('t1.id_carrera');
			$this->db->order_by('t1.id_carrera', 'desc');
		}else if($periodo && $facultad && $sede && $carrera && !$curso){
			$this->db->group_by('t1.id_curso');
			$this->db->order_by('t1.id_curso', 'asc');
		}else if($periodo && $facultad && $sede && $carrera && $curso && !$asignatura){
			$this->db->group_by('t1.id_asignatura');
			$this->db->order_by('t1.id_curso', 'asc');
		}

		$this->db->join('facultades', 'facultades.id_facultad = t1.id_facultad');
		$this->db->join('sedes', 'sedes.id_sede = t1.id_sede');
		$this->db->join('carreras', 'carreras.id_facultad = t1.id_facultad AND carreras.id_carrera = t1.id_carrera');
		$this->db->join('cursos as t4', 't4.id_facultad = t1.id_facultad AND t4.id_carrera = t1.id_carrera AND t4.id_curso = t1.id_curso');
		$this->db->join('asignaturas as t5', 't5.id_facultad = t1.id_facultad AND t5.id_carrera = t1.id_carrera AND t5.id_curso = t1.id_curso AND t5.id_asignatura = t1.id_asignatura');

		$inscripciones = $this->db->get('inscripciones as t1');

		if($inscripciones->result())
			return $inscripciones;
		return false;
	}
	
	/*
	*INSCRIPCIONES DETALLES
	*
	*/
	function get_detalles_inscripcion($periodo = false, $facultad = false, $sede = false, $carrera = false, $curso = false, $asignatura = false){
		
		$this->db->select('*');
		
		if($periodo)
			$this->db->where('t1.id_periodo', $periodo);
		if($facultad)
			$this->db->where('t1.id_facultad', $facultad);
		if($sede)
			$this->db->where('t1.id_sede', $sede);
		if($carrera)
			$this->db->where('t1.id_carrera', $carrera);
		if($curso)
			$this->db->where('t1.id_curso', $curso);
		if($asignatura)
			$this->db->where('t1.id_asignatura', $asignatura);

		if(!$periodo){
			$this->db->group_by('t1.id_periodo');
			$this->db->order_by('t1.id_periodo', 'desc');
		}else if($periodo && !$facultad){
			$this->db->group_by('t1.id_facultad');
			$this->db->order_by('t1.id_facultad', 'asc');
		}else if($periodo && $facultad && !$sede){
			$this->db->group_by('t1.id_sede');
			$this->db->order_by('t1.id_sede', 'asc');
		}else if($periodo && $facultad && $sede && !$carrera){
			$this->db->group_by('t1.id_carrera');
			$this->db->order_by('t1.id_carrera', 'desc');
		}else if($periodo && $facultad && $sede && $carrera && !$curso){
			$this->db->group_by('t1.id_curso');
			$this->db->order_by('t1.id_curso', 'asc');
		}else if($periodo && $facultad && $sede && $carrera && $curso && !$asignatura){
			$this->db->group_by('t1.id_asignatura');
			$this->db->order_by('t1.id_curso', 'asc');
		}

		$this->db->join('facultades', 'facultades.id_facultad = t1.id_facultad');
		$this->db->join('sedes', 'sedes.id_sede = t1.id_sede');
		$this->db->join('carreras', 'carreras.id_facultad = t1.id_facultad AND carreras.id_carrera = t1.id_carrera');
		$this->db->join('cursos as t4', 't4.id_facultad = t1.id_facultad AND t4.id_carrera = t1.id_carrera AND t4.id_curso = t1.id_curso');
		$this->db->join('asignaturas as t5', 't5.id_facultad = t1.id_facultad AND t5.id_carrera = t1.id_carrera AND t5.id_curso = t1.id_curso AND t5.id_asignatura = t1.id_asignatura');

		$inscripciones = $this->db->get('detalles_inscripcion as t1');

		if($inscripciones->result())
			return $inscripciones;
		return false;
	}

	
	function guardar_inscripcion_evaluacion($id_facultad, $id_sede, $id_carrera, $id_semestre, $periodo, $id_persona, $id_asignatura, $oportunidad = false, $calificacion = false, $fecha){
		$datos = array(
			'id_facultad' => $id_facultad,
			'id_sede' => $id_sede,
			'id_carrera' => $id_carrera,
			'id_semestre' => $id_semestre,
			'periodo' => $periodo,
			'id_persona' => $id_persona,
			'id_asignatura' => $id_asignatura,
			'id_oportunidad' => $oportunidad, 
			'calificacion' => '-',
			'fecha' => $fecha,
		);
		$this->db->insert('inscripciones_evaluacion', $datos);
	}
	
	function obtener_lista_cpi($id_universidad, $id_facultad, $id_sede, $id_carrera, $id_semestre, $anho){	
	
		$result = mysql_query("SELECT  personas.id_persona, personas.apellido, personas.nombre FROM personas LEFT JOIN inscripciones_semestre ON personas.id_persona = inscripciones_semestre.id_persona WHERE inscripciones_semestre.id_universidad = $id_universidad AND inscripciones_semestre.id_facultad = $id_facultad AND inscripciones_semestre.id_sede = $id_sede AND inscripciones_semestre.id_carrera = $id_carrera AND inscripciones_semestre.id_semestre = $id_semestre AND inscripciones_semestre.anho = $anho ORDER BY personas.apellido ASC") or die(mysql_error());

		if(mysql_num_rows($result) > 0)
			return $result;
		return false;

	}


	function get_asignatura($facultad, $carrera, $semestre, $id_asignatura = false){
		$this->db->where('t1.id_facultad', $facultad);
		$this->db->where('t1.id_carrera', $carrera);
		$this->db->where('t1.id_semestre', $semestre);
		if($id_asignatura)
			$this->db->where('t1.id_asignatura', $id_asignatura);
		$asignaturas = $this->db->get('asignaturas as t1');
		if($asignaturas->result())
			return $asignaturas;
		return false;
	}
/*	
	function get_semestre($facultad,  $sede, $carrera, $persona = false){
		$this->db->select('*');
		if($persona){
			$this->db->where('inscripciones_semestre.id_facultad', $facultad);
			$this->db->where('inscripciones_semestre.id_sede', $sede);
			$this->db->where('inscripciones_semestre.id_carrera', $carrera);
			$this->db->where('inscripciones_semestre.id_persona', $persona);
			$this->db->join('semestres', 'semestres.id_semestre = inscripciones_semestre.id_semestre', 'right');
			$this->db->group_by('inscripciones_semestre.id_semestre');
			$result = $this->db->get('inscripciones_semestre');
		}else{
			$this->db->where('t1.id_facultad', $facultad);
			$this->db->where('t1.id_carrera', $carrera);
			$result = $this->db->get('semestres as t1');
		}
		
		if($result->result())
			return $result;
		return false;
	}
*/	
	function get_inscripcion_evaluacion_final($id_facultad, $id_sede, $id_carrera, $id_semestre, $periodo, $id_persona = false, $id_asignatura = false, $oportunidad = false){
		if($id_persona){
			$datos = array(
				'id_facultad' => $id_facultad,
				'id_sede' => $id_sede,
				'id_carrera' => $id_carrera,
				'id_semestre' => $id_semestre,
				'id_periodo' => $periodo,
				'id_persona' => $id_persona,
				'id_asignatura' => $id_asignatura,
			);
			$result = $this->db->get_where('inscripciones_evaluacion', $datos);

		}else{
			$this->db->where('t1.id_facultad', $id_facultad);
			$this->db->where('t1.id_sede', $id_sede);
			$this->db->where('t1.id_carrera', $id_carrera);
			$this->db->where('t1.id_semestre', $id_semestre);
			$this->db->where('t1.id_periodo', $periodo);
			$this->db->where('t1.id_asignatura', $id_asignatura);
			$this->db->where('t1.id_oportunidad', $oportunidad);
			$this->db->join('personas as t2', 't2.id_persona = t1.id_persona');
			$this->db->join('detalles_inscripcion_semestre as t3', 't3.id_facultad = t1.id_facultad AND t3.id_sede = t1.id_sede AND t3.id_carrera = t1.id_carrera AND t3.id_semestre = t1.id_semestre AND t3.id_asignatura = t1.id_asignatura');
			$this->db->group_by('t2.id_persona');
			$result = $this->db->get('inscripciones_evaluacion as t1');
		}
		
		if($result->result())
			return $result;
		return false;
	}
	
	function get_correlatividad($id_facultad, $id_carrera, $id_semestre, $id_asignatura){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_carrera', $id_carrera);
		$this->db->where('id_semestre1', $id_semestre);
		$this->db->where('id_asignatura1', $id_asignatura);
		$result = $this->db->get('correlatividades');
		
		if($result->result())
			return $result;
		return false;
	}

	function get_pp_min($id_facultad){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->order_by('pp_minimo', 'desc');
		$result = $this->db->get('oportunidades');
		
		if($result->result())
			return $result;
		return false;
	}
	
	function get_asistencia_min($id_facultad){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->order_by('asistencia_minima', 'desc');
		$result = $this->db->get('oportunidades');
		
		if($result->result())
			return $result;
		return false;
	}
	
	function get_oportunidad($id_facultad, $id_oportunidad = false){
		$this->db->where('id_facultad', $id_facultad);
		if($id_oportunidad)
			$this->db->where('id_oportunidad', $id_oportunidad);
		$result = $this->db->get('oportunidades');
		
		if($result->result())
			return $result;
		return false;
	}
	
	/*
	*
	*FACULTADES
	*Utilizado en los controles(cpi, reporte)
	*/	
	function get_facultad($id_facultad = false, $id_periodo = false, $id_actividad = false, $fecha = false){
		$session_data = $this->session->userdata('logged_in');
		$id_rol = $session_data['id_rol'];
		
		if($id_facultad)
			$this->db->where('t1.id_facultad', $id_facultad);

		if($id_rol != 1){ //Programador
			$id_persona = $session_data['id_persona'];
			$this->db->where('t3.id_persona', $id_persona);
			$this->db->where('t3.estado', true);	
			$this->db->join('usuarios as t3', 't1.id_facultad = t3.id_facultad');
		}
		
		if($id_periodo)
			$this->db->where('t1.id_periodo', $id_periodo);
			
		if($id_actividad){
			$this->db->where('t1.id_actividad', $id_actividad);
		}
		if($fecha){
			$this->db->where('t1.fecha_inicio <=', $fecha);
			$this->db->where('t1.fecha_fin >=', $fecha);
		}
		
		$this->db->where('t1.id_actividad', $id_actividad);
		$this->db->join('facultades as t2', 't1.id_facultad = t2.id_facultad');
		$this->db->group_by('t1.id_facultad');
		$facultades = $this->db->get('periodos as t1');

		if($facultades->result())
			return $facultades;
		return false;
	}

	/*
	*
	*SEDES
	*
	*/
	function get_sede($id_facultad, $id_sede = false, $id_periodo = false, $id_actividad = false, $fecha = false){
		$session_data = $this->session->userdata('logged_in');
		$id_rol = $session_data['id_rol'];
		if($id_rol != 1 && $id_rol != 3){ //Desarrollo, Direccion academica
			$id_persona = $session_data['id_persona'];
			$this->db->where('t3.id_facultad', $id_facultad);
			$this->db->where('t3.id_persona', $id_persona);
			$this->db->where('t3.estado', true);
			$this->db->join('usuarios as t3', 't1.id_facultad = t3.id_facultad AND t1.id_sede = t3.id_sede');	
		}
		if($id_sede)
			$this->db->where('t1.id_sede', $id_sede);
		
		if($id_periodo)
			$this->db->where('t1.id_periodo', $id_periodo);
		
		if($id_actividad){		
			$this->db->where('t1.id_actividad', $id_actividad);
		}
		if($fecha){
			$this->db->where('t1.fecha_inicio <=', $fecha);
			$this->db->where('t1.fecha_fin >=', $fecha);
		}

		$this->db->where('t1.id_facultad', $id_facultad);
		$this->db->group_by('t1.id_sede');

		$this->db->join('sedes as t2', 't2.id_sede = t1.id_sede');
		$sedes = $this->db->get('periodos as t1');
		
		if($sedes->result())
			return $sedes;
		return false;
	}
	
	/*
	*
	*CARRERAS
	*
	*/
	function get_carrera($id_facultad, $id_sede = false, $id_carrera = false, $id_periodo = false, $id_actividad = false, $fecha = false){
		$session_data = $this->session->userdata('logged_in');
		$id_rol = $session_data['id_rol'];
		if($id_rol != 1 && $id_rol != 3){ //Desarrollo, Direccion academica
			$id_persona = $session_data['id_persona'];
			$this->db->where('t3.id_facultad', $id_facultad);
			$this->db->where('t3.id_persona', $id_persona);
			$this->db->where('t3.estado', true);
			$this->db->join('usuarios as t3', 't1.id_facultad = t3.id_facultad AND t1.id_sede = t3.id_sede');	
		}
		
		if($id_carrera)
			$this->db->where('t1.id_carrera', $id_carrera);
			
		if($id_periodo)
			$this->db->where('t1.id_periodo', $id_periodo);
			
		if($id_actividad){		
			$this->db->where('t1.id_actividad', $id_actividad);
		}
		if($fecha){
//			$this->db->where('t1.fecha_inicio <=', $fecha);
//			$this->db->where('t1.fecha_fin >=', $fecha);
		}

		$this->db->where('t1.id_facultad', $id_facultad);
		$this->db->where('t1.id_sede', $id_sede);
		$this->db->where('t1.id_actividad', $id_actividad);
		$this->db->group_by('t1.id_carrera');

		$this->db->join('carreras as t2', 't2.id_facultad = t1.id_facultad AND t2.id_carrera = t1.id_carrera');
		$carreras = $this->db->get('periodos as t1');
		if($carreras->result())
			return $carreras;
		return false;
	}
	
	/*
	*
	*PERIODOS
	*Utilizados en los controles(reporte_cpi)
	*/
	function get_periodo($id_facultad = false, $id_sede = false, $id_carrera = false, $id_semestre = false, $id_periodo = false){
		if($id_facultad)
			$this->db->where('t1.id_facultad', $id_facultad);

		if($id_sede)
			$this->db->where('t1.id_sede', $id_sede);

		if($id_carrera)
			$this->db->where('t1.id_carrera', $id_carrera);

		if($id_periodo)
			$this->db->where('t1.id_periodo', $id_periodo);

		$this->db->group_by('t1.id_periodo');
		$this->db->order_by('t1.id_periodo', 'desc');

		$periodos = $this->db->get('periodos as t1');
		if($periodos->result())
			return $periodos;
		return false;
	}
	/**/
}
?>