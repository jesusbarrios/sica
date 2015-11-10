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

class M_sub_menu extends CI_Model{

	function verificar_existencia_sub_menu($sub_menu){
		$result = $this->db->get_where('menus', array('menu' => $menu));
		
		if($result->num_rows() > 0)
			return true;
		
 		return false; 
	}
	
	function agregar_menu($datos){
		$this->db->insert('menus', $datos);
	}
	
	function borrar_sub_menu($menu, $id){
		$result = $this->db->get_where('menu_detalles', array('id_menu' => $id_menu));
		
		if($result->num_rows() > 0)
			return FALSE;
			
		$this->db->delete('menus', array('id_menu' => $id_menu));
		return TRUE;
	}
	
	function get_sub_menu($menu = false){
		
		if($menu)
			$result = $this->db->get_where('menu_detalles', array('id_menu' => $menu));
		else
			$result = $this->db->get_where('menu_detalles');
		
		if($result->num_rows() > 0)
			return $result->result();
			
		return false;
	}
}
?>