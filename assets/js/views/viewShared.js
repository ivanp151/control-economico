var $jquery = jQuery.noConflict();

	var datePicker = Backbone.View.extend({
		// `initialize()`: Automatically called upon instantiation. Where you make all types of bindings, _excluding_ UI events, such as clicks, etc.
		initialize: function(){
		    _.bindAll(this, 'render'); // fixes loss of context for 'this' within methods       
		    //this.render(); // not all views are self-rendering. This one is.		    
		},
		// `render()`: Function in charge of rendering the entire view in `this.el`. Needs to be manually called by the user.
		render: function(obj){
			obj.datepicker({
		        inline:true,
		        numberOfMonths:1,
		        minDate: 0, maxDate: "+6M ",
		        monthNames: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SETIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
		        dayNamesMin:['Do','Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		        dayNames:['DOMINGO','LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO'],
		        dateFormat: 'dd/mm/yy',
		        onSelect: function(date) {var fecha=date.split(",");$jquery("#fecha").html(fecha[1]+", "+fecha[2]+" DEL"+fecha[3]); 
		        var f_form=fecha[0].split("/"); /**/ $jquery("#fecha1").attr("value",f_form[2]+"-"+f_form[1]+"-"+f_form[0]);}
		    });             
		}
	});

/*function para redondear el valor en soles */
function roundCurrency(val){
    return parseFloat((Math.round(val)).toFixed(2));
}
/* function para convertir un numero a una fecha formato dd/mm/aaaa */
function numToDate(val){
	var date = new Date(val),
		month = (parseInt(date.getMonth(),10)+parseInt(1,10));
		month = (month>9)? month : ("0"+month);
    return date.getDate()+"/"+month+"/"+date.getFullYear();
}