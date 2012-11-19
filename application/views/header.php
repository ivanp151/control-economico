<header>
    <div class="logo">
        <img src="/assets/images/logo.png"/>
    </div>  
    <div class="cnt-head">
        <div class="user-info">
            <div class="cnt-user">
                <div class="user-name">
                    <span class="name"><?php echo $this->session->userdata('name_user');?></span><br/>
                    <span class="user"><?php echo $this->session->userdata('user_user');?></span>
                </div>
                <div class="user-img">
                    <img src="/assets/images/fotosPerfil/<?php echo $this->session->userdata('url_foto');?>"/>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <nav>
            <ul>
                
                <!--<li><a href="portal-control-economico" class="<?php echo ($menu=="home")?"nav-select":"";  ?>"><?=lang('header.home')?></a></li>-->
                <li><a href="/<?php echo $this->lang->lang();?>/registro-ingresos-diarios" class="<?php echo ($menu=="income")?"nav-select":""; ?>"><?=lang('header.income')?></a></li>
                <!--<li><a href="#" class="<?php echo ($menu=="home")?"nav-select":"";  ?>">Inversi&oacute;n</a></li>-->
                <li><a href="/<?php echo $this->lang->lang();?>/registro-egresos-diarios" class="<?php echo ($menu=="expenses")?"nav-select":"";  ?>"><?=lang('header.expenses')?></a></li>
                <!--<li><a href="/<?php echo $this->lang->lang();?>/registro-prestamos-diarios" class="<?php echo ($menu=="loans")?"nav-select":"";  ?>"><?=lang('header.loans')?></a></li>
                <li><a href="/<?php echo $this->lang->lang();?>/mis-datos-personales" class="<?php echo ($menu=="myaccount")?"nav-select":"";  ?>"><?=lang('header.myAccount')?></a></li>
                <li><a href="/<?php echo $this->lang->lang();?>/reporte-cuentas" class="<?php echo ($menu=="report")?"nav-select":"";  ?>"><?=lang('header.reports')?></a></li>
            -->
                <li><a href="/<?php echo $this->lang->lang();?>/inicio/cerrar-session" class="last out"><?=lang('header.out')?></a></li>
            </ul>

        </nav>
    </div>
    </header>