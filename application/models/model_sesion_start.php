<?php 
class model_sesion_start extends CI_Model {
   /* constructor de la clase
   ****************************************************************************************/
   function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->helper('date');
      $this->load->library('session');
      
      //$this->load->helper('email');
      $this->load->library('email');
   }
   /* constructor de la clase
   ****************************************************************************************/
   function sesion_start($user,$pass){
      $sql1  =    'SELECT usuario FROM usuario WHERE usuario="'.$user.'"';
      $sql2  =    'SELECT id_usuario,usuario FROM usuario WHERE usuario="'.$user.'" AND contrasenia="'.$pass.'"';
      
      $this->db->trans_start();
         // verificando si existe el usuario existe
         $result = $this->db->query( $sql1 );
         //verificando si existe el email
         if ( $result->num_rows() > 0 ){
            // verificando si password existe
            $result = $this->db->query( $sql2 );
            if ( $result->num_rows() == 0 ){
               $rs->result = array(
                  "success" => false,
                  "msj" => "Contraseña no existe"
               );
            }else{
               // existe usuario y password
               
               foreach ($result->result() as $row){
                  $idUser = $row->id_usuario;
                  $userUser = $row->usuario;
               }
               $sql3  =    'SELECT nombres,url_foto FROM persona WHERE id_persona='.$idUser;
               $result = $this->db->query( $sql3 );
               //verificando si hay datos
               if ( $result->num_rows() != 0 ){
                  foreach ($result->result() as $row){
                     $nameUser = $row->nombres;
                     $urlUserFoto = $row->url_foto;                    
                  }  
               }else{

               }
               $this->session->set_userdata('id_user',$idUser);
               $this->session->set_userdata('user_user',$userUser);
               $this->session->set_userdata('name_user',$nameUser);
               $this->session->set_userdata('url_foto',$urlUserFoto);
               $rs->result = array(
                  "success" => true,
                  "msj" => ""
               );
            }
            //existe verificar si su codigo
         }else{            
            $rs->result = array(
               "success" => false,
               "msj" => "Usuario no identificado"
            );
         }
      $this->db->trans_complete();

      
      return $rs;
   }
   /* constructor de la clase
   ****************************************************************************************/
   function usuario_login($email){
         
   }
   
   function inserta_usuario($datos = array()){
      
   }
   /* constructor de la clase
   ****************************************************************************************/
   function inserta_email_code( $email , $code ,$st){
      
      //;
      //'INSERT INTO control.mailcode (id_mail, email, code, expire) VALUES (NULL,"'.$email.'","'.$code.'", (select now()+INTERVAL 24 hour))'
      $string = $st;

      //return false;
      
      // VERIFICANDO SI EXISTE
      $sql1  =    'SELECT email AS result FROM mailcode WHERE email="'.$email.'"';
      $sql2  =    'SELECT email AS result FROM mailcode WHERE email="'.$email.'" AND expire>NOW() LIMIT 1';
      $sql3  =    'UPDATE mailcode SET  code = "'.$string.'", expire = (SELECT DATE_ADD( NOW( ) , INTERVAL 1 DAY ))  WHERE  email="'.$email.'"';

      $sql4  =    'INSERT INTO mailcode(id_mail,  email ,  code ,  expire) VALUES (NULL,"'.$email.'","'.$string.'",NOW()+36000)';

      $this->db->trans_start();
         // verificando si existe el emai y el codigo
         $result = $this->db->query( $sql1 );
         //$result = $this->db->query( $sql2 );
         //$result = $this->db->query( $sql3 );
         //$result = $this->db->query( $sql4 );
         //verificando si existe el email
         if ( $result->num_rows() > 0 ){
            //consulando si el email a expirado
            $result = $this->db->query( $sql2 );
            if ( $result->num_rows() == 0 ){
               //email y codigo an expirado actualizamos codigo y fecha de expiracion
               $result = $this->db->query( $sql3 );
               $rs->result = array(
                  "success" => true,
                  "msj" => "HA SIDO ACTUALIZADO"
               );
            }else{
               //existe email y enviamos nuevamente su codigo
               $rs->result = array(
                  "success" => true,
                  "msj" => "Verifique su email ha sido enviado un codigo"
               );
            }
            //existe verificar si su codigo
         }else{
            $result = $this->db->query( $sql4 );
            $rs->result = array(
               "success" => true,
               "msj" => "Verifique su email ha sido enviado un codigo"
            );
         }
      return $rs;
   }
   /* valida_email_code : valida email con codigo enviado a su correo electronico
   ****************************************************************************************/
   function valida_email_code( $email , $code){
      $sql1  =    'SELECT email AS result FROM mailcode WHERE email="'.$email.'"';
      $sql2  =    'SELECT email AS result FROM mailcode WHERE email="'.$email.'" AND code="'.$code.'" AND expire>now() LIMIT 1';
      
      $this->db->trans_start();
         // verificando si existe el emai y el codigo
         $result = $this->db->query( $sql1 );
         //verificando si existe el email
         if ( $result->num_rows() > 0 ){
            //consulando si el email a expirado
            $result = $this->db->query( $sql2 );
            if ( $result->num_rows() == 0 ){
               //email y codigo an expirado actualizamos codigo y fecha de expiracion
               $rs->result = array(
                  "success" => false,
                  "msg" => "Su codigo ha expirado"
               );
            }else{
               //existe email y enviamos nuevamente su codigo
               $rs->result = array(
                  "success" => true,
                  "msg" => "Exitos"
               );
            }
            //existe verificar si su codigo
         }else{
            //$result = $this->db->query( $sql4 );
            $rs->result = array(
               "success" => false,
               "msg" => "Ud. no ha creado su codigo de ingreso"
            );
         }
      $this->db->trans_complete();

      return $rs;
   }
}
?>