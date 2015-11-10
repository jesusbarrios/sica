<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

<!--	<link rel="stylesheet" href="<?=base_url()?>css/frm_login.css" type="text/css" /> -->
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


	echo "<div id=lista>";	
		echo $lista;
	echo "</div>";
?>
</body>
</html>