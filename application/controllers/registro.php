<?php 
class registro extends CI_Controller{
	function index()
	{
		$this->load->library('session');
		if($this->session->userdata('id_user')!=""){
			$this->load->view('register_user');
	    }else{
	    	Header("Location: /");
	    }
		
	}
	function validacion(){

	}
	function kubiak(){
		$this->load->view('kubiak.php');
	}
	
}
?>