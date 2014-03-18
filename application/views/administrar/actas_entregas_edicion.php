<form class="span10 offset1">
	<!--<form class="span10 offset1" action="http://sistemas.fsbolivar.com.ve/inventario/buscar" method="post">-->
	<legend>Acta de Entrega</legend>
	<div class="row-fluid">
		<div class="controls">
			<div class="input-prepend span3">
				<label>Id</label>
				<span class="add-on"><i class="icon-barcode"></i></span>
				<input class="span10" name="id" type="text" placeholder="Id" disabled value="<?php echo $actas_entregas_detalles->id; ?>">
			</div>
		</div>
		<div class="controls">
			<div class="input-prepend span3">
				<label>Fecha</label>
				<span class="add-on"><i class="icon-calendar"></i></span>
				<input class="span10 fecha fecha2" name="fecha_entrega" type="text" placeholder="dd/mm/aaaa" value="<?php echo $actas_entregas_detalles->fecha_entrega; ?>">
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="controls">
			<div class="input-prepend span3">
				<label>Sede</label>
				<span class="add-on"><i class="icon-home"></i></span>
				<select class="span10" name="sede" id="sede">
					<option value="<?php echo $actas_entregas_detalles->id_sede; ?>"><?php echo $actas_entregas_detalles->nombre_sede; ?></option>
					<option>--Sede--</option>
					<?php
					foreach ($sedes as $row) {
						$str = '<option value =' . $row->id . '>' . $row->nombre . '</option>';
						echo $str;
					}
					?>
				</select>
			</div>
		</div>
		<div class="controls">
			<div class="input-prepend span3">
				<label>Gerencia</label>
				<span class="add-on"><i class="icon-briefcase"></i></span>
				<select class="span10" name="gerencia" id="gerencia">
					<option value="<?php echo $actas_entregas_detalles->id_gerencia; ?>"><?php echo $actas_entregas_detalles->nombre_gerencia; ?></option>
					<option>--Gerencia--</option>
					<?php
					foreach ($gerencias as $row) {
						$str = '<option value =' . $row->id . '>' . $row->nombre . '</option>';
						echo $str;
					}
					?>
				</select>
			</div>
		</div>
		<div class="controls">
			<div class="input-prepend span3">
				<label>Realizado por</label>
				<span class="add-on"><i class="icon-user"></i></span>
				<select class="span10" name="cedula" id="sede">
					<option value="<?php echo $actas_entregas_detalles->cedula_usuario; ?>"><?php echo $actas_entregas_detalles->nombre_usuario . ' ' . $actas_entregas_detalles->apellido_usuario; ?></option>
					<option>--Usuario--</option>
<?php
foreach ($usuarios as $row) {
	$str = '<option value =' . $row->cedula . '>' . $row->nombre . ' ' . $row->apellido . '</option>';
	echo $str;
}
?>
				</select>
			</div>
		</div>
		<div class="controls">
			<div class="input-prepend span3">
				<label>Entregado a</label>
				<span class="add-on"><i class="icon-user"></i></span>
				<input class="span10" name="entregado_a" type="text" placeholder="Entregado a" value="<?php echo $actas_entregas_detalles->entregado_a; ?>">
			</div>
		</div>
		<!--</form>-->
	</div>
	<div class="row-fluid">
		<div class="controls">
			<div class="input-prepend span12">
				<label>Nota de entrega</label>
				<span class="add-on"><i class="icon-text-height"></i></span>
				<textarea class="span10" rows="10" name="nota"><?php echo $actas_entregas_detalles->nota; ?></textarea>
			</div>
		</div>
	</div>
	<div class="row-fluid" style="margin-top: 20px;">
		<div class="accordion" id="accordion2">
			<div class="accordion-group" style="border-color:#FFF ">
				<div class="accordion-heading accordion-toggle" style=" height:25px;">
					<a class="collapsed text-info" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="margin-top:5px; " class="btn btn-primary">
						Agregar Articulos <i class="icon-search"></i>
					</a>			
				</div>
				<div id="collapseOne" class="accordion-body collapse" style="height: 0px;">
					<div class="accordion-inner span12">
						<div class="control-group">
							<!--<form class="span10 offset1" action="<?php echo base_url(); ?>inventario/getArticulos" method="post">-->
							<div class="controls">
								<div class="input-prepend span3">
									<label>Tipo Articulo</label>
									<span class="add-on"><i class="icon-list"></i></span>
									<select class="span9" name="_tipo_articulo" id="_tipo_articulo" onchange="cargarArticulos();">
										<option value="">--Tipo--</option>
<?php
foreach ($tipos_articulos as $row) {
	$str = '<option value =' . $row->id . '>' . $row->nombre . '</option>';
	echo $str;
}
?>
									</select>
								</div>		
							</div>
							<div class="controls">
								<div class="input-prepend span3">
									<label>Articulos</label>
									<span class="add-on"><i class="icon-calendar"></i></span>
									<select class="span9" name="_id_articulo" id="_id_articulo">
										<option>--Todos--</option>
									</select>
								</div>
							</div>
							<div class="controls">
								<div class="input-prepend span3">
									<label>Cantidad</label>
									<span class="add-on"><i class="icon-barcode"></i></span>
									<input class="span9" name="_cantidad" type="text" placeholder="Cantidad" >
								</div>
							</div>
							<div class="controls">
								<div class="input-prepend span1">
									<label style="color:#fff;">Agregar</label>
									<button class="btn btn-primary " type="button" id="_agregar_articulo"><i class="icon-list icon-white"></i> Agregar</button>
									<!--<input type="submit">-->

								</div>		
							</div>

						</div>
					</div>
				</div>
			</div>	
		</div>
		<table id="tabla_item" class="table table-hover table-bordered table-striped">
			<thead>
				<tr style="background:#d44413; color: #FFF">
					<th class="span1">N° Item</th>
					<th class="span6">Articulo</th>
					<th class="span2">Color</th>
					<th class="span1">Cantidad</th>
					<th class="span2">Edicion</th>
				</tr>
			</thead>
			<tbody>

				<?php
				$i = 0;
				foreach ($lista_articulo as $row) {
					$i = $i + 1;
					$str = '<tr>' .
									'<td class="centrado">' . $i . '</td>' .
									'<td>' . $row->nombre_articulo . '</td>' .
									'<td>' . $row->color_articulo . '</td>' .
									'<td>' . $row->cantidad . '</td>' .
									'<td class="centrado">' .
									' <a class="btn btn-mini btn-danger" onclick="eliminarArticulo(' . $row->id_articulo . ')">' .
									' <i class="icon-minus icon-white"></i></a>' .
									'</td>' .
									'</tr>';
					echo $str;
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="row-fluid">
		<div class="controls">
			<div class="btn-group">
				<button class="btn btn-primary" type="button" id="_guardar"><i class="icon-ok icon-white"></i> Guardar y Continuar</button>
				<a href="<?php echo base_url() . 'entregas/pdf_acta_entrega/' . $actas_entregas_detalles->id; ?>" class="btn btn-primary" target="_blank"><i class="icon-download-alt icon-white"></i> PDF</a>
				<a href="<?php echo base_url() . 'entregas'; ?>" class="btn btn-primary"><i class="icon-backward icon-white"></i> Regresar</a>

			</div>
		</div>
	</div>
</form>

<script type="text/javascript">var tb = '<?php echo $tb; ?>';</script>
<script src="<?php echo base_url(); ?>media/funcion_js/fn_actas_entregas.js"></script>