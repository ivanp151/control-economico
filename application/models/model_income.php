<?php 
class model_income extends CI_Model {
   /* constructor de la clase
   ****************************************************************************************/
   function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->helper('date');
      $this->load->library('session');
   }
   /* loadincome carga los ingresos q pertenecen a l usuario logeado
   *****************************************************************************************/
   function loadIncome(){
      $user= $this->session->userdata('id_user');
      $sql = 'SELECT id_tipo_ingreso as id, concepto as concepto
                     FROM tipo_ingreso
                     WHERE usuarioid_usuario ='.$user;

      $this->db->trans_start();
         $result = $this->db->query($sql);         
      $this->db->trans_complete();
      //verificando si hay datos en el resultado
      if ($result->num_rows() > 0)
      {
         $rs->result = array(
               "success" => true,
               "data" => array()
         );
         foreach ($result->result() as $row)
         {
            $rs->result['data'][] =$row;
            
         }
      }else{
         $rs->result = array(
            "success" => false,
            "msj" => "Es su primera vez en control"
         );
      }
      return $rs;
   }
   /* Guarda nuevo ingreso
   ****************************************************************************************/
   function saveIncome($typeIncome,$concept,$amount,$date){
      $user= $this->session->userdata('id_user');
      $sql = 'INSERT INTO ingresos (
                  id_ingreso,
                  concepto,monto,
                  fecha_ingreso,
                  fecha_registro,
                  usuarioid_usuario,
                  tipo_ingresoid_tipo_ingreso)
               VALUES(NULL,"'.$concept.'",'.$amount.',"'.$date.'",now(),"'.$user.'",'.$typeIncome.')';

      $this->db->trans_start();
         $result = $this->db->query($sql);         
      $this->db->trans_complete();

      if( $result != false ){
         mysql_query("COMMIT");
         $rs->result= array(
                     "success" => true                            
                 );
      }else{
         mysql_query("ROLLBACK");
         $rs->result = array(
                     "success" => false
                 );
      }
      return $rs;
   }
   /* gurarda nuevo tipo de ingreso
   ****************************************************************************************/
   function saveNewType($type){
      $user= $this->session->userdata('id_user');
      $sql = 'INSERT INTO tipo_ingreso (
                  id_tipo_ingreso,
                  concepto,
                  inversionid_inversion,
                  usuarioid_usuario
                  )
               VALUES(NULL,"'.$type.'",NULL,'.$user.')';
      $this->db->trans_start();
         $result = $this->db->query($sql);
      $this->db->trans_complete();

      
      if( $result != false ){
         mysql_query("COMMIT");
         $rs->result= array(
                     "success" => true                            
                 );
      }else{
         mysql_query("ROLLBACK");
         $rs->result = array(
                     "success" => false
                 );
      }
      return $rs;     
   }
   /* listIncome : consulta la lista de ingresos q se hicieron
   **************************************************************************************/
   function listIncome(){
      $user= $this->session->userdata('id_user');
      $sql = 'SELECT 
                  ingresos.id_ingreso AS id,
                  tipo_ingreso.concepto AS typeIncome,
                  ingresos.concepto AS concept,
                  ingresos.monto AS amount,
                  ingresos.fecha_ingreso AS dateIngreso,
                  ingresos.fecha_registro AS dateRegister
               FROM    tipo_ingreso
                  INNER JOIN ingresos ON tipo_ingreso.id_tipo_ingreso=ingresos.tipo_ingresoid_tipo_ingreso
               WHERE ingresos.usuarioid_usuario='.$user.' ORDER BY ingresos.fecha_ingreso DESC';

      $this->db->trans_start();
         $result = $this->db->query($sql);         
      $this->db->trans_complete();
      //verificando si hay datos en el resultado
      if ($result->num_rows() > 0)
      {
         $rs->result = array(
               "success" => true,
               "data" => array()
         );
         foreach ($result->result() as $row)
         {
            $rs->result['data'][] =$row;
            
         }
      }else{
         $rs->result = array(
            "success" => false,
            "msj" => "No tiene Ingresos Registrados"
         );
      }
      return $rs;
   }
   /* constructor de la clase
   ****************************************************************************************/
   function inserta_email_code( $email , $code){
      //;
      //'INSERT INTO control.mailcode (id_mail, email, code, expire) VALUES (NULL,"'.$email.'","'.$code.'", (select now()+INTERVAL 24 hour))'

      // VERIFICANDO SI EXISTE
      $query = $this->db->query('SELECT email AS result FROM control.mailcode WHERE email="'.$email.'"  LIMIT 1');
      
      //$query[]
      // SINO EXISTE REGISTRA EMAIL CREA UN NUEVO CODIGO Y A ENVIA EMAIL

      // SI EXISTE EMAIL VERIFICAR SI CODIGO AUN NO HA EXPIRADO
      // SI A EXPIRADO CREAR UN NUEVO CODIGO Y ENVIAR MENSAJE DE DE Q SE HA CREADO UN NUEVO CODIGO Y SE ENVIA  EMAIL
      // 
      //$query = $this->db->query('SELECT saveCodeEmail("'.$email.'","'.$code.'") as result');
      $a=$query->result();
      return $a[0];
   }
   /* valida_email_code : valida email con codigo enviado a su correo electronico
   ****************************************************************************************/
   function valida_email_code( $email , $code){
      //;
      //'INSERT INTO control.mailcode (id_mail, email, code, expire) VALUES (NULL,"'.$email.'","'.$code.'", (select now()+INTERVAL 24 hour))'
      $query = $this->db->query('SELECT validCodeEmail("'.$email.'","'.$code.'") as result');
      $a=$query->result();
      return $a[0];
   }
}
?>