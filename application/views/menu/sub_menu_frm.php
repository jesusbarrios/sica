<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<style>
		fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    margin: 0 auto;
		    padding: 0 33px;
		    width: 350px;
		}
		legend {
		    background-color: #FFFFFF;
		    border: 1px solid #A0A0A0;
		    border-radius: 7px 7px 7px 7px;
		    color: #000000;
		    font-size: 15px;
		    font-weight: bold;
		    padding: 2px 20px;
		}
		label {
		    color: #000000;
		    float: left;
		    font-size: 15px;
		    margin-top: 20px;
		    padding-right: 7px;
		    text-align: right;
		    vertical-align: top;
		    width: 90px;
		}
		input, select {
		    margin: 20px 3px 0px 0px;
		}
		input[type="submit"] {
		    cursor: pointer;
		    margin: 20px 97px;
		}
		.error_message{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		    
		}
		.ok_message{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}

		.error{
			color: #FF0000;
		    font-size: 11px;
		    margin : 5px 0px 0px 97px;
		}
		
		.obligatorio{
			color: #ff0000;
		}

		
	</style>
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$(document).ready(function(){
			$('#slc_menu').change(function(){
				menu = $(this).val();
				
				
				$.post('<?=base_url()?>menu/sub_menu/cambiar_lista_sub_menu/' + menu, '', function (respuesta) {
					$('#lista').html(respuesta)
				});

//alert(menu)
			});
		});
		
	</script>
	
</head>

<body>
	<?php
		echo form_open('menu/menu/guardar');
		
		
		echo form_fieldset('Nuevo Sub-menu');
		
		if(isset($ok_message))
			echo "<div class=ok_message>" . $ok_message . "</div>";

		//MENU
		if(!isset($menu))
			$menu = "";
			
		$menus = array('' => '-----');
		foreach($menus_list as $row){
			$menus[$row->id_menu] = $row->menu;
		}	
			
		echo form_label('Menu:', 'slc_menu');
		echo form_dropdown('slc_menu', $menus, $menu, 'id=slc_menu');
		echo "<br>";
		
		
		
		//SUB MENU
		if(!isset($sub_menu))
			$sub_menu = "";
			
		$txt_sub_menu = array(
			'name'=> 'txt_sub_menu',
			'id'=>'txt_sub_menu',
			'autofocus'=>'autofocus',
			'size' => '20',
			'maxlength' => '20',
			'value' => $menu);
		
		echo form_label('Sub Menu:', $txt_sub_menu['id']);
		echo form_input($txt_sub_menu);
		echo "<span class=obligatorio>*</span>";
		echo form_error($txt_sub_menu['id'], "<div class=error>", "</div>");
		echo "<br>";
		
			
		//POSICION
		if(!isset($posicion))
			$posicion = "";
		
		$txt_posicion = array(
			'name'=> 'txt_posicion',
			'id'=>'txt_posicion',
			'size' => '2',
			'maxlength' => '2',
			'value' => $posicion);
		
		echo form_label('Posición:', $txt_posicion['id']);
		echo form_input($txt_posicion);
		echo form_error($txt_posicion['id'], "<div class=error>", "</div>");
		echo "<br>";
		
		
		
		//ESTADO
		if(!isset($estado))
			$estado = '1';
			
		$estados = array(
			'1' => 'Activado',
			'0' => 'Desactivado');
			
		echo form_label('Estado:', 'slc_estado');
		echo form_dropdown('slc_estado', $estados, $estado);
		echo "<br>";
			

		//BOTON
		$boton = array(
			'value'=>'Guardar');
		
		echo form_submit($boton);
			
		echo form_fieldset_close();
		echo form_close();

		if($sub_menus){
			echo "<div id=lista>";
				$this->load->view('menu/sub_menu_lista.php', array('sub_menus' => $sub_menus), FALSE);
			echo "</div>";
		}
	?>
</body>
</html>