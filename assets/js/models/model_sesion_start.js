// variables glovales
var $jquery = jQuery.noConflict();
var viewSesion= new sesionStart();

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
        this.fetch({error: this.errorFetch,async: false});
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
        ""                      :   "root",
        "!/nuevoUsuario/"       :   "nuevoUsuario",
        "!/codigoConfirmacion/*email/" :   "codigoConfirmacion",
        "!/reporte/*sales/"     :   "rootGeneral"
    },
    /*
    *   root cuando la url no contiente nada por defecto
    *******************************************************************************************/
    root: function(){
        /*var url="/index.php/inicio/validar";
        var res = new Resul();
        res.setUrl(url);*/        
        viewSesion.render("#login");
    },
    codigoConfirmacion : function(email){
        viewSesion.deleteView();
        viewSesion.render("#comfirmCode");
        viewSesion.loadEmail(email);
    },
    nuevoUsuario : function(){
        viewSesion.deleteView();
        viewSesion.render("#sendMail");
    },
    /*
    *   historicSales : Funcion q se encargara de cargar la vista Historico de ventas
    *******************************************************************************************/
    historicSales   :   function(){
        //view.remove();
        var panel2a =new panel();
        panel2a.render("#historic-sell");
    }
});

