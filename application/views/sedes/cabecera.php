<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			alert()
			$('#btn_agregar').click(function() { 

				sede = $('#slc_sede').val();
				$.post('<?=base_url()?>carreras/mostrar_formulario_agregar/' + sede, '', function (respuesta) {
					$('#frm_agregar').html(respuesta)
				});
				
			});
			
			$('#slc_sede').change(function() { 
				
				sede = $('#slc_sede').val();
				

				$.post('<?=base_url()?>carreras/actualizar_lista/' + sede, '', function (respuesta) {
					$('#lista').html(respuesta)
				});

				
			});
			
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

		 .frm_error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
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
	</style>
</head>

<body>
	<?php
		echo form_fieldset('Carreras');
		
		
		if($sedes){
		
			//CAMPO SEDES
			$opciones = array();
			foreach($sedes as $row)
				$opciones[$row->id_sede] = $row->ciudad;	
			
			$this->table->add_row(array(
				form_label('Sede:'),
				form_dropdown('slc_sede', $opciones, FALSE, 'id = slc_sede autofocus=autofocus')
			));
			
			
			//BOTON DE NUEVA CARRERA
			$btn_agregar = array(
				'type' => 'button',
				'value' => 'Agregar carrera',
				'id' => 'btn_agregar'
			);
						
			$this->table->add_row(array(
				NULL,
				form_input($btn_agregar)
			));
		}

		
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0">'));
		echo $this->table->generate();
		
		echo "<div id=frm_agregar>";
		echo "</div>";	
		
		
		echo "<div id=frm_crear>";
			$this->load->view('carreras/formulario_crear', FALSE);
		echo "</div>";

		echo form_fieldset_close();

	?>
</body>
</html>