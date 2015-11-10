<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<style>
		 fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    font-size: 11px;
		    margin: 0 auto;
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
		    padding-right: 0px;
		    text-align: right;
		    vertical-align: top;
		    width: 140px;
		}

		input {
			margin: 0px 3px 0px 0px;
		}

		input[type="button"], input[type="submit"]  {
		    cursor: pointer;
 		    margin: 0px 10px 0px 0px; 
		}

		.error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 12px;
		    margin: 2px;
		    padding: 1px 3px;
		    text-align: left;
		}

		.ok{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 12px;
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
			margin: 10px auto;
		}
		
		table td{
			padding: 5px 5px;
		}
	</style>
	
</head>

<body>
<?php
	echo form_fieldset('Reporte de sedes');
	
	if($sedes){
		$contador_sedes = 1;
		foreach($sedes->result() as $row){
			$relaciones = $this->sedes->get_carrera($row->id_facultad, $row->id_sede);
			if($relaciones){
				$cant_carrera = $relaciones->num_rows();
				$contador_carrera = 1;
				foreach($relaciones->result() as $row_carrera){
					if($contador_carrera == 1){
						$this->table->add_row(array(
							array('data' => $contador_sedes++, 'rowspan' => $cant_carrera),
							array('data' => $row->sede, 'rowspan' => $cant_carrera),
							array('data' => $contador_carrera . '- ' . $row_carrera->carrera, 'style' => 'font-style:italic'),
						));		
					}else{
						$this->table->add_row(array(
							array('data' => $contador_carrera . '- ' . $row_carrera->carrera, 'style' => 'font-style:italic'),
						));
					}
					$contador_carrera ++;
				}
			}else{
				$cant_carrera = 0;
				$this->table->add_row(array(
					array('data' => $contador_sedes++, 'rowspan' => $cant_carrera),
					array('data' => $row->sede, 'rowspan' => $cant_carrera),
//					$contador_carrera . '- ' . $row_carrera->carrera,
					array('data' => 'No tiene carrera relacionada', 'style' => 'color:red; font-style:italic'),
				));
			}
			
		}
		$this->table->set_heading('N<sup>ro</sup>', 'Sedes', 'Carreras');
		$this->table->set_template(array ( 'table_open'  => '<table border="2" cellpadding="2" cellspacing="0" class="tbl_detalles">' ));
		echo $this->table->generate();
	}
	echo form_fieldset_close();
?>
</body>
</html>