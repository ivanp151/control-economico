<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Busportal_user_controller extends CI_Controller {
    
    //constructor de controlador
    public function __construct()
    {
            parent::__construct();
            $this->load->library('session');
    }
    
    //***************************************creacion de vistas************************************//    
    public function enter_register()
    {       
       //if(!$this->session->userdata('comprado_exito'))
       //{ 
         $data["res"]=$this->input->post('information',TRUE); 
         if(!empty($data["res"]))
         { 
           if(isset($_SESSION['logged_in']))
           {  
              if(md5('3185busportal')==$this->session->userdata('logged_in'))
              {     
                   $data_union=$data["res"];
                   $data_union=explode("/", $data_union);
                   $id_itinerary=$data_union[0];
                   $date=$data_union[1];
                   $number_seat=$data_union[2];
                   $email=$this->session->userdata('email');
                   $name=$this->session->userdata('name');
                   $this->load->model('Busportal_user_model');
                  
                   $this->session->set_userdata('s_id_itinerary',$id_itinerary);
                   $this->session->set_userdata('s_date',$date);
                   $this->session->set_userdata('s_number_seat',$number_seat);

                   $data_return= $this->Busportal_user_model->getData_itenerary_user($id_itinerary,$date,$number_seat);
                   $data["data"] = stripslashes(json_encode($data_return));
                   $data["data2"]='{"success":true,"account":true,"msg":"","data":{"email":"'.$email.'","'.$name.'":"edy  aguirre"}}';
                   $this->load->view('page_register_passenger', $data);               
              }  
              else
                $this->load->view('page_enter_register', $data);
            } 
            else
               $this->load->view('page_enter_register', $data);
          }
          else
            $this->load->view('index'); 
      // }
      // else
      // {
       //  $this->session->unset_userdata('comprado_exito');   
       //  $this->load->view('index'); 
      // }   
        
    }

    public function register_passenger()
    {
        if(isset($_SESSION['email']))
        {
          if(!$this->session->userdata('comprado_exito'))
          {  
            $data["data"]=$this->input->post("appdata");
            $data["data2"]=$this->input->post("appdata2");
            $this->load->view('page_register_passenger', $data);
          }
          else
          {
           $this->session->unset_userdata('comprado_exito');   
           $this->load->view('index'); 
          }
        }
        else
          $this->load->view('index');       
    }

    public function confirm_sales() {

        if(isset($_SESSION['email']))
        {
          $data["result"]=$this->input->post("data_sales");
          $this->load->view('page_confirm_sales.php',$data);
        }
        else
          $this->load->view('index');    
    }
    //*******************************************************************************************/
    
    //registro de usuarios
    public function set_create_user($data_user='') {        
        $data=array();
        $data['result'] = $data_user;
        $data['result'] = stripslashes(json_encode(array("success" => isset($data), "data" => $data['result'])));
        $this->load->view('json', $data);
    }
    
    //guardar la sesion del itenerario  
    public function get_itenerary_user($id_itinerary=null,$date=null,$number_seat=null) {        
        
        
        $this->session->set_userdata('s_id_itinerary',$id_itinerary);
        $this->session->set_userdata('s_date',$date);
        $this->session->set_userdata('s_number_seat',$number_seat);

        $data = array();
        if ($id_itinerary) 
        {                  
            $this->load->model('Busportal_user_model');
            $data_return= $this->Busportal_user_model->getData_itenerary_user($id_itinerary,$date,$number_seat);
            $data['result'] = stripslashes(json_encode(array("success" => isset($data),"data" => $data_return)));
        
        }
        else 
            $data['result'] = '{"sucess":false}';
        
        $this->load->view('json', $data);

    }
     
    //funcion registro usuario formulario1
    public function insert_form1_user()
    {             
         $data = array();         
         $mail=$this->input->post('mail',TRUE);  
         $pass=$this->input->post('pass',TRUE);  
         $captcha=$this->input->post('capt',TRUE);

         if(!empty($mail) && !empty($pass) && !empty($captcha))
         {
            if(strtolower($captcha)==strtolower($this->session->userdata('random_number')))
            {                        
              $data_sesion_user = array(                                      
                                      'email'=> $mail,
                                      'pass'=> $pass
                    );
              $this->session->set_userdata($data_sesion_user);
              $data['result'] = stripslashes(json_encode(array("success" => true,"account"=>false,"data" => $mail)));              
            }
            else
              $data['result'] = '{"success":false,"msg":"Las letras de la imagen son incorrectas"}';         
         } 
         else  
             $data['result'] = '{"success":"false","msg":"llenas los campos correctamente"}';
         
         $this->load->view('json', $data);

    }  
           
    //funcion validar existencia de correo
    public function get_exist_mail()
    { 
         $data = array();         
         $mail=$this->input->post('mail',TRUE);    
         //$mail="edy@busportal.com";                           
         if($mail)
         {
              $this->load->model('Busportal_user_model');
              $data_get= $this->Busportal_user_model->get_exist_mail($mail);
              $data['result'] = stripslashes(json_encode(array("success" => $data_get['success'],"msg"=>$data_get['msg'])));       
         } 
         else  
             $data['result'] = '{"success":false}';
         
         $this->load->view('json', $data);
    }  
 
    //funcion login de usuario
    function login_user()
    {   
         $data = array();         
         $mail=$this->input->post('mail',TRUE);  
         $pass=$this->input->post('pass',TRUE);

         if(!empty($mail) && !empty($pass))
         {    
              $this->load->model('Busportal_user_model');
              $data= $this->Busportal_user_model->login_user($mail,$pass);
              if($data['resend'])
              {
                  $data['result'] = stripslashes(json_encode(array("success" => $data['resend'],"account"=>true,"msg" => $data['msg'],"data"=>$data['data_user'])));       
                  if($data['resend'])
                  {
                     $codigo_comprobacion=md5('3185busportal');
                     $data_sesion_user = array(                                      
                                      'email'     => $mail,
                                      'logged_in' =>$codigo_comprobacion, 
                                      'name'=>$data['data_user']['name']
                    );
                    $this->session->set_userdata($data_sesion_user);
                  }  
              } 
              else 
                $data['result'] = stripslashes(json_encode(array("success" => $data['resend'],"msg" => $data['msg'])));       
         } 
         else  
             $data['result'] = '{"success":false,"msg":"Los datos no existen"}';
                     
         $this->load->view('json', $data);       
    }
    
    //  devolver datos del usuario
    function get_data_customer()
    {  
        $data=array();
        $mail=$this->input->post('email',TRUE);
        //$mail='edy@busportal.com';
        if(!empty($mail))
        {  
            $this->load->model('Busportal_user_model');
            $data_return= $this->Busportal_user_model->get_data_customer($mail);
            $data['result'] = stripslashes(json_encode(array("success" => $data_return['success'],"data" => $data_return['data_user'])));       
               
        } 
         else  
             $data['result'] = '{"success":false}';
                     
         $this->load->view('json', $data);   

    }
    //funcion para registrar nuevo customer
    function customer_new_register()
    {   
         $data = array();                 
         $decode_customer=$this->input->post('new_account',TRUE);    //htmlspecialchars() - htmlentities() o strip_tags() 
         $decode_customer=json_decode(stripslashes($decode_customer),TRUE);   
         //$decode_customer=json_decode(stripslashes('{"information":{"name":"elias","type_document":"dni","number_document":"45587898","last_name":"mamani","celephone":"951576978","day":"dia","month":"mes","year":"ano","city":"ciudad"}}'),TRUE);
         $customer=$decode_customer['information'];
         $email = $this->session->userdata('email');
         $pass = $this->session->userdata('pass'); 
         if(!empty($decode_customer))
         {   
             $this->load->model('Busportal_user_model');
             $data_return= $this->Busportal_user_model->register_new_customer($customer,$email,$pass);
             $data['result'] = stripslashes(json_encode(array("success" => $data_return['success'],"data" => $data_return['data_user'])));       
             if($data_return['success'])
             {
                $this->session->unset_userdata('pass');
                $codigo_comprobacion=md5('3185busportal');
                $data_sesion_user = array(                                      
                                      'email'     => $email,
                                      'logged_in' =>$codigo_comprobacion, 
                                      'name'=>$data_return['data_user']
                );
                $this->session->set_userdata($data_sesion_user);
             }   
                 
         }
         else  
             $data['result'] = '{"success":false,"msg":"Todos los campos son obligatorios"}';                   
         $this->load->view('json',$data);
    }

    //funcion para registro de pasajeros,compra,transaccion.
    function passenger_register()
    {    
         
         $data = array();                 
         $data_passenger=$this->input->post('data_passenger',TRUE);     
         $decode_passenger=json_decode(stripslashes($data_passenger),TRUE);   
         $account=$decode_passenger['data_older']['account'];
         $travel=$decode_passenger['data_older']['travel'];       
         $passenger=$decode_passenger['passenger'];        
         $email_send_ticket=$decode_passenger['email_ticket'];   
         $code_cupon=$decode_passenger['code_cupon'];  
         $apply_cupon=$decode_passenger['apply_cupon'];      
         $mail = $this->session->userdata('email'); 
         $id_itinerary = $this->session->userdata('s_id_itinerary');
         $date = $this->session->userdata('s_date');         
         $seat_customer='';        
         if($account)
         {
            $older='';
            $pass='';
         }             
         else
         {
             $older=$decode_passenger['data_older']['older'];
             $pass = $this->session->userdata('pass'); 
         }      
         if($travel)
              $seat_customer=$decode_passenger['data_older']['older']['seat'];            
         if(!empty($decode_passenger))
         {
              $this->load->model('Busportal_user_model');
              $data_return= $this->Busportal_user_model->register_purchase_customer($account,$travel,$passenger,$older,$mail,$pass,$seat_customer,$id_itinerary,$date,$apply_cupon,$code_cupon);
              $data['result'] = stripslashes(json_encode(array("success" => $data_return['success'],"data"=>$data_return['data_purchase'],"msg"=>'')));                                 
              if($data_return['success'])
              { 
                if(!isset($_SESSION['logged_in']))
                {  
                   $this->session->unset_userdata('pass');
                   $codigo_comprobacion=md5('3185busportal');
                   $data_sesion_user = array(                                                                            
                                      'logged_in' =>$codigo_comprobacion, 
                                      'name'=>$data_return['data_purchase']['passenger'][0]['name']
                   );
                   $this->session->set_userdata($data_sesion_user);
                }   

                $this->session->set_userdata('comprado_exito',true);                 
                $this->session->set_userdata('code_voucher',$data_return['data_purchase']['num_voucher']);
              }  
               
         } 
         else  
             $data['result'] = '{"success":false}';                   
         $this->load->view('json',$data);
    }
    
    //funcion para actualizar cliente
    function update_customer()
    {
        $data=array();
        $data_customer=$this->input->post('data_older',TRUE);
        $data_customer=json_decode(stripslashes($data_customer),TRUE);
        $mail = $this->session->userdata('email'); 
        //$data_customer=json_decode(stripslashes('{"older":{"passenger-name":"Edy","passenger-last-name":"Mamani Canaza","day":"","moth":"","year":"","type_document":"dni","number_document":"45587898","number_celephone":"951576978","city":"lim"}}'),TRUE);       
        $data_update=$data_customer['older'];    
        $name=$data_customer['older']['passenger-name']." ".$data_customer['older']['passenger-last-name']; 
        if(!empty($data_update)) 
        {
            $this->load->model('Busportal_user_model');
            $data_return= $this->Busportal_user_model->register_update_customer($data_update,$mail);
            $data['result'] = stripslashes(json_encode(array("success" => $data_return)));  
            if($data_return)
            { 
              $this->session->unset_userdata('name');
              $this->session->set_userdata('name', $name);
            }           
        }
        else
            $data['result'] = '{"sucess":"false"}';   
                    
        $this->load->view('json',$data);
   }

    //implementar con  mailchimp
    function  send_ticket_mail()
    { 
        //$pdf="/index.php/Busportal_user_controller/get_ticket_voucher/";
        $pdf="https://www.tuentrada.com/Online/help/instructivo_e-ticket.pdf";
        $mails="guillaume.ridoux@gmail.com,hassan_bourgi@hotmail.fr,aguirre_4595@hotmail.com";
        $this->load->library('mailchimp/busportal_mail');
        $mail=new Busportal_mail(); 
        //$mail->ticketDetail($pdf, $mails);
    }

    //obtener cupones de descuento
    function get_cupon()
    {
        $data=array();
        $data_return=array();
        $code_cupon=$this->input->post('code_cupon',TRUE);
        $email = $this->session->userdata('email');
        if($code_cupon!='')
        {
             $this->load->model('Busportal_user_model');
             $data_return= $this->Busportal_user_model->get_cupon($code_cupon,$email); 
             $data['result'] = stripslashes(json_encode(array("success" => $data_return['value'],"amount" => $data_return['amount'],"msg"=>$data_return['msg'])));  
        } 
        else          
             $data['result'] = '{"sucess":"false","msg":"El numero de cupon vacio"}';
                        
        $this->load->view('json',$data);    

    }

    //eliminar sesion de usuarios
    function destroy_session()
    {   
        $data=array();
        $this->session->destroy();
        $data['result'] = '{"success":true}';
        $this->load->view('json',$data);    

    }

    //funcion para recuperar password
    function recover_password()
    {

    } 
    
    //obtener captcha en register
    function get_captcha()
    {    
        $string = '';

        for ($i = 0; $i < 5; $i++) {
          $string .= chr(rand(97, 122));
        }

        //$_SESSION['random_number'] = $string;
        $this->session->set_userdata('random_number',$string); 
        $dir = 'assets/fonts/';

        $image = imagecreatetruecolor(165, 50);

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
        imagettftext ($image, 30, 0, 10, 40, $color, $dir.$font, $this->session->userdata('random_number'));
        //echo $dir.$font;
        header("Content-type: image/png");
        imagepng($image);

    }

    
}

?>