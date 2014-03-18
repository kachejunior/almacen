<div class="span10 offset1">	
	<div class="span4 offset4">
			<form id="formulario" class="well">
				<!--<form class="span10 offset1" action="http://mujervf.fsbolivar.com.ve/usuarios/iniciar_session" method="post">-->
				<legend>Cambio de Clave</legend>
				<div class="controls">
					<div class="input-prepend span12">
						<label>Password Nuevo</label>
						<span class="add-on"><i class="icon-certificate"></i></span>
						<input class="span11" type="password" name="pass_nuevo" placeholder="Password" required>
					</div>
				</div>
				<div class="controls">
					<div class="input-prepend span12">
						<label>Repetir Password</label>
						<span class="add-on"><i class="icon-certificate"></i></span>
						<input class="span11" type="password" name="pass_repetir" placeholder="Password" required>
					</div>
				</div>
				<div class="controls" id="_alerta">
				</div>
				<div class="controls">
					<button type="submit" class="btn btn-primary" id="_cambio_clave" data-loading-text="Verificando....">Guardar</button>
				</div>
		</form>
	</div>
</div>

<script src="<?php echo base_url();?>media/funcion_js/fn_login.js"></script>