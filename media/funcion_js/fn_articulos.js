var mensaje_exito = '<div class="alert alert-success" id="_mensaje"><button type="button" class="close" data-dismiss="alert">×</button><strong>Guardado con Exito!</strong></div>';
var mensaje_error_datos = '<div class="alert alert-error" id="_mensaje"><button type="button" class="close" data-dismiss="alert">×</button><strong>Error al Guardar!</strong> Verifica los datos (La cedula puede ser repetida o faltan campos)</div>';

function vacio(q) {
	for (i = 0; i < q.length; i++) {
		if (q.charAt(i) != " ") {
			return false;
		}
	}
	return true;
}

function limpiar_form() {
	var item = ['[name=id]', '[name=nombre]', '[name=sede]', '[name=gerencia]', '[name=ubicacion]'];

	for (var i = 0; i < item.length; i++) {
		$(item[i]).val('');
	}
	$('[name=cantidad_disponible]').val(0);
	$('#cantidad_disponible').prop('disabled', false);
	$('#_mensaje_alerta').append('');
}

function verificar() {
	var item = ['[name=nombre]', '[name=sede]', '[name=gerencia]'];

	for (var i = 0; i < item.length; i++) {
		if (vacio($(item[i]).val())) {
			$(item[i]).focus();
			return false;
		}
	}
	return true;
}

function actualizar() {
	var url = base_url + 'inventario/buscar';
	$.ajax({
		url: url,
		data: null,
		processData: 'false',
		dataType: 'json',
		type: "POST",
		success: function(datos) {
			$('#tabla tbody').html('');
			for (var i = 0; i < datos.length; i++) {
				cadena = '<tr>' +
								'<td class="centrado">' + datos[i].id + '</td>' +
								'<td>' + datos[i].nombre_sede + '</td>' +
								'<td class="centrado">' + datos[i].nombre_gerencia + '</td>' +
								'<td class="centrado">' + datos[i].nombre + '</td>' +
								'<td class="centrado">' + datos[i].ubicacion+ '</td>' +
								'<td class="centrado">' + datos[i].cantidad_disponible + '</td>' +
								'<td class="centrado"><a class="btn btn-mini btn-warning" onclick="get(' + datos[i].id + ')">' +
								'<i class="icon-wrench icon-white"></i></a>' +
								' <a class="btn btn-mini btn-danger" onclick="eliminar(' + datos[i].id + ')">' +
								'<i class="icon-minus icon-white"></i></a></td>' +
								'</tr>';
				$('#tabla tbody').append(cadena);
				if (!$('#tablal tbody').is(':visible')) {
					$('#tabla caption').click();
				}
			}
		},
		error: function() {
			alert('Se ha producido un error de actualizacion');
		}
	});
	return true;
}

function get(id) {
	var url = base_url + 'inventario/get/' + id;
	//alert(url);
	//$(location).attr('href', url)
	$.ajax({
		url: url,
		data: null,
		processData: 'false',
		dataType: 'json',
		type: "POST",
		success: function(datos) {
			$('#form_articulo').modal('show');
			//alert(datos.id+' '+datos.nombre);
			$('[name=id]').val(datos.id);
			$('[name=nombre]').val(datos.nombre);
			$('[name=sede]').val(datos.id_sede);
			$('[name=gerencia]').val(datos.id_gerencia);
			$('[name=ubicacion]').val(datos.ubicacion);
			$('[name=cantidad_disponible]').val(datos.cantidad_disponible);
			$('#cantidad_disponible').prop('disabled', true);
		},
		error: function() {
			alert('Se ha producido un error');
		}
	});
	return true;
}

function eliminar(id) {
	if (!confirm('¿Desea Eliminar el Articulo?'))
		return false;
	if (!confirm('Esta seguro. ¿Desea eliminarla?'))
		return false;
	var url = base_url + 'inventario/eliminar/' + id;
	$.ajax({
		url: url,
		data: null,
		processData: 'false',
		dataType: 'json',
		type: "POST",
		success: function(datos) {
			if (datos == 1)
				actualizar();
			alert('Registro eliminado exitosamente');
		},
		error: function() {
			alert('Se ha producido un error al eliminar');
		}
	});
	return true;
}

function guardar() {
	var post = $("#form_articulo").serialize();
	var enlace;
	
	if ($('[name=id]').val() == '')
		enlace = base_url + "inventario/agregar";
	else {
		enlace = base_url + "inventario/editar";
		post += "&id=" + $('[name=id]').val();
	}
//	alert(post+'  '+enlace);
	$.ajax({
		url: enlace,
		data: post,
		processData: 'false',
		type: 'POST',
		success: function(datos) {
			
			
			if (datos == -1) {
				alert('Error en verificacion');
				return false;
			}
			if (datos == -2) {
				alert('Ya el articulo existe en la sede y gerencia');
				return false;
			}
			if (datos == -10) {
				alert('Error al guardar.\nDatos incompletos');
				return false;
			} else {
				actualizar();
				alert('Exito al guardar');
				$('#form_articulo').modal('hide');
				//$('#_mensaje_alerta').append(mensaje_exito);
			}
			
		},
		error: function() {
			alert('Se ha producido un error de guardado');
		}
	});
}

/*---------------------Busqueda por filtro----------------------------*/
function xls() {
	var post = "_nombre=" + $('[name=_nombre]').val();
	post += "&_sede=" + $('[name=_sede]').val();
	post += "&_gerencia=" + $('[name=_gerencia]').val();
	post += "&_status=" + $('[name=_status]').val();
	var url = base_url + 'inventario/xls';
	$(location).attr('href', url);
//alert(post);
}
function buscar() {
	var post = $('#form_busqueda_articulo').serialize();
	var url = base_url + 'inventario/buscar';
	//alert(url+' '+post);
	$.ajax({
		url: url,
		data: post,
		processData: 'false',
		dataType: 'json',
		type: "POST",
		success: function(datos) {
			$('#tabla tbody').html('');
			for (var i = 0; i < datos.length; i++) {
				cadena = '<tr>' +
								'<td class="centrado">' + datos[i].id + '</td>' +
								'<td>' + datos[i].nombre_sede + '</td>' +
								'<td class="centrado">' + datos[i].nombre_gerencia + '</td>' +
								'<td class="centrado">' + datos[i].nombre + '</td>' +
								'<td class="centrado">' + datos[i].ubicacion + '</td>' +
								'<td class="centrado">' + datos[i].cantidad_disponible + '</td>' +
								'<td class="centrado"><a class="btn btn-mini btn-warning" onclick="get(' + datos[i].id + ')">' +
								'<i class="icon-wrench icon-white"></i></a>' +
								' <a class="btn btn-mini btn-danger" onclick="eliminar(' + datos[i].id + ')">' +
								'<i class="icon-minus icon-white"></i></a></td>' +
								'</tr>';
				$('#tabla tbody').append(cadena);
				if (!$('#tablal tbody').is(':visible')) {
					$('#tabla caption').click();
				}
			}
		},
		error: function() {
			alert('Se ha producido un error');
		}
	});
	return true;
}

$(document).ready(function() {
	$('#form_articulo').submit(function() {
		guardar();
		return false;
	});

	$('#_buscar').click(function() {
		buscar();
	});

	$('#_exportar_xls').click(function() {
		xls();
	});

	$('#form_articulo').on('hidden', function() {
		limpiar_form();
	});
});