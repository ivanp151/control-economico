<?php 
class ingresos extends CI_Controller{
	function index()
	{
		//cargando los helpers de lenguaje y url
		$this->load->helper('language');
		$this->load->helper('url');
 
		// load language file
		
		$this->lang->load('header');
		$this->lang->load('ingreso');

		$this->load->library('session');
		if($this->session->userdata('id_user')!=""){
			$this->load->view('ingresos');
	    }else{
	    	Header("Location: /");
	    }
	}
	/*ingreso 
	***********************************************************************/
	function ingreso(){
		$this->load->model('model_income');	
		$rs = $this->model_income->loadIncome();
		$rs->result = stripslashes(json_encode($rs->result));
		$this->load->view('json',  $rs);
	}
	function registro(){
		//$this->load->view('register_user');
		$this->load->model('model_income');	
		$rs = $this->model_income->saveIncome($_POST['typeIncome'],$_POST['conceptIncome'],$_POST['amount'],$_POST['date']);
		$rs->result = stripslashes(json_encode($rs->result));
		$this->load->view('json',  $rs);

	}
	function nuevotipo(){
		$this->load->model('model_income');
		$rs = $this->model_income->saveNewType($_POST['newType']);
		//$rs->result = stripslashes(json_encode($rs->result));
		//verificando
		if($rs->result["success"]){
			$rs = $this->model_income->loadIncome();
			$rs->result = stripslashes(json_encode($rs->result));			
		}
		else{
			$rs->result = stripslashes(json_encode($rs->result));
		}
		$this->load->view('json',  $rs);
	}
	function listaingresos(){
		$this->load->model('model_income');
		$rs = $this->model_income->listIncome();
		$rs->result = stripslashes(json_encode($rs->result));
		$this->load->view('json',  $rs);
	}
	
}
?>