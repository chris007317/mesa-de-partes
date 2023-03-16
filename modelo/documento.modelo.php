<?php 
	require_once "consultas.php";
	Class ModeloDocumento{
		
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/* listar tipos de tramite */
		public function mdlMostrarTipoTramite(){
			$sql = "SELECT * FROM tipo_tramite ORDER BY nombreTipoTramite ASC";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;				
		}

		public function mdlAgregarTramite($numeroTramite, $siglasTramite, $asuntoTramite, $folioTramite, $archivoTramite, $anexos, $fechaRegistro, $tipoTramite, $idSubGerencia, $idPersona, $idUsuario, $idEntradaSalida, $idEstado){
			$sql = "INSERT INTO tramites(numTramite, siglasTramite, asuntoTramite, folioTramite, archivoTramite, anexoTramite, fechaRegistroTramite, idTipoTramite, idSubGerencia, idTramitePersona, idTramiteUsuario, idEntradaSalida, idEstado) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$arrData = array($numeroTramite, $siglasTramite, $asuntoTramite, $folioTramite, $archivoTramite, $anexos, $fechaRegistro, $tipoTramite, $idSubGerencia, $idPersona, $idUsuario, $idEntradaSalida, $idEstado); 
			$respuesta = $this->consulta->insert($sql, $arrData);	
			return $respuesta;
		}

		public function mdlAgregarRuta($idTramite, $idSubGerencia, $idUsuario, $fechaRegistro){
			$sql = "INSERT INTO rutas(idRutaTramite, idRutaSubGerencia, idRutaUsuario, fechaRegistroRuta) VALUES (?,?,?,?)";
			$arrData = array($idTramite, $idSubGerencia, $idUsuario, $fechaRegistro); 
			$respuesta = $this->consulta->insert($sql, $arrData);	
			return $respuesta;	
		}

		public function mdlAgregarHistoria($idTramite, $idGerencia, $idSubGerencia){
			$sql = "SELECT * FROM gerentes WHERE idGerenteGerencia = $idGerencia AND estado = 1 LIMIT 1";
			$gerente = $this->consulta->select($sql);
			$sql1 = "SELECT * FROM responsables WHERE idResponsableSubGerencia = $idSubGerencia AND estado = 1 LIMIT 1";
			$responsable = $this->consulta->select($sql1);
			$sql3 = "INSERT INTO historia(idHistoriaTramite, idHistoriaGerente, idHistoriaSubGerente) VALUES (?,?,?)";
			$arrData = array($idTramite, $gerente['idGerente'], $responsable['idResponsable']); 
			$respuesta = $this->consulta->insert($sql3, $arrData);	
			return $respuesta;	
		}

		public function mdlMostrarDocumentos($tipoTramite){
			$sql = "SELECT tramites.*, nombreTipoTramite, nombreSubGerencia, nombresPersona, apellidoPaternoPersona, apellidoMaternoPersona, dniPersona FROM tramites
				INNER JOIN tipo_tramite ON tramites.idTipoTramite = tipo_tramite.idTipoTramite
				INNER JOIN sub_gerencias ON tramites.idSubGerencia = sub_gerencias.idSubGerencia
				INNER JOIN personas ON tramites.idTramitePersona= personas.idPersona
				WHERE idEntradaSalida = $tipoTramite AND estadoTramite = TRUE ORDER BY tramites.fechaRegistroTramite ASC;";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;					
		}

		public function mdlBuscarTramite($item, $valor){
			$sql = "SELECT tramites.*, date(fechaRegistroTramite) AS fechaRegistro, TIME(fechaRegistroTramite) AS hora, nombreTipoTramite, nombreSubGerencia, nombresPersona, apellidoPaternoPersona, apellidoMaternoPersona, dniPersona 
				FROM tramites
				INNER JOIN tipo_tramite ON tramites.idTipoTramite = tipo_tramite.idTipoTramite
				INNER JOIN sub_gerencias ON tramites.idSubGerencia = sub_gerencias.idSubGerencia
				INNER JOIN personas ON tramites.idTramitePersona= personas.idPersona WHERE $item = '$valor' LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}

		public function mdlEditarTramite($numeroTramite, $siglasTramite, $asuntoTramite, $folioTramite, $fechaRegistro, $tipoTramite, $idTramite){
			$sql ="UPDATE tramites SET numTramite = ?, siglasTramite = ?, asuntoTramite = ?, folioTramite = ?, fechaRegistroTramite = ?, idTipoTramite = ? 
					WHERE idTramite = $idTramite;";
			$arrData = array($numeroTramite, $siglasTramite, $asuntoTramite, $folioTramite, $fechaRegistro, $tipoTramite); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}

		public function mdlEditarTramiteValor($item, $valor, $idTramite){
			$sql ="UPDATE tramites SET $item = ? WHERE idTramite = $idTramite;";
			$arrData = array($valor); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}

		public function mdlVerRutaDocumento($item, $valor){
			$sql = "SELECT rutas.*, date(fechaRegistroRuta) AS fechaRegistro, TIME(fechaRegistroRuta) AS hora, nombreSubGerencia, nombreGerencia FROM rutas
					INNER JOIN sub_gerencias ON idRutaSubGerencia = idSubGerencia
					INNER JOIN gerencias ON idGer = idGerencia WHERE $item = '$valor' ORDER BY fechaRegistroRuta ASC;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}

		public function mdlVerHistoria($item, $valor){
			$sql = "SELECT historia.*, CONCAT(ger.apellidoPaternoPersona, ' ', ger.apellidoMaternoPersona, ', ', ger.nombresPersona) AS gerente,
					nombreGerencia, CONCAT(res.apellidoPaternoPersona, ' ', res.apellidoMaternoPersona, ', ', res.nombresPersona) AS responsable,
					nombreSubGerencia FROM historia 
					INNER JOIN gerentes ON idHistoriaGerente = idGerente
					INNER JOIN personas AS ger ON idGerentePersona = ger.idPersona
					INNER JOIN gerencias ON idGerenteGerencia = idGerencia 
					INNER JOIN responsables ON idHistoriaSubGerente= idResponsable
					INNER JOIN personas AS res ON idResponsablePersona= res.idPersona
					INNER JOIN sub_gerencias ON idResponsableSubGerencia= idSubGerencia
					WHERE idHistoriaTramite = 2 ORDER BY idhistoria ASC;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;			
		}
	}