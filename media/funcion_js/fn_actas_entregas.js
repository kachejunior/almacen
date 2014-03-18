var ultimo_id;
function vacio(q) {  
	for ( i = 0; i < q.length; i++ ){
		if ( q.charAt(i) != " " ){
			return false;
		}
	}
	return true;
}


function verificar(){
	var item = ['[name=fecha_entrega]','[name=sede]' ,'[name=gerencia]','[name=cedula]','[name=entregado_a]', '[name=nota]'];

	for( var i=0; i< item.length; i++){
		if (vacio($(item[i]).val())){
			$(item[i]).focus();
			$(item[i]).addClass("inputWarning");
			return false;
		}
	}
	return true;	
}

function cargarArticulos(){
	var post = "_tipo_articulo="+$('[name=_tipo_articulo]').val();
    var url = base_url+'inventario/getArticulos';
	//alert(post+" "+url);
    $.ajax({
        url: url,
        data: post,
        processData: 'false',
		dataType: 'json',
        type: "POST",
        success: function(datos) {
			//alert(datos);
			$('#_id_articulo').html('');
			for (var i=0; i<datos.length; i++){
				var cadena = '<option value ='+datos[i].id+'>'+datos[i].nombre+' ('+datos[i].cantidad_disponible+')</option>' ;
				$('#_id_articulo').append(cadena);
				if(!$('#_id_articulo').is(':visible')){
					$('#_id_articulo caption').click();
				}
			}
        },
        error: function() {alert('Se ha producido un error');}
    });
    return true;
}


function eliminarArticulo(id_articulo){
	if(!confirm('Esta seguro. ¿Desea eliminarla?'))
		return false;
	var post = "id="+$('[name=id]').val();
	var post = "id_articulo="+id_articulo;
	var url = base_url+'inventario/eliminar_acta/';
	alert(post+' '+url);
	$.ajax({
			url: url,
			data: null,
			processData: 'false',
			dataType: 'json',
			type: "POST",
			success: function(datos){
				if (datos == 1){
					actualizar();
					cargarArticulos();
					alert('Registro eliminado exitosamente');
				}
			},
			error: function() {alert('Se ha producido un error');}
	});
	return true;
}

function actualizar(){
	var post = "id="+$('[name=id]').val();
    var url = base_url+'entregas/lista_articulos';
    $.ajax({
        url: url,
        data: post,
        processData: 'false',
		dataType: 'json',
        type: "POST",
        success: function(datos) {
				$('#tabla_item tbody').html('');
			for (var i=0; i<datos.length; i++){
				var j=i+1;
				cadena='<tr>'+
					'<td class="centrado">'+ j +'</td>'+
					'<td>'+ datos[i].nombre_articulo +'</td>'+
					'<td class="centrado">'+ datos[i].color_articulo+'</td>'+
					'<td class="centrado">'+ datos[i].cantidad+'</td>'+
					'<td class="centrado">'+
					' <a class="btn btn-mini btn-danger" onclick="eliminarArticulo('+datos[i].id+')">'+
					'<i class="icon-minus icon-white"></i></a></td>'+
				'</tr>';
				$('#tabla_item tbody').append(cadena);
				if(!$('#tabla_item tbody').is(':visible')){
					$('#tabla_item caption').click();
				}
			}
        },
        error: function() {alert('Se ha producido un error');}
    });
    return true;
}

function agregar_articulo ()
{
	if (!verificar()) return false;
	var post = "_id_articulo="+$('[name=_id_articulo]').val();
	post += "&id="+$('[name=id]').val();
	post += "&_cantidad="+$('[name=_cantidad]').val();
	var enlace = base_url +"inventario/agregar_acta";
	
	//alert(post+'  '+enlace);
	$.ajax({
			url: enlace,
			data: post,
			processData: 'false',
			type: 'POST',
			success: function(datos){
			if(datos == -10){
				alert('Error en la cantidad');
				return false;
			}
			
			if(datos == -1){
				alert('Error de validacion');
				return false;
			}
			if(datos == 1){
				alert('Agregado con exito');
				actualizar();
				cargarArticulos()
			}
		},
		error: function() {alert('Se ha producido un error');}
	});
}


function eliminar(id){
	if(!confirm('Esta seguro. ¿Desea eliminarla?'))
		return false;
	var url = base_url+'entregas/eliminar/'+id;
	$.ajax({
			url: url,
			data: null,
			processData: 'false',
			dataType: 'json',
			type: "POST",
			success: function(datos){
				alert (datos);
				if (datos == 1)
				{
					actualizar();
					alert('Registro eliminado exitosamente');
				}
			},
			error: function() {alert('Se ha producido un error');}
	});
	return true;
}

function guardar(){
	if (!verificar()) return false;
	var post = "fecha_entrega="+$('[name=fecha_entrega]').val();
	post += "&sede="+$('[name=sede]').val();
	post += "&gerencia="+$('[name=gerencia]').val();
	post += "&cedula="+$('[name=cedula]').val();
	post += "&entregado_a="+$('[name=entregado_a]').val();
	post += "&nota="+$('[name=nota]').val();
	var enlace;
	if($('[name=id]').val() =='')
		enlace = base_url +"entregas/agregar";
	else{
		post += "&id="+$('[name=id]').val();
		enlace = base_url +"entregas/editar";
	}
	//alert(post+'  '+enlace);
	$.ajax({
			url: enlace,
			data: post,
			processData: 'false',
			type: 'POST',
			success: function(datos){
			if(!$.isNumeric(datos) || datos<1){
				alert('Error al guardar.\nVerifique los datos he intente de nuevo');
				return false;
			}
			else{
				alert('Exito al guardar');
				url = base_url+"entregas/edicion/"+datos;
				$(location).attr('href',url);
				//$('#_mensaje_alerta').append(mensaje_exito);
			}
		},
		error: function() {alert('Se ha producido un error');}
	});
}

/*---------------------Busqueda por filtro----------------------------*/
function buscar(){
	var post= "_sede="+$('[name=_sede]').val();
	post += "&_gerencia="+$('[name=_gerencia]').val();
	post += "&_fecha_inicio="+$('[name=_fecha_inicio]').val();
	post += "&_fecha_final="+$('[name=_fecha_final]').val();
    var url = base_url+'servicios/buscar';
	
//alert(post);
    $.ajax({
        url: url,
        data: post,
        processData: 'false',
	   dataType: 'json',
        type: "POST",
         success: function(datos) {
				$('#tabla tbody').html('');
			for (var i=0; i<datos.length; i++){
				cadena='<tr>'+
					'<td class="centrado">'+ datos[i].id +'</td>'+
					'<td>'+ datos[i].fecha_servicio +'</td>'+
					'<td class="centrado">'+ datos[i].nombre_sede+'</td>'+
					'<td class="centrado">'+ datos[i].nombre_gerencia+'</td>'+
					'<td class="centrado">'+ datos[i].nombre_usuario+'</td>'+
					'<td class="centrado"><a class="btn btn-mini btn-warning" href="'+base_url+'servicios/edicion/'+datos[i].id+'">'+
					'<i class="icon-search icon-white"></i></a>'+
					' <a class="btn btn-mini btn-danger" onclick="eliminar('+datos[i].id+')">'+
					'<i class="icon-minus icon-white"></i></a></td>'+
				'</tr>';
				$('#tabla tbody').append(cadena);
				if(!$('#tablal tbody').is(':visible')){
					$('#tabla caption').click();
				}
			}
        },
					error: function() {alert('Se ha producido un error');}
    });
    return true;
}

	$.mask.definitions['m']='[01]';
	$.mask.definitions['d']='[0123]';
	$.mask.definitions['Y']='[12]';
	$.mask.definitions['y']='[089]';
     $(".fecha2").mask("d9-m9-Yy99");
		 
$('.fecha').datepicker({format: 'dd-mm-yyyy',language: 'es'});

$(document).ready(function(){
	$('#_guardar').click(function(){
		guardar();
	});
	
	$('#_agregar_articulo').click(function(){
		agregar_articulo();
	});
	
	$('#_buscar').click(function(){
		buscar();
	});
	
	$('#myModal').on('hidden', function (){
		limpiar_form();
	});
});