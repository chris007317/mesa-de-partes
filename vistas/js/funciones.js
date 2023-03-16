function mensaje(titulo, mensaje, tipo){
	swal({
		title: titulo,
		text: mensaje,
		type: tipo,
		showConfirmButton: true,
		confirmButtonText: "¡Aceptar!",
	});
}

/*----------  mostrar tablas en data Table  ----------*/
function mostrarDataTable(tabla, link){
	$('#'+tabla).DataTable({
		"ajax":"ajax/"+link,
		"pageLength": 25,
		"deferRender":true,
		"retrieve":true,
		"processing":true,
		"language": {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		}
	});
}

function alertaMensaje(posicion, icono, mensaje){
	swal({
		position: posicion,
		width: '400px',
		showConfirmButton: false,
		timer: 1500,
		html:'<p class="text-secondary">'+icono+'<span style="font-size: 14px"> '+mensaje+'</span></p>'
	});
}


function mensajeReload(titulo, mensaje, tipo){
	swal({
		title: titulo,
		text: mensaje,
		type: tipo,
		showConfirmButton: true,
		confirmButtonText: "¡Aceptar!",
	}).then(function(result){
		if(result.value){
			location.reload();
		}
	});
}

function mostrarDatos(datos, link, tabla){
	$.ajax({
		url:link,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(response){
			$('#'+tabla).html('');
			$('#'+tabla).html(response);
	    }
  	});
}

/*----------  Mostrar imagen previa  ----------*/
function validarArchivo(nombreFile, archivo, datos, link){
	/*----------  validamos el formato del archivo  ----------*/
	if (archivo["type"] == "application/pdf") {
		$.ajax({
			url:link,
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success:function(response){
				let respuesta = JSON.parse(response);
				if (respuesta['valor'] == 'error') {
					mensaje('¡CORREGIR!', '¡Ocurrio un error al cargar el archivo!', 'error');
				}else if (respuesta['valor'] == 'novalido') {
					mensaje('¡CORREGIR!', '¡Formato no valido!', 'error');
				}else if (respuesta['valor'] == 'no') {
					mensaje('¡CORREGIR!', '¡Remitente no registrado!', 'warning');
				}else if(respuesta['valor'] == 'ok'){
					$('input[name="nombreArchivoPrincipal"]').val(respuesta['nombreArchivoNuevo']);
					$("#cuerpoTablaArchivos").prepend(`<tr>
							<td>${respuesta['nombreArchivo']}</td>
							<td>Principal</td>
							<td><div class="btn-group"><button type="button" class="btn btn-danger btn-sm btnBorrarArchivo" carpeta="principal" nombreArchivo="${respuesta['nombreArchivoNuevo']}"><i class="fa fa-trash-alt"></i></buttom></div></td>
						</tr>`);
					$('#btnPrincipal').hide();
					alertaMensaje('top-right', '<i class="fas fa-check-square"></i>', 'El archivo cargo con exito'); 
				}
		    }
	  	});	

	}else{
		$('input[name="'+nombreFile+'"]').val("");
		swal({
			title: "¡Error al subir archivo!",
			text: "La archivo debe estar en formato pdf",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});
	}
}
var idAnexo = 0;
/*----------  Mostrar imagen previa  ----------*/
function validarAnexo(nombreFile, archivo, datos, link){
	/*----------  validamos el formato del archivo  ----------*/
	if (archivo["type"] == "application/pdf") {
		$.ajax({
			url:link,
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success:function(response){
				let respuesta = JSON.parse(response);
				if (respuesta['valor'] == 'error') {
					mensaje('¡CORREGIR!', '¡Ocurrio un error al cargar el archivo!', 'error');
				}else if (respuesta['valor'] == 'novalido') {
					mensaje('¡CORREGIR!', '¡Formato no valido!', 'error');
				}else if (respuesta['valor'] == 'no') {
					mensaje('¡CORREGIR!', '¡Remitente no registrado!', 'warning');
				}else if(respuesta['valor'] == 'ok'){
					let anexos = $('input[name="nombreArchivoAnexo"]').val();
					idAnexo++;
					$("#cuerpoTablaArchivos").append(`<tr>
							<td>${respuesta['nombreArchivo']}</td>
							<td>Anexo</td>
							<td><div class="btn-group"><button type="button" class="btn btn-danger btn-sm btnBorrarArchivo" carpeta ="anexos" id="${idAnexo}" nombreArchivo="${respuesta['nombreArchivoNuevo']}"><i class="fa fa-trash-alt"></i></buttom></div></td>
						</tr>`);
					$('#anexos').append('<input type="hidden" name="anexos[]" value="'+respuesta['nombreArchivoNuevo']+'" id="fila'+idAnexo+'">');
					alertaMensaje('top-right', '<i class="fas fa-check-square"></i>', 'El archivo cargo con exito'); 
					$fileupload = $('input[name="'+nombreFile+'"]');
					$fileupload.replaceWith($fileupload.clone(true));
				}
		    }
	  	});	

	}else{
		$('input[name="'+nombreFile+'"]').val("");
		swal({
			title: "¡Error al subir archivo!",
			text: "La archivo debe estar en formato pdf",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});	
	}
}

function borrarArchivo(link, datos, carpeta, elemento, anexo){
  $.ajax({
    url:link,
    method: "POST",
    data: datos,
    processData: false,
    contentType: false,
    success:function(response){
      if (response == 'ok') {
        $(elemento).remove();
        alertaMensaje('top-right', '<i class="fas fa-check-square"></i>', 'Archivo removido'); 
        if (carpeta == 'principal') {
          $('#btnPrincipal').show();  
        }else if (carpeta == 'anexos') {
          $('#fila'+anexo+'').remove();
        }
      }else{
        mensaje('¡ERROR!', '¡no se pudo eliminar el archivo!', 'error');
      }
    }
  });
}

function buscarEnTabla(tabla, link, datos){
		$.ajax({
		url: "ajax/"+link,
		type: "POST",
		data: datos,
		cache: false,
		contentType: false,
  	processData: false,
  	dataType: "json",
		success:function(response){
			let datatable = $('#'+tabla).DataTable({
			"pageLength": 25,
			"deferRender":true,
			"retrieve":true,
			"processing":true,
			"language": {
				"sProcessing":     "Procesando...",
				"sLengthMenu":     "Mostrar _MENU_ registros",
				"sZeroRecords":    "No se encontraron resultados",
				"sEmptyTable":     "Ningún dato disponible en esta tabla",
				"sInfo":           "Mostrando registros del _START_ al _END_",
				"sInfoEmpty":      "Mostrando registros del 0 al 0",
				"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
				"sInfoPostFix":    "",
				"sSearch":         "Buscar:",
				"sUrl":            "",
				"sInfoThousands":  ",",
				"sLoadingRecords": "Cargando...",
				"oPaginate": {
					"sFirst":    "Primero",
					"sLast":     "Último",
					"sNext":     "Siguiente",
					"sPrevious": "Anterior"
				},
				"oAria": {
					"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
					"sSortDescending": ": Activar para ordenar la columna de manera descendente"
				}
			}
		});			
		    datatable.clear(); 
		    datatable.rows.add(response.data); 
		    datatable.draw(); 
		}
	});
}

function convertirFecha(fecha){
	let fechaHora = new Date(fecha);
	segundo = fechaHora.getSeconds();
	minuto = fechaHora.getMinutes();
	hora = fechaHora.getHours();
	dia = fechaHora.getDate();
	mes = fechaHora.getMonth();
	año = fechaHora.getFullYear();
	fechaActual = año+'-'+verCero(mes+1)+'-'+verCero(dia)+'T'+verCero(hora)+':'+verCero(minuto)+':'+verCero(segundo);
	return fechaActual;
}

function verCero(val) {
	let nuevo 
    if (val >= 10){
    	nuevo = val; 
    } 
    else{
    	nuevo = '0' + val; 
    } 
    return nuevo;
} 


/*----------  mostrar datos   ----------*/
function mostrarDatos(datos, link, tabla){
	$.ajax({
		url:link,
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(response){
			$('#'+tabla).html('');
			$('#'+tabla).html(response);
	    }
  	});
}