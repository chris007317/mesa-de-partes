$(document).ready(function(){
	buscarEnTabla('tablaGerentes', 'tablaGerentes.ajax.php');
	buscarEnTabla('tablaSubGerentes', 'tablaSubGerentes.ajax.php');
});

$(document).on('click', '#btnBuscarGerente', function(e) {
	let dni = $('input[name="txtDniGerente"]').val();
	if (dni.length == 8 && (/^\d{8}$/.test(dni))) {
		let datos = new FormData();
		datos.append('dni', dni);
		datos.append('funcion', 'buscarDni');
		$.ajax({
			url:"ajax/gerente.ajax.php",
			method:"POST",
			data:datos,
			cache:false,
			contentType:false,
			processData:false,
			success:function(response){
				if (response == 'existe') {
					alertaMensaje('top-right', '<i class="far fa-window-close"></i>', 'El Gerente ya se encuentra registrado');	
				}else if(response == 'noexiste'){
					$('input[name="txtApellidoPaternoGerente"]').removeAttr('readonly'); 
					$('input[name="txtApellidoMaternoGerente"]').removeAttr('readonly'); 				
					$('input[name="txtNombreGerente"]').removeAttr('readonly');
					$('input[name="txtApellidoPaternoGerente"]').val(''); 
					$('input[name="txtApellidoMaternoGerente"]').val(''); 				
					$('input[name="txtNombreGerente"]').val('');
					$('input[name="txtCelularGerente"]').val('');
					$('input[name="txtCorreoGerente"]').val('');
					$('input[name="idGerentePersona"]').val('');
				}else{
					let respuesta = JSON.parse(response);
					$('input[name="txtApellidoPaternoGerente"]').val(respuesta.apellidoPaternoPersona); 
					$('input[name="txtApellidoMaternoGerente"]').val(respuesta.apellidoMaternoPersona); 				
					$('input[name="txtNombreGerente"]').val(respuesta.nombresPersona);
					let idPersona = respuesta.idPersona;
					$('input[name="idGerentePersona"]').val(idPersona);
					$('input[name="txtCelularGerente"]').val(respuesta.celularPersona); 
					$('input[name="txtCorreoGerente"]').val(respuesta.correoPersona);
		 			$('input[name="txtApellidoPaternoGerente"]').attr('readonly', 'readonly'); 
					$('input[name="txtApellidoMaternoGerente"]').attr('readonly', 'readonly'); 				
					$('input[name="txtNombreGerente"]').attr('readonly', 'readonly');
				}
		    }
	  	});
	}else{
		alertaMensaje('top-right', '<i class="far fa-window-close"></i>', 'No se realizo la busqueda');	
	}
});

$('#formAgregarGerente').submit(event=>{
	$.ajax({
		url:"ajax/gerente.ajax.php",
		method: "POST",
		data: $('#formAgregarGerente').serialize(),
		cache: false,
		success:function(response){
			if (response == 'existe') {
				mensaje('¡CORREGIR!', '¡El gerente ya se encuentra registrado!', 'warning');
			}else if (response == 'no') {
				mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				//buscarEnTabla('tablaUsuarios', 'tablaUsuarios.ajax.php', '');
				$("#formAgregarGerente")[0].reset();
				buscarEnTabla('tablaGerentes', 'tablaGerentes.ajax.php');
				mensaje('¡CORRECTO!', 'Gerencia registrado con exito!.' , 'success');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al registrar la gerencia.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});

$(document).on('click', '#cancelarGerencia', function(){
	$("#formAgregarGerente")[0].reset();
});

$(document).on('click', '#cancelarSubGerencia', function(){
	$("#formAgregarSubGerente")[0].reset();
});

$(document).on('click', '#btnBuscarResponsable', function(e) {
	let dniResponsable = $('input[name="txtDniResponsable"]').val();
	if (dniResponsable.length == 8 && (/^\d{8}$/.test(dniResponsable))) {
		let datos = new FormData();
		datos.append('dni', dniResponsable);
		datos.append('funcion', 'buscarDni');
		$.ajax({
			url:"ajax/responsable.ajax.php",
			method:"POST",
			data:datos,
			cache:false,
			contentType:false,
			processData:false,
			success:function(response){
				if (response == 'existe') {
					alertaMensaje('top-right', '<i class="far fa-window-close"></i>', 'El Gerente ya se encuentra registrado');	
				}else if(response == 'noexiste'){
					$('input[name="txtApellidoPaternoResponsable"]').removeAttr('readonly'); 
					$('input[name="txtApellidoMaternoResponsable"]').removeAttr('readonly'); 				
					$('input[name="txtNombreResponsable"]').removeAttr('readonly');
					$('input[name="txtApellidoPaternoResponsable"]').val(''); 
					$('input[name="txtApellidoMaternoResponsable"]').val(''); 				
					$('input[name="txtNombreResponsable"]').val('');
					$('input[name="celularResponsable"]').val('');
					$('input[name="txtCorreoResponsable"]').val('');
					$('input[name="idResponsablePersona"]').val('');
				}else{
					let respuesta = JSON.parse(response);
					$('input[name="txtApellidoPaternoResponsable"]').val(respuesta.apellidoPaternoPersona); 
					$('input[name="txtApellidoMaternoResponsable"]').val(respuesta.apellidoMaternoPersona); 				
					$('input[name="txtNombreResponsable"]').val(respuesta.nombresPersona);
					let idPersona = respuesta.idPersona;
					$('input[name="idResponsablePersona"]').val(idPersona);
					$('input[name="celularResponsable"]').val(respuesta.celularPersona); 
					$('input[name="txtCorreoResponsable"]').val(respuesta.correoPersona);
		 			$('input[name="txtApellidoPaternoResponsable"]').attr('readonly', 'readonly'); 
					$('input[name="txtApellidoMaternoResponsable"]').attr('readonly', 'readonly'); 				
					$('input[name="txtNombreResponsable"]').attr('readonly', 'readonly'); 			

				}
		    }
	  	});
	}else{
		alertaMensaje('top-right', '<i class="far fa-window-close"></i>', 'No se realizo la busqueda');	
	}
});

$('#formAgregarSubGerente').submit(event=>{
	$.ajax({
		url:"ajax/responsable.ajax.php",
		method: "POST",
		data: $('#formAgregarSubGerente').serialize(),
		cache: false,
		success:function(response){
			if (response == 'existe') {
				mensaje('¡CORREGIR!', '¡El nombre la sub gerencia ya se encuentra registrado!', 'warning');
			}else if (response == 'no') {
				mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				//buscarEnTabla('tablaUsuarios', 'tablaUsuarios.ajax.php', '');
				$("#formAgregarSubGerente")[0].reset();
				mensaje('¡CORRECTO!', 'Sub gerencias registrado con exito!.' , 'success');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al registrar la gerencia.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});