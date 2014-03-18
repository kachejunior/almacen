<form class="span10 offset1">
	<!--<form class="span10 offset1" action="http://mujervf.fsbolivar.com.ve/general/agregar/<?php echo $tb;?>" method="post">-->
	<legend>Administración de <?php echo $titulo_form; ?></legend>
		<!-- Button to trigger modal -->
		<div class="control-group">
			<a href="#myModal" role="button" class="btn btn-inverse pull-right" data-toggle="modal" style="margin-bottom:10px; ">
				<i class="icon-plus-sign icon-white"></i> Agregar <?php echo $titulo_singular_form;?></a>
		</div>
		<table id="tabla" class="table table-hover table-bordered table-striped">
			<thead>
				<tr style="background:#000; color: #FFF">
					<th class="span2">Id</th>
					<th class="span8">Nombre</th>
					<th class="span2">Opción</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ($lista as $row)
			{
				$str = '<tr>'.
					'<td class="centrado">'.$row->id.'</td>'.
					'<td>'.strtoupper($row->nombre).'</td>'.
					'<td class="centrado">'.
						'<a class="btn btn-mini btn-warning" onclick="get('.$row->id.')">'.
						' <i class="icon-wrench icon-white"></i></a>'.
						' <a class="btn btn-mini btn-danger" onclick="eliminar('.$row->id.')">'.
						' <i class="icon-minus icon-white"></i></a>'.
					'</td>'.
					'</tr>';
				echo $str;
			}
			?>
			</tbody>
		</table>




<div id="myModal" class="modal hide fade span8 offset2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="left:0;">
	<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4>Datos de <?php echo $titulo_singular_form; ?></h4>
  </div>
  <div class="modal-body">
		<div class="controls">
			<div class="input-prepend span3">
				<label>Id</label>
				<span class="add-on"><i class="icon-barcode"></i></span>
				<input class="span10" name="id" type="text" placeholder="Id" disabled>
			</div>
		</div>
		<div class="controls">
			<div class="input-prepend span8 offset1">
				<label>Nombre</label>
				<span class="add-on"><i class="icon-info-sign"></i></span>
				<input class="span10" name="nombre" type="text" placeholder="Nombre" maxlength="60" required>
			</div>		
		</div>
	</div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
		<button class="btn btn-primary pull-right" type="button" id="_guardar"><i class="icon-ok icon-white"></i> Guardar</button>
												<!--<input type="submit">-->

  </div>
</div
</form>

<script type="text/javascript">var tb = '<?php echo $tb;?>';</script>
<script src="<?php echo base_url();?>media/funcion_js/fn_general.js"></script>