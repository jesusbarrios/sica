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
				window.location.href = '<?=base_url()?>index.php/inscripcion/cpi';
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
		    padding-right: 7px;
		    text-align: right;
		    vertical-align: top;
		    width: 100%;
		    font-style: normal;
		}
		
		table td{
			font-style: italic;
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
			border-bottom: solid 2px #bbb;
			font-weight: bold;
			
		}
		
		table{
			width: 100%;
		}
	</style>
	
</head>

<body>
	<?php
		echo form_open('index.php/inscripcion/cpi');
		echo form_fieldset('Detalles de la inscripción al CPI');
		
		/*
		MENSAJE
		*/

		$this->table->add_row(array(array('data' => 'Inscripción exitosa', 'colspan' => '2', 'class' => 'mensaje')));
	
		/*
		TITULO DE DATOS PERSONAS
		*/
		$this->table->add_row(array(array('data' => 'DATOS PERSONAL', 'colspan' => '2', 'class' => 'titulo')));

		/*
		CAMPO NUMERO DE DOCUMENTO
		*/		
		$this->table->add_row(array(
			form_label('Nro documento:'),
			set_value('txt_documento')
		));

			
			
		/*
		CAMPO TIPO DE DOCUMENTO
		*/
		$tipos_documento_ = $tipos_documento->row_array();
		$tipo_documento = $tipos_documento_['tipo_documento'];
		$this->table->add_row(array(
			form_label('Tipo de documento:'),
			$tipo_documento
		));			
			
			
		
		/*
		CAMPO NOMBRE DEL ALUMNO	
		*/
		$this->table->add_row(array(
			form_label('Nombres:'),
			set_value('txt_nombre')
		));
			
			

		/*
		CAMPO APELLIDO DEL ALUMNO
		*/
		$this->table->add_row(array(
			form_label('Apellidos:', 'txt_apellido'),
			set_value('txt_apellido')
		));



		/*
		CAMPO NACIONALIDAD DEL ALUMNO
		*/
		$this->table->add_row(array(
			form_label('Nacionalidad:', 'txt_nacionalidad'),
			set_value('txt_nacionalidad')
		));
			
			
		
		/*
		CAMPO LUGAR DE NACIMIENTO DEL ALUMNO
		*/
		$this->table->add_row(array(
			form_label('Lugar de nacimiento:', 'txt_lugar_nacimiento'),
			set_value('txt_lugar_nacimiento')
		));
		
		/*
		FECHA NACIMIENTO
		*/
		$this->table->add_row(array( 
			form_label('Fecha de nacimiento:'),
			date("d/m/Y", strtotime(set_value('txt_fecha_nacimiento')))
		));

		/*
		CAMPO GRUPO SANGUINEO DEL ALUMNO
		*/
		$this->table->add_row(array(
			form_label('Grupo sanguíneo:'),
			set_value('txt_grupo_sanguineo')
		));

		/*
		CAMPO GENERO DEL ALUMNO
		*/			
		$this->table->add_row(array(
			form_label('Genero:'),
			set_value('slc_genero')
		));


		/*
		CAMPO ESTADO CIVIL DEL ALUMNO
		*/
		if(!isset($estado_civil))
			$estado_civil = "-";
			
		$slc_estado_civil = array(
			null => '-----',
			'soltero' => 'Soltero/a',
			'casado' => 'Casado/a',
			'divorciado' => 'Divorciado/a',
			'viudo' => 'Viudo/a');
	
		$this->table->add_row(array(
			form_label('Estado civil:', 'slc_estado_civil'),
			set_value('slc_estado_civil')
		));

		
		/*
		CAMPO EMAIL DEL ALUMNO
		*/	
		$this->table->add_row(array(
			form_label('Email:', 'txt_email'),
			set_value('txt_email')
		));

			
		
		/*
		CAMPO TELEFONO MOVIL DEL ALUMNO
		*/
		$this->table->add_row(array(
			form_label('Télefono Celular:', 'txt_telefono_movil'),
			set_value('txt_telefono_movil')
		));
		
		/*
		*
		* DOMICILIO
		*********************************************************************
		*/
		$this->table->add_row(array(array('data' => 'DATOS DOMICILIARIO', 'colspan' => '2', 'class' => 'titulo')));

		//CAMPO PAIS DE DOMICILIO DEL ALUMNO
		$this->table->add_row(array(
			form_label('País:'),
			set_value('txt_pais_domicilio'),
		));
		
		//CAMPO DEPARTAMENTO DE DOMICILIO DEL ALUMNO
		$this->table->add_row(array(
			form_label('Departamento:'),
			set_value('txt_departamento_domicilio')
		));

		
		//CAMPO LOCALIDAD DE DOMICILIO DEL ALUMNO
		$this->table->add_row(array(
			form_label('Localidad:'),
			set_value('txt_localidad_domicilio')
		));
		
		//CAMPO DIRECCION DE DOMICILIO	
		$this->table->add_row(array(
			form_label('Dirección:'),
			set_value('txt_direccion_domicilio')
		));
		
		//CAMPO TELEFONO FIJO DEL ALUMNO	
		$this->table->add_row(array(
			form_label('Télefono fijo:'),
			set_value('txt_telefono_fijo')
		));
		
		/*
		TITULO DE DATOS LABORAL
		*/
		$this->table->add_row(array(array('data' => 'DATOS LABORAL', 'colspan' => '2', 'class' => 'titulo')));

		/*
		CAMPO EMPRESA EN DONDE TRABAJA EL ALUMNO
		*/
		$this->table->add_row(array(
			form_label('Trabajo:'),
			set_value('txt_empresa_trabajo')
		));			
		
		/*
		CAMPO CARGO QUE OCUPA EL ALUMNO EN LA EMPRESA
		*/
		$this->table->add_row(array(
			form_label('Cargo:'),
			set_value('txt_cargo_trabajo')
		));
		
		//CAMPO TELEFONO EMPRESA	
		$this->table->add_row(array(
			form_label('Télefono:'),
			set_value('txt_telefono_trabajo')
		));

		/*
		*
		*  PROCEDENCIA EDUCACIONAL
		*******************************************************************
		*/
		$this->table->add_row(array(array('data' => 'PROCEDENCIA EDUCACIONAL - NIVEL MEDIO', 'colspan' => '2', 'class' => 'titulo')));
		
		/*
		CAMPO COLEGIO
		*/
		$this->table->add_row(array(
			form_label('Colegio:'),
			set_value('txt_colegio')
		));
		
		/*
		CAMPO BACHILLERATO
		*/
		$this->table->add_row(array(
			form_label('Bachillerato:'),
			set_value('txt_bachillerato')
		));
		
		
		/*
		CAMPO PAIS DEL COLEGIO	
		*/			
		$this->table->add_row(array(
			form_label('País:'),
			set_value('txt_pais_colegio')
		));	

		
		/*
		CAMPO DEPARTAMENTO DEL COLEGIO	
		*/
		$this->table->add_row(array(
			form_label('Departamento:'),
			set_value('txt_departamento_colegio')
		));	
			
			
		
		/*
		CAMPO LOCALIDAD DEL COLEGIO
		*/
		$this->table->add_row(array(
			form_label('Localidad:', 'txt_localidad_colegio'),
			set_value('txt_localidad_colegio')
		));		
		
		/*
		CAMPO AÑO DE EGRESO
		*/
		$this->table->add_row(array(
			form_label('Año de egreso:', 'txt_anho_egreso'),
			set_value('txt_anho_egreso')
		));
		
		
		/*
		*
		* SOLICITUD DE INSCRIPCION
		*************************************************************
		*/
		
		$this->table->add_row(array(array('data' => 'SOLICITUD DE INSCRIPCION', 'colspan' => '2', 'class' => 'titulo')));
		
		/*
		*FECHA DE INSCRIPCION
		*/
		$this->table->add_row(array( 
			form_label('Fecha de inscripción:', 'txt_fecha_inscripcion'),
			date("d/m/Y", strtotime(set_value('txt_fecha_inscripcion')))
		));
		
		
		/*
		CAMPO FACULTADES
		*/
		$facultades_ = $facultades->row_array();
		$this->table->add_row(array(
			form_label('Facultad:'),
			$facultades_['facultad']
		));

		/*
		*CAMPO SEDE
		*/
		$sedes_ = $sedes->row_array();
		$this->table->add_row(array(
			form_label('Sede:'),
			$sedes_['sede']
		));

		/*
		CAMPO CARRERA
		*/
		$carreras_ = $carreras->row_array();
		$this->table->add_row(array(
			form_label('Carrera:'),
			$carreras_['carrera']
		));

		/*
		RECIBO DE PAGO
		*/
		$this->table->add_row(array(
			form_label('Segun recibo de pago Nº:'),
			set_value('txt_recibo_pago')
		));	
		
		/*
		*FECHA RECIBO PAGO
		*/
		$this->table->add_row(array( 
			form_label('Fecha de pago:'),
			(set_value('txt_fecha_recibo'))? date("d/m/Y", strtotime(set_value('txt_fecha_recibo'))) : '',
		));
		
		/*
		MENSAJE
		*/
		$this->table->add_row(array(array('data' => 'Inscripción exitosa', 'colspan' => '2', 'class' => 'mensaje')));
		
		$btn_nuevo = array(
			'type' 		=> 'button',
			'name'		=> 'btn_nuevo',
			'id'		=> 'btn_nuevo',
			'value'		=> 'Volver',
			'autofocus'	=> 'autofocus',
		);
		
		$this->table->add_row(array(
			'',
			form_input($btn_nuevo),
		));
		
//		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0">'));
		echo $this->table->generate();
		//$this->table->generate();
		echo form_fieldset_close();
		echo form_close();

?>
</body>
</html>