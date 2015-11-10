<?php
class M_periodo extends CI_Model{
	
/*	function get_ultimo_periodo(){
		$this->db->select_max('id_periodo');
		$periodos = $this->db->get('periodos');
		
		if($periodos->result()){
			$periodos_ = $periodos->row_array();
			return $periodos_['id_periodo'];
		}
	}
	
	function guardar_periodo($id_facultad, $id_sede, $id_carrera, $id_semestre, $id_asignatura, $id_periodo, $estado){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_sede', $id_sede);
		$this->db->where('id_carrera', $id_carrera);
		$this->db->where('id_semestre', $id_semestre);
		$this->db->where('id_asignatura', $id_asignatura);
		$this->db->where('id_periodo', $id_periodo);
		$periodos = $this->db->get('periodos');
		
		$datos = array(
			'id_facultad' 	=> $id_facultad,
			'id_sede' 		=> $id_sede,
			'id_carrera'	=> $id_carrera,
			'id_semestre'	=> $id_semestre,
			'id_asignatura'	=> $id_asignatura,
			'id_periodo' 	=> $id_periodo,
			'estado'		=> $estado,			
		);
		
		if($periodos->result()){
			$this->db->where('id_facultad', $id_facultad);
			$this->db->where('id_sede', $id_sede);
			$this->db->where('id_carrera', $id_carrera);
			$this->db->where('id_semestre', $id_semestre);
			$this->db->where('id_asignatura', $id_asignatura);
			$this->db->where('id_periodo', $id_periodo);
			$this->db->update('periodos', $datos);
		}else
			$this->db->insert('periodos', $datos);
	}
	
	function get_periodo($id_facultad = false, $id_sede = false, $id_carrera = false, $id_semestre = false, $id_asignatura = false, $id_periodo = false){
		
		if($id_facultad)
			$this->db->where('id_facultad', $id_facultad);
		
		if($id_sede)
			$this->db->where('id_sede', $id_sede);
		
		if($id_carrera)
			$this->db->where('id_carrera', $id_carrera);
		
		if($id_semestre)
			$this->db->where('id_semestre', $id_semestre);
		
		if($id_asignatura)
			$this->db->where('id_asignatura', $id_asignatura);
			
		if($id_periodo)
			$this->db->where('id_periodo', $id_periodo);
		
		$periodos = $this->db->get('periodos');
		
		if($periodos->result())
			return $periodos;
		return false;
	}
	
	/*
	*
	*FACULTADES
	*Utilizado en periodos/crear/index, 
	*/
	function get_facultad(){
		$this->db->where('t1.estado', true);
		$this->db->join('facultades as t2', 't2.id_facultad = t1.id_facultad');
		$this->db->group_by('t1.id_facultad');
		$facultades = $this->db->get('relacion_sede_carrera as t1');
		
		if($facultades->result())
			return $facultades;
		return false;
	}
	
	/*
	*
	*SEDES
	*Utilizado en periodos/crear/index, 
	*/
	function get_sede($id_facultad){
		$this->db->where('t1.id_facultad', $id_facultad);
		$this->db->where('t1.estado', true);
		$this->db->join('sedes as t2', 't2.id_sede = t1.id_sede');
		$this->db->group_by('t1.id_sede');
		$this->db->order_by('t1.id_facultad', 'asc');
		$sedes = $this->db->get('relacion_sede_carrera as t1');
		
		if($sedes->result())
			return $sedes;
		return false;
	}
	
	/*
	*
	*CARRERAS
	*Utilizado en periodos/crear/index, 
	*/
	function get_relacion_sede_carrera($id_facultad = false, $id_sede = false, $id_carrera = false, $estado = false){
		$this->db->where('t1.id_facultad', $id_facultad);
		if($id_sede)
			$this->db->where('t1.id_sede', $id_sede);
		else
			$this->db->group_by('t1.id_sede');
		
		if($id_carrera)
			$this->db->where('t1.id_carrera', $id_carrera);
		else if($id_sede)
			$this->db->group_by('t1.id_carrera');


		$this->db->where('t1.estado', $estado);
		$this->db->join('sedes as t2', 't2.id_sede = t1.id_sede');
		$this->db->join('carreras as t3', 't3.id_facultad = t1.id_facultad AND t3.id_carrera = t1.id_carrera');
		
		$this->db->order_by('t1.id_facultad', 'asc');
		$carreras = $this->db->get('relacion_sede_carrera as t1');
		
		if($carreras->result())
			return $carreras;
		return false;
	}
	
	/*
	*
	*SEMESTRES
	*Utilizado en periodos/crear/index, 
	*/
	function get_semestre($id_facultad, $id_carrera, $id_semestre =false, $tipo_semestre = false){
		if($id_semestre)
			$this->db->where('t1.id_semestre', $id_semestre);	
		if($tipo_semestre)
			$this->db->where('t1.tipo_semestre', $tipo_semestre);
		$this->db->where('t1.id_facultad', $id_facultad);
		$this->db->where('t1.id_carrera', $id_carrera);
		$semestres = $this->db->get('semestres as t1');

		if($semestres->result())
			return $semestres;
		return false;
	}
	
	/*
	*
	*ASIGNATURAS
	*Utilizado en periodos/crear/index, 
	*/
	function get_asignatura($id_facultad, $id_carrera, $id_semestre){
		$this->db->where('t1.id_facultad', $id_facultad);
		$this->db->where('t1.id_carrera', $id_carrera);
		$this->db->where('t1.id_semestre', $id_semestre);
		$asignaturas = $this->db->get('asignaturas as t1');
		
		if($asignaturas->result())
			return $asignaturas;
		return false;
	}
	
	/*
	*
	*ACTIVIDADES
	*
	*/
	function get_actividad($id = false, $actividad = false){
		if($id)
			$this->db->where('id_actividad', $id);
		if($actividad)
			$this->db->where('actividad', $actividad);

		$actividades = $this->db->get('actividades');
		if($actividades->result())
			return $actividades;
		return false;
	}
	
	function save_actividad($actividad){
		$this->db->select_max('id_actividad');
		$actividades	= $this->db->get('actividades');
		if($actividades->result()){
			$actividades_ = $actividades->row_array();
			$id_actividad = $actividades_['id_actividad'] + 1;
		}else{
			$id_actividad = 1;
		}
		$datos = array(
			'id_actividad'	=> $id_actividad,
			'actividad'		=> $actividad,
		);
		$this->db->insert('actividades', $datos);
	}
	
	function eliminar_actividad($id){
		$this->db->where('id_actividad', $id);
		$this->db->delete('actividades');
	}
	
	/*
	*
	*PERIODO
	*
	*/
	function guardar_periodo($id_facultad, $id_sede, $id_carrera, $id_semestre, $id_asignatura, $id_periodo, $id_actividad, $fecha_inicio, $fecha_fin, $estado){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_sede', $id_sede);
		$this->db->where('id_carrera', $id_carrera);
		$this->db->where('id_semestre', $id_semestre);
		$this->db->where('id_asignatura', $id_asignatura);
		$this->db->where('id_periodo', $id_periodo);
		$this->db->where('id_actividad', $id_actividad);
		$periodos = $this->db->get('periodos');
		
		$datos = array(
			'id_facultad' 	=> $id_facultad,
			'id_sede' 		=> $id_sede,
			'id_carrera'	=> $id_carrera,
			'id_semestre'	=> $id_semestre,
			'id_asignatura'	=> $id_asignatura,
			'id_periodo' 	=> $id_periodo,
			'id_actividad'	=> $id_actividad,
			'fecha_inicio'	=> $fecha_inicio,			
			'fecha_fin'		=> $fecha_fin,
		);
		
		if($periodos->result()){
			$this->db->where('id_facultad', $id_facultad);
			$this->db->where('id_sede', $id_sede);
			$this->db->where('id_carrera', $id_carrera);
			$this->db->where('id_semestre', $id_semestre);
			$this->db->where('id_asignatura', $id_asignatura);
			$this->db->where('id_periodo', $id_periodo);
			$this->db->where('id_actividad', $id_actividad);
			$this->db->update('periodos', $datos);
			return false;
		}else{
			$this->db->insert('periodos', $datos);
			return true;
		}
	}
/*	
	function get_periodo($id_facultad = false, $id_sede = false, $id_carrera = false, $id_semestre = false, $id_asignatura = false, $id_periodo = false, $id_actividad = false){
		
		if($id_facultad)
			$this->db->where('t1.id_facultad', $id_facultad);
		
		if($id_sede)
			$this->db->where('t1.id_sede', $id_sede);
		
		if($id_carrera)
			$this->db->where('t1.id_carrera', $id_carrera);
		
		if($id_semestre)
			$this->db->where('t1.id_semestre', $id_semestre);
		
		if($id_asignatura)
			$this->db->where('t1.id_asignatura', $id_asignatura);
			
		if($id_periodo)
			$this->db->where('t1.id_periodo', $id_periodo);
		
		if($id_actividad)
			$this->db->where('t1.id_actividad', $id_actividad);

		$periodos = $this->db->get('periodos as t1');
		
		if($periodos->result())
			return $periodos;
		return false;
	}
*/	
	function get_periodos($id_facultad = false, $id_sede = false, $id_carrera = false, $id_semestre = false, $id_asignatura = false, $id_periodo = false, $id_actividad = false, $inicio = false, $fin = false){

		if($id_facultad)
			$this->db->where('t1.id_facultad', $id_facultad);
		
		if($id_sede)
			$this->db->where('t1.id_sede', $id_sede);
		
		if($id_carrera && $id_carrera != 'todas')
			$this->db->where('t1.id_carrera', $id_carrera);

		if($id_periodo)
			$this->db->where('t1.id_periodo', $id_periodo);
		$this->db->order_by('t1.id_periodo', 'desc');
		$periodos = $this->db->get('periodos as t1');
		
		if($periodos->result())
			return $periodos;
		return false;
	}

	//CREACION
	function get_creacion($facultad = false, $sede = false, $carrera = false){
		if($facultad && $sede && $carrera){
			$this->db->where('id_facultad', $facultad);
			$this->db->where('id_sede', $sede);
			$this->db->where('id_carrera', $carrera);
			$this->db->where('estado', true);
			$relaciones = $this->db->get('relacion_sede_carrera');
			if($relaciones->result()){
				$relaciones_ = $relaciones->row_array();
				return $relaciones_['creacion'];
			}
			return false;
		}else if($facultad && $sede){
			$this->db->select_min('creacion');
			$this->db->where('id_facultad', $facultad);
			$this->db->where('id_sede', $sede);
			$this->db->where('estado', true);
//			$this->db->group_by('creacion');
			$relaciones = $this->db->get('relacion_sede_carrera');
			if($relaciones->result()){
				$relaciones_ = $relaciones->row_array();
				return $relaciones_['creacion'];
			}
			return false;
		}else if($facultad){
			$this->db->where('id_facultad', $facultad);
			$facultades = $this->db->get('facultades');
			if($facultades->result()){
				$facultad_ = $facultades->row_array();
				return $facultad_['creacion'];
			}
			return false;
		}
		return false;
	}

	function eliminar_periodo($id_facultad, $id_sede, $id_carrera, $id_semestre, $id_asignatura, $id_periodo, $id_actividad){
/*		$this->db->where('periodos.id_facultad', $id_facultad);
		$this->db->where('periodos.id_sede', $id_sede);
		$this->db->where('periodos.id_carrera', $id_carrera);
		if($id_semestre == 'impar' || $id_semestre == 'pas' || $id_semestre == 'cpi'){
//			$this->db->where('semestres.tipo_semestre', $id_semestre);
			$this->db->join('semestres', 'semestres.id_facultad = periodos.id_facultad AND semestres.id_carrera = periodos.id_carrera AND semestres.id_semestre = periodos.id_semestre AND semestres.tipo_semestre = $id_semestre');
		}else{
			$this->db->where('periodos.id_semestre', $id_semestre);
		}
		if($id_asignatura)
			$this->db->where('periodos.id_asignatura', $id_asignatura);
		$this->db->where('periodos.id_periodo', $id_periodo);
		$this->db->where('periodos.id_actividad', $id_actividad);

		$this->db->delete('periodos');
*/

		$this->db->query("DELETE FROM periodos
USING periodos as t1, semestres as t2 
WHERE t2.tipo_semestre = $id_semestre AND t1.id_periodo = $id_periodo");
	}

}