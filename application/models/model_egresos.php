<?php 
class model_egresos extends CI_Model {
   /* constructor de la clase
   ****************************************************************************************/
   function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->helper('date');
      $this->load->library('session');
   }
   /* Guarda lista de egresos
   ****************************************************************************************/
   function saveExpenses($date,$expenses){
      $user= $this->session->userdata('id_user');
      //insersion agregar nuevos items   
      //insercion agregar
      // opteniendo los valores de al array $expenses
      $error=0;
      foreach ($expenses as $key) {
         # code...
         //$string.= $key[];
         $result = $this->db->query('INSERT INTO egresos (id_egreso,concepto,fecha_egreso,monto,fecha_registro,usuarioid_usuario) VALUES (NULL ,  "'.$key[0].'","'.$date.'", '.$key[1].',  now(),'.$user.')');
         if($result == false){
            $error = 1;
         }
      }
      if(!$error){
         mysql_query("COMMIT");
         $rs->result = array(
           "success" => true                       
         );
         return $rs;
      }else{            
         mysql_query("ROLLBACK");
         $rs->result = array(
           "success" => false
         );
         return $rs;
      }
      return $rs;
      
   }
   /* saca lista de egresos
   ****************************************************************************************/
   function listExpenses(){
      if($this->session->userdata('id_user')!=""){
         $user= $this->session->userdata('id_user');
         $sql = 'SELECT  id_egreso ,  concepto , monto , fecha_egreso 
                  FROM  egresos 
                  WHERE  usuarioid_usuario ='.$user.' ORDER BY fecha_egreso DESC';

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
      }else{

      }
      

   }

   
}
?>