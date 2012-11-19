<?php 
class prestamos extends CI_Controller{
	function index()
	{
		$this->load->helper('language');
		$this->load->helper('url');
 		$this->lang->load('header');
		// load language file
		$this->load->library('session');
		if($this->session->userdata('id_user')!=""){
			$this->load->view('prestamos');
	    }else{
	    	Header("Location: /");
	    }
		
		
	}
	function validacion(){
		

	}
}
?>