<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			$('.eliminar').click(function(args) {
				carrera = $('#slc_carrera').val();
				semestre1 = $('#slc_semestre').val();
				asignatura1 = $('#slc_asignatura').val();
				asignatura2 = this.id;
				$('#frm_msn').hide();

				$.post('<?=base_url()?>asignaturas/correlatividad/obtener_nombre_asignatura/' + asignatura2, {slc_carrera : carrera}, function (nombre_asignatura) {
					if(confirm('Desea eliminar la correlatividad con la asignatura ' + nombre_asignatura + '?')){

						$.post('<?=base_url()?>asignaturas/correlatividad/eliminar_correlatividad/' + asignatura2, {slc_carrera : carrera, slc_semestre1 : semestre1, slc_asignatura1 : asignatura1}, function (respuesta) {
						
							$.post('<?=base_url()?>asignaturas/correlatividad/actualizar_detalle_correlatividad', {slc_carrera : carrera, slc_semestre : semestre1, 
							slc_asignatura : asignatura1, asignatura2 : nombre_asignatura}, function (respuesta) {
								$('#detalle')
								.html(respuesta)
								.show('fast');
							});
						});
					}
				});


			})

	
		});
	</script>

	<style>
/*		 fieldset{
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

		.campo_obligatorio {
		    color: #FF0000;
		    float: left;
		    font-size: 11px;
		    margin-top: 20px;
		    padding: 0 2px;
		}
*/		
		table{
			margin: 10px auto;
		}
		
		 table td{
			padding: 5px 3px;
		}
/*		
		h3.titulo{
			border-bottom : solid 1px #ffffee;
			text-align: center;
		}
*/
		.eliminar{
			color: #bb0000;
			text-decoration: underline;
			cursor: pointer;
		}
	</style>
</head>

<body>

<?php

//	echo form_fieldset('Lista de Asignaturas');
	
//	echo "<div id=list_msn class=" . $list_msn_class . ">" . $list_msn . "</div>";
	if($correlatividades){

		$contador = 1;
		$semestres = array('Primero', 'Segundo', 'Tercero', 'Cuarto', 'Quinto', 'Sexto', 'Septimo', 'Octavo', 'Noveno', 'Decimo');
		
		foreach($correlatividades->result() as $row){

//			$asignaturas = $this->asignaturas->get_asignatura($row->id_carrera, $row->id_semestre2, $row->id_asignatura2);
//			foreach($asignaturas->result() as $row2)
//				$nombre_asignatura = $row2->asignatura;

			$identificador = $row->id_semestre2 . '/' . $row->id_asignatura2;
			$this->table->add_row(array(
				$contador ++,
				$row->semestre,
				$row->asignatura,
				'<span class=eliminar id=' . $identificador . '>Eliminar</span>'
			));

		}

		$this->table->set_heading(array('N<sup>ro</sup>', 'Semestres', 'Asignaturas', array('data' => 'Opciones', 'colspan' => '1')));	
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1">'));

//echo 'si';
	}else{
//		echo 'no';
		$this->table->set_heading(array("No tiene correlatividad asociada"));
		
	}
	echo $this->table->generate();

//	echo form_fieldset_close();	
?>

</body>
</html>