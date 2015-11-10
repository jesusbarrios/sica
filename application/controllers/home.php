<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start(); //we need to call PHP's session object to access it through CI

class Home extends CI_Controller {

 function __construct(){
   parent::__construct();
   $this->load->view('header');
 }

 function index(){
 
   if(!$this->session->userdata('logged_in')){
     redirect('usuario/ingresar', 'refresh');
     
   }else{
     $this->load->view('menu');

   }
 }
/*
 function logout(){
	 $this->session->userdata('logged_in');
	 session_destroy();
	 redirect('usuario/ingresar', 'refresh');
 }
 */
}

?>