<?php 
class hola extends CI_Controller{
	function index()
	{
		echo "Hola Mundo!";
	}
	function holatodos(){
		$this->load->helper('language');
		$this->load->helper('url');
 
		// load language file
		
		$this->lang->load('header');
		$this->load->view('index.php');	

	}
	function kubiak(){
		$this->load->view('kubiak.php');
	}
	
}
?>