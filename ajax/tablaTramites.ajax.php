<?php 
	require_once '../controlador/documento.controlador.php';
	require_once '../modelo/documento.modelo.php';
	Class TablaDocumento{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$documentos = ControladorDocumento::ctrMostrarDocumentos($_POST['estado']);
			if (count($documentos) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				foreach ($documentos as $key => $value) {
					if ($value['idEstado'] == 1) {
						$estadoTramite = "<div class='text-center'><h5><span class='badge badge-info'>Recibido</span></h5></div>";
					}else if ($value['idEstado'] == 2) {
						$estadoTramite = "<div class='text-center'><h5><span class='badge badge-success'>Aprobado</span></h5></div>";
					}else if ($value['idEstado'] == 3) {
						$estadoTramite = "<div class='text-center'><h5><span class='badge badge-warning'>Pendiente</span></h5></div>";
					}else if ($value['idEstado'] == 4) {
						$estadoTramite = "<div class='text-center'><h5><span class='badge badge-danger'>Observado</span></h5></div>";
					}else if($value['idEstado'] == 5){
						$estadoTramite = "<div class='text-center'><h5><span class='badge badge-dark'>Rechazado</span></h5></div>";
					}
					$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarTramite' title='Editar el tramite' idTramite='".$value['idTramite']."' data-toggle='modal' data-target='#editarTramite'><i class='fas fa-edit'></i></button><button class='btn btn-info btn-sm btnVerArchivos' title='Ver archivos' idTramite='".$value['idTramite']."' data-toggle='modal' data-target='#verArchivos'><i class='fas fa-eye'></i></button><button class='btn btn-secondary btn-sm verRuta' title='Ver rutas' idTramite='".$value['idTramite']."' data-toggle='modal' data-target='#verRuta'><i class='fas fa-th-list'></i></button><button class='btn btn-success btn-sm enviarTramite' title='Enviar archivos' idTramite='".$value['idTramite']."' data-toggle='modal' data-target='#enviarTramite'><i class='fas fa-paper-plane'></i></button><button class='btn btn-danger btn-sm eliminarTramite' title='Eliminar tramite' idTramite='".$value['idTramite']."'><i class='fas fa-backspace'></i></button></div>";
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreTipoTramite'].'-'.$value['numTramite'].'-'.$value['siglasTramite'].'",
							"'.$value['asuntoTramite'].'",
							"'.$value['folioTramite'].'",
							"'.$value['fechaRegistroTramite'].'",
							"'.$value['nombreSubGerencia'].'",
							"'.$value['nombresPersona'].' '.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].'",
							"'.$estadoTramite.'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				echo $datosJson;
			}
		}
	}

	$planes = new TablaDocumento();
	$planes->mostrarTabla();