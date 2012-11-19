<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Control Econ&oacute;mico</title>

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/css/basic.css"/>
    <!--[if IE]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection" /><![endif]-->
    <!--[if lte IE 7]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="screen, projection" /><![endif]-->
    <!--[if (gte IE 6)&(lte IE 8)]><script src="js/selectivizr-min.js"></script><![endif]-->
    
</head>
<body class="white">

    <div class="loggin">
        <div class="short-logo">
            <img src="/assets/images/logo.png"/>
        </div>
        
        <div class="sesion-start" method="post" action="">
            <a href="#!/nuevoUsuario/"  class="new-user-control"><?=lang('sesion.newUser')?></a>
            <div id="cnt-general">

            </div>
        </div>
    </div>
<!--    TEMPLATE PARA EL LOGIN    -->
<script id="login" type="text/html">

    <div class="cnt-form">
        <label><?=lang('sesion.user')?></label>
        <input name="usuario" id="usuario" class="notEmpty" type="text" placeholder="<?=lang('sesion.userPlaceholder')?>"/>
        <span class="est"></span>

        <label><?=lang('sesion.password')?></label>
        <input name="contrasenia" id="contrasenia" class="notEmpty" type="password" placeholder="<?=lang('sesion.passwordPlaceholder')?>"/>
        <span class="est"></span>
        <!-- mensaje -->
        <div id="msj" >
            <div class="float msg" id="msjText"><span></span></div>
            <div class="clear"></div>        
        </div>
        <!-- end mensaje -->
        <a href="#" class="lostPass"><?=lang('sesion.lostPassword')?></a>
        <button id="sesionStart" class="btn btn-success btn-log" type="submit"><?=lang('sesion.buttonAction')?></button>
    </div>

</script>
<!--    TEMPLATE PARA SENDEMAIL DE CONFIRMACION PARA REGISTRO DE NUEVO USUARIO    -->
<script id="sendMail" type="text/html">
    <div id="send-email"class="cnt-form">
        <p><?=lang('sesion.messageSendEmail')?></p>
        <label><?=lang('sesion.email')?></label>

        <input id="email" name="email" class="email" type="text" placeholder="<?=lang('sesion.emailPlaceholder')?>"/>
        <span class="est"></span>

        <label><?=lang('sesion.imageChange')?></label>
        <img id="img-captcha" class="captcha" src="/en/inicio/getCaptcha"/>
        <a class="reload" href="#">(Actualizar)</a>
        <input id="code-img" name="code-ing" class="notEmpty" type="text" placeholder=""/>
        <span class="est"></span>
        <div id="msj" >
            <div class="float msg" id="msjText"><span></span></div>
            <div class="clear"></div>        
        </div>
        <button id="sendEmailButton" class="btn btn-success btn-log"><?=lang('sesion.sendMail')?></button>
    </div>
</script>
<!--    TEMPLATE PARA CONFIRMAR EL CODIGO Q SE ENVIA AL CORREO ELECTRONICO    -->
<script id="comfirmCode" type="text/html">
<div id="code-confirm"class="cnt-form">
    <label>Email de cuenta:</label>
    <span id="emailCreateAccount" >control@control.com</span><br/><br/>
    <input id="emailVerify" type="hidden"/>
    <p>Ingresar el c&oacute;digo enviado a su correo clect&oacute;nico</p>
    <input id="code" name="code" type="text" placeholder="C&oacute;digo" />
    <div id="msj" >
        <div class="float msg" id="msjText"><span></span></div>
        <div class="clear"></div>        
    </div>
    <button id="validCodeEmailButton" class="btn btn-success btn-log">Validar</button>
</div>
</script>
    <div id="js">
        <!--    PLUGINS   -->
        <script src="/assets/js/plugins/jquery-1.7.2.min.js"></script>
        <!--    FRAMEWORK BACKBONEJS    -->
        <script src="/assets/js/plugins/underscore.js"></script>
        <script src="/assets/js/plugins/backbone.js"></script>
        <!-- PARA CIFRADO -->
        <script src="/assets/js/plugins/sha1-min.js" type="text/javascript"></script>
        <!--    VIEW BACKBONEJS    -->
        <script src="/assets/js/views/view_sesion_start.js"></script>
        <!--    MODELS BACKBONEJS    -->
        <script src="/assets/js/models/model_sesion_start.js"></script>

        
        
    </div>

</body>
</html>