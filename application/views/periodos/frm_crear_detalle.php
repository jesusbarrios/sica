<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			$('.eliminar').click(function(args) {
				if($('#slc_facultad').val())
					slc_facultad = $('#slc_facultad').val();
				else
					slc_facultad = false;
				slc_sede		= $('#slc_sede').val();
				slc_carrera 	= $('#slc_carrera').val();
				slc_semestre 	= $('#slc_semestre').val();
				slc_periodo 	= $('#slc_periodo').val();
				slc_actividad 	= $('#slc_actividad').val();
				id_carrera 	= $(this).attr('id');
				$.post('<?=base_url()?>index.php/periodos/crear/obtener_nombre_carrera', {slc_facultad : slc_facultad, carrera : id_carrera}, function (nombre_asignatura) {
					if(confirm('Desea eliminar el periodo de la carrera "' + nombre_asignatura + '"?')){
						$.post('<?=base_url()?>index.php/periodos/crear/eliminar', {slc_facultad : slc_facultad, slc_sede : slc_sede, slc_carrera : slc_carrera, slc_semestre : slc_semestre, slc_periodo : slc_periodo, slc_actividad : slc_actividad, carrera : id_carrera}, function (respuesta) {
								alert(respuesta)
								$('#detalle')
								.html(respuesta)
								.show('fast');
						});
					}
				});
			})
		});
	</script>

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
		.eliminar{
			color:red;
			cursor : pointer;
		}

/*
		 .error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
*/		 .msn{
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
			margin: 10px auto;
		}
		
		 table td{
			padding: 5px 3px;
		}
		
		h3.titulo{
			border-bottom : solid 1px #ffffee;
			text-align: center;
		}
		#lista table td span.eliminar{
			color: #bb0000;
			text-decoration: underline;
			cursor: pointer;
		}
	</style>
</head>

<body>
<?php

//	echo form_fieldset('Lista de Asignaturas');
	if($msn)
		echo "<span class= msn>$msn</span>";

	if($periodos){

		$contador = 1;

		foreach($periodos->result() as $row){
			if($mostrar_carrera && $mostrar_semestre){
				$this->table->set_heading(array('Nro', 'Per', 'Fac', 'Sed', 'Carr', 'Semestres', 'Desde', 'Hasta', 'Opcion'));	

				$this->table->add_row(array(
					$contador ++,

					$row->id_periodo,
					$row->id_facultad,
					$row->id_sede,
					$row->carrera,
					$row->semestre,
					date('Y/m/d', strtotime($row->fecha_inicio)),
					date('Y/m/d', strtotime($row->fecha_fin)),
					"<span class=eliminar id=$row->id_carrera>Eliminar</span>",
				));	
			}else if($mostrar_carrera){
				$this->table->set_heading(array('Nro', 'Carreras', 'Desde', 'Hasta', 'Opcion'));	
				$this->table->add_row(array(
					$contador ++,
					$row->carrera,
					date('Y/m/d', strtotime($row->fecha_inicio)),
					date('Y/m/d', strtotime($row->fecha_fin)),
					"<span class=eliminar id=$row->id_carrera>Eliminar</span>",
				));
			}else if($mostrar_semestre){
				$this->table->set_heading(array('Nro', 'Semestres', 'Desde', 'Hasta', 'Opcion'));	
				$this->table->add_row(array(
					$contador ++,
					$row->semestre,
					date('Y/m/d', strtotime($row->fecha_inicio)),
					date('Y/m/d', strtotime($row->fecha_fin)),
					"<span class=eliminar id=$row->id_carrera>Eliminar</span>",
				));
			}else{
				$this->table->set_heading(array('Nro', 'Desde', 'Hasta', 'Opcion'));	
				$this->table->add_row(array(
					$contador ++,
					date('Y/m/d', strtotime($row->fecha_inicio)),
					date('Y/m/d', strtotime($row->fecha_fin)),
					"<span class=eliminar id=$row->id_carrera>Eliminar</span>",
				));
			}
		}

		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1">'));

	}else{

		$this->table->set_heading(array('No hay periodos'));

	}

	echo $this->table->generate();
//	echo form_fieldset_close();	

?>
</body>
</html>