<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    
    <script>
    $(document).ready(function () {
    	$('.oportunidades').change(function(args) {
	    	asignatura = $(this).attr('id');
	    	oportunidad = $(this).val();
	    	
	    	campo = 'chk_' + asignatura;
	    	
	    	if(oportunidad){
		    	$('#' + campo).attr('disabled', false);
		    }else{
		    	$('#' + campo).attr('checked', false);
			    $('#' + campo).attr('disabled', true);
		    }
	     })
	     
	     $('checkbox').keypress(function(e){
			  if(e.which == 13){
				  return false;
			}
		  });
		  
		  $('.oportunidades').keypress(function(e){
		    if(e.which == 13){
		      return false;
		    }
		  });

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
		.error {
		    color: #FF0000;
		    font-size: 11px;
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

	if($detalles_inscripcion_semestre){
			$contador = 0;
			
			foreach($detalles_inscripcion_semestre->result() as $row){
				$id_facultad = $row->id_facultad;
				$id_sede = $row->id_sede;
				$id_carrera = $row->id_carrera;
				$id_semestre = $row->id_semestre;
				$id_periodo = $row->periodo;
				$id_persona = $row->id_persona;
				$id_asignatura = $row->id_asignatura;
				
				$campo = 'chk_' . $id_asignatura;
				$inscripciones_evaluacion = $this->m_inscripcion->get_inscripcion_evaluacion_final($id_facultad, $id_sede, $id_carrera, $id_semestre, $id_periodo, $id_persona, $row->id_asignatura);
				
				if($inscripciones_evaluacion){
					$row_inscripcion = $inscripciones_evaluacion->row_array();
					$this->table->add_row(array(
						form_label($row->asignatura),
						$row->parcial,
						$row->asistencia,
						'Inscripto',
						'',
					));
				}else{
					$pendiente = false;
					$correlatividades = $this->m_inscripcion->get_correlatividad($id_facultad, $id_carrera, $id_semestre, $row->id_asignatura);
					
					if($correlatividades){
						foreach($correlatividades->result() as $row_correlatividad){
							$id_semestre2 = $row_correlatividad->id_semestre2;
							$id_asignatura2 = $row_correlatividad->id_asignatura2;
							$inscripcion_correlativo = $this->m_inscripcion->get_inscripcion_evaluacion_final($id_facultad, $id_sede, $id_carrera, $id_semestre2, $id_periodo, $id_persona, $id_asignatura2);
							//SI TIENE CORRELATIVIDADES, ENTONCES VERIFICA SI TODAS SON APROBADAS
							if($inscripcion_correlativo){
								$row_inscripcion_correlativo = $inscripcion_correlativo->row_array();
								if($row_inscripcion_correlativo['calificacion'] < 2)
									$pendiente = true;
							//SI NUNCA SE INSCRIBIO A UNA ASIGNATURA CORRELATIVA, DIRECTAMENTE TIENE ASIGNATURAS PENDIENTES
							}else{
								$pendiente = true;
							}
						}
					}

					if($row->parcial >= $pp_min && $row->asistencia >= $asistencia_min && !$pendiente){
						$this->table->add_row(array(
							form_label($row->asignatura),
							$row->parcial,
							$row->asistencia,
							array('data' => form_checkbox($campo, true, set_value($campo)), 'style' => 'text-align:center'),
//							form_checkbox($campo),
							'',
						));
					}else{
						$observacion = '';
						$observacion .= ($pendiente)? 'Correlatividad<br> ' : '';
						$observacion .= ($row->parcial < $pp_min)? 'PP<br> ' : '';
						$observacion .= ($row->asistencia < $asistencia_min)? 'Asistencia,' : '';
						$this->table->add_row(array(
							form_label($row->asignatura),
							$row->parcial,
							$row->asistencia,
//							'X',
							array('data' => 'X', 'style' => 'text-align:center'),
							array('data' => $observacion, 'class' => 'error'),
						));
					}
				}
				$contador += 1;
			}
			$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="tbl_detalles">' ));
			if($contador > 1){
				$this->table->set_heading(array('Asignaturas', 'Parciales', 'Asistencias', 'Opciones', 'Observaciones'));	
			}else{
				$this->table->set_heading(array('Asignatura', 'Parcial', 'Asistencia', 'Opcion', 'Observación'));
			}
			echo $this->table->generate();	
			
		}
?>
</body>
</html>