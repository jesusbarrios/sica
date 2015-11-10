<?php

	$campo_evaluacion = array(
		null => '----',
		1 => 'Primera',
		2 => 'Segunda',
		3 => 'Tercera',
	);
	$campo_asistencia = array(null => '---');
	for($i = 0; $i <= 100; $i++)
		$campo_asistencia[$i] = $i;
	
	$campo_pp = array(null => '-----');
	for($i = 0; $i <= 100; $i++)
		$campo_pp[$i] = $i; 
	
	$calificaciones = array('0' => '0 (cero)', '1' => '1 (Uno)', '2' => '2 (Dos)', '3' => '3 (Tres)', '4' => '4 (Cuatro)', '5' => '5 (Cinco)');
	$campo_calificacion = array(null => '---');
	for($i = 0; $i <= 5; $i++)
		$campo_calificacion[$i] = $calificaciones[$i]; 
	$semestre = '';
	foreach($asignaturas->result() as $row){
/*		
		if($semestre != $row->id_semestre){
			$this->table->add_row(array(
				array( 'data' => $row->id_semestre, 'colspan' => 5)
			));
			
			$semestre = $row->id_semestre;
		}
*/		
		$campo_fecha = array(
			'type' => 'date',
			'name' => 'txt_fecha_' . $row->id_asignatura,
			'id' => 'txt_fecha_' . $row->id_asignatura,
			'size' => '10',
		);
		
		$campo_acta = array(
			'type' => 'text',
			'name' => 'txt_acta_' . $row->id_asignatura,
			'id' => 'txt_acta_' . $row->id_asignatura,
			'size' => '10',
		);
		$this->table->add_row(array(
			$row->asignatura,
//			form_dropdown('pp_' . $row->id_asignatura, $campo_pp),
			array( 'data' => form_dropdown('calificacion_' . $row->id_asignatura, $campo_calificacion), 'styles' => 'text-aling:center'),
			form_dropdown('evaluacion_' . $row->id_asignatura, $campo_evaluacion),
			form_input($campo_fecha),
			form_input($campo_acta),
		));
	}	

	$btn_aceptar = array(
		'name'=>'',
		'value'=>'Aceptar'
	);
	
	$btn_cancelar = array(
		'name'	=> 'btn_cancelar2',
		'id'	=> 'btn_cancelar2',
		'value'	=> 'Cancelar'
	);


	$this->table->add_row(array(
		NULL,
		array( 'data' => form_submit($btn_aceptar) . form_submit($btn_cancelar), 'colspan' => 3)
	));

	$this->table->set_heading('Asignaturas', 'Calificacion', 'Evaluacion', 'Fecha', 'Acta');

	$tmpl = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="mytable">' );
	$this->table->set_template($tmpl);

	echo $this->table->generate();
?>