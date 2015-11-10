<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/inscripcion.js"></script>

	<style>
		fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    margin: 0 auto 20px auto;
		    padding: 1 33px;
		    width: 695px;
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
		    margin-top: 20px;
		    padding-right: 7px;
		    text-align: right;
		    vertical-align: top;
		    width: 150px;
		}
		input, select {
			margin: 20px 3px 0px 0px;
		}
		input[type="submit"] {
		    cursor: pointer;
		    margin: 20px 145px;
		}
		.frm_error{
			color: #ff0000;
		    margin: 0px 0px 0px 157px;
		    font-size: 10px;
		}
		.ok_message{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		.error_message{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		.obligatorio {
		    color: #FF0000;
		    font-size: 11px;
		    margin-top: 20px;
		    padding: 0 2px;
		}
		
		a{
			margin: 20px 145px;
		}
	</style>
	
</head>

<body>
	<?php	
		$opciones_sede = array();
		foreach($sedes as $row)
			$opciones_sede[$row->id_sede] = $row->ciudad;
			
		$opciones_carrera = array();
		foreach($carreras as $row)
			$opciones_carrera[$row->id_carrera] = $row->carrera;
		
		if(isset($ok_menssage))	
			echo "<div class='ok_message'>" . $ok_menssage . "</div>";
		
		if(isset($error_menssage))	
			echo "<div class='error_message'>" . $error_menssage . "</div>";
		
		echo form_fieldset("Inscriptos al CPI");
		echo form_label('Sede:', 'slc_sede');
		echo form_dropdown('slc_sede', $opciones_sede, 1, 'autofocus=autofocus id=slc_sede');
		echo "<br>";
		
		echo form_label('Carrera:', 'slc_carrera');
		echo form_dropdown('slc_carrera', $opciones_carrera, 1, 'autofocus=autofocus id=slc_carrera');
		echo "<br>";

		echo "<div id=lista>";
			if($lista){
				$this->load->view('inscripcion/detalle_lista_cpi.php', array('lista' => $lista), FALSE);
			}else{
				echo "No hay inscriptos";
			}
			
		echo "</div>";
		echo form_fieldset_close();

?>
</body>
</html>