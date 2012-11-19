<?php 
class egresos extends CI_Controller{
	//constructor
	public function __construct()
	{
	    parent::__construct();
	    // Your own constructor code
	    $this->load->helper('language');
		$this->load->helper('url');
 
		// load language file
		
		$this->lang->load('header');
		$this->load->library('session');
		$this->load->model('model_egresos');

		if($this->session->userdata('id_user')!=""){
		
	    }else{
	    	Header("Location: /");
	    }
	    
	}
	function index()
	{
		$this->load->view('egresos');
		//validando		
	}
	/* loadEgresos : function para cargar Egresos
	****************************************************************/
	function loadEgresos(){
		$rs=$this->model_egresos->listExpenses();
		$rs->result = stripslashes(json_encode($rs->result));
		$this->load->view('json',  $rs);	
	}
	/* saveEgresos : funcion para guardar los egresos
	****************************************************************/
	function saveEgresos(){
		$fecha = $this->input->post('fecha');
		$egresos = json_decode($this->input->post('egresos'));
		$rs=$this->model_egresos->saveExpenses($fecha,$egresos);
		$rs->result = stripslashes(json_encode($rs->result));
		//verificando si 
		$this->load->view('json',  $rs);	
	}
}
?>