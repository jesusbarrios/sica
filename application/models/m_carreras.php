<?php

class M_carreras extends CI_Model{

	function get_carrera($id_facultad = false, $id_carrera = false, $carrera = false){
		if($id_facultad)
			$this->db->where('id_facultad', $id_facultad);
		if($id_carrera)
			$this->db->where('id_carrera', $id_carrera);
		if($carrera)
			$this->db->where('carrera', $carrera);

		$this->db->order_by('carreras.carrera', 'asc');
		$carreras = $this->db->get('carreras');

		if($carreras->result())
			return $carreras;
		return FALSE;
	}
	
	function get_carrera_libre($id_facultad, $id_sede){
		$this->db->distinct();
		$this->db->where('t1.id_facultad', $id_facultad);
		$this->db->where('t2.id_facultad', null);
		$this->db->join('relacion_sede_carrera as t2', 't2.id_facultad = t1.id_facultad AND t2.id_sede = $id_sede AND t2.id_carrera = t1.id_carrera', 'left');
		$relaciones = $this->db->get('carreras as t1');
		if($relaciones->result())
			return $relaciones;
		return false;
/*		$this->db->select('t1.id_carrera');
		$this->db->order_by('t1.id_carrera', 'ASC');
		$this->db->where("t2.id_sede = $id_sede");
		$query = $this->db->get('carreras as t1, relacion_sede_carrera as t2');

		if($query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
*/
	}
	
	function existe_carrera($carrera){

		$result = $this->db->get_where('carreras', array('carrera' => $carrera));

		if($result->num_rows > 0)
			return true;

		return false;
	}
	
	function get_id_max(){

		$this->db->select('id_carrera');
		$this->db->order_by('id_carrera', 'desc');
		$this->db->limit(1);
		$result = $this->db->get_where('carreras');

		foreach($result->result() as $row){
			return $row->id_carrera;
		}
		
		return 0;
	}
	
	function guardar($facultad, $carrera, $estado, $cantidad_curso){
		
		$this->db->select_max('t1.id_carrera');
		$this->db->where('t1.id_facultad', $facultad);
		$carreras = $this->db->get('carreras as t1');
		if($carreras){
			$carreras_ = $carreras->row_array();
			$id_carrera = $carreras_['id_carrera'] + 1;
		}else
			$id_carrera = 1;

		$datos = array(
			'id_facultad' => $facultad,
			'id_carrera' => $id_carrera,
			'carrera' => $carrera,
			'estado' => $estado
		);

		$this->db->insert('carreras', $datos);
		
		$semestres = array('CPI', 'Primer', 'Segundo', 'Tercer', 'Cuarto', 'Quinto', 'Sexto', 'Septimo', 'Octavo', 'Noveno', 'Decimo');
		
		for($i = 1; $i <= $cantidad_curso + 1; $i++){
			$datos = array(
				'id_facultad' => $facultad,
				'id_carrera' => $id_carrera,
				'id_semestre' => $i,
				'semestre' => (isset($semestres[$i - 1]))? $semestres[$i - 1] : $i,
			);
			
			$this->db->insert('semestres', $datos);	
		}
	}
	
	function get_semestres($id_facultad, $id_carrera){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_carrera', $id_carrera);
		$result = $this->db->get('semestres');

		return $result;
	}
	
	function get_cantidad_semestre($id_facultad, $id_carrera){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_carrera', $id_carrera);
		$result = $this->db->get('semestres');
		
		return $result;
	}
	
	function get_asignatura($id_facultad, $id_carrera){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_carrera', $id_carrera);
		$result = $this->db->get('asignaturas');
		
		if($result->result())
			return $result;
		return false;
	}
		
	function obtener_nombre($id){		
		$this->db->where(array('id_carrera' => $id));
		$result = $this->db->get('carreras');
		
		if($result->num_rows() > 0){
			$row = $result->row();
			return $row->carrera;
		}
		echo false;
	}
	
	function eliminar($id_facultad, $id_carrera){
		$this->db->delete('semestres', array('id_facultad' => $id_facultad, 'id_carrera' => $id_carrera));
		$result = $this->db->delete('carreras', array('id_facultad' => $id_facultad, 'id_carrera' => $id_carrera));
		if($result)
			return true;
		
		return false;
	}
	
	function eliminar_relacion_sede_carrera($id_facultad, $id_sede, $id_carrera){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_sede', $id_sede);
		$this->db->where('id_carrera', $id_carrera);
		$this->db->delete('relacion_sede_carrera');
	}
	
	function get_inscripcion_asignatura($facultad = false, $sede = false, $carrera = false){
		$this->db->select('*');
		if($facultad)
			$this->db->where('t1.id_facultad', $facultad);
		
		if($sede)
			$this->db->where('t1.id_sede', $sede);
			
		if($carrera)
			$this->db->where('t1.id_carrera', $carrera);
		
		$result = $this->db->get('inscripciones_asignatura as t1');
		
		if($result->result())
			return $result;
		return false;
	}
	
	/*
	*
	*SEDES
	*
	*/
	function get_sede($id_sede = false){
		if($id_sede)
			$this->db->where('sedes.id_sede', $id_sede);
		$sedes = $this->db->get('sedes');
		if($sedes->result())
			return $sedes;
		return false;
	}
	
	/*
	*
	*RELACIONES SEDE CARRERA
	*
	*/
	function save_relacion_sede_carrera($id_facultad, $id_sede, $id_carrera, $fecha, $estado){
		$datos = array(
			'id_facultad'		=> $id_facultad,
			'id_sede' 			=> $id_sede,
			'id_carrera' 		=> $id_carrera,
			'creacion'	=> $fecha,
			'estado'			=> $estado,
		);
		
		$this->db->insert('relacion_sede_carrera', $datos);

	}

	function get_relacion_sede_carrera($id_facultad = false, $id_sede = false, $id_carrera = false, $estado = false){
		$this->db->select('t1.*, t2.facultad, t3.sede, t4.carrera');
		if($id_facultad)
			$this->db->where('t1.id_facultad', $id_facultad);
		else
			$this->db->group_by('t1.id_facultad');
		if($id_sede)
			$this->db->where('t1.id_sede', $id_sede);
		else if($id_facultad)
			$this->db->group_by('t1.id_sede');
		if($id_carrera)
			$this->db->where('t1.id_carrera', $id_carrera);
		else if($id_sede && $id_facultad)
			$this->db->group_by('t1.id_carrera');
		if($estado)
			$this->db->where('t1.estado', $estado);

		$this->db->join('facultades as t2', 't2.id_facultad = t1.id_facultad');
		$this->db->join('sedes as t3', 't3.id_sede = t1.id_sede');
		$this->db->join('carreras as t4', 't4.id_facultad = t1.id_facultad AND t4.id_carrera = t1.id_carrera');
		
		$this->db->order_by('t1.id_facultad', 'asc');
		$carreras = $this->db->get('relacion_sede_carrera as t1');
		
		if($carreras->result())
			return $carreras;
		return false;
	}
	
	function actualizar_relacion_sede_carrera($id_facultad, $id_sede, $id_carrera, $fecha, $estado){
		$this->db->where('id_facultad', $id_facultad);
		$this->db->where('id_sede', $id_sede);
		$this->db->where('id_carrera', $id_carrera);
		$datos = array(
			'estado'	=> $estado,
		);
		$this->db->update('relacion_sede_carrera', $datos);
	}
	
	/*
	*
	*FACULTADES
	*
	*/
	
	function get_facultad(){
		$facultades = $this->db->get('facultades');
		if($facultades->result())
			return $facultades;
		return false;
	}
	/*
	*
	*CREACION
	*
	*/
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
}
?>