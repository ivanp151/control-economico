var jsonResponse,
    that,
    calendario = new datePicker(),
    val;
/*
*   VISTA sesionStart : para visualizar el formulario de validacion
*********************************************************************************************************************************/
var expensesForm = Backbone.View.extend({
    //contenedor de la vista
    el : "#cnt-updatable",
    events:{
        "click button#add-expense"          : "addExpense",
        "click a.edit"                      : "editRow",
        "click a.del"                       : "delRow",
        "click a.save"                      : "updateRow",
        "click button#save-list-expenses"   : "saveExpenses",
        "keypress input#amount"             : "verifyMoney",
        "keypress input.amount"             : "verifyMoney"
        //"click a.filter"                    : "filterTable"
        
    },
    //constructor de nuestra clase
    initialize : function(){
        _.bindAll( this , 'render');
        //this.render();
    },
    /*
    * filterTable : filtra la tabla por el parametro indicado
    * @e object html was clicked
    *****************************************************************************/
    filterTable : function(e){
        var elem = $jquery(e),
            value = elem.attr("value"),
            date,
            i=0,
            next,
            money=0;
            if(value=="ok"){
                $jquery("tr.success").remove();
                $jquery(".table tbody tr").attr("style","");

                $jquery(".table tbody tr").each(function(index){
                    var tr=$jquery(this);
                    if(tr.hasClass('rowExp')){
                        if(i==0){
                            date = tr.find("td:eq(1)").html();
                            money = parseFloat(money)+parseFloat(tr.find("td:eq(3)").attr("value"));
                        }else{
                            next = tr.find("td:eq(1)").html();
                            if(date==next){
                                money = parseFloat(money)+parseFloat(tr.find("td:eq(3)").attr("value"));
                            }
                            else{
                                money = parseFloat(money);
                                tr.after('<tr class="success important"><td>Total</td><td>'+date+'</td><td></td><td>'+roundCurrency(money)+'</td></tr>');
                                money = parseFloat(tr.find("td:eq(3)").attr("value"));
                                date = next;
                            }    
                        }
                        i++;
                        tr.attr("style","display:none");
                    }            
                });
                elem.attr("value","fail");
            }else{
                $jquery("tr.success").remove();
                $jquery(".table tbody tr").attr("style","");
                elem.attr("value","ok");
            }
        
        //quitando eventos
        //$jquery(".filter").off('click');
        
    },
    /*
    * filterMonth : filtra la tabla por el parametro indicado por mes
    * @e object html was clicked
    *****************************************************************************/
    filterMonth : function(e){
       var elem = $jquery(e),
            value = elem.attr("value"),
            date,
            i=0,
            next,
            aux1,
            aux2,
            money=0;
            if(value=="ok"){
                $jquery("tr.success").remove();
                $jquery(".table tbody tr").attr("style","");

                $jquery(".table tbody tr").each(function(index){
                    var tr=$jquery(this);
                    if(tr.hasClass('rowExp')){
                        if(i==0){
                            aux1 = tr.find("td:eq(1)").html().split("/");
                            date = aux1[1];
                            money = parseFloat(money)+parseFloat(tr.find("td:eq(3)").attr("value"));
                        }else{
                            aux2 = tr.find("td:eq(1)").html().split("/");
                            next = aux2[1];
                            if(date==next){
                                money = parseFloat(money)+parseFloat(tr.find("td:eq(3)").attr("value"));
                            }
                            else{
                                money = parseFloat(money);
                                tr.after('<tr class="success important"><td>Total</td><td>'+aux1.join("/")+'</td><td></td><td>'+roundCurrency(money)+'</td></tr>');
                                money = parseFloat(tr.find("td:eq(3)").attr("value"));
                                date = next;
                            }    
                        }
                        i++;
                        tr.attr("style","display:none");
                    }            
                });
                elem.attr("value","fail");
            }else{
                $jquery("tr.success").remove();
                $jquery(".table tbody tr").attr("style","");
                elem.attr("value","ok");
            }
    },
    /*
    * filterGraph : filtra la elgrafico por el parametro indicado por día
    * @e object html was clicked
    *****************************************************************************/
    monthGraph : function(){
        this.drawGrap(jsonResponse,"months");
    },
    verifyMoney : function(e){
        //alert(e.keyCode);
        var key = e.keyCode,
            i ,
            a = $jquery(e.target).attr("value"),
            array = a.substr();
            this.point=0;
            //contando los puntos en la cadena
        
        for( i = 0;i < array.length ;i++){
            if(array[i]=='.'){
                this.point++;
            }
        }
        //alert(this.point);
        if(key>47 && key<58 || key==46||key==44){
            if(key==46){
                if(this.point==0){
                    //this.point++;
                }else{
                    return false;
                }
            }else{

            }
        }
        else{
            return false;
        }
    },
    saveExpenses :function(){
        
        var expenses = new Array();
        that = this;
        $jquery("#tbody tr").each(function(index){
            expenses[index] = new Array();
            expenses[index][0] = $jquery(this).find("td:eq(0)").html();
            expenses[index][1] = $jquery(this).find("td:eq(1)").html();
            
        });
        expenses = JSON.stringify(expenses);
        if(expenses.length>0&&$jquery("#date").attr("value")!=""){
            dat={fecha:that.changeFormat($jquery("#date").attr("value")),egresos:expenses};
            jQuery.ajax({
                type    : 'POST',
                url     : "/index.php/es/registro-ingresos-diarios/guardar-egresos",
                data    : dat,
                dataType: "json",
                success : function(data){
                    //alert(data.success);
                    if(data.success){
                        //jsonResponse=data;
                        that.putTemplate(that.el,"#success-save-exp",{});

                        //that.putTemplate("#typeIncome","#list-incomes",jsonResponse);
                                                   
                    }
                    else{
                        that.putTemplate("#cnt-pop","#msj-fail",{})
                    }
                    return false;
                }

            });
        }
        else{
            alert("faltan llenar campos");
        }
        

    },
    addExpense : function(){
        var str,
            //exp = $jquery("#typeExpense").attr("value"),
            con = $jquery("#concepto").attr("value"),
            amt = $jquery("#amount").attr("value"),
            dat = $jquery("#date").attr("value");
            if(con!=""&&amt!=""){
                str +="<tr id='row"+this.cont+"' >";
                //str +="<td id='type"+this.cont+"' >"+exp+"</td>";
                str +="<td id='conc"+this.cont+"' >"+con+"</td>";
                str +="<td id='amou"+this.cont+"' >"+amt+"</td>";
                str +="<td><a class='item edit' value='"+this.cont+"' href='#'></a><a class='item del' value='"+this.cont+"' href='#'></a></td>";
                str +="</tr>";
                //alert(str);
                $jquery("#concepto,#amount").attr("value","");
                $jquery("#tbody").prepend(str);
                this.cont++;
                this.totalAmount = parseFloat(this.totalAmount,10)+parseFloat(amt,10)
                $jquery("#total-amount").html(this.totalAmount);
            }
            else{
                alert("faltan datos");
            }
            
    },
    /*
    * updateRow : function que que actualiza con los valores nuevos la fila
    */
    updateRow :function(e){
        var target = $jquery(e.target),
            value = target.attr("value"),
            concep = $jquery("#editConce"+value).attr("value"),
            amount = $jquery("#editAmoun"+value).attr("value");
            if(concep!=""&&amount!=""){
                $jquery("#conc"+value).html(concep);
                $jquery("#amou"+value).html(amount);
                val = value;
                this.putObj(target.parent(),"#ctrlsButton",{});
            }
            else{
                alert("verifique los datos");
            }

    },
    editRow : function(e){
        var target=$jquery(e.target),
            elem = target.attr("value"),
            concep = $jquery("#conc"+elem).html(),
            amount = $jquery("#amou"+elem).html();
            //alert(concepto);
        $jquery("#conc"+elem).html("<input id='editConce"+elem+"' type='text' value='"+concep+"' />");
        $jquery("#amou"+elem).html("<input id='editAmoun"+elem+"' class='amount' type='text' value='"+amount+"' />");
        val =elem;
        this.putTemplate(target.parent(),"#saveButton",{});
    },
    delRow : function(e){

        var elem = $jquery(e.target).attr("value"),
            amt = $jquery("#amou"+elem).html();
        if(confirm("Desea Eliminar"+elem)){
            $jquery("#row"+elem).remove();
            this.cont--;
            this.totalAmount = parseFloat(this.totalAmount,10)-parseFloat(amt,10);
            $jquery("#total-amount").html(this.totalAmount);
        }
        else{

        }
    },
    /* putObject : funcion que recibe el id de una template y renderiza en el contenedor de la vista
    ****************************************************************************************************/
    putObj : function( cnt , templat , jsonResponse ){ 
        jsonResponse = jsonResponse;
        var template = _.template( $jquery( templat ).html() , jsonResponse );
        cnt.html( template );
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
    /* validCodeEmailButton :  funcion que verifica 
    ****************************************************************************************************/
    validCodeEmailButton : function(){
        dat = {email:$jquery("#emailVerify").attr("value"),codigo:$jquery("#code").attr("value")};
        $jquery.post('/index.php/inicio/validarEmailSendCode',dat,function(data){
            //no se ha validado password
            if(!data.success){
                that.showMessage("fail",data.msj);
            }
            else{                
                document.location = "#!/codigoConfirmacion/"+$jquery("#email").attr("value")+"/";
            }
        },"json");
    },
    /* deleteView : remueve todo el contenido de el contenedor
    ****************************************************************************************************/
    deleteView : function(){
        $jquery(this.el).children().remove();
    },
    changeFormat : function(date){
        var dat=date.split("/");
        return dat[2]+"-"+dat[1]+"-"+dat[0];
    },
    /*
    * dataGraph  : procesa la primera renderizacion de la data
    * @jsonResponse {json } : 
    ****************************************************************************/
    dataGraph : function(jsonResponse){
        var i,j=0,data=new Array(),aux,dateAux,cost = 0 ;
        jsonResponse=jsonResponse;
          
        for( i = 0 ; i < jsonResponse.length ;i++){
            
            // si es 0 entonces dateAux igual a la primera fecha
            if(i==0){
                dateAux = jsonResponse[i].fecha_egreso;
                cost = cost + parseFloat(jsonResponse[i].monto,10);
            }// entonces hacemos comparaciones
            else{
                if( dateAux == jsonResponse[i].fecha_egreso ){
                    cost = cost + parseFloat(jsonResponse[i].monto,10);
                }
                else{
                    //escribo el resultado
                    data[j] = new Array();
                    aux = dateAux.split("-");
                    data[j][0] = Date.UTC( parseInt(aux[0],10) , parseInt(parseInt(aux[1],10) -1), parseInt(aux[2],10) );
                    data[j][1] = roundCurrency(cost);
                    //incrementa
                    dateAux = jsonResponse[i].fecha_egreso;
                    cost = 0;
                    cost = cost + parseFloat(jsonResponse[i].monto,10); 
                    j++;
                }
            }
        }

        return data;
    },
    /*
    * dataMonthGraph  : procesa la primera renderizacion de la data por mes
    * @jsonResponse {json } : 
    ****************************************************************************/
    dataMonthGraph : function(jsonResponse){
        var i,j=0,data=new Array(),aux,dateAux,cost = 0 , aux1,aux2;
        jsonResponse=jsonResponse;
          
        for( i = 0 ; i < jsonResponse.length ;i++){
            
            // si es 0 entonces dateAux igual a la primera fecha
            if(i==0){
                aux1 = jsonResponse[i].fecha_egreso.split("-");
                dateAux = jsonResponse[i].fecha_egreso;
                cost = cost + parseFloat(jsonResponse[i].monto,10);
            }// entonces hacemos comparaciones
            else{
                aux2 =jsonResponse[i].fecha_egreso.split("-");
                if(i==jsonResponse.length -1){
                    data[j] = new Array();
                    aux = dateAux.split("-");
                    data[j][0] = Date.UTC( parseInt(aux[0],10) , parseInt(parseInt(aux[1],10) -1), parseInt(aux[2],10) );
                    data[j][1] = roundCurrency(cost);
                }
                else{
                    if( aux1[1] == aux2[1] ){
                        cost = cost + parseFloat(jsonResponse[i].monto,10);
                    }
                    else{
                        //escribo el resultado
                        console.log("aux1: "+aux1[1]+"--> aux2: "+aux2[1]);
                        data[j] = new Array();
                        aux = dateAux.split("-");
                        data[j][0] = Date.UTC( parseInt(aux[0],10) , parseInt(parseInt(aux[1],10) -1), parseInt(aux[2],10) );
                        data[j][1] = roundCurrency(cost);
                        //incrementa
                        aux1 = jsonResponse[i].fecha_egreso.split("-");
                        dateAux = jsonResponse[i].fecha_egreso;
                        cost = 0;
                        cost = cost + parseFloat(jsonResponse[i].monto,10); 
                        j++;
                    }
                }
            }
        }

        return data;
    },
    drawGrap :function(jsonResponse,opt){
        var dataGraph;
        switch(opt){
            case "days":
                dataGraph = this.dataGraph(jsonResponse);
            break;
            case "months":
                dataGraph = this.dataMonthGraph(jsonResponse);
            break;
        }
        
        
    var chart;
        Highcharts.setOptions({
            lang:{
                months : ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
                shortMonths : ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Set','Oct','Nov','Dic']
            }
        });
        
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'cnt-updatable',
                type: 'column'
            },
            title: {
                text: 'Egresos generales de : '+NAMEUSER
            },
            subtitle: {
                text: 'Fuente : controlEconómico'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Soles (s/.)'
                }
            },
            legend: {
                layout: 'vertical',
                backgroundColor: '#FFFFFF',
                align: 'left',
                verticalAlign: 'top',
                x: 480,
                y: 0,
                floating: true,
                shadow: true
            },
            tooltip: {
                formatter: function() {
                    return 'Fecha :<b>'+ numToDate(this.x) +
                        '</b><br/>Monto: S/.<b>'+ this.y +'</b>';
                }
            },
            
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Egresos',
                data: dataGraph
    
            }]
        });
        //alert(chart.dateFormat());
    
        

    },

    render : function(tmpl,jsonResponse){ 
        that =this;
        this.cont = 0;
        this.totalAmount =0;
        this.showTemplate( tmpl , jsonResponse );
        calendario.render($jquery("#date"));
        //this.loadValidateForm();
        this.point=0;
        $jquery(".filter").on('click',function(){
            that.filterTable(this);
            return false;
        });
        $jquery(".month").on('click',function(){
            that.filterMonth(this);
            return false;
        });

        $jquery(".filterGraph").on('click',function(){

            that.filterGraph(this);
            return false;
        });
        $jquery(".monthGraph").on('click',function(){

            that.monthGraph(this);
            return false;
        });
                
    }
    
});


$jquery(function(){
   

});
