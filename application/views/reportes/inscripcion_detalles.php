<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
    
    <script> 
	    $(document).ready(function () {
	    
	    });
    </script>
    
	<style>
		fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    margin: 0 auto;
		    padding: 0 33px;
		    width: 550px;
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
		table{
			margin:  auto;
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
		input {
			margin: 0px 3px 0px 0px;
		}
		input[type="submit"] {
		    cursor: pointer;
		}
		.frm_alert{
			color: #000000;
		    background: none repeat scroll 0 0 #ffff00;
		    border: 1px solid #888800;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		.frm_ok{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		.campo_obligatorio{
		    color: #FF0000;
		    float: left;
		    font-size: 11px;
		    margin-top: 20px;
		    padding: 0 2px;
		}
		
		.tbl_detalles{
			margin: 10px auto;
		}
		
		.tbl_detalles td label{
			width: 100%;
			text-align: left;
			margin: 1px 5px;
		}
	</style>
	
</head>

<body>
<?php
	
	if($detalles_inscripcion){
		$this->table->set_heading('N<sup>ro</sup>', 'Estudiantes', 'Documentos', 'Fecha Inscripción');
		$cont = 1;
		foreach($detalles_inscripcion->result() as $row)
		$this->table->add_row(array(
			$cont ++,
			$row->apellido . ', ' . $row->nombre,
			number_format($row->documento),
			date('d-m-Y', strtotime($row->fecha)),
//			$row->id_periodo . $row->id_facultad . $row->id_sede . $row->id_carrera . $row->id_semestre . $row->id_asignatura,
		));
	}else{
		$this->table->add_row('No hay inscripciones');
	}
	
	$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="">' ));
	echo $this->table->generate();	
?>
</body>
</html>