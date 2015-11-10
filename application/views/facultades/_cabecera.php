<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			
			$('#slc_sede').change(function() { 
				sede = $(this).val();

				$.post('<?=base_url()?>carreras/actualizar_lista','', function (respuesta) {
					$('#lista').html(respuesta)
					alert(respuesta);
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
		echo form_fieldset('');

		if($sedes){

			//CAMPO SEDES
			$opciones = array('0' => 'Todas');
			foreach($sedes->result() as $row)
				$opciones[$row->id_sede] = $row->ciudad;	

			$this->table->add_row(array(
				form_label('Sede:'),
				form_dropdown('slc_sede', $opciones, FALSE, 'id = slc_sede autofocus=autofocus')
			));
		}

		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0">'));
		echo $this->table->generate();
		

		echo form_fieldset_close();

	?>
</body>
</html>