/*----------  previsualizar la imagen del producto  ----------*/
$(document).on('click', '#btnBuscarRemitente', function(e) {
  let dni = $('input[name="txtDniRemitente"]').val();
  if (dni.length == 8 && (/^\d{8}$/.test(dni))) {
    let datos = new FormData();
    datos.append('dni', dni);
    datos.append('funcion', 'buscarDni');
    $.ajax({
      url:"ajax/persona.ajax.php",
      method:"POST",
      data:datos,
      cache:false,
      contentType:false,
      processData:false,
      success:function(response){
        if(response == 'noexiste'){
          $('input[name="txtApellidoPaternoRemitente"]').removeAttr('readonly'); 
          $('input[name="txtApellidoMaternoRemitente"]').removeAttr('readonly');         
          $('input[name="txtNombreRemitente"]').removeAttr('readonly');
          $('input[name="txtNombreRemitente"]').focus();
          $('input[name="txtApellidoPaternoRemitente"]').val(''); 
          $('input[name="txtApellidoMaternoRemitente"]').val('');        
          $('input[name="txtNombreRemitente"]').val('');
          $('input[name="txtCelularRemitente"]').val('');
          $('input[name="txtCorreoRemitente"]').val('');
          $('input[name="idRecurrente"]').val('');
        }else{
          let respuesta = JSON.parse(response);
          $('input[name="txtApellidoPaternoRemitente"]').val(respuesta.nombresPersona); 
          $('input[name="txtApellidoMaternoRemitente"]').val(respuesta.apellidoPaternoPersona);        
          $('input[name="txtNombreRemitente"]').val(respuesta.apellidoMaternoPersona);
          $('input[name="idRecurrente"]').val(respuesta.idPersona);
          $('input[name="txtCelularRemitente"]').val(respuesta.celularPersona); 
          $('input[name="txtCorreoRemitente"]').val(respuesta.correoPersona);
          $('input[name="txtApellidoPaternoRemitente"]').attr('readonly', 'readonly'); 
          $('input[name="txtApellidoMaternoRemitente"]').attr('readonly', 'readonly');         
          $('input[name="txtNombreRemitente"]').attr('readonly', 'readonly'); 
        }
      }
    });
  }else{
    alertaMensaje('top-right', '<i class="far fa-window-close"></i>', 'No se realizo la busqueda'); 
  }
});

$(document).on('click', '#btnCancelarRemitente', function(e){
  $("#formAgregarRemitente")[0].reset();
  $('input[name="idPersona"]').val('');
});

$('#formAgregarRemitente').submit(event=>{
  $.ajax({
    url:"ajax/persona.ajax.php",
    method: "POST",
    data: $('#formAgregarRemitente').serialize(),
    cache: false,
    success:function(response){
      if (response == 'no') {
        mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
      }else if (response > 0 ) {
        $('input[name="idPersona"]').val(response);
        $('input[name="dniPersona"]').val($('input[name="txtDniRemitente"]').val());
        alertaMensaje('top-right', '<i class="fas fa-check-square"></i>', 'Los datos fueron registrados con exito'); 
      }else{
        mensaje('¡ERROR!', '¡Ah ocurrido un  error al registrar los datos del remitente.' , 'error');
      }
    }
  });
  event.preventDefault();
});


$('input[name="filePrincipal"]').change(function(){
  let archivo = this.files[0];
  let dniPersona = $('input[name="txtDniRemitente"]').val();
  let datos = new FormData();
  datos.append('archivo', archivo);
  datos.append('dniPersona', dniPersona);
  datos.append('carpeta', 'principal');
  datos.append('funcion', 'subirArchivo');
  validarArchivo("filePrincipal", archivo, datos, "ajax/documento.ajax.php");
});

$(document).on('change', '#cmbTipoTramite', function(){
  $(this).find("option[value='']").remove();
});


$(document).on('change', '#cmbGerencias', function(){
  idGerencia = $(this).val();
  let funcion = 'mostrarSubGerencias';
  let datos = new FormData();
  datos.append("idGerencia", idGerencia);
  datos.append("funcion", funcion);
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
      $('#cmbSubGerencia').html(template);
    }
  });  
  $(this).find("option[value='']").remove();  
  $("input[name='txtResponsable']").val('');          
});

$(document).on('change', '#cmbSubGerencia', function(){
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
      $('input[name="txtResponsable"]').val(response.nombresPersona + " " + response.apellidoPaternoPersona + " " + response.apellidoMaternoPersona);
    }
  });  
  $("#cmbGerencias").find("option[value='']").remove();
});

$('input[name="fileAnexo"]').change(function(){
  let archivo = this.files[0];
  let dniPersona = $('input[name="txtDniRemitente"]').val();
  let datos = new FormData();
  datos.append('archivo', archivo);
  datos.append('dniPersona', dniPersona);
  datos.append('carpeta', 'anexos');
  datos.append('funcion', 'subirArchivo');
  validarAnexo("fileAnexo", archivo, datos, "ajax/documento.ajax.php");
});


$('#formAgregarDocumento').submit(event=>{
  $.ajax({
    url:"ajax/documento.ajax.php",
    method: "POST",
    data: $('#formAgregarDocumento').serialize(),
    cache: false,
    success:function(response){
    if (response == 'no') {
        mensaje('¡CORREGIR!', '¡no se permite caracteres especiales!', 'warning');
      }else if (response == 'ok') {
        //buscarEnTabla('tablaUsuarios', 'tablaUsuarios.ajax.php', '');
        $("#formAgregarDocumento")[0].reset();
        $("#formAgregarRemitente")[0].reset();
        $('#cuerpoTablaArchivos').html('');
        $('#btnPrincipal').show();
        mensaje('¡CORRECTO!', 'El tramite fue registrado con exito!.' , 'success');
      }else{
        mensaje('¡ERROR!', '¡Ah ocurrido un  error al registrar el tramite.' , 'error');
      }
    }
  });
  event.preventDefault();
});

$(document).on('click', '.btnBorrarArchivo', function(){
  let anexo = $(this).attr('id');
  let datos = new FormData();
  let nombreArchivo = $(this).attr('nombreArchivo');
  let carpeta = $(this).attr('carpeta');
  let elemento = $(this).parents('tr');
  datos.append("funcion", 'eliminarArchivo');
  datos.append("carpeta", carpeta);
  datos.append("nombreArchivo", nombreArchivo);
  borrarArchivo('ajax/documento.ajax.php', datos, carpeta, elemento, anexo)

});


