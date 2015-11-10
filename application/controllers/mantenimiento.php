<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mantenimiento extends CI_Controller {

	/*
	*
	*De la tabla vieja "inscripciones_asignaturas" que tenia como cabecera a persona lo volcamos a una nueva tabla inscripciones que tiene
	*como cabecera asignaturas, esto es una correccion de diseño
	*/
	function index(){
		$periodos2 = $this->db->get('inscripciones_asignatura');
		$id_periodo 	= 0;
		$id_facultad 	= 0;
		$id_sede 		= 0;
		$id_carrera 	= 0;
		$id_semestre 	= 0;
		$id_asignatura	= 0;
		$id_persona 	= 0;
		$contador1		= 0;
		$contador2		= 0;

		foreach($periodos2->result() as $row){
			$contador1 ++;
			$id_periodo		= $row->id_periodo;
			$id_facultad 	= $row->id_facultad;
			$id_sede 		= $row->id_sede;
			$id_carrera 	= $row->id_carrera;
			$id_semestre 	= $row->id_semestre;
			$id_asignatura 	= $row->id_asignatura;
			$id_persona 	= $row->id_persona;

			$datos = array(
				'periodo'	=> $id_periodo,
				'facultad'	=> $id_facultad,
				'sede'		=> $id_sede,
				'carrera'	=> $id_carrera,
				'semestre'	=> $id_semestre,
				'asignatura'	=> $id_asignatura,
				'persona'	=> $id_persona,
			);

			$result = $this->db->get_where('detalles_inscripcion', $datos);

			if(!$result->result()){
				$contador2 ++;
				$datos = array(
					'periodo'	=> $id_periodo,
					'facultad'	=> $id_facultad,
					'sede'		=> $id_sede,
					'carrera'	=> $id_carrera,
					'semestre'	=> $id_semestre,
					'asignatura'=> $id_asignatura,
					'persona'	=> $id_persona,
					'fecha'		=> $row->estado,
					'estado'	=> true,
				);

				$this->db->insert('detalles_inscripcion', $datos);
			}

		}
echo $id_asignatura;
		echo $contador1 . 'recorridos,' . $contador2  . 'volcados';
	}
/*
	function index(){

		$result = $this->db->get('usuarios');

		if($result->num_rows($result) > 0){
		
			$usuario = $result->result();
			
			foreach($usuario as $row){

				$id_universidad = $row->id_universidad;
				$id_facultad = $row->id_facultad;
				$id_sede = $row->id_sede;
				$id_persona = $row->id_persona;

				$datos = array(
					'id_universidad' => $id_universidad,
					'id_facultad' => $id_facultad,
					'id_sede' => 1,
					'id_persona' => $id_persona,
					'id_tipo_usuario' => 3,
					'id_categoria_tipo_usuario' => 1);

				$this->db->insert('relaciones_usuario_tipo', $datos);

			}
		}	
		
		echo 'ok';	
	}
*/	

/*
	function index(){
		
		$colegios = $this->db->get('relaciones_colegio_persona');
		
		foreach( $colegios->result() as $row){
			
			$departamento = $row->departamento;
			
			$result = $this->db->get_where('departamentos', array('departamento' => $departamento));
		
			if($result->num_rows() > 0){
				foreach($result->result() as $fila)
					$id_departamento = $fila->id_departamento;
			}else{

				$this->db->select_max('id_departamento');
				$this->db->where('id_pais', 1);
				$departamentos = $this->db->get('departamentos');

				foreach($departamentos->result() as $fila){
					$id_departamento = $fila->id_departamento + 1;
				}
					
				$datos = array(
					'id_pais' => 1,
					'id_departamento' => $id_departamento,
					'departamento' => $departamento);

				$this->db->insert('departamentos', $datos);
			}
			
			
			$ciudad = $row->localidad;
			
			$result = $this->db->get_where('ciudades', array('id_departamento' => $id_departamento, 'ciudad' => $ciudad));
		
			if($result->num_rows() > 0){
				foreach($result->result() as $fila)
					$id_ciudad = $fila->id_ciudad;
			}else{
				$datos = array(
					'id_pais' => 1,
					'id_departamento' => $id_departamento);
				$this->db->select_max('id_ciudad');
				$ciudades = $this->db->get_where('ciudades', $datos);
				$id_ciudad = 1;
				foreach($ciudades->result() as $fila){
					$id_ciudad = $fila->id_ciudad + 1;
				}
					
				$datos = array(
					'id_pais' => 1,
					'id_departamento' => $id_departamento,
					'id_ciudad' => $id_ciudad,
					'ciudad' => $ciudad);

				$this->db->insert('ciudades', $datos);
			}
			
			//COLEGIOS
			$colegio = $row->colegio;
			
			$result = $this->db->get_where('colegios', array('id_departamento' => $id_departamento, 'id_ciudad' => $id_ciudad, 'colegio'=> $colegio));
		
			if($result->num_rows() > 0){
				foreach($result->result() as $fila)
					$id_colegio = $fila->id_colegio;
			}else{
				$datos = array(
					'id_pais' => 1,
					'id_departamento' => $id_departamento,
					'id_ciudad' => $id_ciudad);
				$this->db->select_max('id_colegio');
				$colegios = $this->db->get_where('colegios', $datos);
				$id_colegio = 1;
				foreach($colegios->result() as $fila){
					$id_colegio = $fila->id_colegio + 1;
				}
					
				$datos = array(
					'id_pais' => 1,
					'id_departamento' => $id_departamento,
					'id_ciudad' => $id_ciudad,
					'id_colegio' => $id_colegio,
					'colegio' => $colegio);

				$this->db->insert('colegios', $datos);
			}
			
			//BACHILLERATOS
			$bachillerato = $row->bachillerato;
			
			$result = $this->db->get_where('bachilleratos', array('bachillerato' => $bachillerato));
		
			if($result->num_rows() > 0){
				foreach($result->result() as $fila)
					$id_bachillerato = $fila->id_bachillerato;
			}else{
				$this->db->select_max('id_bachillerato');
				$bachilleratos = $this->db->get_where('bachilleratos');
				$id_bachillerato = 1;
				foreach($bachilleratos->result() as $fila){
					$id_bachillerato = $fila->id_bachillerato + 1;
				}
					
				$datos = array(
					'id_bachillerato' => $id_bachillerato,
					'bachillerato' => $bachillerato);

				$this->db->insert('bachilleratos', $datos);
					
//				$this->db->insert('procedencia_educacional', $datos);
			}					
			//RELACION COLEGIO BACHILLERATO
			
			$datos = array(
				'id_pais' => 1,
				'id_departamento' => $id_departamento,
				'id_ciudad' => $id_ciudad,
				'id_colegio' => $id_colegio,
				'id_bachillerato' => $id_bachillerato);
						
			$result = $this->db->get_where('relacion_colegio_bachillerato', $datos);
					
			if($result->num_rows() < 1){
				$this->db->insert('relacion_colegio_bachillerato', $datos);
			}
			
			$datos = array(
				'id_pais' => 1,
				'id_departamento' => $id_departamento,
				'id_ciudad' => $id_ciudad,
				'id_colegio' => $id_colegio,
				'id_bachillerato' => $id_bachillerato,
				'anho_egreso' => $row->anho_egreso,
				'id_persona' => $row->id_persona);
			
			$result = $this->db->get_where('procedencia_educacional', $datos);
					
			if($result->num_rows() < 1)
				$this->db->insert('procedencia_educacional', $datos);
					
		}
		
		echo 'Proceso Exitoso';
	}
	
	function cambios(){
		$pais = 1;
		$departamento = 1;
		$ciudad = 25;
	
	
		$datos_buscar = array(
			'id_pais' => $pais,
			'id_departamento' => $departamento,
			'id_ciudad' => $ciudad);
	
			
		$result = $this->db->get_where('colegios', $datos_buscar);
		
		if($result->num_rows() > 0){
			echo "Hay " . $result->num_rows() . " registros con esos datos";
			
			$datos_condicion = array(
				'id_pais' => $pais,
				'id_departamento' => $departamento,
				'id_ciudad' => $ciudad);
			
			$datos_nuevo = array(
				'id_ciudad' => 9);
			
			$this->db->where($datos_condicion);
			$this->db->update('colegios', $datos_nuevo);

		}else{
			echo "No hay registros";
		}
	}
*/
}	
?>