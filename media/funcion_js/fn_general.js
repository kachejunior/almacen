function vacio(q) {  
	for ( i = 0; i < q.length; i++ ){
		if ( q.charAt(i) != " " ){
			return false;
		}
	}
	return true;
}

function limpiar_form(){
	var item = ['[name=id]', '[name=nombre]'];

	for( var i=0; i< item.length; i++){
		$(item[i]).val('');
	}
}

function verificar(){
	var item =
	['[name=nombre]'];

	for( var i=0; i< item.length; i++){
		if (vacio($(item[i]).val())){
			$(item[i]).focus();
			return false;
		}
	}
	return true;
}

function actualizar(){
    var url = base_url+'general/get/'+tb;
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
					'<td class="centrado">'+ datos[i].id +'</td>'+
					'<td>'+ datos[i].nombre +'</td>'+
					'<td class="centrado"><a class="btn btn-mini btn-warning" onclick="get('+datos[i].id+')">'+
					'<i class="icon-wrench icon-white"></i></a>'+
					' <a class="btn btn-mini btn-danger" onclick="eliminar('+datos[i].id+')">'+
					'<i class="icon-minus icon-white"></i></a></td>'+
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
	var url = base_url+'general/get/'+tb+'/'+id;
	$.ajax({
			url: url,
			data: null,
			processData: 'false',
			dataType: 'json',
			type: "POST",
			success: function(datos) {
				$('#myModal').modal('show');
					$('[name=id]').val(datos.id);
					$('[name=nombre]').val(datos.nombre);
			},
			error: function() {alert('Se ha producido un error');}
	});
	return true;
}

function eliminar(id){
	if(!confirm('Esta seguro. ¿Desea eliminarla?'))
		return false;
	var url = base_url+'general/eliminar/'+tb+'/'+id;
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
	var post = "nombre="+$('[name=nombre]').val();
	post += "&id="+$('[name=id]').val();
	var enlace;
	if($('[name=id]').val() == '')
		enlace = base_url +"general/agregar/"+tb;
	else
		enlace = base_url +"general/editar/"+tb;
	//alert(post + ' ' + enlace);
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
				alert('Exito al guardar');
				$('#myModal').modal('hide');
			}
		},
		error: function() {alert('Se ha producido un error');}
	});
}

$(document).ready(function(){
	$('#_guardar').click(function(){
		guardar();
	});
	
	$('#myModal').on('hidden', function (){
		limpiar_form();
	});
});