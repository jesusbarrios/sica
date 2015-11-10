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

class M_rol extends CI_Model{


	function get_rol_predeterminado($id_universidad, $id_facultad, $id_sede, $id_persona){

		$datos = array(
			'id_universidad' => $id_universidad,
			'id_facultad' => $id_facultad,
			'id_sede' => $id_sede,
			'id_persona' => $id_persona,
			'id_rol_predeterminado' => '1');

		$result = $this->db->get_where('relaciones_usuario_rol', $datos);

		if($result->num_rows() > 0){

			foreach($result->result() as $row)
				return $row->id_rol_predeterminado;

		}
		
		return false;
	}
	
	function get_cantidad_rol($id_universidad, $id_facultad, $id_sede, $id_persona){

		$datos = array(
			'id_universidad' => $id_universidad,
			'id_facultad' => $id_facultad,
			'id_sede' => $id_sede,
			'id_persona' => $id_persona);

		$result = $this->db->get_where('relaciones_usuario_rol', $datos);

		return $result->num_rows();
	}

	function get_relaciones_rol_menu($id_rol){
		$result = $this->db->get_where('relaciones_rol_menu', array('id_rol' => $id_rol));

		if($result->num_rows() > 0)
			return $result->result();
		
		return false;
	}
	
	function verificar_existencia_rol($rol){
	
		$result = $this->db->get_where('roles', array('rol' => $rol));
		
		if($result->num_rows() > 0)
			return true;
		
		return false;
	}

	function agregar_rol($rol){
		$datos = array(
			'rol' => $rol,
			'estado' => '1');
		$this->db->insert('roles', $datos);
	}

	function borrar_rol($id_rol){
		$this->db->select('t1.id_rol, t2.id_rol');
		$this->db->where('t1.id_rol', $id_rol);
		$this->db->or_where('t2.id_rol', $id_rol); 
		$result = $this->db->get('relaciones_usuario_rol as t1, relaciones_rol_menu as t2');
		
		if($result->num_rows() > 0){
			return FALSE;

		}else{
			$this->db->delete('roles', array('id_rol' => $id_rol));
			return TRUE;
		}
	}


	function get_rol($id_rol = FALSE){
		if(!$id_rol)
			$result = $this->db->get('roles');
		else
			$result = $this->db->get_where('roles', array('id_rol' => $id_rol));
		
		if($result->num_rows() > 0)
			return $result->result();

		return FALSE;
	}

}
?>