$(document).ready(function(){
	let datos = new FormData();
	datos.append('estado', 2);
	buscarEnTabla('tablaTramites', 'tablaTramites.ajax.php', datos);	
});

$(document).on('click', '.editarTramite', function(e){
	let idTramite = $(this).attr('idTramite');
	$("#formEditarTramite")[0].reset();
	let datos = new FormData();
	datos.append('idTramite', idTramite);
	datos.append('funcion', 'buscarTramite');
	$.ajax({
		url: 'ajax/documento.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(response){
			let fecha = convertirFecha(response['fechaRegistroTramite']);
			$('input[name="dateFechaRegistro"]').val(fecha);
			$('#cmbTipoTramite').val(response['idTipoTramite']);
			$('input[name="txtFolioTramite"]').val(response['folioTramite']);
			$('input[name="txtNumeroTramite"]').val(response['numTramite']);
			$('input[name="txtSiglasTramite"]').val(response['siglasTramite']);
			$('textarea[name="txtAsuntoTramite"]').val(response['asuntoTramite']);
			$('input[name="idTramite"]').val(response['idTramite']);
		}	
	});
}); 

$('#formEditarTramite').submit(event=>{
	$.ajax({
		url: 'ajax/documento.ajax.php',
		method: "POST",
		data: $('#formEditarTramite').serialize(),
		cache: false,
		success: function(response){
			if (response == 'novalido') {
				mensaje('¡CORREGIR!', '¡No se permiten caracteres especiales!', 'warning');
			}else if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡El tramite fue editado con exito!', 'success');
				$('#formEditarTramite').trigger('reset');
				$("#editarTramite").modal('hide');
				let datos = new FormData();
				datos.append('estado', 2);
				buscarEnTabla('tablaTramites', 'tablaTramites.ajax.php', datos);
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
		}
	});
	event.preventDefault();
})

$(document).on('click', '.btnVerArchivos', function(e){
	let idTramite = $(this).attr('idTramite');
	let datos = new FormData();
	datos.append('funcion', 'mostrarArchivos');
	datos.append('idTramite', idTramite);
	$.ajax({
		url: 'ajax/documento.ajax.php',
		method: 'POST',
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json',
		success: function(response){
			$('#tituloTramite').html(response.titulo);
			$('#cuerpoTablaArchivos').html('');
			$('#cuerpoTablaArchivos').html(response.tabla);
		}
	});
});


$(document).on('click', '.enviarTramite', function(e){
	let idTramite = $(this).attr('idTramite');
	$("#formEnviarTramite")[0].reset();
	let datos = new FormData();
	datos.append('idTramite', idTramite);
	datos.append('funcion', 'buscarTramite');
	$.ajax({
		url: 'ajax/documento.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(response){
			$('#tituloEnvio').html(response['nombreTipoTramite']+'-'+response['numTramite']+'-'+response['siglasTramite']);
			$('#cmbEstadoTramite').val(response['idEstado']);
			$('input[name="idEnvioTramite"]').val(response['idTramite']);
		}	
	});
}); 

$(document).on('change', '#cmbGerencias', function(){
  idGerencia = $(this).val();
  let datos = new FormData();
  datos.append("idGerencia", idGerencia);
  datos.append("funcion", 'mostrarSubGerencias');
  let template ='<option value="">Seleccione una opción</option>';
  $.ajax({
    url:"ajax/responsable.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(response){
      response.forEach(valor =>{
        template +=`
          <option value="${valor.idSubGerencia}">${valor.nombreSubGerencia}</option>
        `;
      });
      $('#cmbSubGerencias').html(template);
    }
  }); 
  $(this).find("option[value='']").remove();     
  $("input[name='txtResponsable']").val('');       
  let datos1 = new FormData();
  datos1.append("idGerencia", idGerencia);
  datos1.append("funcion", 'buscarGerente');
  $.ajax({
    url:"ajax/gerente.ajax.php",
    method: "POST",
    data: datos1,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(response){
    	$('input[name="txtGerente"]').val(response['apellidoPaternoPersona']+' '+response['apellidoMaternoPersona']+', '+response['nombresPersona']);
    	$('input[name="idGerente"]').val(response['idGerente']);
    }
  }); 
});

$(document).on('change', '#cmbSubGerencias', function(){
  let idSubGerencia = $(this).val();
  let datos = new FormData();
  datos.append("idSubGerencia", idSubGerencia);
  datos.append("funcion", 'buscarResponsable');
  $.ajax({
    url:"ajax/responsable.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(response){
      $('input[name="txtResponsable"]').val(response.apellidoPaternoPersona + " " + response.apellidoMaternoPersona + ", " + response.nombresPersona);
      $('input[name="idResponsable"]').val(response['idResponsable']);
    }
  });  
  $("#cmbSubGerencias").find("option[value='']").remove();
});

$('#formEnviarTramite').submit(event=>{
	$.ajax({
		url: 'ajax/documento.ajax.php',
		method: "POST",
		data: $('#formEnviarTramite').serialize(),
		cache: false,
		success: function(response){
			if (response == 'ok') {
				mensaje('¡CORRECTO!', '¡El tramite fue editado con exito!', 'success');
				$('#formEnviarTramite').trigger('reset');
				$("#enviarTramite").modal('hide');
				let datos = new FormData();
				datos.append('estado', 2);
				buscarEnTabla('tablaTramites', 'tablaTramites.ajax.php', datos);
			}else{
				mensaje('¡ERROR!', '¡Ah ocurrido un  error al realizar la accion! Comuniquese con el administrador.' , 'error');
			}
		}
	});
	event.preventDefault();
})

$(document).on('click', '.verRuta', function(e){
	let idTramite = $(this).attr('idTramite');
	let datos = new FormData();
	datos.append('idTramite', idTramite);
	datos.append('funcion', 'mostrarRuta');
	$.ajax({
		url: 'ajax/documento.ajax.php',
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(response){
			console.log("response", response);
			$('#ruta').html('');
			$('#ruta').html(response);
		}
	});
});

$(document).on('click', '.eliminarTramite', function(e){
	let idTramite = $(this).attr('idTramite');
	swal({
		title: 'ELIMINAR TRAMITÉ',
		text: '¿Está seguro de eliminar el tramité?',
		type: 'warning',
		showConfirmButton: true,
		confirmButtonText: "¡Aceptar!",
		showCancelButton: true,
		cancelButtonText: "¡Salir!",
	}).then(function(result){
		if(result.value){
			let datos = new FormData();
			datos.append('idTramite', idTramite);
			datos.append('funcion', 'eliminarTramite');
			$.ajax({
				url:'ajax/documento.ajax.php',
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success:function(response){
						if (response=='ok') {
							let datos1 = new FormData();
							datos1.append('estado', 2);
							buscarEnTabla('tablaTramites', 'tablaTramites.ajax.php', datos1);
							alertaMensaje('top-right', '<i class="fas fa-check-circle"></i>', 'El tramite fue removido con exito'); 
						}
			    }
		  	});
		}
	});
});