<?php 
	require_once "consultas.php";
	Class ModeloPersona{
		private $nombrePersona;
		private $apellidoPaterno;
		private $apellidoMaterno;
		private $dni;
		private $correoPersona;
		private $celularPersona;
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  mostrar persona  ----------*/
		public function mdlMostrarPersona($item, $valor){
			$sql = "SELECT * FROM personas  WHERE $item = '$valor' LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		/*----------  agregar persona  ----------*/
		public function mdlRegistrarPersona($nombrePersona, $apellidoMaterno, $apellidoPaterno, $dni, $correo, $celular){
			$this->nombrePersona = $nombrePersona;
			$this->apellidoMaterno = $apellidoMaterno;
			$this->apellidoPaterno = $apellidoPaterno;
			$this->dni = $dni;
			$this->correoPersona = $correo;
			$this->celularPersona = $celular;
			$sql = "SELECT idPersona FROM personas WHERE dniPersona = '$this->dni' LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO personas (dniPersona, nombresPersona, apellidoPaternoPersona, apellidoMaternoPersona, celularPersona, correoPersona) VALUES(?,?,?,?,?,?)";
				$arrData = array($this->dni, $this->nombrePersona, $this->apellidoPaterno, $this->apellidoMaterno,$this->celularPersona,$this->correoPersona); 
				$respuesta = $this->consulta->insert($sql, $arrData);
			}else{
				$respuesta = $respuesta['idPersona'];
			}
			return $respuesta;
		}

		/*----------  editar un campo de la person  ----------*/
		public function mdlEditarPersona($idPersona, $celularPersona, $correoPersona){
			$this->idPersona = $idPersona;
			$this->celularPersona = $celularPersona;
			$this->correoPersona = $correoPersona;
			$sql = "UPDATE personas SET celularPersona = ?, correoPersona = ? WHERE idPersona = $this->idPersona";
			$arrData = array($this->celularPersona, $this->correoPersona); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}
	}

 ?>