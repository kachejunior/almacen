<div class="navbar  navbar-fixed-top ">
      <div class="navbar-inner"  style="margin-bottom:40px;">
	 <div class="container">
		<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		 <a class="brand " href="#">Almacen FSB</a>
	<div class="nav-collapse collapse">
        
		<?php if( $this->session->userdata('nombre')==TRUE) { ?>
        <ul class="nav">
         <li><a href="<?php echo base_url()?>estadistica">Estadisticas</a></li>
		<li><a href="<?php echo base_url()?>entregas">Actas Entregas</a></li>
		<li><a href="<?php echo base_url()?>salidas">Actas Recepcion</a></li>
		<li><a href="<?php echo base_url()?>inventario">Inventario</a></li>
		<?php if($this->session->userdata('grupo_usuario')==1) { ?>
		<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administracion <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li class="nav-header">Adm. Sistemas</li>
					  <li><a href="<?php echo base_url()?>general/admin/sedes">Sedes</a></li>
					  <li><a href="<?php echo base_url()?>general/admin/status_actividades">Estatus Actividad</a></li>
					  <li><a href="<?php echo base_url()?>general/admin/gerencias">Gerencias</a></li>
					  <li><a href="<?php echo base_url()?>lugar">Lugares</a></li>
					   <li><a href="<?php echo base_url()?>general/admin/tipos_articulos">Tipos Articulos</a></li>
                          <li class="nav-header">Adm. Usuarios</li>
                          <li><a href="<?php echo base_url()?>general/admin/status_usuarios">Status de usuario</a></li>
                          <li><a href="<?php echo base_url()?>general/admin/grupos_usuarios">Grupo de usuario</a></li>
                          <li><a href="<?php echo base_url()?>usuarios">Usuarios</a></li>
                        </ul>
          </li>
		<?php }?>
        </ul>
		<ul class="nav pull-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="icon-user icon-white"></i>
					<?php echo $this->session->userdata('nombre');?> 
					<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo base_url()?>cambiar_password">Cambiar Clave</a></li>
					<li class="divider"></li>
					<li><a href="<?php echo base_url()?>usuarios/cerrar_session">Cerrar Session</a></li>
				</ul>
			</li>
		</ul>
		<?php }?>
      </div>
	 </div>
	</div>
</div>
<div style="height: 50px;">
	<input type="hidden" id="tipo_usuario"  name="tipo_usuario"  value="<?php echo $this->session->userdata('grupo_usuario'); ?>">
</div>