<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
    
    <script>
    	$(document).ready(function () {
	    	$('form').keypress(function(e){   
		    	if(e == 13)
		    		return false;
		    }).ready(function(){
			    $('#txt_documento').focus();
		    });
		    
		    $('input[type=text]').keypress(function(e){
		    	if(e.which == 13)
		    		return false;
		    });
		  
		    $('input[type=date]').keypress(function(e){
			    if(e.which == 13)
			    	return false;
			});
		  
			$('select').keypress(function(e){
				if(e.which == 13)
					return false;
			});
			
			$("#btn_nuevo").click(function(){
				window.location.href = '<?=base_url()?>index.php/inscripcion/cpi.html';
			});

			$("#btn_buscar").click(function(){
    			documento = $('#txt_documento').val();
	    		$.post('<?=base_url()?>index.php/inscripcion/cpi/autocompletar_campos', {documento : documento}, function (respuesta) {
	    			
	    			if(respuesta == 'no-registrado'){		    
	    				//DATOS PERSONAL
	    				$('#slc_tipo_documento').val('').attr('readonly', false);
						$('#txt_nombre').val('').attr('readonly', false);
						$('#txt_apellido').val('').attr('readonly', false);
						$('#txt_nacionalidad').val('').attr('readonly', false);
						$('#txt_lugar_nacimiento').val('').attr('readonly', false);
						$('#txt_fecha_nacimiento').val('').attr('readonly', false);
						$('#txt_grupo_sanguineo').val('').attr('readonly', false);
						$('#slc_genero').val('').attr('readonly', false);
						$('#slc_estado_civil').val('').attr('readonly', false); //es modificable
						$('#txt_email').val('').attr('readonly', false); //es modificable
						$('#txt_telefono_movil').val('').attr('readonly', false); // es modificable
						
						//DATOS DE DOMICILIO
						//Todos los campos laboral son editables porque se puede cambiar permanentemente
						
						//DATOS LABORAL
						//Todos los campos laboral son editables porque se puede cambiar permanentemente
						
						//DATOS DE PROCEDENCIA EDUCACIONAL
						$('#txt_colegio').val('').attr('readonly', false);
						$('#txt_bachillerato').val('').attr('readonly', false);
						$('#txt_pais_colegio').val('').attr('readonly', false);
						$('#txt_departamento_colegio').val('').attr('readonly', false);
						$('#txt_localidad_colegio').val('').attr('readonly', false);
						$('#txt_anho_egreso').val('').attr('readonly', false);
						
	    			}else{

						var datos = $.parseJSON(respuesta);
						_focus = true;						

						//TIPO DE DOCUMENTO
						if(datos['tipo_documento'] != ''){
							$('#slc_tipo_documento').val(datos['tipo_documento']);
							$('#slc_tipo_documento option:not(:selected)').attr('disabled',true);
						}else{
							$('#slc_tipo_documento').val('').attr('readonly' , false);
							if(_focus){
								$('#slc_tipo_documento').focus;
								_focus = false;
							}
						}
						
						//NOMBRE
						if(datos['nombre'] != ''){
							$('#txt_nombre').val(datos['nombre']).attr('readonly', true);
						}else{
							$('#txt_nombre').val('');
							if(_focus)
								$('#txt_nombre').focus();
							_focus = false;
						}
						
						//APELLIDO
						if(datos['apellido'] != ''){
							$('#txt_apellido').val(datos['apellido']).attr('readonly', true);
						}else{
							$('#txt_apellido').val('');
							if(_focus)
								$('#txt_apellido').focus();
							_focus = false;
						}
						
						//NACIONALIDAD
						if(datos['nacionalidad'] != ''){
							$('#txt_nacionalidad').val(datos['nacionalidad']).attr('readonly', true);
						}else{
							$('#txt_nacionalidad').val('');
							if(_focus)
								$('#txt_nacionalidad').focus();
							_focus = false;
						}
						
						//LUGAR DE NACIMIENTO
						if(datos['lugar_nacimiento'] != ''){
							$('#txt_lugar_nacimiento').val(datos['lugar_nacimiento']).attr('readonly', true);
						}else{
							$('#txt_lugar_nacimiento').val('');
							if(_focus)
								$('#txt_lugar_nacimiento').focus();
							_focus = false;
						}
						
						//FECHA DE NACIMIENTO
						if(datos['fecha_nacimiento'] != ''){
							$('#txt_fecha_nacimiento').val(datos['fecha_nacimiento']).attr('readonly', true);
						}else{
							$('#txt_fecha_nacimiento').val('');
							if(_focus)
								$('#txt_fecha_nacimiento').focus();
							_focus = false;
						}
						
						//GRUPO SANGUINEO
						if(datos['grupo_sanguineo'] != ''){
							$('#txt_grupo_sanguineo').val(datos['grupo_sanguineo']).attr('readonly', true);
						}else{
							$('#txt_grupo_sanguineo').val('');
							if(_focus)
								$('#txt_grupo_sanguineo').focus();
							_focus = false;
						}
						
						//GENERO
						if(datos['genero'] != ''){
							$('#slc_genero').val(datos['genero']).attr('type', 'input');
							$('#slc_genero option:not(:selected)').attr('disabled',true);
							
						}else{
							$('#slc_genero').val('');
							if(_focus)
								$('#slc_genero').focus();
							_focus = false;
						}
						
						//ESTADO CIVIL
						if(datos['estado_civil'] != ''){
							$('#slc_estado_civil').val(datos['estado_civil']);
						}else{
							$('#slc_estado_civil').val('');
							if(_focus)
								$('#slc_estado_civil').focus();
							_focus = false;
						}

						//EMAIL
						if(datos['correo'] != ''){
							$('#txt_email').val(datos['correo']);
						}else{
							$('#txt_email').val('');
							if(_focus)
								$('#txt_email').focus();
							_focus = false;
						}
						
						//TELEFONO CELULAR
						if(datos['telefono'] != ''){
							$('#txt_telefono_movil').val(datos['telefono']);
						}else{
							$('#txt_telefono_movil').val('');
							if(_focus)
								$('#txt_telefono_movil').focus();
							_focus = false;
						}
						
						//PAIS DOMICILIO
						if(datos['pais_domicilio'] != ''){
							$('#txt_pais_domicilio').val(datos['pais_domicilio']);
						}else{
							$('#txt_pais_domicilio').val('');
							if(_focus)
								$('#txt_pais_domicilio').focus();
							_focus = false;
						}
						
						//DEPARTAMENTO DOMICILIO
						if(datos['departamento_domicilio'] != ''){
							$('#txt_departamento_domicilio').val(datos['departamento_domicilio']);
						}else{
							$('#txt_departamento_domicilio').val('');
							if(_focus)
								$('#txt_departamento_domicilio').focus();
							_focus = false;
						}
						
						
						//LOCALIDAD DOMICILIO
						if(datos['ciudad_domicilio'] != ''){
							$('#txt_localidad_domicilio').val(datos['ciudad_domicilio']);
						}else{
							$('#txt_localidad_domicilio').val('');
							if(_focus)
								$('#txt_localidad_domicilio').focus();
							_focus = false;
						}
						
						//DIRECCION
						if(datos['direccion_domicilio'] != ''){
							$('#txt_direccion_domicilio').val(datos['direccion_domicilio']);
						}else{
							$('#txt_direccion_domicilio').val('');
							if(_focus)
								$('#txt_direccion_domicilio').focus();
							_focus = false;
						}
						
						//TELEFONO FIJO
						if(datos['telefono_domicilio'] != ''){
							$('#txt_telefono_fijo').val(datos['telefono_domicilio']);
						}else{
							$('#txt_telefono_fijo').val('');
							if(_focus)
								$('#txt_telefono_fijo').focus();
							_focus = false;
						}
						
						//TRABAJO
						if(datos['empresa_trabajo'] != ''){
							$('#txt_empresa_trabajo').val(datos['empresa_trabajo']);
						}else{
							$('#txt_empresa_trabajo').val('');
							if(_focus)
								$('#txt_empresa_trabajo').focus();
							_focus = false;
						}
						
						//CARGO TRABAJO
						if(datos['cargo_trabajo'] != ''){
							$('#txt_cargo_trabajo').val(datos['cargo_trabajo']);
						}else{
							$('#txt_cargo_trabajo').val('');
							if(_focus)
								$('#txt_cargo_trabajo').focus();
							_focus = false;
						}
						
						//TELEFONO TRABAJO
						if(datos['telefono_trabajo'] != ''){
							$('#txt_telefono_trabajo').val(datos['telefono_trabajo']);
						}else{
							$('#txt_telefono_trabajo').val('');
							if(_focus)
								$('#txt_telefono_trabajo').focus();
							_focus = false;
						}
						
						//COLEGIO
						if(datos['colegio'] != ''){
							$('#txt_colegio').val(datos['colegio']).attr('readonly', true);
						}else{
							$('#txt_colegio').val('');
							if(_focus)
								$('#txt_colegio').focus();
							_focus = false;
						}
						
						//BACHILLERATO
						if(datos['bachillerato'] != ''){
							$('#txt_bachillerato').val(datos['bachillerato']).attr('readonly', true);
						}else{
							$('#txt_bachillerato').val('');
							if(_focus)
								$('#txt_bachillerato').focus();
							_focus = false;
						}
						
						//PAIS COLEGIO
						if(datos['pais_colegio'] != ''){
							$('#txt_pais_colegio').val(datos['pais_colegio']).attr('readonly', true);
						}else{
							$('#txt_pais_colegio').val('');
							if(_focus)
								$('#txt_pais_colegio').focus();
							_focus = false;
						}
						
						//DEPARTAMENTO COLEGIO
						if(datos['departamento_colegio'] != ''){
							$('#txt_departamento_colegio').val(datos['departamento_colegio']).attr('readonly', true);
						}else{
							$('#txt_departamento_colegio').val('');
							if(_focus)
								$('#txt_departamento_colegio').focus();
							_focus = false;
						}
						
						//LOCALIDAD COLEGIO
						if(datos['localidad_colegio'] != ''){
							$('#txt_localidad_colegio').val(datos['ciudad_colegio']).attr('readonly', true);
						}else{
							$('#txt_localidad_colegio').val('');
							if(_focus)
								$('#txt_localidad_colegio').focus();
							_focus = false;
						}
						
						//AÑO DE EGRESO
						if(datos['anho_egreso'] != ''){
							$('#txt_anho_egreso').val(datos['anho_egreso']).attr('readonly', true);
						}else{
							$('#txt_anho_egreso').val('');
							if(_focus)
								$('#txt_anho_egreso').focus();
							_focus = false;
						}
					}	

//					alert('ok');	
				});
				
    		})

    		$('#slc_facultad').change(function() { 
				facultad = $(this).val();
				
				if(facultad != ''){
					$.post('<?=base_url()?>index.php/inscripcion/cpi/actualizar_slc_sede/' + facultad, '', function (respuesta) {
//						alert(respuesta)
						$('#slc_sede').html(respuesta);
					});
				}else{
					$('#slc_sede').html("<option value=''>-----</option>");
				}
			});

			$('#slc_sede').change(function() { 
				facultad = $('#slc_facultad').val();
				sede = $(this).val();
				
				if(sede != ''){
					$.post('<?=base_url()?>index.php/inscripcion/cpi/actualizar_slc_carrera', {facultad : facultad, sede : sede}, function (respuesta) {
//						alert(respuesta);
						$('#slc_carrera').html(respuesta);
					});
				}else{
					$('#slc_carrera').html("<option value=''>-----</option>");
				}
			});

	
		$('#slc_genero').on('change', function() {
			sexo = $(this).val();
			
			
			if(sexo == "Masculino"){
				datos = "<option value=''>-----</option><option>Soltero</option><option>Casado</option>Divorciado</option><option>Viudo</option>";
			}else if(sexo == "Femenino"){
				datos = "<option value=''>-----</option><option>Soltera</option><option>Casada</option>Divorciada</option><option>Viuda</option>";
			}else{
				datos = "<option value=''>-----</option>";
			}
	
			$('#slc_estado_civil').html(datos);
	
		});
	});
	
    </script>

	<style>
		form{
			margin: 0 230px;
	    	width: 950px;
		}
		
		form h3{
			text-align: center;
			border-bottom: solid 2px #fff;
		}
		
		fieldset{
			border: 1px solid #BBBBBB;
			border-radius: 10px 10px 10px 10px;
			margin: 0;
			background-color: #EEEEEE;
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
		    width: 100%;
		}
		input, select {
			margin: 20px 3px 0px 0px;
		}
		input[type="submit"] {
		    cursor: pointer;
		}
		.frm_error{
			color: #ff0000;
		    margin: 0px;
		    font-size: 11px;
		}
		.mensaje{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
/*		.frm_error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
*/		.obligatorio {
		    color: #FF0000;
		    font-size: 11px;
		    margin-top: 20px;
		    padding: 0 2px;
		}
		
		a{
			margin: 20px 145px;
		}
		
		.titulo{
			text-align: center;
			font-weight: bold;
			border-bottom: solid 2px #bbb;
			font-size: 17px;
			
		}
		
		table{
			width: 100%;
		}
	</style>
	
</head>

<body>
	<?php
		echo form_open('');
		echo form_fieldset('Inscripción al CPI');
		
	
		/*
		TITULO DE DATOS PERSONAS
		*/
		$this->table->add_row(array(array('data' => 'DATOS PERSONAL', 'colspan' => '2', 'class' => 'titulo')));

		/*
		CAMPO NUMERO DE DOCUMENTO
		*/		
		$txt_documento = array(
			'name'		=> 	'txt_documento',
			'id'		=> 	'txt_documento',
			'maxlength'	=> 	'15',
			'size'		=> 	'15',
			'value' 	=> 	set_value('txt_documento'),
		);
		
		$btn_buscar = array(
			'type' => 'button',
			'name' 	=> 'btn_buscar',
			'id'	=> 'btn_buscar',
			'value' => 'Buscar',
		);
			

		$this->table->add_row(array(
			form_label('Nro documento:', 'txt_documento'),
			form_input($txt_documento)
			. "<span class=obligatorio>*</span>"
			. form_input($btn_buscar)
			. form_error('txt_documento', '<div class="frm_error">', '</div>')
		));
			
		/*
		CAMPO TIPO DE DOCUMENTO
		*/
		if(!isset($tipo_documento))
			$tipo_documento = '';
		
		$opciones_tipo_documento = array();
		foreach($tipos_documento->result() as $row)
			$opciones_tipo_documento[$row->id_tipo_documento] = $row->tipo_documento;

		$this->table->add_row(array(
			form_label('Tipo de documento:', 'slc_tipo_documento'),
			form_dropdown('slc_tipo_documento', $opciones_tipo_documento, set_value('slc_tipo_documento'))
			. "<span class=obligatorio>*</span>"
		));			
			
			
		
		/*
		CAMPO NOMBRE DEL ALUMNO	
		*/
			
		$txt_nombre = array(
			'name'=>'txt_nombre',
			'id'=>'txt_nombre',
			'maxlength'=>'25',
			'size'=>'25',
			'value' => set_value('txt_nombre'),
		);
		
		$this->table->add_row(array(
			form_label('Nombres:', 'txt_nombre'),
			form_input($txt_nombre)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_nombre', '<div class="frm_error">', '</div>')
		));
			
			

		/*
		CAMPO APELLIDO DEL ALUMNO
		*/
		if(!isset($apellido))
			$apellido = "";
		
		$txt_apellido = array(
			'name'=>'txt_apellido',
			'id'=>'txt_apellido',
			'maxlength'=>'25',
			'size'=>'25',
			'value' => set_value('txt_apellido'),
		);
		
		$this->table->add_row(array(
			form_label('Apellidos:', 'txt_apellido'),
			form_input($txt_apellido)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_apellido', '<div class="frm_error">', '</div>')
		));



		/*
		CAMPO NACIONALIDAD DEL ALUMNO
		*/
		if(!isset($nacionalidad))
			$nacionalidad = "";
			
		$txt_nacionalidad = array(
			'name'=>'txt_nacionalidad',
			'id'=>'txt_nacionalidad',
			'maxlength'=>'20',
			'size'=>'20',
			'value' => set_value('txt_nacionalidad'),
		);
		
		$this->table->add_row(array(
			form_label('Nacionalidad:', 'txt_nacionalidad'),
			form_input($txt_nacionalidad)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_nacionalidad', '<div class="frm_error">', '</div>')
		));
			
			
		
		/*
		CAMPO LUGAR DE NACIMIENTO DEL ALUMNO
		*/	
		if(!isset($lugar_nacimiento))
			$lugar_nacimiento = "";
			
		$txt_lugar_nacimiento = array(
			'name'=>'txt_lugar_nacimiento',
			'id'=>'txt_lugar_nacimiento',
			'maxlength'=>'45',
			'size'=>'45',
			'value' => set_value('txt_lugar_nacimiento'),
		);
		
		$this->table->add_row(array(
			form_label('Lugar de nacimiento:', 'txt_lugar_nacimiento'),
			form_input($txt_lugar_nacimiento)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_lugar_nacimiento', '<div class="frm_error">', '</div>')
		));
		
		$txt_fecha_nacimiento = array(
			'type' => 'date',
			'name'=>'txt_fecha_nacimiento',
			'id'=>'txt_fecha_nacimiento',
			'value' => set_value('txt_fecha_nacimiento'),
//			'required' => 'required',
			'placeholder' => 'yyyy-mm-dd',
		);

		$this->table->add_row(array( 
		form_label('Fecha de nacimiento:', 'txt_fecha_nacimiento'),
		form_input($txt_fecha_nacimiento) .
		"<span class=obligatorio>*</span>" .
		form_error('txt_fecha_nacimiento', '<div class="frm_error">', '</div>')));

		/*
		CAMPO GRUPO SANGUINEO DEL ALUMNO
		*/	
		$txt_grupo_sanguineo = array(
			'name' => 'txt_grupo_sanguineo',
			'id' => 'txt_grupo_sanguineo',
			'maxlength' => '5',
			'size' => '5',
			'value' => set_value('txt_grupo_sanguineo'),
		);	

		$this->table->add_row(array(
			form_label('Grupo sanguíneo:', 'txt_grupo_sanguineo'),
			form_input($txt_grupo_sanguineo)
			. form_error('txt_grupo_sanguineo', '<div class="frm_error">', '</div>')
		));

		/*
		CAMPO GENERO DEL ALUMNO
		*/	
		if(!isset($sexo))
			$sexo = "-";
			
		$slc_genero = array(
			null => '-----',
			'Masculino' => 'Masculino',
			'Femenino' => 'Femenino');	
			
		$this->table->add_row(array(
			form_label('Genero:', 'slc_genero'),
			form_dropdown('slc_genero', $slc_genero, set_value('slc_genero'), 'id="slc_genero"')
			. "<span class=obligatorio>*</span>"
			. form_error('slc_genero', '<div class="frm_error">', '</div>')
		));

		/*
		CAMPO ESTADO CIVIL DEL ALUMNO
		*/
		if(!isset($estado_civil))
			$estado_civil = "-";
			
		$slc_estado_civil = array(
			null => '-----',
			'Soltero' => 'Soltero/a',
			'Casado' => 'Casado/a',
			'Divorciado' => 'Divorciado/a',
			'Viudo' => 'Viudo/a');
	
		$this->table->add_row(array(
			form_label('Estado civil:', 'slc_estado_civil'),
			form_dropdown('slc_estado_civil', $slc_estado_civil, set_value('slc_estado_civil'), 'id="slc_estado_civil"')
			. "<span class=obligatorio>*</span>"
			. form_error('slc_estado_civil', '<div class="frm_error">', '</div>')
		));

			
			
			
		
		/*
		CAMPO EMAIL DEL ALUMNO
		*/	
		$txt_email = array(
			'name' => 'txt_email',
			'id' => 'txt_email',
			'maxlength' => '50',
			'size' => '50',
			'value' => set_value('txt_email'),
		);
		
		$this->table->add_row(array(
			form_label('Email:', 'txt_email'),
			form_input($txt_email)
//			. "<span class=obligatorio>*</span>"
			. form_error('txt_email', '<div class="frm_error">', '</div>')
		));

			
		
		/*
		CAMPO TELEFONO MOVIL DEL ALUMNO
		*/	
		$txt_telefono_movil = array(
			'name' => 'txt_telefono_movil',
			'id' => 'txt_telefono_movil',
			'maxlength' => '15',
			'size' => '15',
			'value' => set_value('txt_telefono_movil')
		);

		$this->table->add_row(array(
			form_label('Télefono Celular:', 'txt_telefono_movil'),
			form_input($txt_telefono_movil)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_telefono_movil', '<div class="frm_error">', '</div>')
		));
		
		/*
		*
		*DOMICILIO
		*
		*/
		$this->table->add_row(array(array('data' => 'DATOS DOMICILIARIO', 'colspan' => '2', 'class' => 'titulo')));

		//CAMPO PAIS DE DOMICILIO DEL ALUMNO
		$txt_pais_domicilio = array(
			'name' => 'txt_pais_domicilio',
			'id' => 'txt_pais_domicilio',
			'maxlength' => '25',
			'size' => '25',
			'value' => set_value('txt_pais_domicilio')
		);
			
		$this->table->add_row(array(
			form_label('País:', 'txt_pais_domicilio'),
			form_input($txt_pais_domicilio)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_pais_domicilio', '<div class="frm_error">', '</div>')
		));
		
		//CAMPO DEPARTAMENTO DE DOMICILIO DEL ALUMNO
		$txt_departamento_domicilio = array(
			'name' => 'txt_departamento_domicilio',
			'id' => 'txt_departamento_domicilio',
			'maxlength' => '50',
			'size' => '50',
			'value' => set_value('txt_departamento_domicilio')
		);
			
		$this->table->add_row(array(
			form_label('Departamento:', 'txt_departamento_domicilio'),
			form_input($txt_departamento_domicilio)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_departamento_domicilio', '<div class="frm_error">', '</div>')
		));

		
		//CAMPO LOCALIDAD DE DOMICILIO DEL ALUMNO
		$txt_localidad_domicilio = array(
			'name' => 'txt_localidad_domicilio',
			'id' => 'txt_localidad_domicilio',
			'maxlength' => '30',
			'size' => '30',
			'value' => set_value('txt_localidad_domicilio')
		);		
	
		$this->table->add_row(array(
			form_label('Localidad:', $txt_localidad_domicilio['id']),
			form_input($txt_localidad_domicilio)
			. "<span class=obligatorio>*</span>"
			. form_error($txt_localidad_domicilio['id'], '<div class="frm_error">', '</div>')
		));
		
		//CAMPO DIRECCION DE DOMICILIO	
		$txt_direccion_domicilio = array(
			'name' => 'txt_direccion_domicilio',
			'id' => 'txt_direccion_domicilio',
			'maxlength' => '50',
			'size' => '50',
			'value' => set_value('txt_direccion_domicilio')
		);
			
		$this->table->add_row(array(
			form_label('Dirección:', 'txt_direccion_domicilio'),
			form_input($txt_direccion_domicilio)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_direccion_domicilio', '<div class="frm_error">', '</div>')
		));
		
		//CAMPO TELEFONO FIJO DEL ALUMNO	
		$txt_telefono_fijo = array(
			'name' => 'txt_telefono_fijo',
			'id' => 'txt_telefono_fijo',
			'maxlength' => '15',
			'size' => '15',
			'value' => set_value('txt_telefono_fijo'),
		);
			
		$this->table->add_row(array(
			form_label('Télefono fijo:', 'txt_telefono_fijo'),
			form_input($txt_telefono_fijo)
			. form_error('txt_telefono_fijo', '<div class="frm_error">', '</div>')
		));
		
		/*
		TITULO DE DATOS LABORAL
		*/
		$this->table->add_row(array(array('data' => 'DATOS LABORAL', 'colspan' => '2', 'class' => 'titulo')));

		/*
		CAMPO EMPRESA EN DONDE TRABAJA EL ALUMNO
		*/
		$txt_empresa_trabajo = array(
			'name' => 'txt_empresa_trabajo',
			'id' => 'txt_empresa_trabajo',
			'maxlength' => '45',
			'size' => '45',
			'value' => set_value('txt_empresa_trabajo'),
		);	
			
		$this->table->add_row(array(
			form_label('Trabajo:', 'txt_empresa_trabajo'),
			form_input($txt_empresa_trabajo)
			. form_error('txt_empresa_trabajo')
		));
			
			
		
		/*
		CAMPO CARGO QUE OCUPA EL ALUMNO EN LA EMPRESA
		*/
		$txt_cargo_trabajo = array(
			'name' => 'txt_cargo_trabajo',
			'id' => 'txt_cargo_trabajo',
			'maxlength' => '45',
			'size' => '45',
			'value' => set_value('txt_cargo_trabajo'),
		);
		
		$this->table->add_row(array(
			form_label('Cargo:', 'txt_cargo_trabajo'),
			form_input($txt_cargo_trabajo)
			. form_error('txt_cargo_trabajo')
		));
		
		//CAMPO TELEFONO EMPRESA	
		$txt_telefono_trabajo = array(
			'name' => 'txt_telefono_trabajo',
			'id' => 'txt_telefono_trabajo',
			'maxlength' => '15',
			'size' => '15',
			'value' => set_value('txt_telefono_trabajo'),
		);
			
		$this->table->add_row(array(
			form_label('Télefono:', 'txt_telefono_trabajo'),
			form_input($txt_telefono_trabajo),
		));
			
/*		
		
*/		
		/*
		TITULO DE DATOS PERSONAS
		*/
		$this->table->add_row(array(array('data' => 'PROCEDENCIA EDUCACIONAL - NIVEL MEDIO', 'colspan' => '2', 'class' => 'titulo')));
		
		
		/*
		PROCEDENCIA EDUCACIONAL
		*/

		$txt_colegio = array(
			'name' => 'txt_colegio',
			'id' => 'txt_colegio',
			'maxlength' => '100',
			'size' => '50',
			'value' => set_value('txt_colegio')
		);
		
		$this->table->add_row(array(
			form_label('Colegio:', 'txt_colegio'),
			form_input($txt_colegio)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_colegio', '<div class="frm_error">', '</div>')
		));
		
		/*
		CAMPO BACHILLERATO
		*/
		$txt_bachillerato = array(
			'name' => 'txt_bachillerato',
			'id' => 'txt_bachillerato',
			'maxlength' => '100',
			'size' => '50',
			'value' => set_value('txt_bachillerato')
		);
		$this->table->add_row(array(
			form_label('Bachillerato:', 'txt_bachillerato'),
			form_input($txt_bachillerato)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_bachillerato', '<div class="frm_error">', '</div>')
		));
		
		
		/*
		CAMPO PAIS DEL COLEGIO	
		*/			
		$txt_pais_colegio = array(
			'name' => 'txt_pais_colegio',
			'id' => 'txt_pais_colegio',
			'maxlength' => '25',
			'size' => '25',
			'value' => set_value('txt_pais_colegio'),
		);
		$this->table->add_row(array(
			form_label('País:', 'txt_pais_colegio'),
			form_input($txt_pais_colegio)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_pais_colegio', '<div class="frm_error">', '</div>')
		));	

		
		/*
		CAMPO DEPARTAMENTO DEL COLEGIO	
		*/			
		$txt_departamento_colegio = array(
			'name' => 'txt_departamento_colegio',
			'id' => 'txt_departamento_colegio',
			'maxlength' => '25',
			'size' => '25',
			'value' => set_value('txt_departamento_colegio'),
		);
		$this->table->add_row(array(
			form_label('Departamento:', 'txt_departamento_colegio'),
			form_input($txt_departamento_colegio)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_departamento_colegio', '<div class="frm_error">', '</div>')
		));	
			
			
		
		/*
		CAMPO LOCALIDAD DEL COLEGIO
		*/
		$txt_localidad_colegio = array(
			'name' => 'txt_localidad_colegio',
			'id' => 'txt_localidad_colegio',
			'maxlength' => '30',
			'size' => '30',
			'value' => set_value('txt_localidad_colegio')
		);	
			
		$this->table->add_row(array(
			form_label('Localidad:', 'txt_localidad_colegio'),
			form_input($txt_localidad_colegio)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_localidad_colegio', '<div class="frm_error">', '</div>')
		));		
		
		/*
		CAMPO AÑO DE EGRESO
		*/
		$txt_anho_egreso = array(
			'name' => 'txt_anho_egreso',
			'id' => 'txt_anho_egreso',
			'maxlength' => '4',
			'size' => '4',
			'value' => set_value('txt_anho_egreso'),
		);
		
		$this->table->add_row(array(
			form_label('Año de egreso:', 'txt_anho_egreso'),
			form_input($txt_anho_egreso)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_anho_egreso', '<div class="frm_error">', '</div>')
		));
		
		
		/*
		* SOLICITUD DE INSCRIPCION
		*/
		
		$this->table->add_row(array(array('data' => 'SOLICITUD DE INSCRIPCION', 'colspan' => '2', 'class' => 'titulo')));

		/*
		PERIODOS
		*/
		$slc_periodo = array('' => '-----');
		if($periodos){
			foreach($periodos->result() as $row)
				$slc_periodo[$row->id_periodo] = $row->id_periodo;
		}
		$this->table->add_row(array(
			form_label('Periodo:', 'slc_periodo'),
			form_dropdown('slc_periodo', $slc_periodo, set_value('slc_periodo'), 'id=slc_periodo')
			. "<span class=obligatorio>*</span>"
			. form_error('slc_periodo	', '<div class="frm_error">', '</div>')
		));	
		
		/*
		*FECHA DE INSCRIPCION
		*/		
		$txt_fecha_inscripcion = array(
			'type' => 'date',
			'name'=>'txt_fecha_inscripcion',
			'id'=>'txt_fecha_inscripcion',
			'value' => set_value('txt_fecha_inscripcion'),
//			'required' => 'required',
			'placeholder' => 'yyyy-mm-dd',
		);

		$this->table->add_row(array( 
		form_label('Fecha de inscripción:', 'txt_fecha_inscripcion'),
		form_input($txt_fecha_inscripcion) .
		"<span class=obligatorio>*</span>" .
		form_error('txt_fecha_inscripcion', '<div class="frm_error">', '</div>')));
		
		
		/*
		CAMPO FACULTADES
		*/
		$opciones_facultad = array('' => '-----');
		if($facultades){
			foreach($facultades->result() as $row)
				$opciones_facultad[$row->id_facultad] = $row->facultad;
		}
		$this->table->add_row(array(
			form_label('Facultad:', 'slc_facultad'),
			form_dropdown('slc_facultad', $opciones_facultad, set_value('slc_facultad'), 'id=slc_facultad')
			. "<span class=obligatorio>*</span>"
			. form_error('slc_facultad', '<div class="frm_error">', '</div>')
		));	

		/*
		*CAMPO SEDE
		*/
		$opciones_sede = array('' => '-----');
		if($sedes){
			foreach($sedes->result() as $row)
				$opciones_sede[$row->id_sede] = $row->sede;
		}
		$this->table->add_row(array(
			form_label('Sede:', 'slc_sede'),
			form_dropdown('slc_sede', $opciones_sede, set_value('slc_sede'), 'id=slc_sede')
			. "<span class=obligatorio>*</span>"
			. form_error('slc_sede', '<div class="frm_error">', '</div>')
		));

		/*
		CAMPO CARRERA
		*/
		$opciones_carrera = array('' => '-----');
		if($carreras){				
			foreach($carreras->result() as $row)
				$opciones_carrera[$row->id_carrera] = $row->carrera;
		}else{
			$opciones_carrera = array('' => '-----');
		}

		$this->table->add_row(array(
			form_label('Carrera:', 'slc_carrera'),
			form_dropdown('slc_carrera', $opciones_carrera, set_value('slc_carrera'), 'id=slc_carrera')
			. "<span class=obligatorio>*</span>"
			. form_error('slc_carrera', '<div class="frm_error">', '</div>')
		));

		/*
		RECIBO DE PAGO
		*/			
		$txt_recibo_pago = array(
			'name' => 'txt_recibo_pago',
			'id' => 'txt_recibo_pago',
			'maxlength' => '25',
			'size' => '25',
			'value' => set_value('txt_recibo_pago'),
		);
		$this->table->add_row(array(
			form_label('Segun recibo de pago Nº:', 'txt_recibo_pago'),
			form_input($txt_recibo_pago)
//			. "<span class=obligatorio>*</span>"
			. form_error('txt_recibo_pago', '<div class="frm_error">', '</div>')
		));	
		
		/*
		*FECHA RECIBO PAGO
		*/		
		$txt_fecha_recibo = array(
			'type' => 'date',
			'name'=>'txt_fecha_recibo',
			'id'=>'txt_fecha_recibo',
			'value' => set_value('txt_fecha_recibo'),
//			'required' => 'required',
			'placeholder' => 'yyyy-mm-dd',
		);

		$this->table->add_row(array( 
		form_label('Fecha de pago:', 'txt_fecha_recibo'),
		form_input($txt_fecha_recibo) .
//		"<span class=obligatorio>*</span>" .
		form_error('txt_fecha_recibo', '<div class="frm_error">', '</div>')));

		/*
		TITULO DE CUENTA
		*/
//		$this->table->add_row(array(array('data' => 'Datos de la cuenta', 'colspan' => '2', 'class' => 'titulo')));		
/*
		
		$txt_clave = array(
			'name' => 'txt_clave',
			'id' => 'txt_clave',
			'maxlength' => '15',
			'size' => '15',
			'type' => 'password');
			
		$this->table->add_row(array(
			form_label('Clave de acceso:', $txt_clave['id']),
			form_input($txt_clave)
			. "<span class=obligatorio>*</span>"
			. form_error($txt_clave['id'], '<div class="frm_error">', '</div>')
		));

		$txt_confirmar_clave = array(
			'name' => 'txt_confirmar_clave',
			'id' => 'txt_confirmar_clave',
			'maxlength' => '15',
			'size' => '15',
			'type' => 'password');
		
		$this->table->add_row(array(
			form_label('Confirmar clave:', 'txt_confirmar_clave'),
			form_input($txt_confirmar_clave)
			. "<span class=obligatorio>*</span>"
			. form_error('txt_confirmar_clave', '<div class="frm_error">', '</div>')
		));
*/

		$boton = array(
			'type' 	=> 'submit',
			'name'	=> '',
			'value'	=> 'Aceptar',
		);
		
		$this->table->add_row(array(
			'',
			form_input($boton),
		));
//		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0">'));
		echo $this->table->generate();
		//$this->table->generate();
		echo form_fieldset_close();
		echo form_close();

?>
</body>
</html>