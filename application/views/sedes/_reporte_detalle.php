<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<link rel="stylesheet" href="<?=base_url()?>css/frm_login.css" type="text/css" />
	
	
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
	</style>	
</head>

<body>
<?php
	if($sedes){
		$cont = 0;
		foreach($sedes->result() as $row){
			$cont ++;
			$relaciones_sede_carrera = $this->sedes->get_carrera($row->id_sede);
			
			if($relaciones_sede_carrera){
				$lista = "<ol>";
				foreach($relaciones_sede_carrera->result() as $row_relacion){
					$lista .= "<li>$row_relacion->carrera</li>";
				}
				$lista .= "</ol>";
			}else{
				$lista = "";
			}
			$this->table->add_row(array(
				$cont,
				$row->ciudad,
				$lista,
			));
		}
		$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="tbl_detalles">' ));
		$this->table->set_heading('N<sup>ro</sup>', 'Sedes', 'Carreras');
		echo $this->table->generate();
	}
?>
</body>
</html>