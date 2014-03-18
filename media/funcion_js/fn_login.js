var mensaje_error_datos= '<p class="text-error">Usuario o password Invalido</p>';
var cambio_contraseña_error= '<p class="text-error">El password no coinciden</p>';
var cambio_contraseña_exito= '<p class="text-success">Cambio Exitoso</p>';

function vacio(q) {  
	for ( i = 0; i < q.length; i++ ){
		if ( q.charAt(i) != " " ){
			return false;
		}
	}
	return true;
}

function verificar(){
	var item =
	['[name=cedula]','[name=clave]'];

	for( var i=0; i< item.length; i++){
		if (vacio($(item[i]).val())){
			$(item[i]).focus();
			return false;
		}
	}
	return true;
}

function verificar_datos(){
	if (!verificar()) return false;
	var post = "cedula="+$('[name=cedula]').val();
	post += "&clave="+$('[name=clave]').val();
	var enlace;
	enlace = base_url +'usuarios/iniciar_session';
	//alert(post+' '+enlace);
	$.ajax({
			url: enlace,
			data: post,
			processData: 'false',
			type: "POST",
			success: function(datos){
			if(!$.isNumeric(datos) || datos<1){
				$('#_alerta').append(mensaje_error_datos);
				return false;
			}else{
				$(location).attr('href', base_url+'inventario');
			}
		},
		error: function() {alert('Se ha producido un error');}
	});
}

function cambiar_clave(){
	
	if ($('[name=pass_nuevo]').val()!=$('[name=pass_repetir]').val()){
		$('#_alerta').append(cambio_contraseña_error);
		return false;
	}
	
	var post = "pass_nuevo="+$('[name=pass_nuevo]').val();
	var enlace;
	enlace = base_url +'usuarios/cambiar_clave';
	//alert(post+' '+enlace);
	$.ajax({
			url: enlace,
			data: post,
			processData: 'false',
			type: "POST",
			success: function(datos){
			if(!$.isNumeric(datos) || datos<1){
				$('#_alerta').append(cambio_contraseña_error);
				return false;
			}else{
				$('#_alerta').html(cambio_contraseña_exito);
				return false;
			}
		},
		error: function() {alert('Se ha producido un error');}
	});
}

$(document).ready(function(){
	$('.carousel').carousel({
		interval: 5000
	});
	$(".positive-integer").numeric({ decimal: false, negative: false }, function() { alert("Positive integers only"); this.value = ""; this.focus(); });
	
//	$('#_guardar').click(function(){
//		verificar_datos();
//	});
	$('#formulario').submit(function(event){
		event.preventDefault();
		verificar_datos();
	});
	$('[name=cedula]').focus();

	$('#_cambio_clave').click(function(){
		cambiar_clave();
	});
});