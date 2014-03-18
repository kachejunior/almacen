function vacio(q) {  
	for ( i = 0; i < q.length; i++ ){
		if ( q.charAt(i) != " " ){
			return false;
		}
	}
	return true;
}

function limpiar_form(){
	var item = ['[name=_cedula]', '[name=cedula]', '[name=nombre]','[name=apellido]','[name=telefono]',
		'[name=correo]','[name=grupo_usuario]','[name=status_usuario]','[name=sede]'];

	for( var i=0; i< item.length; i++){
		$(item[i]).val('');
	}
	$('[name=cedula]').attr('disabled',false);
}

function verificar(){
	var item =
	['[name=cedula]','[name=nombre]','[name=apellido]','[name=telefono]','[name=correo]'
	,'[name=grupo_usuario]','[name=status_usuario]','[name=sede]'];

	for( var i=0; i< item.length; i++){
		if (vacio($(item[i]).val())){
			$(item[i]).focus();
			return false;
		}
	}
	return true;
}

function actualizar(){
    var url = base_url+'usuarios/get';
    $.ajax({
        url: url,
        data: null,
        processData: 'false',
				dataType: 'json',
        type: "POST",
        success: function(datos) {
				$('#tabla tbody').html('');
			for (var i=0; i<datos.length; i++){
				cadena='<tr>'+
					'<td class="centrado">'+ datos[i].cedula +'</td>'+
					'<td>'+ datos[i].nombre + ' ' + datos[i].apellido +'</td>'+
					'<td class="centrado">'+ datos[i].correo+'</td>'+
					'<td class="centrado">'+ datos[i].telefono+'</td>'+
					'<td class="centrado"><a class="btn btn-mini btn-warning" onclick="get('+datos[i].cedula+')">'+
					'<i class="icon-wrench icon-white"></i></a>'+
					' <a class="btn btn-mini btn-danger" onclick="eliminar('+datos[i].cedula+')">'+
					'<i class="icon-minus icon-white"></i></a>'+
					' <a class="btn btn-mini btn-danger" onclick="reset_passwd('+datos[i].cedula+')">'+
					'<i class="icon-refresh icon-white"></i></a></td>'+
				'</tr>';
				$('#tabla tbody').append(cadena);
				if(!$('#tabla tbody').is(':visible')){
					$('#tabla caption').click();
				}
			}
        },
        error: function() {alert('Se ha producido un error');}
    });
    return true;
}

function get(id){
	var url = base_url+'usuarios/get/'+id;
	$.ajax({
			url: url,
			data: null,
			processData: 'false',
			dataType: 'json',
			type: "POST",
			success: function(datos) {
				$('#myModal').modal('show');
					$('[name=_cedula]').val(datos.cedula);
					$('[name=cedula]').val(datos.cedula);
					$('[name=nombre]').val(datos.nombre);
					$('[name=apellido]').val(datos.apellido);
					$('[name=telefono]').val(datos.telefono);
					$('[name=correo]').val(datos.correo);
					$('[name=grupo_usuario]').val(datos.grupo_usuario);
					$('[name=status_usuario]').val(datos.status_usuario);
					$('[name=sede]').val(datos.sede);
					$('[name=cedula]').attr('disabled','');
			},
			error: function() {alert('Se ha producido un error');}
	});
	return true;
}

function eliminar(id){
	if(!confirm('Esta seguro. ¿Desea eliminarla?'))
		return false;
	var url = base_url+'usuarios/eliminar/'+id;
	$.ajax({
			url: url,
			data: null,
			processData: 'false',
			dataType: 'json',
			type: "POST",
			success: function(datos){
				if (datos == 1)
					actualizar();
			},
			error: function() {alert('Se ha producido un error');}
	});
	return true;
}

function guardar(){
	if (!verificar()) return false;
	var post = "cedula="+$('[name=cedula]').val();
	post += "&nombre="+$('[name=nombre]').val();
	post += "&apellido="+$('[name=apellido]').val();
	post += "&telefono="+$('[name=telefono]').val();
	post += "&correo="+$('[name=correo]').val();
	post += "&grupo_usuario="+$('[name=grupo_usuario]').val();
	post += "&status_usuario="+$('[name=status_usuario]').val();
	post += "&sede="+$('[name=sede]').val();
	var enlace;
	if($('[name=_cedula]').val() == '')
		enlace = base_url +"usuarios/agregar";
	else
		enlace = base_url +"usuarios/editar";
	//alert(post+' '+enlace);
	$.ajax({
			url: enlace,
			data: post,
			processData: 'false',
			type: "POST",
			success: function(datos){
			if(!$.isNumeric(datos) || datos<1){
				alert('Error al guardar.\nVerifique los datos he intente de nuevo');
				return false;
			}else{
				actualizar();
				$('#myModal').modal('hide');
			}
		},
		error: function() {alert('Se ha producido un error');}
	});
}

function reset_passwd(id){
	if(!confirm('¿Seguro quiere reiniciar la clave?'))
		return false;
	var url = base_url+'usuarios/resetear_clave/'+id;
	$.ajax({
			url: url,
			data: null,
			processData: 'false',
			dataType: 'json',
			type: "POST",
			success: function(datos){
				if (datos == 1){
					alert('Clave Reseteada con Exito');
					actualizar();
				}
			},
			error: function() {alert('Se ha producido un error');}
	});
	return true;
}

$(document).ready(function(){
	$('#_guardar').click(function(){
		guardar();
	});
	
	$('#myModal').on('hidden', function (){
		limpiar_form();
	});
	$('#myModal').on('shown', function (){
		$('[name=cedula]').focus();
	});
});