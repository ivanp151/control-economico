<?php 
class excel extends CI_Controller{
	function index()
	{
		$this->load->view('excel');
	}
    
    public function importar()
    {
        //echo $_FILES['file']['name'];

        //$name     = $_FILES['file']['name'];
        $tname    = $_FILES['file']['tmp_name'];
 		//echo "name:".$name." - ".$tname;	
        //echo $tname;
        // Buscamos nuestra clase para leer el Excel
        require_once BASEPATH.'libraries/excel_reader2.php';
        // Instanciamos nuestra clase

        $dato = new Spreadsheet_Excel_Reader($tname);
 
        //Aqui vamos a leer el Excel, mostrandolo con un simple HTML
        $html = "<table cellpadding='2' border='1'>";
        $data = '{"success":true,"data":[';
        for ($i = 2; $i <= $dato->rowcount($sheet_index=0); $i++) {
 
            //Verificamos que cada celda la fila no se encuentra vacia
            if($dato->val($i,2) != ''){
                $html .= "<tr>";
                // leemos columna por columna
                $data .= '{';
                for ($j = 1; $j <= $dato->colcount($sheet_index=0); $j++) { 
                    $value   = $dato->val($i,$j);
                    //json
                    if($dato->val($i,1)=="espanol"){
                    	if($dato->colcount($sheet_index=0)==$j){
                    		$data.='"'.$dato->val(1,$j).'":"'.$dato->val($i,$j).'"';	
                    	}
                    	else{
                    		$data.='"'.$dato->val(1,$j).'":"'.$dato->val($i,$j).'"';	
                    		$data.=',';	
                    	}
                    }         
                    $html .="<td>".$value." </td>";
                    // Aqui podemos insertar cada fila del excel en una tabla Mysql
                }
                if($i==$dato->rowcount($sheet_index=0)){
                    $data .="}";    
                }
                else{
                    $data .="},";       
                }
                
                $html .="</tr>";
            }
        }
        $html .="</table>";   
        // Imprimimos el HMTL
 		$data.="]}";
        echo $data;
    }
    public function importarLang()
    {

        //echo $_FILES['file']['name'];
        header('Content-Type: text/html; charset=ASCII'); 
        //$name     = $_FILES['file']['name'];
        $tname    = $_FILES['file']['tmp_name'];
        //echo "name:".$name." - ".$tname;  
        //echo $tname;
        // Buscamos nuestra clase para leer el Excel
        require_once BASEPATH.'libraries/excel_reader2.php';
        // Instanciamos nuestra clase

        $dato = new Spreadsheet_Excel_Reader($tname);
 
        //Aqui vamos a leer el Excel, mostrandolo con un simple HTML
        $html = "<table cellpadding='2' border='1'>";
        $data = '';
        for ($i = 2; $i <= $dato->rowcount($sheet_index=0); $i++) {
 
            //Verificamos que cada celda la fila no se encuentra vacia
            if($dato->val($i,2) != ''){
                $html .= "<tr>";
                // leemos columna por columna
                
                for ($j = 1; $j <= $dato->colcount($sheet_index=0); $j++) { 
                    $value   = $dato->val($i,$j);
                    //json
                    //if($dato->val($i,1)=="espanol"){
                        //if($dato->colcount($sheet_index=0)==$j){
                        if($j==2){
                            $data .= '$lang[';
                            //$data.="'".$dato->val($i,1)."']= '".$dato->val($i,3)."';<br/>";    
                            $data.='"'.$dato->val($i,1).'"]= "'.$dato->val($i,4).'";<br/>';    
                        }
                    //}         
                    $html .="<td>".$value." </td>";
                    // Aqui podemos insertar cada fila del excel en una tabla Mysql
                }
                                
                $html .="</tr>";
            }
        }
        $html .="</table>";   
        // Imprimimos el HMTL
        echo $data;
    }
	
}
?>