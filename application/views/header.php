<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<title>FaCyT | SICA</title>

	<style>
		body{
			margin: 0px;
			padding: 0px;
		}

		#header {
		   	background-color: #CCCCCC;
		    border-bottom: 1px solid #A0A0A0;
		    margin: 0 auto 20px;
		    padding: 10px;
		    text-align: center;
		}

		#header h1, #header h2, #header h3 {
		    margin: 0;
		}
		
	</style>	
</head>

<body>
	
	<div id="header">
	<?php
		$url = base_url();
		$url2 = parse_url($url);
		if($url2['host'] == 'localhost')
			$facultad 	= 'Desarrollo';
		else if($url2['host'] == 'cyt.uni.edu.py')
			$facultad 	= 'FACULTAD DE CIENCIAS Y TECNOLOGIA';
	?>
		<h1>UNIVERSIDAD NACIONAL DE ITAPUA</h1>
		<h2><?=$facultad?></h2>
		<h3>Sistema Informático de Control Académico</h3>

	</div>
	
</body>
</html>