<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<style>
		 fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    font-size: 11px;
		    margin: 10px auto;
		    padding: 10 33px;
		    width: 600px;
		    font-size: 13px;
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
		    margin-top: 0px;
		    padding-right: 7px;
		    text-align: right;
		    vertical-align: top;
		    width: 140px;
		}

		 .error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		 .ok{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		 .campo_obligatorio {
		    color: #FF0000;
		    float: left;
		    font-size: 11px;
		    margin-top: 20px;
		    padding: 0 2px;
		}
		
		 table{
			margin: 10px;
		}
		
		 table td{
			padding: 5px 3px;
		}
		
		h3.titulo{
			border-bottom : solid 1px #ffffee;
			text-align: center;
		}
	</style>
</head>

<body>
	<?php
		//FACULTAD
		if($actividades){
			foreach($actividades->result() as $row){
				$campo_desde = 'txt_desde_' . $row->id_actividad;
				$campo_hasta = 'txt_hasta_' . $row->id_actividad;
				$txt_desde = array(
					'id'	=> $campo_desde,
					'name'	=> $campo_desde,
					'type'	=> 'date',
				);
				
				$txt_hasta = array(
					'id'	=> $campo_hasta,
					'name'	=> $campo_hasta,
					'type'	=> 'date',
				);
				$this->table->add_row(array(
					form_label($row->actividad, $campo_desde),
					form_input($txt_desde),
					form_input($txt_hasta),
				));
 			}
 			if($actividades->num_rows() > 1)
 				$this->table->set_heading('Actividades', 'Desde', 'Hasta');
 			else
 				$this->table->set_heading('Actividad', 'Desde', 'Hasta');
 			
 			$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1">'));
			echo $this->table->generate();
		}else{
			echo 'No hay actividades registrado';
		}
	?>
</body>
</html>