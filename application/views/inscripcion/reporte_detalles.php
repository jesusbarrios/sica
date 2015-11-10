<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    
    <script>
    $(document).ready(function () {
/*    	$('.oportunidades').change(function(args) {
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
*/

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

	if($inscripciones){
		$contador = 0;
			
		foreach($inscripciones->result() as $row){
			$contador += 1;
			$this->table->add_row(array(
				$contador,
				$row->apellido . ' ' . $row->nombre,
				$row->parcial . '%',
				$row->asistencia . '%',
//				'ok',
//				'ok',
			));
		}

		$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="tbl_detalles">' ));
//		if($contador > 1){
//			$this->table->set_heading(array('N<sup>ro</sup>', 'Estudiante', 'PP', 'Asistencia'));
//		}else{
		$this->table->set_heading(array('N<sup>ro</sup>', 'Estudiantes', 'PP', 'Asistencia'));
//		}
		echo $this->table->generate();	
	}else{	
		$this->table->set_heading(array('No hay inscripción registrada'));
		echo $this->table->generate();	
	}
?>
</body>
</html>