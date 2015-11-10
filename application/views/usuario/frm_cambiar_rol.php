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
			margin:  15px auto;
		}
		.boton{
			text-align: center;
		}
	</style>
	
</head>

<body>
<?php
	echo form_open();
		echo form_fieldset('Cambiar rol');
		/*
		*Usuarios
		*/
		if($usuarios){
			foreach($usuarios->result() as $row){
				if($row->predeterminado){
					$datos = "<img src=" . base_url() . "iconos/Ok-icon.png />";
					$this->table->add_row(array(
						$row->rol,
						$datos,
					));
				}else{
					$datos = array(
						'name'		=> 'radio_predeterminado',
						'id'		=> 'radio_predeterminado',
						'value' 	=> $row->id_rol,
					);

					$this->table->add_row(array(
						$row->rol,
						($datos)? form_radio($datos) : $datos,
					));
				}
				
				
			}
		}

			

		$this->table->set_heading('Roles', 'Predeterminado');
		$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="">' ));
		echo $this->table->generate();
		
		$btn_aceptar = array(
			'type'	=> 'submit',
			'name'	=>'btn_aceptar',
			'id'	=>'btn_aceptar',
			'class'	=>'boton',
			'value'	=>'Aceptar',
		);

		$this->table->set_heading(form_input($btn_aceptar));
		$this->table->set_template(array ( 'table_open'  => '<table border="0" cellpadding="2" cellspacing="0" class="">' ));
		echo $this->table->generate();

		echo form_fieldset_close();
		echo form_close();		
?>
</body>
</html>