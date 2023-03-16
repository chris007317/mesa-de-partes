<?php 
  $tipoDocumento = ControladorDocumento::ctrMostrarTipoTramite();
  $gerencias = ControladorGerente::crtrMostrarGerencias(1);
 ?>
<div class="content-wrapper" style="min-height: 1667.6px;">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-10">
          <h1 >Documentos recibidos</h1>
        </div>
        <div class="col-sm-2">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Documentos recibidos</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <div class="form-group d-sm-flex">
                <a href="mesa-partes" class="btn btn-info btn-sm" target="_blank"><i class="fas fa-plus"></i> registrar tramité</a>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped dt-responsive" id="tablaTramites" width="100%">
                <thead style="font-size: 13px">
                  <tr>
                    <th style="width: 15px;">#</th>
                    <th>Tramite</th>
                    <th style="width: 200px;">Asunto</th>
                    <th style="width: 15px;">Folios</th>
                    <th style="width: 100px;">Fecha Registro</th>
                    <th>Viene de</th>
                    <th>Remitente</th>
                    <th style="width: 50px;">Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody style="font-size: 13px">
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              Footer
            </div>
            <!-- /.card-footer-->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>


<div class="modal" id="editarTramite">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formEditarTramite">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title">Editar tramite</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-6">
              <label class="lbl-form" for="dateFechaRegistro">Fecha registro</label>
              <div class="input-group input-group-sm">
                <input type="datetime-local" class="form-control" name="dateFechaRegistro" required>
              </div>
            </div>
            <div class="form-group col-6">
              <label class="lbl-form" for="cmbTipoTramite">Tipo tramite:</label>
              <select class="form-control form-control-sm" name="cmbTipoTramite" id="cmbTipoTramite" required>
                <?php foreach ($tipoDocumento as $key => $value): ?>
                  <option value="<?php echo $value['idTipoTramite']; ?>"><?php echo $value['nombreTipoTramite']; ?></option>
                <?php endforeach ?>
              </select>
            </div>            
          </div>
          <div class="form-row">
            <div class="form-group col-3">
              <label class="lbl-form" for="txtFolioTramite">Folios:</label>
              <input type="number" class="form-control form-control-sm" name="txtFolioTramite" value="0" min="0" required>
            </div>
            <div class="form-group col-3">
              <label class="lbl-form" for="txtNumeroTramite">Número:</label>
              <input type="text" class="form-control form-control-sm" name="txtNumeroTramite" placeholder="Número" pattern="[0-9]+" required>
            </div>
            <div class="form-group col-6">
              <label class="lbl-form" for="txtSiglasTramite">Siglas:</label>
              <input type="text" class="form-control form-control-sm" name="txtSiglasTramite" placeholder="Siglas tramite" required>
            </div>            
          </div>
          <div class="form-row">
            <label class="lbl-form">Asunto:</label>
            <textarea class="form-control" name="txtAsuntoTramite" rows="3" placeholder="Describir el asunto"></textarea>
          </div>                  
        </div>
        <input type="hidden" name="funcion" value="editarTramite">
        <input type="hidden" name="idTramite">
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="verArchivos">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header bg-light">
        <h4 class="modal-title" id="tituloTramite"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        <!-- Modal body -->
      <div class="modal-body ">
        <table class="table table-striped table-sm m-0 p-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Tipo</th>
              <th style="width: 40px;">Ver</th>
            </tr>
          </thead>
          <tbody id="cuerpoTablaArchivos">
          </tbody>
        </table>                 
      </div>
        <!-- Modal footer -->
      <div class="modal-footer">
        <div>
          <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="enviarTramite">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="formEnviarTramite">
        <!-- Modal Header -->
        <div class="modal-header bg-light">
          <h4 class="modal-title" id="tituloEnvio"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-6">
              <label class="lbl-form" for="dateFechaEnvio">Fecha de envió</label>
              <div class="input-group input-group-sm">
                <input type="datetime-local" class="form-control" name="dateFechaEnvio" required>
              </div>
            </div>
            <div class="form-group col-6">
              <label class="lbl-form" for="cmbEstadoTramite">Estado tramité:</label>
              <select class="form-control form-control-sm" name="cmbEstadoTramite" id="cmbEstadoTramite" required>
                <option value="1">RECIBIDO</option>
                <option value="2">APROBADO</option>
                <option value="3">PENDIENTE</option>
                <option value="4">OBSERVADO</option>
                <option value="5">RECHAZADO</option>
              </select>
            </div>            
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label class="lbl-form" for="cmbGerencias">Seleccioné gerencia:</label>
              <select class="form-control form-control-sm" name="cmbGerencias" id="cmbGerencias" required>
                <option value="">Seleccioné una opción</option>
                <?php foreach ($gerencias as $key => $value): ?>
                  <option value="<?php echo $value['idGerencia']; ?>"><?php echo $value['nombreGerencia']; ?></option>
                <?php endforeach ?>
              </select>
            </div>        
            <div class="form-group col-6">
              <label class="lbl-form" for="txtGerente">Gerente:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtGerente" placeholder="Apellidos y nombres" readonly>
              </div>
            </div> 
          </div>
          <div class="form-row">
            <div class="form-group col-6">
              <label class="lbl-form" for="cmbSubGerencias">Seleccioné sub gerencia:</label>
              <select class="form-control form-control-sm" name="cmbSubGerencias" id="cmbSubGerencias" required>
                <option value="">Seleccioné una opción</option>
              </select>
            </div>        
            <div class="form-group col-6">
              <label class="lbl-form" for="txtResponsable">Responsable:</label>
              <div class="input-group input-group-sm">
                <input type="text" class="form-control" name="txtResponsable" placeholder="Apellidos y nombres" readonly>
              </div>
            </div> 
          </div>                
        </div>
        <input type="hidden" name="funcion" value="enviarTramite">
        <input type="hidden" name="idEnvioTramite">
        <input type="hidden" name="idGerente">
        <input type="hidden" name="idResponsable">
        <!-- Modal footer -->
        <div class="modal-footer">
          <div>
            <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
          </div>
          <div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="verRuta">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header bg-light">
        <h4 class="modal-title">Ruta de tramité</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        <!-- Modal body -->
      <div class="modal-body ">   
        <div class="timeline timeline-inverse pb-0 mb-0" id="ruta">                  
        </div>   
      </div>
        <!-- Modal footer -->
      <div class="modal-footer">
        <div>
          <button type="button" class="btn btn-dark" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>