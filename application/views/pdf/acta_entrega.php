<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
		<link href="<?php echo base_url();?>media/css/pdf.css" rel="stylesheet" media="all">
	</head>
	<body>
		<p style="text-align: center; line-height:150%;"><b>ACTA DE ENTREGA</b><br/>(ID <?php echo strtoupper($actas_entregas_detalles->id);  echo ' '.strtoupper($actas_entregas_detalles->nombre_sede)?>)<br></p>

		<table class="ecabezado_pdf">
			<tr>
				<td class="fecha"><strong>FECHA</strong></td>
				<td class="nombre"><?php echo $actas_entregas_detalles->fecha_entrega?></td>
			</tr>
			<tr>
				<td class="fecha"><strong>PARA</strong></td>
				<td class="nombre"><?php echo strtoupper($actas_entregas_detalles->entregado_a)?></td>
			</tr>
			<tr>
				<td class="gerencia"><strong>GERENCIA</strong></td>
				<td class="nombre"><?php echo strtoupper($actas_entregas_detalles->nombre_gerencia)?></td>
			</tr>
		</table>

		<table class="datos_solicitud" style="margin-top: 20px;">
			<tr>
				<td>Por medio del presente acta hago constar la entrega de los siguientes materiales:</td>
			</tr>
		</table>
		<table style="width:100%">
			<thead>
				<tr>
					<th>N° Item</th>
					<th>Articulo</th>
					<th>Color</th>
					<th>Cantidad</th>
				<tr>
			</thead>
			<tbody>
				<?php
			$i=0;
			foreach ($lista_articulo as $row)
			{
				$i= $i+1;
				$str = '<tr>'.
					'<td style="text-align:center">'.$i.'</td>'.
					'<td style="text-align:center">'.$row->nombre_articulo.'</td>'.
					'<td style="text-align:center">'.$row->color_articulo.'</td>'.
					'<td style="text-align:center">'.$row->cantidad.'</td>'.
					'</tr>';
				echo $str;
			}
			?>
			</tbody>
		</table>
		<table class="datos_solicitud" style="margin-top: 20px;">
			<tr>
				<td><strong>Observaciones:</strong></td>
			</tr>
		</table>
		<table class="datos_solicitud" style="margin-top: 10px;">
			<tr>
				<td ><?php echo str_replace("\n", '<br>',$actas_entregas_detalles->nota); ?></td>
			</tr>
		</table>

		<table class="firmas" style="margin-top: 200px; border:0px;">
			<tr>
				<td class="centrado">___________________________</td>
				<td class="centrado" style="width:300px;"></td>
				<td class="centrado">___________________________</td>
			</tr>
			<tr>
				<td class="municipio centrado" style="text-align:center">FIRMA DEL ENCARGADO</td>
				<td class="municipio centrado"></td>
				<td class="municipio centrado" style="text-align:center">FIRMA DEL USUARIO</td>
			</tr>
			<tr>
				<td class="centrado" style="text-align:center"><?php echo strtoupper($actas_entregas_detalles->nombre_usuario).' '.strtoupper($actas_servicio_detalles->apellido_usuario); ?></td>
				
			</tr>
			<tr><td class="centrado" style="text-align:center">C.I. <?php echo strtoupper($actas_entregas_detalles->cedula_usuario); ?></td></tr>
		</table>

	</body>
</html>