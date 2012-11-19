<?php 
class reportes extends CI_Controller{
	function index()
	{
		$this->load->helper('language');
		$this->load->helper('url');
 
		// load language file
		
		$this->lang->load('header');
		//validando sesion
		$this->load->library('session');
		if($this->session->userdata('id_user')!=""){
			$this->load->view('reportes');
	    }else{
	    	Header("Location: /");
	    }
		
	}
	function validacion(){
		
	}
}
?>