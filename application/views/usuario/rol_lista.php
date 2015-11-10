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
	
		$this->table->set_heading(array('Nro', 'Roles', 'Opción'));
		$this->table->set_caption("Lista de roles" . $mensaje);
		$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="lista">' ));
		$contador = 1;

		foreach($roles as $row)
			//$this->table->add_row($contador++, $row->rol, '<span class=delete id=' .$row->id_rol . '>borrar</span>');
			$this->table->add_row($contador++, $row->rol, '<a href=' . base_url() . 'usuario/rol/delete/' . $row->id_rol . '>borrar</a>');

		echo $this->table->generate();

	?>
</body>
</html>