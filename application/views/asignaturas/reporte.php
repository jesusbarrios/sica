<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?= base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			semestres = new Array('CPI', 'Primer', 'Segundo', 'Tercer', 'Cuarto', 'Quinto', 'Sexto', 'Septimo', 'Octavo', 'Noveno', 'Decimo');
			
			$('#slc_carrera').change(function() { 
				
				carrera = $(this).val();
				$('#slc_semestre option[value=""]').prop('selected', true);
				$('#slc_semestre_correlativo option[value=""]').prop('selected', true);
				$('#lista').hide('fast');
				
				$.post('<?= base_url()?>asignaturas/obtener_cantidad_semestre/' + carrera, '', function (respuesta) {
					cantidad_curso_actual = $('#slc_semestre option').length - 1;
					if(cantidad_curso_actual < respuesta){
						for(i = cantidad_curso_actual; i < respuesta; i ++){
							$('#slc_semestre').append(new Option(semestres[i], i, false, false));
						}	
					}else{
						
						for(i = cantidad_curso_actual; i >= respuesta; i --){
							$("#slc_semestre option[value=" + i + "]").remove();
							
						}
					}
				});

			});

			$('#slc_semestre').change(function(args) {
				carrera = $('#slc_carrera').val();
				semestre = $(this).val();
				if(semestre != ''){
					$.post('<?= base_url()?>asignaturas/actualizar_lista/' + carrera + '/' + semestre, '', function (respuesta) {
						$('#lista')
						.show()
						.html(respuesta)
					});
				}else{
					$('#lista').hide('fast');
				}
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
	echo form_fieldset('Reporte de asignaturas');
		if($carreras){

			//CAMPO CARRERA
			$opciones = array('' => '-----');
			foreach($carreras->result() as $row)
				$opciones[$row->id_carrera] = $row->carrera;	
	
			$this->table->add_row(array(
				form_label('Carrera:'),
				form_dropdown('slc_carrera', $opciones, FALSE, 'id = slc_carrera autofocus=autofocus')
			));
				
			//CAMPO SEMESTRES
			$opciones = array('' => '-----');
	
			$this->table->add_row(array(
				form_label('Semestre:'),
				form_dropdown('slc_semestre', $opciones, FALSE, 'id = slc_semestre')
			));
				
			$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0">'));
			echo $this->table->generate();
	}
	echo form_fieldset_close();
	
	echo "<div id=lista></div>";
?>
</body>
</html>