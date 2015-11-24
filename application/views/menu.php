<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
	 <style>

	#menu{	
		background-color: #ffffff;
	    float: left;
	    margin: 5px;
	    width: 200px;
	    height: 1000px;
	}
	
	#menu > ul {
	    margin: 0;
	    padding: 0;
	}
	
	#menu ul li {
	    background-color: #FFFFFF;
	    color: #6C6C6C;
	    cursor: default;
	    font-size: 19px;
	    list-style: none outside none;
	    margin: 0 0 2px;
	    padding: 4px 8px 4px 0;
	    text-align: right;
	    text-transform: capitalize;
	    border-bottom: solid 2px #cccccc;
	}
	
	#menu ul li:hover{
	    color:#000000;
	    background-color: #eeeeee;
	}
	
	#menu ul li:hover ul {
	    display: block;
	    color:#000000;
	}
	
	#menu ul li ul {
	    background-color: #E5E5E5;
	    border-radius: 0 10px 10px 0;
	    display: none;
	    margin: -24px 200px;
	    padding: 0;
	    position: absolute;
	}
	
	#menu ul li ul li{
		margin: 0 0 2px 2px;
	    padding: 2px 10px;
	    text-align: left;
	}
	
	#menu ul li ul li a {
	    color: #999999;
	    margin: 0 0 0 8px;
	    text-decoration: none;
	    text-transform: none;
	}
	
	#menu ul li ul li a:hover {
	    color: #000000;
	}
	 </style>
</head>
<body>
	<div id="menu">
	<?php
	
		$session_data = $this->session->userdata('logged_in');
		
		/*
		*Programador
		*/
		if($session_data['id_rol'] == 1){
			$menu = array(
				$session_data["alias"] => array(
											'<a href=' . base_url() . 'index.php/usuario/salir>Salir</a>',
											'<a href=' . base_url() . 'index.php/usuario/cambiar_clave>Cambiar contraseña</a>',
											'<a href=' . base_url() . 'index.php/usuario/cambiar_rol>Cambiar rol</a>',
											),
				'Calificaciones' => array(
											'<a href=' . base_url() . 'index.php/calificacion/carga_personal>Por persona</a>',
											'<a href=' . base_url() . 'index.php/calificacion/cargar_por_lista>Por lista de inscriptos</a>',
											'<a href=' . base_url() . 'index.php/calificacion/inscribir_calificar>Inscribir y calificar</a>',
											),
				'Promedios' => array(
											'<a href=' . base_url() . 'index.php/promedio/carga_personal>Por persona</a>',
											'<a href=' . base_url() . 'index.php/promedio/cargar_por_lista>Por lista de inscriptos</a>',
	//										'<a href=' . base_url() . 'promedio/inscribir_calificar>Inscribir y calificar</a>',
											),
				'Inscripciones' => array(
											'<a href=' . base_url() . 'index.php/inscripcion/cpi>al CPI</a>',
											'<a href=' . base_url() . 'index.php/inscripcion/semestre>a semestre</a>',
											'<a href=' . base_url() . 'index.php/inscripcion/evaluacion_final>a evaluación final</a>',
											'<a href=' . base_url() . 'index.php/inscripcion/reporte>reporte</a>',
	//										'<a href=' . base_url() . 'inscripcion/evaluacion_recuperatorio>a examen recuperatorio</a>',
											),
				
				'Reportes' => array(
											'<a href=' . base_url() . 'index.php/reportes/inscripcion>Inscripcion</a>',
											),
				'Periodos' => array(
											'<a href=' . base_url() . 'index.php/periodos/asignaturas>Asignaturas</a>',
											'<a href=' . base_url() . 'index.php/periodos/evaluaciones>Evaluaciones</a>',
											'<a href=' . base_url() . 'index.php/periodos/periodos>Periodos</a>',	
											),							
				'Asignaturas' => array(
	//										'<a href=' . base_url() . 'asignaturas/reporte>Reporte</a>',
											'<a href=' . base_url() . 'index.php/asignaturas/crear>Crear nueva asignatura</a>',
											'<a href=' . base_url() . 'index.php/asignaturas/correlatividad>Correlatividad</a>',
											),
				'Carreras' => array(
//											'<a href=' . base_url() . 'index.php/carreras/reporte>Reporte</a>',
											'<a href=' . base_url() . 'index.php/carreras/crear>Nueva carrera</a>',
											),
				'Sedes' => array(
//											'<a href=' . base_url() . 'index.php/sedes/reporte>Reporte</a>',
											'<a href=' . base_url() . 'index.php/sedes/crear>Nueva sede</a>',
											'<a href=' . base_url() . 'index.php/carreras/habilitar>Habilitación de carrera</a>',
	//										'<a href=' . base_url() . 'sedes/asignar_carrera>Asignar Carrera</a>',
											),
				'Facultades' => array(
//											'<a href=' . base_url() . 'index.php/sedes/reporte>Reporte</a>',
											'<a href=' . base_url() . 'index.php/facultades/crear>Nueva facultad</a>',
	//										'<a href=' . base_url() . 'sedes/asignar_carrera>Asignar Carrera</a>',
											),
				'Usuarios' => array(
//											'<a href=' . base_url() . 'index.php/sedes/reporte>Reporte</a>',
											'<a href=' . base_url() . 'index.php/usuario/recuperar_clave>Recuperar clave</a>',
											'<a href=' . base_url() . 'index.php/usuario/asignar_rol>Asignar rol</a>',
//											'<a href=' . base_url() . 'index.php/usuario/roles>Roles</a>',
											'<a href=' . base_url() . 'index.php/usuario/registrar_usuario>Registrar usuario</a>',
	//										'<a href=' . base_url() . 'sedes/asignar_carrera>Asignar Carrera</a>',
											),
			);
		
		/*
		*Auxiliar Academico
		*/
		}else if($session_data['id_rol'] == 2){
			$menu = array(
				$session_data["alias"] => array(
											'<a href=' . base_url() . 'index.php/usuario/salir>Salir</a>',
											'<a href=' . base_url() . 'index.php/usuario/cambiar_clave>Cambiar contraseña</a>',
											'<a href=' . base_url() . 'index.php/usuario/cambiar_rol>Cambiar rol</a>',
											),
				'Inscripciones' => array(
											'<a href=' . base_url() . 'index.php/inscripcion/cpi>al CPI</a>',
//											'<a href=' . base_url() . 'index.php/inscripcion/semestre>a semestre</a>',
//											'<a href=' . base_url() . 'index.php/inscripcion/evaluacion_final>a evaluación final</a>',
//											'<a href=' . base_url() . 'index.php/inscripcion/reporte>reporte</a>',
	//										'<a href=' . base_url() . 'inscripcion/evaluacion_recuperatorio>a examen recuperatorio</a>',
											),
				'Reportes' => array(
											'<a href=' . base_url() . 'index.php/reportes/inscripcion>Inscripciones</a>',
											'<a href=' . base_url() . 'index.php/reportes/evaluacion_final>Evaluacion Final</a>',
											'<a href=' . base_url() . 'index.php/reportes/recuperatorio>Recuperatorio</a>',
											),
				'Periodos' => array(
											'<a href=' . base_url() . 'index.php/periodos/asignaturas>Asignaturas</a>',
											'<a href=' . base_url() . 'index.php/periodos/evaluaciones>Evaluaciones</a>',
											),
			);
			
		/*
		*Direccion Academica
		*/
		}else if($session_data['id_rol'] == 3){
			$menu = array(
				$session_data["alias"] => array(
											'<a href=' . base_url() . 'index.php/usuario/salir>Salir</a>',
											'<a href=' . base_url() . 'index.php/usuario/cambiar_clave>Cambiar contraseña</a>',
											'<a href=' . base_url() . 'index.php/usuario/cambiar_rol>Cambiar rol</a>',
											),
				'Inscripciones' => array(
											'<a href=' . base_url() . 'index.php/inscripcion/cpi>al CPI</a>',
//											'<a href=' . base_url() . 'index.php/inscripcion/semestre>a semestre</a>',
//											'<a href=' . base_url() . 'index.php/inscripcion/evaluacion_final>a evaluación final</a>',
//											'<a href=' . base_url() . 'index.php/inscripcion/reporte>reporte</a>',
	//										'<a href=' . base_url() . 'inscripcion/evaluacion_recuperatorio>a examen recuperatorio</a>',
											),
				'Reportes' => array(
											'<a href=' . base_url() . 'index.php/reportes/reporte_cpi>Inscripciones al CPI</a>',
											),
				'Periodos' => array(
											'<a href=' . base_url() . 'index.php/periodos/asignaturas>Asignaturas</a>',
											'<a href=' . base_url() . 'index.php/periodos/evaluaciones>Evaluaciones</a>',
											),
			);
			
		}
		echo ul($menu);
	?>
	</div>
</body>
</html>

