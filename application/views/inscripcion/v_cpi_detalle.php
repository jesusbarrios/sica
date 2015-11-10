<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/inscripcion.js"></script>

	<style>
		fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    margin: 0 auto 20px auto;
		    padding: 1 33px;
		    width: 695px;
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

		.ok_message{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		
		a{
			margin: 20px 145px;
		}
	</style>
	
</head>

<body>
	<fieldset>

		<div class='ok_message'>
			La inscripción fue exitosa
		</div>
	
		<a href=<?=base_url()?>>Ir a la página principal</a>
			
	</fieldset>
</body>
</html>