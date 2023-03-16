<?php 
	require_once "consultas.php";
	Class ModeloGerente{
		private $idGerentePersona;
		private $idGerencia;
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/* buscar existencia de gerente */
		public function mdlBuscarGerente($dni){
			$sql = "SELECT idGerente, idGerentePersona, idGerenteGerencia, gerentes.estado, dniPersona, idPersona, nombresPersona, apellidoPaternoPersona,
				apellidoMaternoPersona, correoPersona, celularPersona
			    FROM gerentes
				INNER JOIN personas ON idGerentePersona = idPersona WHERE dniPersona = '$dni' AND gerentes.estado = TRUE LIMIT 1";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
		public function mdlBuscarGerencia($nombreGerencia){
			$sql = "SELECT * FROM gerencias
				WHERE nombreGerencia = '$nombreGerencia' AND estado = TRUE LIMIT 1";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
		public function mdlAgregarGerencia($nombreGerencia){
			$sql = "INSERT INTO gerencias(nombreGerencia) VALUES (?)";
			$arrData = array($nombreGerencia); 
			$respuesta = $this->consulta->insert($sql, $arrData);	
			return $respuesta;
		}
		public function mdlAgregarGerente($idGerentePersona, $idGerencia){
			$this->idGerentePersona = $idGerentePersona;
			$this->idGerencia = $idGerencia;
			$sql = "INSERT INTO gerentes(idGerentePersona, idGerenteGerencia) VALUES (?,?)";
			$arrData = array($this->idGerentePersona, $this->idGerencia); 
			$respuesta = $this->consulta->insert($sql, $arrData);	
			return $respuesta;
		}
		/* mostrar gerencias */
		public function mdlMostrarGerencias($estado){
			$sql = "SELECT * FROM gerencias WHERE estado = $estado";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
		/* buscar gerente */
		public function mdlMostrarGerente($item, $valor){
			$sql = "SELECT idGerente, idGerenteGerencia, gerentes.estado, dniPersona, idPersona, nombresPersona, apellidoPaternoPersona,
				apellidoMaternoPersona, correoPersona, celularPersona
			    FROM gerentes
				INNER JOIN personas ON idGerentePersona = idPersona WHERE $item = '$valor' AND gerentes.estado = TRUE LIMIT 1";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;	
		}

		public function mdlTablaGerencias(){
			$sql = "SELECT gerentes.*, idGerencia, nombreGerencia, personas.* FROM gerentes
				INNER JOIN personas ON idGerentePersona = idPersona
				INNER JOIN gerencias ON idGerenteGerencia = idGerencia WHERE gerentes.estado = TRUE;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
	}