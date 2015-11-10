<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<link rel="stylesheet" href="<?=base_url()?>css/frm_login.css" type="text/css" />
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			
			$('.eliminar').click(function() { 
				$('#txt_sede').val('');
				id = this.id;
				$.post('<?=base_url()?>index.php/sedes/crear/obtener_nombre', {slc_sede : id}, function (sede) {
				
					if(sede == 'acupado'){
						$('#mensaje').html('No se puede eliminar xq esta siendo usado');
					}else{						
						if(confirm("Seguro que quieres eliminar la sede " + sede)){
							$.post('<?=base_url()?>index.php/sedes/crear/eliminar', {id_sede : id}, function (respuesta) {
								$('#detalle').html(respuesta)
								$('#txt_sede').focus();
							});	
						}
					}
				});
			});
		});
	</script>


	<style>
		#lista fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    font-size: 11px;
		    margin: 0 auto;
		    padding: 10 33px;
		    width: 600px;
		    font-size: 13px;
		}

		#lista legend {
		    background-color: #FFFFFF;
		    border: 1px solid #A0A0A0;
		    border-radius: 7px 7px 7px 7px;
		    color: #000000;
		    font-size: 15px;
		    font-weight: bold;
		    padding: 2px 20px;
		}

		#lista table{
			margin: 10px auto;
		}

		#lista table td{
			padding: 1px 10px;
		}

		#lista table td span.eliminar{
			color: #bb0000;
			text-decoration: underline;
			cursor: pointer;
		}

		#lista table tr:hover{
			background-color: #ffeeee;
		}
		
		.eliminar{
			color : red;
		}
		
		.eliminar:hover{
			cursor: pointer;
		}
	</style>	
</head>

<body>
<?php
	if($msn)
		echo "<div class=ok>$msn</div>";
	if($sedes){
		$cont = 0;
		foreach($sedes->result() as $row){
			$cont ++;
			$relaciones_sede_carrera = $this->sedes->get_ralacion_sede_carrera($row->id_sede);
			$this->table->add_row(array(
				$cont,
				$row->sede,
				($relaciones_sede_carrera)? 'En uso' : "<span class=eliminar id=$row->id_sede>Eliminar</span>",
			));		
		}
		$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="tbl_detalles">' ));
		$this->table->set_heading('N<sup>ro</sup>', array('data' => 'Sedes', 'colspan' => '2'));
		echo $this->table->generate();
	}
?>
</body>
</html>