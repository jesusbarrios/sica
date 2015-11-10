<?php

class M_calificacion extends CI_Model{

	function guardar_inscripcion_semestre($id_facultad, $id_sede, $id_carrera, $id_semestre, $periodo, $id_persona, $fecha, $estado = false){
		$datos = array(
			'id_facultad' => $id_facultad,
			'id_sede' => $id_sede,
			'id_carrera' => $id_carrera,
			'id_semestre' => $id_semestre,
			'periodo' => $periodo,
			'id_persona' => $id_persona,
			'fecha' => $fecha,
			'estado' => $estado,
		);
		$this->db->insert('inscripciones_semestre', $datos);
	}


	function guardar_detalles_inscripcion_semestre($id_facultad, $id_sede, $id_carrera, $id_semestre, $periodo, $id_persona, $id_asignatura, $parcial = false, $asistencia = false, $estado = false, $fecha){
		$datos = array(
			'id_facultad' => $id_facultad,
			'id_sede' => $id_sede,
			'id_carrera' => $id_carrera,
			'id_semestre' => $id_semestre,
			'periodo' => $periodo,
			'id_persona' => $id_persona,
			'id_asignatura' => $id_asignatura,
			'parcial' => $parcial, 
			'asistencia' => $asistencia,
			'estado' => $estado,
			'fecha' => $fecha,
		);
		$this->db->insert('detalles_inscripcion_semestre', $datos);
	}


/*	function get_inscripcion_semestre($id_facultad, $id_sede, $id_carrera, $id_semestre, $id_persona){
		$datos = array(
			'id_facultad' => $id_facultad,
			'id_sede' => $id_sede,
			'id_carrera' => $id_carrera,
			'id_semestre' => $id_semestre,
			'id_persona' => $id_persona,
		);
		$result = $this->db->get_where('inscripciones_semestre', $datos);

		if($result->result())
			return $result;
		return false;
	}
*/	


	function obtener_lista_cpi($id_universidad, $id_facultad, $id_sede, $id_carrera, $id_semestre, $anho){	
	
		$result = mysql_query("SELECT  personas.id_persona, personas.apellido, personas.nombre FROM personas LEFT JOIN inscripciones_semestre ON personas.id_persona = inscripciones_semestre.id_persona WHERE inscripciones_semestre.id_universidad = $id_universidad AND inscripciones_semestre.id_facultad = $id_facultad AND inscripciones_semestre.id_sede = $id_sede AND inscripciones_semestre.id_carrera = $id_carrera AND inscripciones_semestre.id_semestre = $id_semestre AND inscripciones_semestre.anho = $anho ORDER BY personas.apellido ASC") or die(mysql_error());

		if(mysql_num_rows($result) > 0)
			return $result;
		return false;
	}

	function get_inscripcion_semestre($facultad = false, $sede = false, $carrera = false, $semestre = false, $periodo = false, $persona = false){
		$this->db->select('*');
		if($facultad){
			$this->db->where('inscripciones_semestre.id_facultad', $facultad);
		}
		
		if($sede){
			$this->db->where('inscripciones_semestre.id_sede', $sede);
		}
			
		if($carrera){
			$this->db->where('inscripciones_semestre.id_carrera', $carrera);
		}
		
		if($semestre){
			$this->db->where('inscripciones_semestre.id_semestre', $semestre);
		}

		if($periodo){
			$this->db->where('inscripciones_semestre.periodo', $periodo);
		}
		
		if($persona){
			$this->db->where('inscripciones_semestre.id_persona', $persona);
		}

		$this->db->join('facultades', 'facultades.id_facultad = inscripciones_semestre.id_facultad');
		$this->db->join('sedes', 'sedes.id_sede = inscripciones_semestre.id_sede');
		$this->db->join('carreras', 'carreras.id_carrera = inscripciones_semestre.id_carrera');
//		$this->db->join('semestres', 'semestres.id_semestres = inscripciones_semestre.id_semestres');
			
		$this->db->select('inscripciones_semestre.*');
		
		$result = $this->db->get('inscripciones_semestre');
		
//		echo $result->num_rows();
		
		if($result->result())
			return $result;
		return false;
		
		
	}

	function get_detalle_inscripcion_semestre($facultad = false, $sede = false, $carrera = false, $semestre = false, $periodo = false, $persona = false, $id_asignatura = false){
		$this->db->select('*');
		if($facultad){
			$this->db->where('detalles_inscripcion_semestre.id_facultad', $facultad);
		}
		
		if($sede){
			$this->db->where('detalles_inscripcion_semestre.id_sede', $sede);
		}
			
		if($carrera){
			$this->db->where('detalles_inscripcion_semestre.id_carrera', $carrera);
		}
		
		if($semestre){
			$this->db->where('detalles_inscripcion_semestre.id_semestre', $semestre);
		}

		if($periodo){
			$this->db->where('detalles_inscripcion_semestre.periodo', $periodo);
		}
		
		if($persona){
			$this->db->where('detalles_inscripcion_semestre.id_persona', $persona);
		}
		
		if($id_asignatura)
			$this->db->where('detalles_inscripcion_semestre.id_asignatura', $id_asignatura);

//		$this->db->join('facultades', 'facultades.id_facultad = inscripciones_semestre.id_facultad');
//		$this->db->join('sedes', 'sedes.id_sede = inscripciones_semestre.id_sede');
//		$this->db->join('carreras', 'carreras.id_carrera = inscripciones_semestre.id_carrera');
//		$this->db->join('semestres', 'semestres.id_semestres = inscripciones_semestre.id_semestres');

//		$this->db->select('detalles_inscripcion_semestre.*');
//		$this->db->select('*');

		$result = $this->db->get('detalles_inscripcion_semestre');

//		echo $result->num_rows();

		if($result->result())
			return $result;
		return false;
	}

	
	
	function get_sede($facultad = false, $persona = false){
		$this->db->select('*');
		$this->db->where('t1.id_facultad', $facultad);
		$this->db->where('t1.id_persona', $persona);
		$this->db->join('sedes', 'sedes.id_sede = t1.id_sede');
		$this->db->group_by('t1.id_sede');
//		$this->db->select('detalles_inscripcion_semestre.*');
		$result = $this->db->get('inscripciones_evaluacion as t1');
		if($result->result())
			return $result;
		return false;
	}
	
	function get_carrera($facultad,  $sede, $persona){
		$this->db->select('*');
		$this->db->where('t1.id_facultad', $facultad);
		$this->db->where('t1.id_sede', $sede);
		$this->db->where('t1.id_persona', $persona);
		$this->db->join('carreras', 'carreras.id_carrera = t1.id_carrera');
		$this->db->group_by('t1.id_carrera');
		$result = $this->db->get('inscripciones_evaluacion as t1');
		
		if($result->result())
			return $result;
		return false;
	}
	
	function get_semestre($facultad,  $sede, $carrera, $persona){
		$this->db->select('*');
		$this->db->where('t1.id_facultad', $facultad);
		$this->db->where('t1.id_sede', $sede);
		$this->db->where('t1.id_carrera', $carrera);
		$this->db->where('t1.id_persona', $persona);
		$this->db->join('semestres', 'semestres.id_semestre = t1.id_semestre', 'right');
		$this->db->group_by('t1.id_semestre');
		$result = $this->db->get('inscripciones_evaluacion as t1');
		
		if($result->result())
			return $result;
		return false;
	}
	
	function get_asignatura($facultad, $sede, $carrera, $semestre, $periodo, $persona){

		$this->db->select('*');
		$this->db->where('t1.id_facultad', $facultad);
		$this->db->where('t1.id_sede', $sede);
		$this->db->where('t1.id_carrera', $carrera);
		$this->db->where('t1.id_semestre', $semestre);
		$this->db->where('t1.periodo', $periodo);
		$this->db->where('t1.id_persona', $persona);	
//		if($id_asignatura)
//			$this->db->where('t1.id_asignatura', $id_asignatura);	

		$this->db->where('asignaturas.id_facultad', $facultad);	
		$this->db->where('asignaturas.id_carrera', $carrera);
		$this->db->where('asignaturas.id_semestre', $semestre);


		$this->db->join('inscripciones_evaluacion as t1', 'asignaturas.id_asignatura = t1.id_asignatura', 'left');
		$this->db->group_by('asignaturas.asignatura');

		$result = $this->db->get('asignaturas');
		
		if($result->result())
			return $result;
			
		return false;
		
		
	}
	
	function get_inscripcion_evaluacion_final($id_facultad, $id_sede, $id_carrera, $id_semestre, $periodo, $id_persona, $id_asignatura = false, $oportunidad = false){
	

		$this->db->where('t1.id_facultad', $id_facultad);
		$this->db->where('t1.id_sede', $id_sede);
		$this->db->where('t1.id_carrera', $id_carrera);
		$this->db->where('t1.id_semestre', $id_semestre);
		$this->db->where('t1.periodo', $periodo);
		$this->db->where('t1.id_persona', $id_persona);
		if($id_asignatura)
			$this->db->where('id_asignatura', $id_asignatura);
			
		$this->db->join('asignaturas as t2', 't1.id_facultad = t2.id_facultad AND t1.id_carrera = t2.id_carrera AND t1.id_semestre = t2.id_semestre AND t1.id_asignatura = t2.id_asignatura');
		$this->db->join('oportunidades', 'oportunidades.id_facultad = t1.id_facultad AND oportunidades.id_oportunidad = t1.id_oportunidad');

		$result = $this->db->get_where('inscripciones_evaluacion as t1');
		
		if($result->result())
			return $result;
		return false;
		
	}
	
	function cargar_calificacion($id_facultad, $id_sede, $id_carrera, $id_semestre, $id_asignatura, $periodo, $id_persona, $calificacion){

		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_sede', $id_sede);
		$this->db->where('id_carrera', $id_carrera);
		$this->db->where('id_semestre', $id_semestre);
		$this->db->where('id_asignatura', $id_asignatura);
		$this->db->where('periodo', $periodo);
		$this->db->where('id_persona', $id_persona);
		$this->db->set('calificacion', $calificacion);
//		echo $calificacion;
		$this->db->update('inscripciones_evaluacion');

	}
}
?>