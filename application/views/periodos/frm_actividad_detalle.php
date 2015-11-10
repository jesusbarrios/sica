<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<script>
		$('document').ready(function() {
			$('.eliminar').click(function() {
				$.post('<?=base_url()?>index.php/periodos/actividades/eliminar', {id : (this).id}, function (respuesta) {
					$("#detalle").html(respuesta);
				});
			})
		});
	</script>
	<style>
		.eliminar{
			color: red;
			cursor: pointer;
		}
	</style>
</head>

<body>
	<?php
		$this->load->model('m_periodo');
		if($actividades){
			$cont = 1;
			foreach($actividades->result() as $row){
				
				$detalles_periodo = $this->m_periodo->get_detalle_periodo($row->id_actividad);
				$this->table->add_row(array(
					$cont++,
					$row->id_actividad,
					$row->actividad,
					($detalles_periodo)? 'En uso' : "<span id=$row->id_actividad class=eliminar>Eliminar</span>",
				));
			}
			$this->table->set_heading('N<sup>ro</sup>', 'Código', 'Actividades', 'Eliminar');
			$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1" class="detalles>"'));
			echo $this->table->generate();
		}else{
			echo "No hay actividad registrada";
		}
	?>
</body>
</html>