<form class="span10 offset1">
	<!--<form class="span10 offset1" action="http://sistemas.fsbolivar.com.ve/entregas/buscar" method="post">-->
	<legend>Control de Entregas Realizadas</legend>
		<!-- Button to trigger modal -->
		<div class="accordion" id="accordion2">
                <div class="accordion-group" style="border-color:#FFF ">
                  <div class="accordion-heading accordion-toggle" style=" height:25px;">
                    <a class="collapsed text-info" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="margin-top:5px; ">
                     Busqueda Avanzada <i class="icon-search"></i>
                    </a>
				  <a href="<?php echo base_url().'entregas/nuevo'; ?>" class="btn-inverse btn-small pull-right">
				  <i class="icon-plus-sign icon-white"></i> Crear nuevo acta de entrega</a>						
                  </div>
                  <div id="collapseOne" class="accordion-body collapse" style="height: 0px;">
                    <div class="accordion-inner span12">
						<div class="control-group">
							<div class="controls">
								<div class="input-prepend span3">
									<label>Sede</label>
									<span class="add-on"><i class="icon-home"></i></span>
									<select class="span9" name="_sede" id="_sede">
										<?php
										if (($this->session->userdata('grupo_usuario') == 1) or ($this->session->userdata('grupo_usuario') == 2)) {
											echo '<option value="">--Sede--</option>';
											foreach ($sedes as $row) {
												$str = '<option value =' . $row->id . '>' . $row->nombre . '</option>';
												echo $str;
											}
										}

										if ($this->session->userdata('grupo_usuario') == 3) {
											echo '<option value="1">Caroni</option>';
										}
										if ($this->session->userdata('grupo_usuario') == 4) {
											echo '<option value="2">Heres</option>';
										}
										?>
									</select>
								</div>		
							</div>
							<div class="controls">
								<div class="input-prepend span3">
									<label>Gerencia</label>
									<span class="add-on"><i class="icon-list"></i></span>
									<select class="span9" name="_gerencia" id="_gerencia">
										<option value="">--Tipo--</option>
										<?php 
											foreach ($gerencias as $row)
											{
												$str = '<option value ='.$row->id.'>'.$row->nombre.'</option>';
												echo $str;
											} 		
										?>
									</select>
								</div>		
							</div>
							<div class="controls">
								<div class="input-prepend span3">
									<label>Fecha Inicio Entrega</label>
									<span class="add-on"><i class="icon-calendar"></i></span>
									<input class="span9 fecha" name="_fecha_inicio" type="text" placeholder="Fecha Inicio">
								</div>
							</div>
							<div class="controls">
								<div class="input-prepend span3">
									<label>Fecha Final Entrega</label>
									<span class="add-on"><i class="icon-calendar"></i></span>
									<input class="span9 fecha" name="_fecha_final" type="text" placeholder="Fecha Final">
								</div>
							</div>
							<div class="controls">
									<div class="input-prepend span1">
										<label style="color:#fff;">Buscar</label>
										<button class="btn btn-primary " type="button" id="_buscar"><i class="icon-search icon-white"></i></button>
										<button class="btn btn-primary " type="button" id="_exportar_xls"><i class="icon-download-alt icon-white"></i></button>
										
										<!--<input type="submit">-->
									</div>		
							</div>
							
                    </div>
                  </div>
                </div>
              </div>	
		</div>
	<!--</form>-->
		<table id="tabla" class="table table-hover table-bordered table-striped">
			<thead>
				<tr style="background:#000; color: #FFF">
					<th class="span1">Id</th>
					<th class="span2">Fecha de Entrega</th>
					<th class="span2">Sede</th>
					<th class="span3">Gerencia</th>
					<th class="span3">Encargado</th>
					<th class="span1">Opción</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ($actas_entregas as $row)
			{
				$str = '<tr>'.
					'<td class="centrado">'.$row->id.'</td>'.
					'<td>'.$row->fecha_entrega.'</td>'.
					'<td>'.$row->nombre_sede.'</td>'.
					'<td>'.$row->nombre_gerencia.'</td>'.
					'<td>'.$row->nombre_usuario.'</td>'.
					'<td class="centrado">'.
						'<a class="btn btn-mini btn-warning" href="'.  base_url().'entregas/edicion/'.$row->id.'">'.
						' <i class="icon-search icon-white"></i></a>';
				if ($this->session->userdata('grupo_usuario') == 1) {
					$str = $str . '<a class="btn btn-mini btn-danger" onclick="eliminar(' . $row->id . ')"><i class="icon-minus icon-white"></i></a>';
				}
				$str = $str . '</td></tr>';
				echo $str;
			}
			?>
			</tbody>
		</table>

</form>

<script type="text/javascript">var tb = '<?php echo $tb;?>';</script>
<script type="text/javascript">var grupo_usuario = '<?php echo $this->session->userdata('grupo_usuario') ; ?>';</script>
<script src="<?php echo base_url();?>media/funcion_js/fn_actas_entregas.js"></script>