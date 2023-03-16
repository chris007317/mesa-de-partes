<?php 
  $gerencias = ControladorGerente::crtrMostrarGerencias();
 ?>
  <div class="content-wrapper" style="min-height: 1592.4px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Configuración del sistema</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">configuración</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="#gerencias" data-toggle="tab">Gerencias</a></li>
                  <li class="nav-item"><a class="nav-link active" href="#subGerencias" data-toggle="tab">Sub gerencias</a></li>
                  <li class="nav-item"><a class="nav-link" href="#responsables" data-toggle="tab">Gerentes y responsables</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane" id="gerencias">
                    <div class="row">
                      <div class=" col-lg-5">
                        <h3 class="titulo-form text-center">Registrar gerencia</h3>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="formAgregarGerente" method="POST">
                          <div class="card-body">
                            <div class="form-group">
                              <label class="lbl-form" for="txtGerencia">Nombre de gerencia:</label>
                              <input type="text" class="form-control form-control-sm" name="txtGerencia" placeholder="Nombre de gerencia" required>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-sm-6">
                                <label class="lbl-form" id="txtDniGerente">DNI gerente:</label>
                                <div class="input-group input-group-sm">
                                  <input type="text" class="form-control" name="txtDniGerente" placeholder="Ingrese DNI" maxlength="8" minlength="8" pattern="[0-9]+" required>
                                  <span class="input-group-append">
                                    <button type="button" class="btn btn-info btn-flat" id="btnBuscarGerente"><i class="fas fa-search"></i></button>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group col-sm-6">
                                <label class="lbl-form" for="txtNombreGerente">Nombre del gerente:</label>
                                <input type="text" class="form-control form-control-sm" name="txtNombreGerente" placeholder="Nombre del gerente" readonly required>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-sm-6">
                                <label class="lbl-form" id="txtApellidoPaternoGerente">Apellido Paterno:</label>
                                <input type="text" class="form-control form-control-sm" name="txtApellidoPaternoGerente" placeholder="Apellido paterno" readonly required>
                              </div>
                              <div class="form-group col-sm-6">
                                <label class="lbl-form" for="txtApellidoMaternoGerente">Apellido materno:</label>
                                <input type="text" class="form-control form-control-sm" name="txtApellidoMaternoGerente" placeholder="Apellido materno" readonly required>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-sm-6">
                                <label class="lbl-form" name="txtCelularGerente">Celular:</label>
                                <input type="text" class="form-control form-control-sm" name="txtCelularGerente" placeholder="Celular">
                              </div>
                              <div class="form-group col-sm-6">
                                <label class="lbl-form" for="txtCorreoGerente">Correo:</label>
                                <input type="email" class="form-control form-control-sm" name="txtCorreoGerente" placeholder="Correo">
                              </div>
                            </div>
                          </div>
                          <input type="hidden" name="idGerentePersona">
                          <input type="hidden" name="funcion" value="agregarGerente">
                          <div class="btn-100">
                            <button type="button" id="cancelarGerencia" class="btn btn-dark btn-sm col-4"><i class="fas fa-window-close"></i> Cancelar</button>
                            <button type="submit" class="btn btn-info btn-sm col-4"><i class="fas fa-save"></i> Guardar</button>
                          </div>
                        </form>
                      </div>   
                      <div class="table-responsive col-lg-7">
                        <div class="buscar-grupo">
                          <h3 class="titulo-form">Gerencias</h3>
                        </div>
                        <div>
                          <table class="table table-bordered table-striped dt-responsive" id="tablaGerentes" width="100%">
                            <thead style="font-size: 13px">
                              <tr>
                                <th style="width: 15px;">#</th>
                                <th>Gerencia</th>
                                <th>Gerente</th>
                                <th>Celular</th>
                                <th>Acciones</th>
                              </tr>
                            <tbody style="font-size: 13px">
                            <tbody >
                            </tbody>
                          </table>
                        </div>                               
                          
                        </div>
                      
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="active tab-pane" id="subGerencias">
                    <div class="row">
                      <div class=" col-lg-4">
                        <h3 class="titulo-form text-center">Registrar sub gerencia</h3>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" id="formAgregarSubGerente">
                          <div class="card-body">
                            <div class="form-group">
                              <label id="cmbGerencias" class="lbl-form">Gerencia: </label>
                              <select class="form-control form-control-sm" name="cmbGerencias" required>
                                <option value="0">Seleccione gerencia</option>
                                <?php foreach ($gerencias as $key => $value): ?>
                                <option value="<?php echo $value['idGerencia']; ?>"><?php echo $value['nombreGerencia'] ?></option>  
                                <?php endforeach ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label class="lbl-form" for="txtSubGerencia">Nombre de sub gerencia:</label>
                              <input type="text" class="form-control form-control-sm" name="txtSubGerencia" placeholder="Nombre de gerencia" required>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-sm-6">
                                <label class="lbl-form" id="txtDniSubGerente">DNI responsable:</label>
                                <div class="input-group input-group-sm">
                                  <input type="text" class="form-control" name="txtDniResponsable" placeholder="Ingrese DNI" maxlength="8" minlength="8" required>
                                  <span class="input-group-append">
                                    <button type="button" id="btnBuscarResponsable" class="btn btn-info btn-flat"><i class="fas fa-search"></i></button>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group col-sm-6">
                                <label class="lbl-form" for="txtNombreResponsable">Nombre del responsable:</label>
                                <input type="text" class="form-control form-control-sm" name="txtNombreResponsable" placeholder="Nombre del gerente" readonly required>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-sm-6">
                                <label class="lbl-form" id="txtApellidoPaternoResponsable">Apellido paterno:</label>
                                <input type="text" class="form-control form-control-sm" name="txtApellidoPaternoResponsable" placeholder="Apellido paterno" readonly required>
                              </div>
                              <div class="form-group col-sm-6">
                                <label class="lbl-form" for="txtApellidoMaternoResponsable">Apellido materno:</label>
                                <input type="text" class="form-control form-control-sm" name="txtApellidoMaternoResponsable" placeholder="Apellido materno" readonly required>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-sm-6">
                                <label class="lbl-form" id="celularResponsable">Celular:</label>
                                <input type="text" class="form-control form-control-sm" name="celularResponsable" placeholder="Celular">
                              </div>
                              <div class="form-group col-sm-6">
                                <label class="lbl-form" for="txtCorreoResponsable">Correo:</label>
                                <input type="email" class="form-control form-control-sm" name="txtCorreoResponsable" placeholder="Correo">
                              </div>
                            </div>
                          </div>
                          <input type="hidden" name="idResponsablePersona">
                          <input type="hidden" name="funcion" value="agregarSubGerencia">
                          <div class="btn-100">
                            <button type="button" id="cancelarSubGerencia" class="btn btn-dark btn-sm col-4"><i class="fas fa-window-close"></i> Cancelar</button>
                            <button type="submit" class="btn btn-info btn-sm col-4"><i class="fas fa-save"></i> Guardar</button>
                          </div>
                        </form>
                      </div>   
                      <div class="table-responsive col-lg-8">
                        <div class="buscar-grupo">
                          <h3 class="titulo-form">Sub gerencias</h3>
                        </div>
                        <table class="table table-bordered table-striped dt-responsive" id="tablaSubGerentes" width="100%">
                            <thead style="font-size: 13px">
                              <tr>
                                <th style="width:15px;">#</th>
                                <th>Gerencia</th>
                                <th>Sub Gerencia</th>
                                <th>Responsable</th>
                                <th style="width:40px">Celular</th>
                                <th>Acciones</th>
                              </tr>
                            </thead>
                            <tbody style="font-size:13px">
                            </tbody>
                        </table>
                      </div>                               
                      
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="responsables">
                    <table class="table table-sm">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Apellidos y Nombres</th>
                            <th>Depencia</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody id="cuerpoTablaRequisitos">
                          <tr>
                            <td>3</td>
                            <td>Christian I. Vilca justiniano</td>
                            <td>Gerencia de desarrollo</td>
                            <td>
                              <div class="btn-group">
                                <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                              </div>
                          </td>
                          </tr>
                        </tbody>
                    </table>                    
                  </div>
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>

    </section>
    <!-- /.content -->
  </div>