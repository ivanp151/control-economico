// variables glovales
var expenses = new expensesForm();


$jquery(function(){
    var routes = new Routers();
    Backbone.history.start();    
});


/*
*   ROUTER PARA LA GESTIONAR LA NAVEGACION
******************************************************************************************************************/
var Routers = Backbone.Router.extend({
    routes : {
        // (:) PARA datos dinamicos que tiene q estar  incluido dentro del url
        // (*) para todo el url es un parametro dinamico
        ""                          :   "root",
        "!/egresos/"                :   "root",
        "!/lista-egresos/"          :   "listExpenses",
        "!/grafico-egresos/"        :   "graphExpenses"
    },
    /*
    *   root cuando la url no contiente nada por defecto
    *******************************************************************************************/
    root: function(){
        $jquery(".controls").slideUp('fast');
        expenses.render("#new-expenses",{});

        /*var url="/index.php/inicio/validar";
        var res = new Resul();
        res.setUrl(url);
        */
        //cargando json tipos de ingresos
        /*$jquery.getJSON(
            '/index.php/en/ingresos/cargar-ingreso',
            function(data){

                //data = {"success":false,"data":[{"id":1,"concepto":"Inversión"},{"id":2,"concepto":"Sueldo"}],"msj":""};
                if(data.success){
                    //jsonResponse = {"success":true,"data":[{"id":1,"concepto":"Inversión"},{"id":2,"concepto":"Sueldo"}],"msj":""};
                    jsonResponse = data;
                    expenses.render("#new-expenses",jsonResponse);
                }
                else{
                    expenses.addIncome();
                    //alert("es su primera vez");
                }
            }
        );*/
        
    },
    listExpenses : function(){
        

        $jquery("#ctrl1").removeClass("filterGraph");
        $jquery("#ctrl1").addClass("filter");
        $jquery("#ctrl2").removeClass("monthGraph");
        $jquery("#ctrl2").addClass("month");

        $jquery.getJSON(
            '/index.php/en/registro-ingresos-diarios/listar-egresos',
            function(data){
                //data = {"success":false,"data":[{"id":1,"concepto":"Inversión"},{"id":2,"concepto":"Sueldo"}],"msj":""};
                if(data.success){
                    //jsonResponse = {"success":true,"data":[{"id":1,"concepto":"Inversión"},{"id":2,"concepto":"Sueldo"}],"msj":""};
                    jsonResponse = data.data;
                    //alert(jsonResponse[0].fecha_egreso);
                    expenses.render("#list-egresos",jsonResponse);
                    $jquery(".controls").slideDown('fast');
                }
                else{
                    expenses.render("#msg-empty",{});
                    //alert("es su primera vez");
                }
            }
        );
        
        //jsonResponse ={"success":true,"data":[{"id":1,"typeIncome":"Sueldo","concept":"Busportal pago Febrero","amount":2500.00,"dateIngreso":"2012-03-05","dateRegister":"2012-03-05 21:10:53"},{"id":2,"typeIncome":"Inversion","concept":"Busportal pago marzo ","amount":1500.00,"dateIngreso":"2012-04-05","dateRegister":"2012-04-06 21:10:53"},{"id":3,"typeIncome":"Sueldo","concept":"Busportal pago abril","amount":2200.00,"dateIngreso":"2012-05-05","dateRegister":"2012-05-06 21:10:53"},{"id":4,"typeIncome":"Sueldo","concept":"Busportal pago Mayo","amount":3500.00,"dateIngreso":"2012-06-05","dateRegister":"2012-06-06 21:10:53"},{"id":12,"typeIncome":"Inversion","concept":"Iternet Inalambrico","amount":2900.00,"dateIngreso":"2012-07-05","dateRegister":"2012-03-12 21:10:53"}],"msj":""};
        
    },
    /* graficar progreso de ingresos 
    ****************************************************/
    graphExpenses : function(){
        //$jquery(".controls").slideUp('fast');
        $jquery(".controls").slideDown('fast');

        $jquery("#ctrl1").removeClass("filter");
        $jquery("#ctrl1").addClass("filterGraph");
        $jquery("#ctrl2").removeClass("month");
        $jquery("#ctrl2").addClass("monthGraph");

        $jquery.getJSON(
            '/index.php/en/registro-ingresos-diarios/listar-egresos',
            function(data){
                //data = {"success":false,"data":[{"id":1,"concepto":"Inversión"},{"id":2,"concepto":"Sueldo"}],"msj":""};
                if(data.success){
                    //jsonResponse = {"success":true,"data":[{"id":1,"concepto":"Inversión"},{"id":2,"concepto":"Sueldo"}],"msj":""};
                    jsonResponse = data.data;
                    //alert(jsonResponse[0].fecha_egreso);
                    expenses.drawGrap(jsonResponse,"months");
                }
                else{
                    expenses.render("#msg-empty",{});
                    //alert("es su primera vez");
                }
            }
        );
        
        //expenses.render("#graph-egresos",jsonResponse);
    }
});

