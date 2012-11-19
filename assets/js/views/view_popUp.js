var that;
    
/*
*   VISTA popUp
*********************************************************************************************************************************/
var popUp = Backbone.View.extend({
    //contenedor de la vista
    el:'body',
    events:{        
        "click a.closePopUp"    : "closePopUp",
        "click div#basePopUp"     : "closePopUp"
    },
    //constructor de nuestra clase
    initialize : function(){
        _.bindAll( this , 'render','closePopUp');
        //this.render();
    },
    /*
    * closePopUp :FUNCION que cierra el pop up creado
    */
    closePopUp : function(){
        var that = this;
        that.cntPop = $jquery("#popUp"),
        that.basPop = $jquery("#basePopUp");
        that.cntPop.fadeOut(100,function(){
            that.basPop.fadeOut(100,function(){
                that.cntPop.remove();
                that.basPop.remove();
                $jquery(that.el).css("overflow","");
            });
        });
    },
    /*
    * loadPopUp :FUNCION que crea popUp
    */
    loadPopUp :function(cntId,title){
        var div='<div id="basePopUp"></div>',
            //cntPop ='<div id="popUp"><a class="closePopUp"></a></div>';
            cntPop = $jquery('<div id="popUp"><a href="#" class="closePopUp"></a><h1>'+title+'</h1><div id="'+cntId+'"></div></div>').css({
                background : 'white'
            });
        $jquery(this.el).append(div);
        $jquery(this.el).append(cntPop);
        $jquery(this.el).css("overflow","hidden");
    },
    render : function(cntId,title){ 
        //alert("estoy inicioan");
        this.loadPopUp(cntId,title);
    }
});

