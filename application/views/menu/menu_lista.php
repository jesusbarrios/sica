<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	

	<style>
		#lista{
			margin: 10px;			
		}
		
		table{
			margin: 0 auto;
		}
		
		caption{
			font-style: italic;
			font-weight: bolder;
		}
		
		.delete{
			cursor : pointer;
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
		
	</style>
	
</head>

<body>
	<?php
		
		if(isset($list_ok_message))
			$mensaje = "<div class=ok_message> " . $list_ok_message . "</div>";
		
		else if(isset($list_error_message))
			$mensaje = "<div class=error_message>" . $list_error_message . "</div>";
		
		else
			$mensaje = "";
	
		$this->table->set_heading(array('Nro', 'Menus', 'Posiciones', 'Estados', 'Opción'));
		$this->table->set_caption("Lista de menus" . $mensaje);
		$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="lista">' ));
		$contador = 1;

		foreach($menus as $row)
			//$this->table->add_row($contador++, $row->rol, '<span class=delete id=' .$row->id_rol . '>borrar</span>');
			$this->table->add_row($contador++, $row->menu, $row->posicion, ($row->estado == '0')? 'Desactivado' : 'Activado', '<a href=' . base_url() . 'menu/menu/delete/' . $row->id_menu . '>borrar</a>');

		echo $this->table->generate();

	?>
</body>
</html>