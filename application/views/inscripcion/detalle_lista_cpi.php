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
		
		table tr:hover{
			background-color: #ddd;
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
		
		span.borrar:hover{
			color: #ff0000;
		}
		
		span.ingresar:hover{
			color: #00bb00;
		}
		
		span.ver:hover{
			color: #0000bb;
		}
		
		span.borrar, span.ingresar, span.ver {
			cursor : pointer;
			font-weight: bold;
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
	
		$this->table->set_heading(array('Nro', 'Apellido', 'Nombre', 'Opción'));
		$this->table->set_caption("Lista de Inscriptos al CPI" . $mensaje);
		$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="lista">' ));
		$contador = 1;

		while($row = mysql_fetch_assoc($lista))
			$this->table->add_row($contador++, $row['apellido'], $row['nombre'], '<span class=ver id=' . $row['id_persona'] . '>Ver</span>  <span class=ingresar id=' . $row['id_persona'] . '>Ingresar</span>  <span class=borrar id=' . $row['id_persona'] . '>Borrar</span>');

		echo $this->table->generate();

	?>
</body>
</html>