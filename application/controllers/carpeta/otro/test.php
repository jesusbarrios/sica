<?php

class Test extends CI_Controller{

	function index(){

		$id = $this->input->post('id_sede');
		echo 'desde controlador con el dato ' . $id;

	}

}

?>