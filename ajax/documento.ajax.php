<?php 
	require_once '../controlador/documento.controlador.php';
	require_once '../modelo/documento.modelo.php';
	session_start();
	date_default_timezone_set('America/Lima');
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'subirArchivo') {
		if (isset($_FILES['archivo']['tmp_name']) && !empty($_FILES['archivo']['tmp_name']) && $_FILES['archivo']['error'] == 0 && !empty($_POST['dniPersona'])) {
			if (empty($_POST['dniPersona']) && !isset($_POST['dniPersona'])) {
				$response = '{"valor":"error"}';
				echo json_encode($response);
			}
			$dni = $_POST['dniPersona'];
			$nombrePdf = $dni.'-'.date("d-m-Y").'-'.uniqid();
			$directorio = '../archivos/'.$_POST['carpeta'].'/';
			$ruta = $directorio.$nombrePdf.".pdf";

			if ($_FILES['archivo']['type'] == "application/pdf") {

				if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta)) {
					$response = '{"valor":"ok", "nombreArchivo":"'.$_FILES['archivo']['name'].'","nombreArchivoNuevo":"'.$nombrePdf.'.pdf"}';
					echo json_encode($response);
				}else{
					$response = '{"valor":"error"}';
					echo json_encode($response);
				}
			}else{
				$response = '{"valor":"novalido"}';
				echo json_encode($response);
			}
		}else{
			$response = '{"valor":"no"}';
			echo json_encode($response);
		}		
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'eliminarArchivo') {
		if (unlink('../archivos/'.$_POST['carpeta'].'/'.$_POST['nombreArchivo'])) {
			echo "ok";
		}else{
			echo "error";
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'agregarDocumento') {
		$documento = ControladorDocumento::ctrAgregarTramite();
		echo $documento;
		
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarTramite') {
		$documento = ControladorDocumento::ctrBuscarTramite('idTramite', $_POST['idTramite']);
		echo json_encode($documento);
	}

	/* editar el tramite */
	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarTramite') {
		$documento = ControladorDocumento::ctrEditarTramite();
		echo $documento;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarArchivos') {
		$documento = ControladorDocumento::ctrBuscarTramite('idTramite', $_POST['idTramite']);
		$template = '';
		$arrData = [];
		$titulo = $documento['nombreTipoTramite'].'-'.$documento['numTramite'].'-'.$documento['siglasTramite'];
		$anexos = json_decode($documento['anexoTramite']);
		$num = 1;
		$template .='<tr>
			<td>'.$num.'</td>
			<td>Principal</td> 
			<td></button><a href="pdfview?tipo=principal&archivo='.$documento['archivoTramite'].'" class="btn btn-danger btn-sm btnVerArchivo" title="Ver archivo" target="_blank"><i class="fas fa-file-pdf"></i></a>
			</td>
		</tr>';
		foreach ($anexos as $key => $value) {
			$template .='<tr>
				<td>'.($num+1).'</td>
				<td>Anexo '.$num.'</td> 
				<td><a href="pdfview?tipo=anexos&archivo='.$value->anexo.'" class="btn btn-danger btn-sm btnVerArchivo" title="Ver archivo" target="_blank"><i class="fas fa-file-pdf"></i></a>
				</td>
			</tr>';			
			$num++;
		}
		$arrData = array('titulo'=>$titulo, 'tabla'=>$template);
		echo json_encode($arrData);
	}

	if(isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'enviarTramite'){
		$documento = ControladorDocumento::ctrEnviarDocumento();
		echo $documento;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarRuta') {
		$documento = ControladorDocumento::ctrBuscarTramite('idTramite', $_POST['idTramite']); 
		$rutaDocumento = ControladorDocumento::ctrVerRutaDocumento('idRutaTramite',$_POST['idTramite']);
		$historiaDocumento = ControladorDocumento::ctrVerHistoria('idHistoriaTramite',$_POST['idTramite']);
		$template = '';
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$cont = 0;
		$ref= '';
		if($documento['idEntradaSalida'] == 1){
			$ref = 'DOCUMENTO ENVIADO A';
		}else{
			$ref = 'DOCUMENTO RECIBIDO DE';
		}
		foreach ($rutaDocumento as $key => $value) {
			if ($value['fechaRegistro'] == $documento['fechaRegistro']) {
				if ($cont == 0) {
					$dia = date('d',strtotime($documento['fechaRegistro']));
					$mes = date('m',strtotime($documento['fechaRegistro']));
					$year = date('Y',strtotime($documento['fechaRegistro']));
					$nombreDocumento = $documento['nombreTipoTramite'].'-'.$documento['numTramite'].'-'.$documento['siglasTramite'];
					if ($documento['idEstado'] == 1) {
						$estadoTramite = "<span class='badge badge-info'>Recibido</span>";
					}else if ($documento['idEstado'] == 2) {
						$estadoTramite = "<span class='badge badge-success'>Aprobado</span>";
					}else if ($documento['idEstado'] == 3) {
						$estadoTramite = "<span class='badge badge-warning'>Pendiente</span>";
					}else if ($documento['idEstado'] == 4) {
						$estadoTramite = "<span class='badge badge-danger'>Observado</span>";
					}else if($documento['idEstado'] == 5){
						$estadoTramite = "<span class='badge badge-dark'>Rechazado</span>";
					}
					$template .= '<div class="time-label"><span class="bg-primary">'.$dia.', '.$meses[$mes-1].' '.$year.'</span></div>
					          <div class="row mb-1">
					            <div class="col-1 centrar"><span class="iconoHistoria bg-warning ml-3"><i class="fas fa-file-alt"></i></span></div>
					            <div class="card col-11 bg-light">
					              <div class="card-header rutaTitulo p-2">
					                <h5 class="card-title p-0 col-10"><span>TRAMITÉ:</span> '.$nombreDocumento.'</h5>
					                <div class="col-2"><i class="fas fa-clock"></i> '.$documento['hora'].'</div>
					              </div>
					              <div class="card-body p-2">
					                <p class="m-0">ASUNTO: '.$documento['asuntoTramite'].'</p>
					                <p class="m-0">DIRIGIDO: '.$documento['nombreSubGerencia'].'</p>
					                <p class="m-0">ESTADO: '.$estadoTramite.'</p>
					              </div>
					            </div>
					          </div>
		                      <div class="row mb-1">
					            <div class="col-1 centrar"><span class="iconoHistoria bg-info ml-3"><i class="fas fa-user"></i></span></div>
					            <div class="card col-11 bg-light">
					              <div class="card-header rutaTitulo p-2">
					                <h5 class="card-title p-0 col-10"><span>REMITENTE: </span> '.$documento['apellidoPaternoPersona'].' '.$documento['apellidoMaternoPersona'].', '.$documento['nombresPersona'].'</h5>
					                <div class="col-2"><i class="fas fa-clock"></i> '.$documento['hora'].'</div>
					              </div>
					            </div>
					          </div>';
					$cont++;
				}
				$template .= '<div class="row mb-1">
					            <div class="col-1 centrar"><span class="iconoHistoria bg-success ml-3"><i class="fas fa-envelope"></i></span></div>
					            <div class="card col-11 bg-light">
					              <div class="card-header rutaTitulo p-2">
					                <h5 class="card-title p-0 col-10"><span>'.$ref.':</span></h5>
					                <div class="col-2"><i class="fas fa-clock"></i> '.$value['hora'].'</div>
					              </div>
					              <div class="card-body p-2">
					                <p class="m-0">GERENCIA: '.$value['nombreGerencia'].'</p>
					                <p class="m-0">SUB GERENCIA: '.$value['nombreSubGerencia'].'</p>
					              </div>
					            </div>
					          </div>';

			}else{
				$dia = date('d',strtotime($value['fechaRegistro']));
				$mes = date('m',strtotime($value['fechaRegistro']));
				$year = date('Y',strtotime($value['fechaRegistro']));
				$template .= '<div class="time-label"><span class="bg-primary">'.$dia.', '.$meses[$mes-1].' '.$year.'</span></div>
							<div class="row mb-1">
					            <div class="col-1 centrar"><span class="iconoHistoria bg-success ml-3"><i class="fas fa-envelope"></i></span></div>
					            <div class="card col-11 bg-light">
					              <div class="card-header rutaTitulo p-2">
					                <h5 class="card-title p-0 col-10"><span>DOCUMENTO ENVIADO A:</span></h5>
					                <div class="col-2"><i class="fas fa-clock"></i> '.$value['hora'].'</div>
					              </div>
					              <div class="card-body p-2">
					                <p class="m-0">GERENCIA: '.$value['nombreGerencia'].'</p>
					                <p class="m-0">SUB GERENCIA: '.$value['nombreSubGerencia'].'</p>
					              </div>
					            </div>
					          </div>';
			}
		}
		$template .= '<div class="time-label"><span class="bg-primary">Historia</span></div>';
		foreach ($historiaDocumento as $key => $value) {
			$template .= '<div class="row mb-1">
				            <div class="col-1 centrar"><span class="iconoHistoria bg-danger ml-3"><i class="fas fa-list"></i></span></div>
				            <div class="card col-11 bg-light">
				              <div class="card-header rutaTitulo p-2">
				                <h5 class="card-title p-0 col-10"><span>REGISTRO DE RESPONSABLES CUANDO SE ENVIO EL DOCUMENTO</span></h5>
				              </div>
				              <div class="card-body p-2">
				                <p class="m-0">'.$value['nombreGerencia'].': '.$value['gerente'].'</p>
				                <p class="m-0">'.$value['nombreSubGerencia'].': '.$value['responsable'].'</p>
				              </div>
				            </div>
				          </div>';
		}
		echo $template;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'eliminarTramite') {
		$documento = ControladorDocumento::ctrEditarTramiteValor('estadoTramite', 0, $_POST['idTramite']);
		echo $documento;
	}