<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			$('.eliminar').click(function(args) {
				carrera = $('#slc_carrera').val();
				semestre = $('#slc_semestre').val();
				asignatura = this.id;
				$('#frm_msn').hide();
				
				$.post('<?=base_url()?>asignaturas/crear/obtener_nombre_asignatura', {slc_carrera : carrera, slc_semestre : semestre, asignatura : asignatura}, function (nombre_asignatura) {

					if(confirm('Desea eliminar la asignatura "' + nombre_asignatura + '"?')){

						$.post('<?=base_url()?>asignaturas/crear/eliminar', {slc_carrera : carrera, slc_semestre : semestre, asignatura : asignatura}, function (respuesta) {		
								$('#detalle')
								.html(respuesta)
								.show('fast')
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
		 .ok{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
*/
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

	if($asignaturas){

		$contador = 1;

		foreach($asignaturas->result() as $row){
			$eliminar = false;
			$correlatividades = $this->m_asignaturas->get_correlatividades($row->id_facultad, $row->id_carrera, $row->id_curso, $row->id_asignatura);
			if($correlatividades)
				$eliminar = true;
				
			$correlatividades = $this->m_asignaturas->get_correlatividades($row->id_facultad, $row->id_carrera, false, false, $row->id_curso, $row->id_asignatura);
			if($correlatividades)
				$eliminar = true;
				
			$this->table->add_row(array(
				$contador ++,
				$row->asignatura,
				($eliminar)? '<span class=eliminar id=' . $row->id_asignatura . '>Eliminar</span>' : 'En uso',
			));	
		}

//		if($mostrar_eliminar)
			$this->table->set_heading(array(null, array('data' => 'Asignaturas', 'colspan' => '2')));	
//		else
//			$this->table->set_heading(array(null, 'Asignaturas'));	
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1">'));

	}else{

		$this->table->set_heading(array('No tiene asignatura'));

	}

	echo $this->table->generate();
//	echo form_fieldset_close();	

?>
</body>
</html>