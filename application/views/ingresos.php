<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta charset="utf-8">
    <title>Control Econ&oacute;mico - Ingresos</title>
    
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/css/basic.css"/>

    <link type="text/css" href="/assets/css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
    
    
    
    <!--[if IE]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection" /><![endif]-->
    <!--[if lte IE 7]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="screen, projection" /><![endif]-->
    <!--[if (gte IE 6)&(lte IE 8)]><script src="js/selectivizr-min.js"></script><![endif]-->
    
</head>
<body id="home">
<div id="wrapper" class="wrapper">
    <?php
        $menu="income";
        include("header.php");
    ?>
    <div class="wrap">
        <div class="wrap-cnt">
            <div class="wrap-white">
                <!-- -->                
                <div class="cnt-updatable menu">
                    <ul class="sub-menu">
                        <li><a href="#" class="sub-nav new-income">Nuevo</a></li>
                        <li><a href="#!/lista-ingresos/" class="sub-nav list-income">Lista</a></li>
                        <li><a href="#!/progreso-de-ingresos/" class="sub-nav line-graph">Gr&aacute;fico</a></li>
                        <div class="clear"></div>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <!-- CONTENEDOR ACTUALIZABLE -->
                <div id="cnt-updatable" class="cnt-updatable">
                    
                </div>
                <div class="news-cnt">
                    <?php include('msg-startup.php');?>
                </div>

                <div class="clear"></div>
            </div>
        </div>
    </div>
    <footer>
        <?php include('footer.php');?> 
    </footer>

    <div class=""></div>
    
</div>
<script id="newIncome" type="text/html">
<form id="save-income">
    <h3><?=lang('ingreso.title')?></h3>
    
    <label><?=lang('ingreso.type')?>:<a class="help" href="#" title="De que proviene el ingreso :) !"></a></label>
    <select class="all " name="typeIncome" id="typeIncome">
        <option value="0">--Seleccionar--</option>
    <% var index;  for(index = 0; index < jsonResponse.data.length; index++){
        %>
        <option value="<%=jsonResponse.data[index].id%>"><%=jsonResponse.data[index].concepto%></option>
        <%}%>
    </select>
    

    <div class="addMore">
        <a class="addIncome" href="#">Agregar tipo ingreso </a>
    </div>

    <label><?=lang('ingreso.concept')?>:<a class="help" href="#" title="Concepto o descripcion del ingreso"></a></label>
        <input class="all notEmpty" name="conceptIncome" id="conceptIncome" type="text" placeholder="<?=lang('ingreso.conceptPlaceholder')?>"/> 
    <span class="est"></span>

    <label><?=lang('ingreso.amount')?>:<a class="help" href="#" title="Monto de ingresos en soles o dolares"></a></label>
        <input class="all notEmpty" name="amount" id="amount" type="text" placeholder="000.00"/>
    <span class="est"></span>

    <label><?=lang('ingreso.date')?>:<a class="help" href="#" title="Fecha para llevar el control exacto de su econom&iacute;a personal"></a></label>
        <input class="all notEmpty" name="date" id="date" type="text" placeholder="<?=lang('ingreso.datePlaceholder')?>"/>
    <span class="est"></span>
    
    <div id="msj">
        <div id="msj-image" class="alert-icon"></div>
        <div class="float msg alert-icon" id="msjText"></div>
        <div class="clear"></div>
    </div>

    
    <div class="buttons">
        <button class="btn btn-danger">Cancelar</button>
        <button id="buttonSaveIncome" class="btn btn-success">Guardar</button>                            
    </div>
</form>
</script>
<!-- MENSAJE DE EXITO -->
<script id="msj-income-save-success" type="text/html">

</script>
<!-- RESUMEN DE INGRESO -->
<script id="resumeIncome" type="text/html">
<div class="report-table">
<a href="#" class="importExcel">Importar Excel</a>
<br/><br/>
<table class="table">
    <thead>
        <tr>            
            <th>Tipo</th>
            <th>Concepto</th>
            <th>Monto</th>                                        
            <th>Fecha Ingreso</th>
            <th>Fecha Guardada</th>
            <th>Acci&oacute;n</th>            
        </tr>
    </thead>
    <tbody>
    <%
    var index;
    for( index = 0; index < jsonResponse.data.length; index++){ %>
        <tr>
            <td><%=jsonResponse.data[index].typeIncome%></td>
            <td><%=jsonResponse.data[index].concept%></td>
            <td>s/. <%=jsonResponse.data[index].amount%></td>
            <td><%=jsonResponse.data[index].dateIngreso%></td>
            <td><%=jsonResponse.data[index].dateRegister%></td>         
            <td><a href="#" value="<%=jsonResponse.data[index].id%>"><img src="/assets/images/Search.png"/></a></td>
        </tr>
    <%}%>
    </tbody>
</table>
</div>    
</script>
<!--CONTENIDO DEL NUEVO INGRESO -->
<script id="new-income-tmpl" type="text/html">

    <label>Registro de tipo de ingreso:<a class="help" href="#" title="Monto de ingresos en soles o dolares"></a></label>
        <input class="all notEmpty" name="newTypeIncome" id="newTypeIncome" type="text" placeholder="Ingrese tipo de ingreso"/>
    <span class="est"></span>
    <div class="buttons">
        <button id="save-type-income" class="btn btn-success">Guardar</button>                            
    </div>
</script>
<!-- LISTA PARA LOS TIPOS DE INGRESO -->
<script id="list-incomes" type="text/html">
    <option value="0">--Seleccionar--</option>
    <%var index;

    for( index = 0;index < jsonResponse.data.length;index++){%>
        <option value="<%=jsonResponse.data[index].id%>" ><%=jsonResponse.data[index].concepto%></option>
    <%}%>
</script>
<!-- MSJ DE TEXTO -->
<script id="msj-success" type="text/html">
<h4>El nuevo ingreso ha sido guardado exitosamente</h4>
</script>
<script id="msj-fail" type="text/html">
<h4>No de pudo guardar el ingreso intente nuevamente</h4>
</script>
<!-- GRAFICO PROGRESO DE INGRESOS -->
<script id="graph-incomes" type="text/html">
<img src="/assets/images/chart.png"/>
</script>
<script id="msg-ingreso" type="text/html">
<h3>El ingreso ha sigo guardado con exito</h3>
</script>
<div id="js">
<!--    PLUGINS   -->
    <script src="/assets/js/plugins/jquery-1.7.2.min.js"></script>
    <script src="/assets/js/plugins/jquery-ui-1.8.18.custom.min.js"></script>
    <script src="/assets/js/plugins/jquery.tipsy.js"></script>    
    <!--    FRAMEWORK BACKBONEJS    -->
    <script src="/assets/js/plugins/underscore.js"></script>
    <script src="/assets/js/plugins/backbone.js"></script>
    <!-- PARA CIFRADO -->
    <script src="/assets/js/plugins/sha1-min.js" type="text/javascript"></script>
    <!--    VIEW BACKBONEJS    -->
    <script src="/assets/js/views/view_popUp.js"></script>
    <script src="/assets/js/views/viewShared.js"></script>
    <script src="/assets/js/views/view_ingresos.js"></script>
    <!--    MODELS BACKBONEJS    -->
    <script src="/assets/js/models/model_ingresos.js"></script>
</div>
</body>
</html>
