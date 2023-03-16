$(document).ready(function(){
	mostrarDataTable('tablaUsuarios', 'tablaUsuarios.ajax.php');
});

$(document).on("click", "#btnAgregarUsuario", function(){
	$("#formAgregarUsuario")[0].reset();
	$('input[name="txtApellidoPaterno"]').attr('readonly', 'readonly'); 
	$('input[name="txtApellidoMaterno"]').attr('readonly', 'readonly'); 				
	$('input[name="txtNombreUsuario"]').attr('readonly', 'readonly'); 
});


$(document).on('click', '#btnBuscarUsuario', function(e) {
	let dni = $('input[name="txtDniUsuario"]').val();
	if (dni.length == 8 && (/^\d{8}$/.test(dni))) {
		let datos = new FormData();
		datos.append('dni', dni);
		datos.append('funcion', 'buscarDni');
		$.ajax({
			url:"ajax/usuario.ajax.php",
			method:"POST",
			data:datos,
			cache:false,
			contentType:false,
			processData:false,
			success:function(response){
				console.log("response", response);
				if (response == 'existe') {
					alertaMensaje('top-right', '<i class="far fa-window-close"></i>', 'El usuario ya se encuentra registrado');	
				}else if(response == 'noexiste'){
					$('input[name="txtApellidoPaterno"]').removeAttr('readonly'); 
					$('input[name="txtApellidoMaterno"]').removeAttr('readonly'); 				
					$('input[name="txtNombreUsuario"]').removeAttr('readonly');
					$('input[name="txtApellidoPaterno"]').val(''); 
					$('input[name="txtApellidoMaterno"]').val(''); 				
					$('input[name="txtNombreUsuario"]').val('');
					$('input[name="idPersona"]').val('');
				}else{
					let respuesta = JSON.parse(response);
					$('input[name="txtApellidoPaterno"]').val(respuesta.nombresPersona); 
					$('input[name="txtApellidoMaterno"]').val(respuesta.apellidoPaternoPersona); 				
					$('input[name="txtNombreUsuario"]').val(respuesta.apellidoMaternoPersona);
					$('input[name="idPersona"]').val(respuesta.idPersona);
		 			$('input[name="txtApellidoPaterno"]').attr('readonly', 'readonly'); 
					$('input[name="txtApellidoMaterno"]').attr('readonly', 'readonly'); 				
					$('input[name="txtNombreUsuario"]').attr('readonly', 'readonly'); 
				}
		    }
	  	});
	}else{
		alertaMensaje('top-right', '<i class="far fa-window-close"></i>', 'No se realizo la busqueda');	
	}
});



$('#formAgregarUsuario').submit(event=>{
	$.ajax({
		url:"ajax/usuario.ajax.php",
		method: "POST",
		data: $('#formAgregarUsuario').serialize(),
		cache: false,
		success:function(response){
			if (response == 'existe') {
				mensaje('¡CORREGIR!', '¡El nombre de usuario ya se encuentra registrado!', 'warning');
			}else if (response == 'no') {
				mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				buscarEnTabla('tablaUsuarios', 'tablaUsuarios.ajax.php', '');
				$("#agregarUsuario").modal("hide");
				mensaje('¡CORRECTO!', '¡Usuario registrado con exito!.' , 'success');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al registrar usuario.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});


$(document).on('click', '.editarUsuario', function(){
	$("#formEditarUsuario")[0].reset();
	let idUsuario = $(this).attr('idUsuario');
	let datos = new FormData();
	datos.append('idUsuario', idUsuario);
	datos.append('funcion', 'mostrarUsuario');
	$.ajax({
		url:"ajax/usuario.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
	    success:function(response){
	    	$('#titulo').html(response['nombresPersona']+' '+response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']);
	    	$('input[name="txtEditarCorreo"]').val(response['correoPersona']); 
	    	$('input[name="txtEditarCeluar"]').val(response['celularPersona']); 
	    	$('input[name="txtEditarUsuario"]').val(response['nombreUsuario']); 
	    	$('input[name="idUsuario"]').val(response['idUsuario']); 
	    	$('input[name="idUsuarioPersona"]').val(response['idPersona']); 
	    	$('#cmbEditarPerfil').val(response['rolUsuario']);
	    }
  	});
});

$('#formEditarUsuario').submit(event=>{
	$.ajax({
		url:"ajax/usuario.ajax.php",
		method: "POST",
		data: $('#formEditarUsuario').serialize(),
		cache: false,
		success:function(response){
			if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡El usuario fue editado con exito!', 'success');
				$('#formEditarUsuario').trigger('reset');
				$("#editarUsuario").modal('hide');
					buscarEnTabla('tablaUsuarios', 'tablaUsuarios.ajax.php', '');
			}else if (response == 'existe'){
				mensaje('ADVERTENCIA!', '¡El nombre de usuario ya existe!', 'warning');
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
	    }
  	});
	event.preventDefault();
});
