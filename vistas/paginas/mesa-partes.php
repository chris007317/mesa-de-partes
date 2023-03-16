<?php 
  $tipoDocumento = ControladorDocumento::ctrMostrarTipoTramite();
  $gerencias = ControladorGerente::crtrMostrarGerencias(1);
 ?>
  <div class="content-wrapper" style="min-height: 1592.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Mesa de partes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Mesa de partes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class=" col-12">
                    <h3 class="titulo-form">Datos del remitente</h3>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="formAgregarRemitente" method="POST">
                      <div class="card-body">
                        <div class="form-row">
                          <div class="form-group col-sm-6 col-lg-3">
                            <label class="lbl-form" id="txtDniRemitente">DNI remitente:</label>
                            <div class="input-group input-group-sm">
                              <input type="text" class="form-control" name="txtDniRemitente" placeholder="Ingrese DNI" maxlength="8" minlength="8" pattern="[0-9]+" required>
                              <span class="input-group-append">
                                <button type="button" class="btn btn-info btn-flat" id="btnBuscarRemitente"><i class="fas fa-search"></i></button>
                              </span>
                            </div>
                          </div>
                          <div class="form-group col-sm-6 col-lg-3">
                            <label class="lbl-form" for="txtNombreRemitente">Nombres:</label>
                            <input type="text" class="form-control form-control-sm" name="txtNombreRemitente" placeholder="Nombre del gerente" readonly required>
                          </div>
                          <div class="form-group col-sm-6 col-lg-3">
                            <label class="lbl-form" id="txtApellidoPaternoRemitente">Apellido Paterno:</label>
                            <input type="text" class="form-control form-control-sm" name="txtApellidoPaternoRemitente" placeholder="Apellido paterno" readonly required>
                          </div>
                          <div class="form-group col-sm-6 col-lg-3">
                            <label class="lbl-form" for="txtApellidoMaternoRemitente">Apellido materno:</label>
                            <input type="text" class="form-control form-control-sm" name="txtApellidoMaternoRemitente" placeholder="Apellido materno" readonly required>
                          </div>
                        </div>
                        <input type="hidden" name="funcion" value="agregarPersona">
                        <div class="form-row">
                          <div class="form-group col-sm-6 col-lg-3">
                            <label class="lbl-form" name="txtCelularRemitente">Celular:</label>
                            <input type="text" class="form-control form-control-sm" name="txtCelularRemitente" placeholder="Celular">
                          </div>
                          <div class="form-group col-sm-6 col-lg-3">
                            <label class="lbl-form" for="txtCorreoRemitente">Correo:</label>
                            <input type="email" class="form-control form-control-sm" name="txtCorreoRemitente" placeholder="Correo">
                          </div>
                          <input type="hidden" name="idRecurrente">
                          <div class="col-lg-6 btn-bottom">
                            <button type="button" id="btnCancelarRemitente" class="btn btn-dark btn-sm col-sm-4 col-lg-3"><i class="fas fa-window-close"></i> Limpiar</button>
                            <button type="submit" class="btn btn-info btn-sm col-sm-4 col-lg-3"><i class="fas fa-save"></i> Guardar</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  <hr>
                  </div>   
                  <form id="formAgregarDocumento" class="row col-12" method="POST">
                    <div class="col-sm-6 col-lg-7">
                      <h3 class="titulo-form">Datos del tramite</h3>
                      <div class="card-body">
                        <div class="form-row">
                          <div class="form-group col-sm-12 col-lg-6">
                            <label class="lbl-form" for="dateFechaRegistro">Fecha registro</label>
                            <div class="input-group input-group-sm">
                              <input type="datetime-local" class="form-control" name="dateFechaRegistro" required>
                            </div>
                          </div>
                          <div class="form-group col-sm-12 col-lg-6">
                            <label class="lbl-form" for="cmbTipoTramite">Tipo tramite:</label>
                            <select class="form-control form-control-sm" name="cmbTipoTramite" id="cmbTipoTramite" required>
                              <option value="">Seleccione una opción</option>
                              <?php foreach ($tipoDocumento as $key => $value): ?>
                                <option value="<?php echo $value['idTipoTramite']; ?>"><?php echo $value['nombreTipoTramite']; ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-sm-3 col-lg-1">
                            <label class="lbl-form" for="txtFolioTramite">Folios:</label>
                            <input type="number" class="form-control form-control-sm" name="txtFolioTramite" value="0" required>
                          </div>
                          <div class="form-group col-sm-3 col-lg-2">
                            <label class="lbl-form" for="txtNumeroTramite">Número:</label>
                            <input type="text" class="form-control form-control-sm" name="txtNumeroTramite" placeholder="Número" pattern="[0-9]+" required>
                          </div>
                          <div class="form-group col-sm-6 col-lg-3">
                            <label class="lbl-form" for="txtSiglasTramite">Siglas:</label>
                            <input type="text" class="form-control form-control-sm" name="txtSiglasTramite" placeholder="Siglas tramite" required>
                          </div>
                          <div class="form-group col-sm-12 col-lg-6">
                            <label class="lbl-form" for="cmbGerencias">Gerencia:</label>
                            <select class="form-control form-control-sm" name="cmbGerencias" id="cmbGerencias" required>
                              <option value="">Seleccione una opción</option>
                              <?php foreach ($gerencias as $key => $value): ?>
                                <option value="<?php echo $value['idGerencia']; ?>"><?php echo $value['nombreGerencia']; ?></option>
                              <?php endforeach ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-sm-12 col-lg-6">
                            <label class="lbl-form" for="cmbSubGerencia">Sub Gerencia:</label>
                            <select class="form-control form-control-sm" name="cmbSubGerencia" id="cmbSubGerencia" required>
                              <option value="">Seleccione una opción</option>
                            </select>
                          </div>
                          <div class="form-group col-sm-12 col-lg-6">
                            <label class="lbl-form" for="txtResponsable">Responsable:</label>
                            <input type="text" class="form-control form-control-sm" name="txtResponsable" placeholder="Apellidos y nombres" readonly>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="lbl-form">Asunto:</label>
                          <textarea class="form-control" name="txtAsuntoTramite" rows="3" placeholder="Describir el asunto"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 col-lg-5">
                      <div class="form-group">
                        <label>Subir archivos</label>
                        <div class="btn-bottom">
                          <div class="invoiceBox" id="btnPrincipal">
                            <label class="lbl-form" for="filePrincipal">
                              <div class="btn btn-sm btn-success" data-text="Archivo principal">
                                Archivo principal
                              </div>
                            </label>
                            <input type="file" id="filePrincipal" multiple="" name="filePrincipal" size="6000" accept="application/pdf" required>
                          </div>
                          <div class="invoiceBox">
                            <label for="fileAnexo">
                              <div class="btn btn-sm btn-warning" data-text="Anexos">
                                Anexos
                              </div>
                            </label>
                            <input type="file" id="fileAnexo" multiple="" name="fileAnexo" size="6000" accept="application/pdf">
                          </div>                        
                        </div>
                      </div>
                      <div class="form-row mb-3">
                        <div class="custom-control custom-radio w-50">
                          <input class="custom-control-input" type="radio" id="rdBtnRecibir" name="rdBtnTipoTramite" value="2" checked>
                          <label for="rdBtnRecibir" class="custom-control-label">Recibir documento</label>
                        </div>
                        <div class="custom-control custom-radio w-50">
                          <input class="custom-control-input" type="radio" id="rdBtnEnviar" name="rdBtnTipoTramite" value="1">
                          <label for="rdBtnEnviar" class="custom-control-label">Enviar documento</label>
                        </div>
                      </div>
                      <div class="table-responsive">
                        <table class="table">
                            <thead>
                              <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Acciones</th>
                              </tr>
                            </thead>
                            <tbody id="cuerpoTablaArchivos">
                            </tbody>
                        </table>
                      </div>   
                      <input type="hidden" name="idPersona" required>
                      <input type="hidden" name="dniPersona" required>
                      <input type="hidden" name="funcion" value="agregarDocumento" required>
                      <input type="hidden" name="nombreArchivoPrincipal" required>
                      <div id="anexos"></div>
                      <div class="col-lg-12 btn-bottom mt-3">
                        <button type="button" id="cancelarGerencia" class="btn btn-dark btn-sm  col-lg-3"><i class="fas fa-window-close"></i> Cancelar</button>
                        <button type="submit" class="btn btn-info btn-sm  col-lg-3"><i class="fas fa-save"></i> Guardar</button>
                      </div>                   
                      
                    </div>
                  </form>
                  
                </div>
                  <!-- /.tab-pane -->
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>

    </section>
    <!-- /.content -->
  </div>