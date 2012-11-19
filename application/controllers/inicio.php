<?php 
class inicio extends CI_Controller{
	//constructor
	public function __construct()
	{
	    parent::__construct();
	    // Your own constructor code
	    $this->load->library('session');
	    $this->load->library('session');
	    if($this->session->userdata('id_user')!=""){

	    }else{
	    	Header("Location: /");
	    }

	}
	function index()
	{
		$this->load->helper('language');
		$this->load->helper('url');
 
		// load language file
		
		$this->lang->load('header');
		
		$this->load->view('inicio');
	}
}
?>