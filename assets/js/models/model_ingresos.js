// variables glovales
var viewIncome= new incomeForm();


$jquery(function(){
    var routes = new Routers();
    Backbone.history.start();    
});
/*
*   Item Model 
**********************************************************************************************************/
var Item = Backbone.Model.extend({
    initialize: function(){
        alert("estoy iniciado");
    }
}); 
/*
*   Result Collection 
**********************************************************************************************************/
var Resul = Backbone.Collection.extend({
    model:Item,
    initialize: function (){
        
    },
    /*
    * set url : funcion q recibe la url y lansa la peticioncon fetch
    ******************************************************************/
    setUrl  :   function(urlinput){
        this.url=urlinput;
       // this.fetch({error: this.errorFetch,async: false});
    },
    /*
    * getJson : funcion
    *****************************************************************/
    getJson : function(){
        return jsonResponse;
        //return this.json;
    },
    /*
    * parse : funcion q recibe la data de la url de esta colleccion
    *****************************************************************/
    parse : function( data ) {
        jsonResponse=data;
        //this.getJson();
    },
    /*
    * errorFetch : funcion q se activa cuando ha habido un error
    *****************************************************************/
    errorFetch: function(){
        //var error = new Error(data.msg);
    }
});

/*
*   ROUTER PARA LA GESTIONAR LA NAVEGACION
******************************************************************************************************************/
var Routers = Backbone.Router.extend({
    routes : {
        // (:) PARA datos dinamicos que tiene q estar  incluido dentro del url
        // (*) para todo el url es un parametro dinamico
        ""                          :   "root",
        "!/lista-ingresos/"         :   "listIncomes",
        "!/progreso-de-ingresos/"   :   "graphIncomes"
    },
    /*
    *   root cuando la url no contiente nada por defecto
    *******************************************************************************************/
    root: function(){
        /*var url="/index.php/inicio/validar";
        var res = new Resul();
        res.setUrl(url);
        */
        //cargando json tipos de ingresos
        $jquery.getJSON(
            '/index.php/en/ingresos/cargar-ingreso',
            function(data){

                //data = {"success":false,"data":[{"id":1,"concepto":"Inversión"},{"id":2,"concepto":"Sueldo"}],"msj":""};
                if(data.success){
                    //jsonResponse = {"success":true,"data":[{"id":1,"concepto":"Inversión"},{"id":2,"concepto":"Sueldo"}],"msj":""};
                    jsonResponse = data;
                    viewIncome.render("#newIncome",jsonResponse);
                }
                else{
                    viewIncome.addIncome();
                    //alert("es su primera vez");
                }
            }
        );
        
    },
    listIncomes : function(){
        $jquery.getJSON(
            '/index.php/en/ingresos/lista-ingresos',
            function(data){
                //data = {"success":false,"data":[{"id":1,"concepto":"Inversión"},{"id":2,"concepto":"Sueldo"}],"msj":""};
                if(data.success){
                    //jsonResponse = {"success":true,"data":[{"id":1,"concepto":"Inversión"},{"id":2,"concepto":"Sueldo"}],"msj":""};
                    jsonResponse = data;
                    viewIncome.render("#resumeIncome",jsonResponse);
                    //viewIncome.render("#newIncome",jsonResponse);
                }
                else{
                    viewIncome.addIncome();
                    //alert("es su primera vez");
                }
            }
        );
        //jsonResponse ={"success":true,"data":[{"id":1,"typeIncome":"Sueldo","concept":"Busportal pago Febrero","amount":2500.00,"dateIngreso":"2012-03-05","dateRegister":"2012-03-05 21:10:53"},{"id":2,"typeIncome":"Inversion","concept":"Busportal pago marzo ","amount":1500.00,"dateIngreso":"2012-04-05","dateRegister":"2012-04-06 21:10:53"},{"id":3,"typeIncome":"Sueldo","concept":"Busportal pago abril","amount":2200.00,"dateIngreso":"2012-05-05","dateRegister":"2012-05-06 21:10:53"},{"id":4,"typeIncome":"Sueldo","concept":"Busportal pago Mayo","amount":3500.00,"dateIngreso":"2012-06-05","dateRegister":"2012-06-06 21:10:53"},{"id":12,"typeIncome":"Inversion","concept":"Iternet Inalambrico","amount":2900.00,"dateIngreso":"2012-07-05","dateRegister":"2012-03-12 21:10:53"}],"msj":""};
        
    },
    /* graficar progreso de ingresos 
    ****************************************************/
    graphIncomes : function(){
        viewIncome.render("#graph-incomes",jsonResponse);
    }
});

