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

class M_menu extends CI_Model{

	
	//GET MENU, RETORNA LA LISTA DE LOS MENU O UN MENU ESPECIFICO EN EL CASO DE QUE SE RECIBA EL ID POR EL PARAMETRO
	function get_menu($id_menu = false){
		if($id_menu)
			$result = $this->db->get_where('menus', array('id_menu' => $id_menu));
		else
			$result = $this->db->get('menus');
		
		if($result->num_rows() > 0)
			return $result->result();
		else
			return false;
	}
	
	function verificar_existencia_menu($menu){
		$result = $this->db->get_where('menus', array('menu' => $menu));
		
		if($result->num_rows() > 0)

			return true;
		
 		return false; 
	}
	
	function agregar_menu($datos){
		$this->db->insert('menus', $datos);
	}
	
	function borrar_menu($id_menu){
		$result = $this->db->get_where('menu_detalles', array('id_menu' => $id_menu));
		
		if($result->num_rows() > 0)
			return FALSE;
			
		$this->db->delete('menus', array('id_menu' => $id_menu));
		return TRUE;
	}
	
	function get_menu_detalles($id_menu, $id_menu_detalle){
		
		$datos = array(
			'id_menu' => $id_menu,
			'id_menu_detalle' => $id_menu_detalle);
		
		$result = $this->db->get_where('menu_detalles', $datos);
		
		if($result->num_rows() > 0)
			return $result->result();
		
		return false;
	}

}
?>