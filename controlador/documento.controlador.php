<?php 
	Class ControladorDocumento{

		static public function ctrMostrarTipoTramite(){
			$tipoTramite = new ModeloDocumento();
			return $tipoTramite->mdlMostrarTipoTramite();
		}

		static public function ctrAgregarTramite(){
			if (isset($_POST['dateFechaRegistro']) && isset($_POST['cmbTipoTramite']) &&
				isset($_POST['txtFolioTramite']) && isset($_POST['txtNumeroTramite']) &&
				isset($_POST['txtSiglasTramite']) && !empty($_POST['dateFechaRegistro']) && 
				!empty($_POST['cmbTipoTramite']) && !empty($_POST['txtFolioTramite']) && 
				!empty($_POST['txtNumeroTramite']) && !empty($_POST['txtSiglasTramite']) &&
				isset($_POST['cmbSubGerencia']) && !empty($_POST['cmbSubGerencia']) &&
				isset($_POST['cmbGerencias']) && !empty($_POST['cmbGerencias']) &&
				isset($_POST['txtAsuntoTramite']) && !empty($_POST['txtAsuntoTramite']) &&
				isset($_POST['idPersona']) && !empty($_POST['idPersona']) &&
				isset($_POST['nombreArchivoPrincipal']) && !empty($_POST['nombreArchivoPrincipal'])
			) {
				$numeroTramite = intval($_POST['txtNumeroTramite']);
				$siglasTramite = trim($_POST['txtSiglasTramite']);
				$asuntoTramite = trim($_POST['txtAsuntoTramite']);
				$folioTramite = intval($_POST['txtFolioTramite']);
				$archivoTramite = $_POST['nombreArchivoPrincipal'];
				$arrAnexos = [];
				if (isset($_POST['anexos'])) {
					$anexos = $_POST['anexos'];
					foreach ($anexos as $key => $value) {
						$fil = array('anexo' => $value);
						array_push($arrAnexos, $fil);
					}
				}
				$anexos = json_encode($arrAnexos);
				$fechaRegistro = $_POST['dateFechaRegistro'];
				$tipoTramite = $_POST['cmbTipoTramite'];
				$idSubGerencia = $_POST['cmbSubGerencia'];
				$idGerencia = $_POST['cmbGerencias'];
				$idPersona = $_POST['idPersona'];
				$idUsuario = $_SESSION['idUsuarioSis'];
				$idEntradaSalida = $_POST['rdBtnTipoTramite'];
				$idEstado = 1;
				if (preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $siglasTramite) &&
					preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $asuntoTramite)
				){
					$documento = new ModeloDocumento();
					$idTramite = $documento->mdlAgregarTramite($numeroTramite, $siglasTramite, $asuntoTramite, $folioTramite, $archivoTramite, $anexos, $fechaRegistro, $tipoTramite, $idSubGerencia, $idPersona, $idUsuario, $idEntradaSalida, $idEstado);
					if ($idTramite > 0) {
						$idRuta = $documento->mdlAgregarRuta($idTramite, $idSubGerencia, $idUsuario, $fechaRegistro);
						if ($idRuta > 0) {
							$idHistoria = $documento->mdlAgregarHistoria($idTramite, $idGerencia, $idSubGerencia);
							if ($idHistoria > 0) {
								return 'ok';
							}
							return 'error';
						}
						return 'error';
					}
					return 'error';
				}else{
					return 'no';
				}
			}
		}

		static public function ctrMostrarDocumentos($tipoTramite){
			$respuesta = new ModeloDocumento();
			return $respuesta->mdlMostrarDocumentos($tipoTramite);
		}
		/* buscar tramite por item y valor */
		static public function ctrBuscarTramite($item, $valor){
			$respuesta = new ModeloDocumento();
			return $respuesta->mdlBuscarTramite($item, $valor);
		}
		/* editar datos de un tramite */
		static public function ctrEditarTramite(){
			if (isset($_POST['dateFechaRegistro']) && isset($_POST['cmbTipoTramite']) &&
				isset($_POST['txtFolioTramite']) && isset($_POST['txtNumeroTramite']) &&
				isset($_POST['txtSiglasTramite']) && !empty($_POST['dateFechaRegistro']) && 
				!empty($_POST['cmbTipoTramite']) && !empty($_POST['txtFolioTramite']) && 
				!empty($_POST['txtNumeroTramite']) && !empty($_POST['txtSiglasTramite']) &&
				isset($_POST['txtAsuntoTramite']) && !empty($_POST['txtAsuntoTramite']) &&
				isset($_POST['idTramite']) && !empty($_POST['idTramite'])
			) {
				$numeroTramite = intval($_POST['txtNumeroTramite']);
				$siglasTramite = trim($_POST['txtSiglasTramite']);
				$asuntoTramite = trim($_POST['txtAsuntoTramite']);
				$folioTramite = intval($_POST['txtFolioTramite']);
				$idTramite = intval($_POST['idTramite']);
				$fechaRegistro = $_POST['dateFechaRegistro'];
				$tipoTramite = $_POST['cmbTipoTramite'];	
				if (preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $siglasTramite) &&
					preg_match('/^[\/\=\\;\\_\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\$\\|\\-\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $asuntoTramite)
				){
					$documento = new ModeloDocumento();
					$respuesta = $documento->mdlEditarTramite($numeroTramite, $siglasTramite, $asuntoTramite, $folioTramite, $fechaRegistro, $tipoTramite, $idTramite);
					if ($respuesta) {
						return 'ok';
					}else{
						return 'error';
					}
				}else{
					return 'novalido';
				}						
			}
		}
		/* editar tramite guardar ruta e historia */
		static public function ctrEnviarDocumento(){
			if (isset($_POST['dateFechaEnvio']) && isset($_POST['cmbEstadoTramite']) &&
				isset($_POST['cmbGerencias']) && isset($_POST['cmbSubGerencias']) &&
				isset($_POST['idGerente']) && !empty($_POST['dateFechaEnvio']) && 
				!empty($_POST['cmbEstadoTramite']) && !empty($_POST['cmbGerencias']) && 
				!empty($_POST['cmbSubGerencias']) && !empty($_POST['idGerente']) &&
				isset($_POST['idResponsable']) && !empty($_POST['idResponsable']) &&
				isset($_POST['idEnvioTramite']) && !empty($_POST['idEnvioTramite'])
			) {
				$fechaEnvio = $_POST['dateFechaEnvio'];
				$estadoTramite = intval($_POST['cmbEstadoTramite']);
				$idGerencia = intval($_POST['cmbGerencias']);
				$idSubGerencia = intval($_POST['cmbSubGerencias']);
				$idGerente = intval($_POST['idGerente']);
				$idResponsable = intval($_POST['idResponsable']);
				$idTramite = intval($_POST['idEnvioTramite']);
				$idUsuario = $_SESSION['idUsuarioSis'];
				$documento = new ModeloDocumento();
				$respuesta = $documento->mdlEditarTramiteValor('idEstado', $estadoTramite, $idTramite);
				if ($respuesta) {
					$idRuta = $documento->mdlAgregarRuta($idTramite, $idSubGerencia, $idUsuario, $fechaEnvio);
					if ($idRuta > 0) {
						$idHistoria = $documento->mdlAgregarHistoria($idTramite, $idGerencia, $idSubGerencia);
						if ($idHistoria > 0) {
							return 'ok';
						}
						return 'error';
					}
					return 'error';					
				}
				return 'error';
			}
		}
		
		static public function ctrVerRutaDocumento($item, $valor){
			$respuesta = new ModeloDocumento();
			return $respuesta->mdlVerRutaDocumento($item, $valor);
		}

		static public function ctrVerHistoria($item, $valor){
			$respuesta = new ModeloDocumento();
			return $respuesta->mdlVerHistoria($item, $valor);
		}

		static public function ctrEditarTramiteValor($item, $valor, $idTramite){
			$documento = new ModeloDocumento();
			$respuesta = $documento->mdlEditarTramiteValor($item, $valor, $idTramite);
			if ($respuesta) {
				return 'ok';
			}
			return 'error';
		}
	}
