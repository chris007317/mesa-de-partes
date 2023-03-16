<?php 
	require_once "consultas.php";
	Class ModeloUsuario{
		private $nombreUsuario;
		private $contraUsuario;
		private $idPersona;
		private $idTipoUsuario;
		public function __construct(){
			$this->consulta = new Consultas();
		}
		/*----------  Mostrar usuarios  ----------*/
		public function mdlMostrarUsuario($atributo, $valor){
			$sql = "SELECT * FROM usuarios WHERE $atributo = '$valor' LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}

		/*----------  mostrar todos los datos del usuario  ----------*/
		public function mdlMostrarDatosUsuario($idUsuario){
			$sql = "SELECT idPersona, idUsuario, nombresPersona, apellidoPaternoPersona, apellidoMaternoPersona, correoPersona, celularPersona, rolUsuario, nombreUsuario
				FROM usuarios 
				INNER JOIN personas ON idUsuarioPersona = idPersona
			    WHERE idUsuario = '$idUsuario' LIMIT 1";
			   $respuesta = $this->consulta->select($sql);
			   return $respuesta;
		}

		/*----------  mostrar usuarios  ----------*/
		public function mdlMostrarUsuarios(){
			$sql = "SELECT idUsuario, rolUsuario, nombreUsuario, estado, idPersona, nombresPersona, apellidoPaternoPersona,
				apellidoMaternoPersona, correoPersona, celularPersona
			    FROM usuarios
				INNER JOIN personas ON idUsuarioPersona = idPersona";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;
		}
		/* buscar existencia de usuario */
		public function mdlBuscarUsuario($dni){
			$sql = "SELECT idUsuario, rolUsuario, nombreUsuario, estado, idPersona, nombresPersona, apellidoPaternoPersona,
				apellidoMaternoPersona, correoPersona, celularPersona
			    FROM usuarios
				INNER JOIN personas ON idUsuarioPersona = idPersona WHERE dniPersona = '$dni'";
		   	$respuesta = $this->consulta->selectAll($sql);
		   	return $respuesta;	
		}
		/*----------  agregar nuevo usuario  ----------*/
		public function mdlAgregarUsuario($idPersona, $nombreUsuario, $contraUsuario, $idTipoUsuario){
			$this->nombreUsuario = $nombreUsuario;
			$this->contraUsuario = $contraUsuario;
			$this->idPersona = $idPersona;
			$this->idTipoUsuario = $idTipoUsuario;
			$sql = "SELECT * FROM usuarios WHERE nombreUsuario = '$this->nombreUsuario' LIMIT 1";
			$respuesta = $this->consulta->select($sql);
			if (empty($respuesta)) {
				$sql = "INSERT INTO usuarios (idUsuarioPersona, nombreUsuario, contraUsuario, rolUsuario) VALUES (?,?,?,?)";
				$arrData = array($this->idPersona, $this->nombreUsuario, $this->contraUsuario, $this->idTipoUsuario); 
				$respuesta = $this->consulta->insert($sql, $arrData);	
			}else{
				$respuesta = false;
			}
			return $respuesta;
		}
		/*----------  editar campos de un usuario  ----------*/
		public function mdlEditarUsuario($nombreUsuario, $idTipoUsuario, $idUsuario){
			$this->nombreUsuario = $nombreUsuario;
			$this->idTipoUsuario = $idTipoUsuario;
			$this->idUsuario = $idUsuario;
			$sql = "UPDATE usuarios  SET  nombreUsuario = ?, rolUsuario = ? 
					WHERE idUsuario = $this->idUsuario";
			$arrData = array($this->nombreUsuario, $this->idTipoUsuario); 
			$respuesta = $this->consulta->update($sql, $arrData);
			return $respuesta;
		}

		/*----------  mostrar usuario  ----------*/
		public function mdlVerUsuarioId($item, $valor, $idUsuario){
			$sql = "SELECT usuarios.*, dniPersona, apellidoPaternoPersona, apellidoMaternoPersona, nombresPersona, celularPersona, correoPersona FROM usuarios 
				INNER JOIN personas ON idUsuarioPersona = idPersona 
				WHERE $item = '$valor' LIMIT 1;";
			$respuesta = $this->consulta->select($sql);
			return $respuesta;
		}
		
	}
