<?php 
class micuenta extends CI_Controller{
	function index()
	{
		$this->load->helper('language');
		$this->load->helper('url');
 
		// load language file
		
		$this->lang->load('header');
		
		$this->load->view('micuenta');	
	}
	function registro(){
		$this->load->helper('language');
		$this->load->helper('url');
 
		// load language file
		
		$this->lang->load('header');
		$this->load->view('register_user');

	}
	function kubiak(){
		$this->load->view('kubiak.php');
	}
	
}
?>