<?php 
class users extends CI_Controller{	
	//constructor
	public function __construct()
	{
	    parent::__construct();
	    // Your own constructor code

	    $this->load->library('session');
	    $this->session->userdata('id_user');
	}
	function index()
	{
		$this->load->helper('language');
		$this->load->helper('url');
 
		// load language file
		
		$this->lang->load('header');
		
		$this->load->view('inicio');
	}
	/* validar : Funcion que verifica la existencia de un usuario
	**************************************************************************/
	function validar(){
		
		//$this->load->library('encrypt');
		$this->load->model('model_sesion_start');
		
		$user = $this->input->post('usuario');
		$pass = $this->input->post('contrasenia');

		$rs = $this->model_sesion_start->sesion_start($user,$pass);

		$rs->result = stripslashes(json_encode($rs->result));
		//verificando si 
		$this->load->view('json',  $rs);
	}
	/* validarEmailSendCode : guarda email y envia codigo
	**************************************************************************/
	function validarEmailSendCode(){
		$this->load->model('model_sesion_start');

		$string = '';
		//dando numero aleatorio
		for ($i = 0; $i < 10; $i++) {
		 $string .= chr(rand(65, 90));
		 $string .= chr(rand(48, 57));
		 $string .= chr(rand(97, 122));
		}
		//verificando el captcha
		if($_POST['codigo'] == $this->session->userdata('captcha_string')){
			$rs = $this->model_sesion_start->inserta_email_code($_POST['email'],$_POST['codigo'],$string);
			//aqui me quede
		}else{
			$rs->result = array(
               "success" => false,
               "msj" => "Captcha incorrecto"
         	);
		}
		$rs->result = stripslashes(json_encode($rs->result));
		//$json = stripslashes(json_decode(json_encode($retorno->result)));
		/**********************************************************************/
    	$email=$this->input->post("email");    	
    	$config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'ivanp151@gmail.com';
        $config['smtp_pass']    = 'reina1+9';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      

        $this->email->initialize($config);

        $this->email->from('ivanp151@gmail.com', 'ControlEconomico');
        $this->email->to($email); 

        $this->email->subject("este es el el codigo de verificacion");

        $this->email->message('<style type="text/css">
body{font-family: arial; font-size: 12px; color:#666;}
table#contenido{font-size: 1.1em;margin:0px; padding:0px;}
table#contenido thead tr th,table#contenido thead tr tr{width: 120px;}
table#contenido thead tr th,table#contenido tbody tr td label{border-bottom:thin solid #eee }
/*table,table thead tr,table thead tr th,table,table tbody tr,table tbody tr td{border:solid thin #eee;}*/
table{border:solid thin #eee;}
table#contenido tfoot tr.foot-mail{background-image:url(http://buscador/assets/images/background-mail.png); height: 45px}
table#contenido tfoot tr.foot-mail td span{float:right; color:#fff;}
td.right-td,td.left-td{width: 100px;}


h1.titulos{text-transform: uppercase; text-align: center}
b.var{font-size: 1.4em; margin-left:30px;}
img.bus{margin-top: 0px;float: left;}
div.cnt-company{float: left;width: 110px;padding: 15px 18px;}
label.label-works{display:block;}
div.cnt-msg{margin:10px; margin-bottom:50px;}
</style>

<table id="contenido" width="750" celpadding="0" cellspacing="0">
	<thead>
		<tr style="background-color:#FABEAA">
			<th colspan="2">
				<img class="bus" src="http://busportal.pe/assets/images/logo-busportal.png" alt="busportal.pe"/>
			</th>
			<th colspan="2">

			</th>
			<th>
				<img src="http://buscador/assets/images/nino.png" alt="busportal.pe"/>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="1" class="left-td"></td>
			<td colspan="3">
				<div class="cnt-msg">
					<h1 class="titulos">bienvenido a busportal.pe</h1>
					<p>Hola: <br/> <b class="var">Ivan</b></p>
					<p>Nuestro sitio web y nuestras aplicaciones permiten comparar fácilmente horarios y precios de múltiples empresas de transporte terrestre a la vez desde una página intuitiva, rápida y completa.
Las flexibilidad del motor de búsqueda BusPortal te permite consultar los precios a lo largo de un mes, brindándote las mejores opciones. Así puedes reservar según tus gustos y necesidades, privilegiando precios o servicios.</p>

				</div>
			</td>
			<td colspan="1" class="right-td"></td>
		</tr>
		<tr>
			<td colspan="5">
				<label class="label-works">Trabajamos con:</label>
				<div class="cnt-company"><img src="http://dev.busportal.pe/assets/images/companys/index/cruz-del-sur.png"/></div>
				<div class="cnt-company"><img src="http://dev.busportal.pe/assets/images/companys/index/civa.png"/></div>
				<div class="cnt-company"><img src="http://dev.busportal.pe/assets/images/companys/index/tepsa.png"/></div>
				<div class="cnt-company"><img src="http://dev.busportal.pe/assets/images/companys/index/oltursa.png"/></div>
				<div class="cnt-company"><img src="http://dev.busportal.pe/assets/images/companys/index/linea.png"/></div>
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr  class="foot-mail">
			<td colspan="5">
				<span>Busportal.pe , el especialista en buses</span>
			</td>
		</tr>
	</tfoot>
</table>'

        	);  

        $this->email->send();
        /******************************************/
        $this->load->view('json',$rs);
	}
	/* validarEmailSendCode : guarda email y envia codigo
	**************************************************************************/
	function validarEmailCode(){
		$this->load->model('model_sesion_start');
		$rs = $this->model_sesion_start->valida_email_code($_POST['email'],$_POST['codigo']);
		$rs->result = stripslashes(json_encode($rs->result));
		//$json = stripslashes(json_decode(json_encode($retorno->result)));
		$this->load->view('json',$rs);
	}
	/* getCaptcha : funcion que genera un captcha 
	**************************************************************************/
	function getCaptcha()
	{	
		$string = '';

        for ($i = 0; $i < 5; $i++) {
          $string .= chr(rand(65, 90));
        }

        //$_SESSION['random_number'] = $string;
        $this->session->set_userdata('captcha_string',$string); 
        $dir = 'assets/fonts/';

        $image = imagecreatetruecolor(120, 30);

        // random number 1 or 2
        $num = rand(1,2);
        if($num==1)
        {
          $font = "Capture it 2.ttf"; // font style
        }
        else
        {
          $font = "Molot.otf";// font style
        }        
        // random number 1 or 2
        $num2 = rand(1,2);
        if($num2==1)
        {
          $color = imagecolorallocate($image, 113, 193, 217);// color
        }
        else
        {
          $color = imagecolorallocate($image, 163, 197, 82);// color
        }

        $white = imagecolorallocate($image, 255, 255, 255); // background color white
        imagefilledrectangle($image,0,0,399,99,$white);
        imagettftext ($image, 20, 0, 0, 20, $color, $dir.$font, $this->session->userdata('captcha_string'));
        //echo $dir.$font;
        header("Content-type: image/png");
        imagepng($image);
	}
	function closeSession(){
		$this->session->destroy();
		Header("Location: /");
	}
}
?>