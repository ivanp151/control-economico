
var jsonResponse,
    that,
    calendario = new datePicker();
/*
*   VISTA sesionStart : para visualizar el formulario de validacion
*********************************************************************************************************************************/
var incomeForm = Backbone.View.extend({
    //contenedor de la vista
    el : "#cnt-updatable",
    events:{
        "focusout input.notEmpty"           : "notEmpty",
        "focusin input.notEmpty"            : "notEmpty",
        "click button#buttonSaveIncome"     : "saveIncome",
        "click a.addIncome"                 : "addIncome",
        "click button#buttonCancel"         : "emptyForm",
        "click a.edit"                      : "editRow",
        "click a.del"                       : "delRow"

    },
    //constructor de nuestra clase
    initialize : function(){
        _.bindAll( this , 'render');
        //this.render();
    },
    /*EMPTY FORM*/
    emptyForm : function(e){
        $jquery(".all").attr("value","");
        $jquery("#typeIncome").attr("value",0);
        return false;
    },
    /* edit row*/
    editRow : function(e){
        var elem = $jquery(e.target);
        return false;
    },
    delRow : function(e){
        var elem = $jquery(e.target);
        return false
    },
    /* agregar income */
    addIncome : function(){
        var pop  = new popUp();
            that = this;
        pop.render('cnt-pop','Registre un nuevo tipo de ingreso');
        this.putTemplate("#cnt-pop","#new-income-tmpl",{});
        $jquery('.help').tipsy({html:true,gravity:'s'});
        $jquery("#save-type-income").click(function(){
            if($jquery("#newTypeIncome").val()!=''){

                var input=$jquery("#newTypeIncome").val(),
                    dat = {newType:input};
                jQuery.ajax({
                    type    : 'POST',
                    url     : "/index.php/es/ingresos/nuevo-tipo-ingreso",
                    data    : dat,
                    dataType: "json",
                    success : function(data){
                        //alert(data.success);
                        if(data.success){
                            jsonResponse=data;
                            that.putTemplate("#cnt-pop","#msj-success",{});

                            that.putTemplate("#typeIncome","#list-incomes",jsonResponse);
                                                       
                        }
                        else{
                            that.putTemplate("#cnt-pop","#msj-fail",{})
                        }
                        return false;
                    }

                });
                
            }
            else{
                return false;
            }   
            
        });
        return false;  
    },
    /* enviando para guardar el ingreso*/
    saveIncome :function(e){
        var dat;
        that = this;
        
        if($jquery("#typeIncome").attr("value")!='0' && $jquery("#conceptIncome").attr("value")!='' && $jquery("#amount").attr("value")!='' && $jquery("#date").attr("value")!=''){

            dat = {typeIncome:$jquery("#typeIncome").attr("value"), conceptIncome:$jquery("#conceptIncome").attr("value"),amount: $jquery("#amount").attr("value"), date:that.changeFormat($jquery("#date").attr("value"))};
            $jquery.post('/index.php/es/ingresos/registro',dat,function(data){
                //no se ha validado password
                if(data.success){
                    that.putTemplate(that.el,"#msg-ingreso",{});
                }
                else{
                    that.showMessage("fail",data.msj);
                }
            },"json"); 

        }
        else{            

            that.showMessage("fail","Faltan ingresar campos para registrar nuevo ingreso");
        }       
        return false;

    },

    /* loadValidateForm : funcion para cargar las validaciones de campos de formularios formularios
    ****************************************************************************************************/
    loadValidateForm : function(){

    },
    /* lostPassword : funcion para mostrar el pop up de olvidado de contraseña
    ****************************************************************************************************/
    lostPassword : function(){
        alert("Olvidaste contraseña .. pop up en construcción");
    },
    /* loadEmail : funcion carga el email obtenido
    ****************************************************************************************************/
    loadEmail : function(email){
        $jquery("#emailCreateAccount").html(email);
        $jquery("#emailVerify").attr("value",email);
    },
    /* putTemplate : funcion que recibe el id de una template y renderiza en el contenedor de la vista
    ****************************************************************************************************/
    putTemplate : function( cnt , templat , jsonResponse ){ 
        jsonResponse = jsonResponse;
        var template = _.template( $jquery( templat ).html() , jsonResponse );
        $jquery( cnt ).html( template );
    },
    /* showTemplate : funcion que recibe el id de una template y renderiza en el contenedor de la vista
    ****************************************************************************************************/
    showTemplate : function( templat , jsonResponse ){ 
        jsonResponse = jsonResponse;
        var template = _.template( $jquery( templat ).html() , jsonResponse );
        $jquery( this.el ).html( template );
    },
    /* showMessage : funcion que recibe el tipo y el mensaje a visualizar en el contenedor de msj
    ****************************************************************************************************/
    showMessage : function( type , msj){
        //verificando typo de mensaje fail o success
        switch(type){
            case "success":
                $jquery("#msj").addClass("success");
                $jquery("#msjText").html(msj);
            break;
            case "fail":
                $jquery("#msj").addClass("alert");
                $jquery("#msjText").html(msj);

            break;
        }
        
    },
    /* changeFormat : cambia el formato de fecha
    ****************************************************************************************************/
    changeFormat : function(date){
        var dat=date.split("/");
        return dat[2]+"-"+dat[1]+"-"+dat[0];
    },
    /* deleteView : remueve todo el contenido de el contenedor
    ****************************************************************************************************/
    deleteView : function(){
        $jquery(this.el).children().remove();
    },
    isEmail: function(mail)
    {
        var exr =/([a-z0-9][-a-z0-9_\+\.]*[a-z0-9])@([a-z0-9][-a-z0-9\.]*[a-z0-9]\.(arpa|root|aero|biz|cat|com|coop|edu|gov|info|int|jobs|mil |mobi|museum|name|net|org|pro|tel|travel|ac|ad|ae|af|ag|ai|al|am| an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo| br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cu|cv| cx|cy|cz|de|dj|dk|dm|do|dz|ec|ee|eg|er|es|et|eu|fi|fj|fk|fm|fo|fr| ga|gb|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn| hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km| kn|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mk| ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl| no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re| ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy| sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)|([0-9]{1,3}\.{1,3}))/;
        return exr.test(mail);
    },

    /* notEmpty : verifica si un input tiene contenido si no tiene agrega clase de fail a span
    ****************************************************************************************************/
    notEmpty : function(e){
        //e.target se aplica para obtener el objeto del evento
        $jquery("#msj").removeClass("alert");
        $jquery("#msjText").remove();
        if( $jquery( e.target ).attr("value") != '' ){
            $jquery( e.target ).next().removeClass("fail").addClass( "ok" );
        }
        else{
            $jquery( e.target ).next().removeClass("ok").addClass( "fail" );  
        }
        
    },
    notNone : function(e){  
        if( $jquery( e.target ).attr("value") != '' ){
            $jquery( e.target ).next().addClass( "ok" );
        }
        else{
            $jquery( e.target ).next().addClass( "fail" );  
        }
    },
    render : function(tmpl,jsonResponse){ 
        this.showTemplate( tmpl , jsonResponse );
        this.loadValidateForm();
        calendario.render($jquery("#date"));
        
        $jquery('.help').tipsy({html:true,gravity:'s'});
        
        //$jquery('.help').live('tipsy',{html:true,gravity:'s'})
        //$jquery('.help').tipsy({html:true,gravity:'s'});
    }
});

$jquery(function(){
   

});
