<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <?php include_once('tagHead.php');?>
    <meta charset="utf-8">
    <title>Control Econ&oacute;mico</title>
    
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/css/basic.css"/>
    <link rel="stylesheet" href="/assets/css/redmond/jquery-ui-1.8.23.custom.css"/>

    <!--[if IE]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection" /><![endif]-->
    <!--[if lte IE 7]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="screen, projection" /><![endif]-->
    <!--[if (gte IE 6)&(lte IE 8)]><script src="js/selectivizr-min.js"></script><![endif]-->
    
</head>
<body id="home">
<div id="wrapper" class="wrapper">
    
    <?php
        $menu="expenses";
        include("header.php");
    ?>
    <div class="wrap">
        <div class="wrap-cnt">
            <div class="wrap-white">
                <div class="cnt-updatable menu">
                    <ul class="sub-menu">
                        <li><a href="#!/egresos/" class="sub-nav new-income">Nuevo</a></li>
                        <li><a href="#!/lista-egresos/" class="sub-nav list-income">Lista</a></li>
                        <li><a href="#!/grafico-egresos/" class="sub-nav line-graph">Gr&aacute;fico</a></li>
                        <div class="clear"></div>
                    </ul>
                    <ul class="controls hide" >
                        <li><a id="ctrl1" class="filter" value="ok" href="#">día</a></li>
                        <li><a id="ctrl2" class="month" value="ok" href="#">Mes</a></li>
                        <!--<li><a class="filter" value="y" href="#">Año</a></li>-->
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <div id="cnt-updatable" class="cnt-updatable">
                    <div class="loadding"></div>
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

<script id="new-expenses" type="text/html">
<h3>Registra tu lista de egresos</h3><br/>
<b>Fecha de registro</b>
<input class="smaller" name="date" id="date" type="text" placeholder="12/12/2012"/>

<table class="table">
    <thead>
        <tr>            
            <!--<th>Tipo Ingreso</th>-->
            <th>Concepto</th>
            <th>Monto</th>
            <th>Acci&oacute;n</th>
        </tr>
        <tr>
            <!--<th>
                <select id="typeExpense" class="smaller"  name="type">
                    <option value="Activo">Activo</option>
                    <option value="Pasivo">Pasivo</option>
                </select>
            </th>-->
            <th>
                <input class="smaller" name="concepto" id="concepto" type="text" placeholder="Concepto"/>
            </th>
            <th>
                <input class="smaller" name="amount" id="amount" type="text" placeholder="000.00"/>
            </th>
            <th>
                <button id="add-expense" class="btn btn-success">Agregar</button>
            </th>
        </tr>
        
    </thead>
    <tbody id="tbody">

    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">TOTAL</td>
            <td><b>S/.</b><b id="total-amount">0.00</b></td>
        </tr>
    </tfoot>
</table>
<div class="right">
    <button id="save-list-expenses" class="btn btn-success">Guardar Lista</button>
</div>
</script>
<script id="msg-empty" type="text/html">
<h1>No existe ningun registro. haga click <a href="#">aqui</a></h1>
</script>
<!-- LISTA DE EGRESOS-->
<script id="list-egresos" type="text/html" >
<a href="#" class="importExcel">Importar Excel</a>
<br/><br/>
<table class="table">
    <thead>
        <tr>
            <th>N&deg;.</th>
            <th>Fecha</th>
            <th>Concepto</th>
            <th>Monto</th>
        </tr>
    </thead>
    <tbody>
<% var i,aux;
    for(i=0; i<jsonResponse.length;i++){
        aux = jsonResponse[i].fecha_egreso.split("-"); %>
        <tr id="row<%=jsonResponse[i].id_egreso%>" value="<%=aux[2]%>/<%=aux[1]%>/<%=aux[0]%>" class="rowExp">
            <td><%=jsonResponse[i].id_egreso%></td>
            <td><%=aux[2]%>/<%=aux[1]%>/<%=aux[0]%></td>
            <td><%=jsonResponse[i].concepto%></td>
            <td value="<%=jsonResponse[i].monto%>"> <b>S/. </b><%=jsonResponse[i].monto%></td>
            <td>
                <a class="edit-in-list item edit" href="#" value="<%=jsonResponse[i].id_egreso%>"></a>
                <a class="dele-in-list item del" href="#" value="<%=jsonResponse[i].id_egreso%>"></a>
            </td>
        </tr>
<%}%>
    </tbody>
</table>
</script>
<!-- GRAFICOS-->
<script id="graph-egresos" type="text/html" >
<table class="table">
    <thead>
        <tr>
            <th>Concepto</th>
            <th>Monto</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
<% var i;
    for(i=0; i<jsonResponse.length;i++){%>
        <tr>
            <td><%=jsonResponse[i].id_egreso%></td>
            <td><%=jsonResponse[i].concepto%></td>
            <td><%=jsonResponse[i].fecha_egreso%></td>
        </tr>
<%}%>
    </tbody>
</table>
</script>
<!-- button save -->
<script id="saveButton" type="text/html">
    <a href='#' class='item save' value='<%=val%>'></a>
</script>
<!-- buttons edit and delete -->
<script id="ctrlsButton" type="text/html">
    <a class="edit-in-list item edit" href="#" value="<%=val%>"></a>
    <a class="dele-in-list item del" href="#" value="<%=val%>"></a>
</script>
<!-- MENSAJE DE EXITO SI HA SIDO GUARDADA LA LISTA DE EGRESOS -->
<script id="success-save-exp" type="text/html">
    <h1>Su lista ha sido guardado exitosamente</h1>
</script>
<div id="js">
    <!--    PLUGINS   -->
    <script src="/assets/js/plugins/jquery-1.7.2.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <!--    FRAMEWORK BACKBONEJS    -->
    <script src="/assets/js/plugins/underscore.js"></script>
    <script src="/assets/js/plugins/backbone.js"></script>
    <script src="/assets/js/plugins/jquery-ui-1.8.18.custom.min.js"></script>
    <!-- PARA CIFRADO -->
    <script src="/assets/js/plugins/sha1-min.js" type="text/javascript"></script>
    <!--    VIEW BACKBONEJS    -->
    <script src="/assets/js/views/viewShared.js"></script>
    <script src="/assets/js/views/view_egresos.js"></script>
    <!--    MODELS BACKBONEJS    -->
    <script src="/assets/js/models/model_egresos.js"></script>
</div>
</body>
</html>
