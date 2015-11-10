<?php

class M_inscripcion_cpi extends CI_Model{

	/*
	*INSCRIPCIONES ASIGNATURA
	*
	*/
	function guardar_inscripcion_asignatura($id_facultad, $id_sede, $id_carrera, $id_semestre, $id_asignatura, $id_periodo, $id_persona, $fecha, $estado = false){
		$datos = array(
			'id_facultad' 	=> $id_facultad,
			'id_sede' 		=> $id_sede,
			'id_carrera' 	=> $id_carrera,
			'id_semestre' 	=> $id_semestre,
			'id_asignatura'	=> $id_asignatura,
			'id_periodo' 	=> $id_periodo,
			'id_persona' 	=> $id_persona,
			'fecha' 		=> $fecha,
			'estado' 		=> $estado,
		);
		$this->db->insert('inscripciones_asignatura', $datos);	
	}
	function get_inscripcion_asignatura($facultad = false, $sede = false, $carrera = false, $semestre = false, $asignatura = false, $periodo = false, $persona = false){
		$this->db->select('*');
		if($facultad)
			$this->db->where('t1.id_facultad', $facultad);

		if($sede)
			$this->db->where('t1.id_sede', $sede);
			
		if($carrera)
			$this->db->where('t1.id_carrera', $carrera);

		if($semestre)
			$this->db->where('t1.id_semestre', $semestre);
		
		if($asignatura)
			$this->db->where('t1.id_asignatura', $asignatura);

		if($periodo)
			$this->db->where('t1.id_periodo', $periodo);

		if($persona)
			$this->db->where('t1.id_persona', $persona);
		
//		$this->db->where('t1.estado', true);
		$this->db->order_by('t2.apellido', 'asc');

		$this->db->join('facultades', 'facultades.id_facultad = t1.id_facultad');
		$this->db->join('sedes', 'sedes.id_sede = t1.id_sede');
		$this->db->join('carreras', 'carreras.id_facultad = t1.id_facultad AND carreras.id_carrera = t1.id_carrera');
		$this->db->join('semestres as t4', 't4.id_facultad = t1.id_facultad AND t4.id_carrera = t1.id_carrera AND t4.id_semestre = t1.id_semestre');
		$this->db->join('asignaturas as t5', 't5.id_facultad = t1.id_facultad AND t5.id_carrera = t1.id_carrera AND t5.id_semestre = t1.id_semestre AND t5.id_asignatura = t1.id_asignatura');
		$this->db->join('personas as t2', 't2.id_persona = t1.id_persona');
		$this->db->join('documentos as t3', 't3.id_persona = t2.id_persona');
		
		$this->db->group_by('t2.id_persona');

		$inscripciones = $this->db->get('inscripciones_asignatura as t1');

		if($inscripciones->result())
			return $inscripciones;
		return false;
	}
	
	/*
	*INSCRIPCIONES EVALUACION
	*
	*/
	
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
	
	function get_detalle_inscripcion_semestre($facultad, $sede, $carrera, $semestre, $periodo = false, $persona = false, $id_asignatura = false){

		$this->db->select('*');
//		if($persona){
		$this->db->where('t1.id_facultad', $facultad);
		$this->db->where('t1.id_sede', $sede);
		$this->db->where('t1.id_carrera', $carrera);
		$this->db->where('t1.id_semestre', $semestre);
		$this->db->where('t1.id_periodo', $periodo);
		$this->db->where('t1.id_persona', $persona);
		if($id_asignatura)
			$this->db->where('t1.id_asignatura', $id_asignatura);

		$this->db->where('t2.id_facultad', $facultad);	
		$this->db->where('t2.id_carrera', $carrera);
		$this->db->where('t2.id_semestre', $semestre);
		
		$this->db->group_by('t2.asignatura');

		$this->db->join('asignaturas as t2', 't2.id_asignatura = t1.id_asignatura', 'left');
	
		$result = $this->db->get('detalles_inscripcion_semestre as t1');
//		}
		
		if($result->result())
			return $result;

		return false;
	}
	
	/*
	*
	*FACULTADES
	*Utilizado en los controles(cpi, reporte)
	*/	
	function get_facultad($id_facultad = false, $id_actividad = false, $fecha = false){
		$session_data = $this->session->userdata('logged_in');
		$id_rol = $session_data['id_rol'];
		
		if($id_facultad)
			$this->db->where('t1.id_facultad', $id_facultad);

		if($id_rol != 1){ //Programador
			$id_persona = $session_data['id_persona'];
			$this->db->where('t3.id_persona', $id_persona);
			$this->db->where('t3.estado', true);	
			$this->db->join('relaciones_persona_rol as t3', 't1.id_facultad = t3.id_facultad');
		}
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
		$facultades = $this->db->get('detalles_periodo as t1');

		if($facultades->result())
			return $facultades;
		return false;
	}

	/*
	*
	*SEDES
	*
	*/
	function get_sede($id_facultad, $id_sede = false, $id_actividad = false, $fecha = false){
		$session_data = $this->session->userdata('logged_in');
		$id_rol = $session_data['id_rol'];
		if($id_rol != 1 && $id_rol != 3){ //Desarrollo, Direccion academica
			$id_persona = $session_data['id_persona'];
			$this->db->where('t3.id_facultad', $id_facultad);
			$this->db->where('t3.id_persona', $id_persona);
			$this->db->where('t3.estado', true);
			$this->db->join('relaciones_persona_rol as t3', 't1.id_facultad = t3.id_facultad AND t1.id_sede = t3.id_sede');	
		}
		if($id_sede)
			$this->db->where('t1.id_sede', $id_sede);
		
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
		$sedes = $this->db->get('detalles_periodo as t1');
		
		if($sedes->result())
			return $sedes;
		return false;
	}
	
	/*
	*
	*CARRERAS
	*
	*/
	function get_carrera($id_facultad, $id_sede, $id_carrera = false, $id_actividad = false, $fecha = false){
		$session_data = $this->session->userdata('logged_in');
		$id_rol = $session_data['id_rol'];
		if($id_rol != 1 && $id_rol != 3){ //Desarrollo, Direccion academica
			$id_persona = $session_data['id_persona'];
			$this->db->where('t3.id_facultad', $id_facultad);
			$this->db->where('t3.id_persona', $id_persona);
			$this->db->where('t3.estado', true);
			$this->db->join('relaciones_persona_rol as t3', 't1.id_facultad = t3.id_facultad AND t1.id_sede = t3.id_sede');	
		}
		
		if($id_carrera)
			$this->db->where('t1.id_carrera', $id_carrera);

		if($id_actividad){		
			$this->db->where('t1.id_actividad', $id_actividad);
		}
		if($fecha){
			$this->db->where('t1.fecha_inicio <=', $fecha);
			$this->db->where('t1.fecha_fin >=', $fecha);
		}

		$this->db->where('t1.id_facultad', $id_facultad);
		$this->db->where('t1.id_sede', $id_sede);
		$this->db->where('t1.id_actividad', $id_actividad);
		$this->db->group_by('t1.id_carrera');

		$this->db->join('carreras as t2', 't2.id_facultad = t1.id_facultad AND t2.id_carrera = t1.id_carrera');
		$carreras = $this->db->get('detalles_periodo as t1');
		if($carreras->result())
			return $carreras;
		return false;

	}
	
	/*
	*
	*PERIODOS
	*Utilizados en los controles(reporte_cpi)
	*/
	function get_periodo($id_facultad, $id_sede, $id_carrera, $id_semestre = false, $id_periodo = false){

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

		$periodos = $this->db->get('detalles_periodo as t1');
		if($periodos->result())
			return $periodos;
		return false;

	}
	/**/
}
?>