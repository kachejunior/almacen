<h1>Inventario</h1>
<table id="tabla" class="table table-hover table-bordered table-striped" >
		<thead>
			<tr style="background:#000; color: #FFF ">
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">Sede</th>
				<th style="text-align: center;">TIpo de Articulo</th>
				<th style="text-align: center;">Nombre de Articulo</th>
				<th style="text-align: center;">Color</th>
				<th style="text-align: center;">Cantidad Actual</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($articulos as $row)
			{
				$str = '<tr style="text-transform: uppercase; border:solid 1px #000">'.
					'<td  style="text-align: center;">'.$row->id.'</td>'.
					'<td  style="text-align: center;">'.$row->nombre_sede.'</td>'.	
					'<td  style="text-align: center;">'.$row->nombre_gerencia.'</td>'.
					'<td  style="text-align: center;">'.$row->nombre.'</td>'.
					'<td  style="text-align: center;">'.$row->ubicacion.'</td>'.		
					'<td  style="text-align: center;">'.$row->cantidad_disponible.'</td>'.
					'</tr>';
				echo $str;
			}
			?>
		</tbody>
	</table>


<?php 
	header("Content-Disposition: attachment; filename=Inventario_".date('d-m-Y').".ods");
	header("Content-Type: application/vnd.oasis.opendocument.spreadsheet");
?>