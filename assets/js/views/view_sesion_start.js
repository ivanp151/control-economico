var jsonResponse,
    that;
/*
*   VISTA sesionStart : para visualizar el formulario de validacion
*********************************************************************************************************************************/
var sesionStart = Backbone.View.extend({
    //contenedor de la vista
    el : "#cnt-general",
    events:{
        "click button#sesionStart"      : "sesionStart",
        "click a.lostPass"              : "lostPassword",
        "click button#sendEmailButton"  : "sendEmailButton",
        //"submit form.sesionForm"      : "sesionStart",    
        "focusout input.notEmpty"       : "notEmpty",
        "focusout input.email"          : "validEmail",
        "click button#validCodeEmailButton" : "validCodeEmailButton",
        "click a.reload"                :  "reloadCaptcha", 
    },
    //constructor de nuestra clase
    initialize : function(){
        _.bindAll( this , 'render','sesionStart');
        //this.render();
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
    /* sendEmailButton : funcino q valida el email y el codigo , manda los dos datos al server
    ****************************************************************************************************/
    sendEmailButton : function(){
        that = this;
        // aqui hay q validar los datos. y enviar al servidor email y codigo y elserver confirma si
        //a enviado un codigo a su correo electronico

        dat = {email:$jquery("#email").attr("value"),codigo:$jquery("#code-img").attr("value")};
        $jquery.post('/index.php/es/inicio/validarEmailSendCode',dat,function(data){
            //no se ha validado password
            if(!data.success){
                that.showMessage("fail",data.msj);
            }
            else{                
                document.location = "#!/codigoConfirmacion/"+$jquery("#email").attr("value")+"/";
            }
        },"json");
        /*var email=$jquery("#email").attr("value");
        event.preventDefault();
        var url="#!/codigoConfirmacion/"+email+"/";
        document.location = url;*/
        
        
    },
    /* showTemplate : funcion que recibe el id de una template y renderiza en el contenedor de la vista
    ****************************************************************************************************/
    showTemplate : function( templat ){ 
        var template = _.template( $jquery( templat ).html() , {} );
        $jquery( this.el ).html( template );
    },
    /* showMessage : funcion que recibe el tipo y el mensaje a visualizar en el contenedor de msj
    ****************************************************************************************************/
    showMessage : function( type , msj){
        //verificando typo de mensaje fail o success
        switch(type){
            case "success":
                $jquery("#msj").addClass("success");
                $jquery("#msjText").html("<span>"+msj+"</span>");
            break;
            case "fail":
                $jquery("#msj").addClass("alert");
                $jquery("#msjText").html("<span>"+msj+"</span>");
            break;
        }
        
    },
    /* validCodeEmailButton :  funcion que verifica 
    ****************************************************************************************************/
    validCodeEmailButton : function(){
        dat = {email:$jquery("#emailVerify").attr("value"),codigo:$jquery("#code").attr("value")};
        $jquery.post('/index.php/es/inicio/validarEmailCode',dat,function(data){
            //no se ha validado password
            if(!data.success){
                that.showMessage("fail",data.msj);
            }
            else{                
                document.location = "/es/registro";
            }
        },"json");
    },
    /* showMessage : funcion que recibe el tipo y el mensaje a visualizar en el contenedor de msj
    ****************************************************************************************************/
    sesionStart : function(){
        var that = this;
        
        //alert("hola");
        var user,pass,dat;
        user = $jquery("#usuario").attr("value");
        pass = $jquery("#contrasenia").attr("value");

        pass = hex_sha1(pass);
        //verificando si los datos estan vacios
        if( user != '' && pass !='' ){
            pass = hex_sha1(pass);
            // solicitando peticion ajax            
            dat = {usuario:user,contrasenia:pass};
            //pasando parametros
            $jquery.post('/index.php/es/inicio/validar',dat,function(data){
                //no se ha validado password
                if(!data.success){
                    that.showMessage("fail",data.msj);
                }
                else{
                    document.location = "/en/portal-control-economico";
                }
            },"json");
        }
        else{
            that.showMessage("fail","Verifique bien sus datos!");
        }
        //retornamos false para no enviar el evento de submit
        return false;
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
    /* validEmail : valida el formato de email
    ****************************************************************************************************/
    validEmail : function(e){
        if(this.isEmail($jquery( e.target ).attr("value"))){
            $jquery( e.target ).next().addClass( "ok" );
        }
        else{
            $jquery( e.target ).next().addClass( "fail" );  
        }
    },
    /* notEmpty : verifica si un input tiene contenido si no tiene agrega clase de fail a span
    ****************************************************************************************************/
    notEmpty : function(e){
        //e.target se aplica para obtener el objeto del evento
        $jquery("#msj").removeClass("alert");
        $jquery("#msjText").children().remove();
        if( $jquery( e.target ).attr("value") != '' ){
            $jquery( e.target ).next().removeClass("fail").addClass( "ok" );
        }
        else{
            $jquery( e.target ).next().removeClass("ok").addClass( "fail" );  
        }
        
    },
    reloadCaptcha : function(){
        $jquery("#img-captcha").attr("src","/en/inicio/getCaptcha");
        return false;
    },
    render : function(tmpl){  
        this.showTemplate( tmpl , {} );
        this.loadValidateForm();
    }
});

function controlUrl (id){
    switch(id){
        case "":
        break;
        case "":
        break;
        case "":
        break;
    }
}

