<?php 
	require_once "consultas.php";
	Class ModeloResponsable{
		private $idResponsablePersona;
		private $idGerencia;
		private $nombreSubGerencia;
		private $idSubGerencia;

		public function __construct(){
			$this->consulta = new Consultas();
		}
		/* buscar existencia de Responsable */
		public function mdlBuscarResponsable($dni){
			$sql = "SELECT idResponsable, idResponsableSubGerencia, responsables.estado, dniPersona, idPersona, nombresPersona, apellidoPaternoPersona,
				apellidoMaternoPersona, correoPersona, celularPersona
			    FROM responsables
				INNER JOIN personas ON idResponsablePersona = idPersona WHERE dniPersona = '$dni' AND responsables.estado = TRUE LIMIT 1";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
		/* buscar sub gerencia */
		public function mdlBuscarSubGerencia($nombreSubGerencia){
			$sql = "SELECT * FROM sub_gerencias
				WHERE nombreSubGerencia = '$nombreSubGerencia' AND estado = TRUE LIMIT 1";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
		/* agregar sub gerencia */
		public function mdlAgregarSubGerencia($idGerencia, $nombreSubGerencia){
			$sql = "INSERT INTO sub_gerencias(idGer, nombreSubGerencia) VALUES (?,?)";
			$arrData = array($idGerencia, $nombreSubGerencia); 
			$respuesta = $this->consulta->insert($sql, $arrData);	
			return $respuesta;

		}
		/* Agregar responsble de la sub gerencia */
		public function mdlAgregarResponsable($idPersona, $idSubGerencia){
			$this->idResponsablePersona = $idPersona;
			$this->idSubGerencia = $idSubGerencia;
			$sql = "INSERT INTO responsables(idResponsablePersona, idResponsableSubGerencia) VALUES (?,?)";
			$arrData = array($this->idResponsablePersona, $this->idSubGerencia); 
			$respuesta = $this->consulta->insert($sql, $arrData);	
			return $respuesta;
		}

		public function mdlMostrarSubGerencia($idGerencia){
			$sql = "SELECT * FROM sub_gerencias WHERE idGer = $idGerencia AND estado = TRUE";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}

		/* buscar resposnsable */
		public function mdlMostrarResponsable($item, $valor){
			$sql = "SELECT idResponsable, idResponsableSubGerencia, responsables.estado, dniPersona, idPersona, nombresPersona, apellidoPaternoPersona,
				apellidoMaternoPersona, correoPersona, celularPersona
			    FROM responsables
				INNER JOIN personas ON idResponsablePersona = idPersona WHERE $item = '$valor' AND responsables.estado = TRUE LIMIT 1";
		   	$respuesta = $this->consulta->select($sql);
		   	return $respuesta;	
		}

		public function mdlTablaSubGerencias(){
			$sql = "SELECT responsables.*, personas.*, idSubGerencia, nombreSubGerencia, idGerencia, nombreGerencia FROM responsables
				INNER JOIN personas ON idResponsablePersona = idPersona
				INNER JOIN sub_gerencias ON idResponsableSubGerencia = idSubGerencia
				INNER JOIN gerencias ON idGer = idGerencia WHERE responsables.estado = TRUE;";
			$respuesta = $this->consulta->selectAll($sql);
			return $respuesta;
		}
	}