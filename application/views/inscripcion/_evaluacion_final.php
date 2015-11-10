<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
    
    <script>
    	$(document).ready(function () {
    		$('#btn_buscar').click(function() {
    			documento = $('#txt_documento').val();
	    		$.post('<?=base_url()?>index.php/inscripcion/semestre/autocompletar_campos', {documento : documento}, function (respuesta) {
	    			alert(respuesta);
					var datos = $.parseJSON(respuesta);
					$('#txt_apellido').val(datos['apellido']);
					$('#txt_nombre').val(datos['nombre']);
					$('#slc_sede').html(datos['sedes']);
					$('#slc_carrera').html(datos['carreras']);
					$('#slc_semestre').html(datos['semestres']);
				});
    		})
    		
    		$('#slc_semestre').change(function() {
    			carrera = $('#slc_carrera').val();
    			semestre = $('#slc_semestre').val();
	    		$.post('<?=base_url()?>index.php/inscripcion/semestre/cargar_detalles', {carrera : carrera, semestre : semestre}, function (respuesta) {
	    			alert(respuesta);
//					var datos = $.parseJSON(respuesta);
					$('#detalles').html(respuesta);
				});
    		})
	});
    </script>
    
	<style>
		fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    margin: 0 auto;
		    padding: 0 33px;
		    width: 350px;
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
		input {
			margin: 0px 3px 0px 0px;
		}
		input[type="submit"] {
		    cursor: pointer;
/* 		    margin: 20px 125px; */
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
	</style>
	
</head>

<body>
<?php
	echo form_open();
		echo form_fieldset('Inscripción a semestre');
		
		if(isset($mensaje))	
			echo "<div class='frm_ok'>" . $mensaje . "</div>";


		$documento = array(
			'type' => 'number',
			'name'=>'txt_documento',
			'id'=>'txt_documento',
			'maxlength'=>'10',
			'size'=>'10',
			'autofocus'=>'autofocus',
			'value' => set_value('txt_documento'),
		);
		
		$boton = array(
			'type' => 'button',
			'id' => 'btn_buscar',
			'name' => 'btn_buscar',
			'value' => 'Buscar'
		);

		$this->table->add_row(array(
			form_label('N<sup>ro</sup> de documento:', 'txt_documento'),
			form_input($documento) . form_submit($boton) .
			form_error('txt_documento', '<div class="frm_error">', '</div>')
		));
		
		$apellido = array(
			'type' => 'text',
			'name'=>'txt_apellido',
			'id'=>'txt_apellido',
			'maxlength'=>'20',
			'size'=>'25',
			'value' => set_value('txt_apellido'),
			'readonly' => 'readonly',
		);
		
		$this->table->add_row(array(
			form_label('Apellido:', ''),
			form_input($apellido)
		));
		
		$nombre = array(
			'type' => 'text',
			'name'=>'txt_nombre',
			'id'=>'txt_nombre',
			'maxlength'=>'20',
			'size'=>'25',
			'value' => set_value('txt_nombre'),
			'readonly' => 'readonly',
		);
		
		$this->table->add_row(array(
			form_label('Nombre:', ''),
			form_input($nombre)
		));
		
		
		/*
		*SEDE
		*/
		
		if($sedes){
			if($sedes->num_rows() > 1)
				$slc_sede = array(null => '-----');
			foreach($sedes->result() as $row)
				$slc_sede[$row->id_sede] = $row->ciudad;	
		}else{
			$slc_sede = array(null => '-----');
		}
		
		$this->table->add_row(
				form_label('Sede:'),
				form_dropdown('slc_sede', $slc_sede, set_value('slc_sede'), 'id=slc_sede')
			);
		
		/*
		*CARRERA
		*/
		if($carreras){
			if($carreras->num_rows() > 1)
				$slc_carrera = array(null => '-----');
			foreach($carreras->result() as $row)
				$slc_carrera[$row->id_carrera] = $row->carrera;
		}else{
			$slc_carrera = array(null => '-----');
		}
		
		$this->table->add_row(
			form_label('Carrera:'),
			form_dropdown('slc_carrera', $slc_carrera, set_value('slc_carrera'), 'id=slc_carrera')
		);
		
		if($semestres){
			if($semestres->num_rows() > 1)
				$slc_semestre = array(null => '-----');
			foreach($semestres->result() as $row)
				$slc_semestre[$row->id_semestre] = $row->semestre;
		}else
			$slc_semestre = array(null => '-----');
		
		$this->table->add_row(
			form_label('Semestre:'),
			form_dropdown('slc_semestre', $slc_semestre, set_value('slc_semestre'), 'id=slc_semestre')
		);
		$this->table->add_row(
			array('data' => '', 'id'=>'detalles', 'colspan' => '2')
		);
		

		$btn_aceptar = array(
			'name'=>'',
			'value'=>'Aceptar'
		);
		
		$btn_cancelar = array(
			'type' => 'button',
			'id'=>'btn_cancelar',
			'value'=>'Cancelar'
		);
			
		$this->table->add_row(array(
			NULL,
			form_submit($btn_aceptar) . form_input($btn_cancelar)
		));
			
		
		
		
		echo $this->table->generate();
			
		echo form_fieldset_close();
		echo form_close();		
?>
</body>
</html>