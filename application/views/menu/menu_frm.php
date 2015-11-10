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
	
</head>

<body>
	<?php
		echo form_open('menu/menu/guardar');
		
		if(isset($menu))
			$menu = $menu;
		else
			$menu = "";
			
		if(isset($posicion))
			$posicion = $posicion;
		else
			$posicion = "";
			
		if(isset($estado))
			$estado = $estado;
		else
			$estado = '1';
			
		$txt_menu = array(
			'name'=> 'txt_menu',
			'id'=>'txt_menu',
			'autofocus'=>'autofocus',
			'size' => '20',
			'maxlength' => '20',
			'value' => $menu);
			
		$txt_posicion = array(
			'name'=> 'txt_posicion',
			'id'=>'txt_posicion',
			'size' => '2',
			'maxlength' => '2',
			'value' => $posicion);
			
		$estados = array(
			'1' => 'Activado',
			'0' => 'Desactivado');
			

		$boton = array(
			'value'=>'Guardar');

		echo form_fieldset('Nuevo menu');
		
		if(isset($ok_message))
			echo "<div class=ok_message>" . $ok_message . "</div>";
		
		echo form_label('Menu:', $txt_menu['id']);
		echo form_input($txt_menu);
		echo "<span class=obligatorio>*</span>";
		echo form_error($txt_menu['id'], "<div class=error>", "</div>");
		echo "<br>";
		
		echo form_label('Posición:', $txt_posicion['id']);
		echo form_input($txt_posicion);
		echo form_error($txt_posicion['id'], "<div class=error>", "</div>");
		echo "<br>";
		
		echo form_label('Estado:', $txt_posicion['id']);
		echo form_dropdown('slc_estado', $estados, $estado);
		echo "<br>";
		
		echo form_submit($boton);
			
		echo form_fieldset_close();
		echo form_close();

		if($menus){
			echo "<div id=lista>";
				$this->load->view('menu/menu_lista.php', array('menus' => $menus), FALSE);
			echo "</div>";
		}
	?>
</body>
</html>