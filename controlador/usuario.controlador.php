<?php 
	Class ControladorUsuario{
		
		static public function ctrIngresoUsuario($usuario, $contra){
			if (isset($usuario)) {
				if (preg_match('/^[a-zA-Z0-9]+$/', $usuario) && preg_match('/^[a-zA-Z0-9]+$/', $contra)) {
					//$encriptarPassword = crypt($contra, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					$valor = $usuario;
					$atributo = 'nombreUsuario';
					$ingresar = new ModeloUsuario();
					$respuesta  = $ingresar->mdlMostrarUsuario($atributo, $valor);
					if (!$respuesta) {
						return 'novalido';	
					}else if ($respuesta['nombreUsuario'] == $usuario && $respuesta['contraUsuario'] == $contra) { 
							$_SESSION['usuarioLogin'] = 'ok';
							$_SESSION['idUsuarioSis'] = $respuesta['idUsuario'];
						if ($respuesta['estado'] == 1) {
							return "ok";
						}
					}else{
						return "novalido";
					}
				}else{
					return 'no';
				}
			}
		}
				/*----------  mostrar todos los usuarios  ----------*/
		static public function ctrMostrarUsuarios(){
			$respuesta = new ModeloUsuario();
			return $respuesta->mdlMostrarUsuarios();
		}
		
		/* buscar si existe un usuario */
		static public function ctrBuscarUsuario($dni){
			$modeloUsuario = new ModeloUsuario();
			$respuesta  = $modeloUsuario->mdlBuscarUsuario($dni);
			if (!empty($respuesta)) {
				return true;
			}
			return false;
		}
		/*----------  Agregar nuevo presidente  ----------*/
		public function ctrAgregarUsuario(){
			if (isset($_POST['txtDniUsuario']) && isset($_POST['txtApellidoPaterno']) &&
				isset($_POST['txtApellidoMaterno']) && isset($_POST['txtNombreUsuario']) &&
				isset($_POST['txtUsuario']) && !empty($_POST['txtUsuario']) &&
				isset($_POST['cmbPerfil']) && !empty($_POST['cmbPerfil']) &&
				isset($_POST['txtContraUsuario']) && !empty($_POST['txtContraUsuario']) &&
				!empty($_POST['txtDniUsuario']) && !empty($_POST['txtApellidoPaterno']) &&
				!empty($_POST['txtApellidoMaterno']) && !empty($_POST['txtNombreUsuario']) 
				
			) {
				$apellidoPaterno = trim($_POST['txtApellidoPaterno']);
				$apellidoMaterno = trim($_POST['txtApellidoMaterno']);
				$nombres = trim($_POST['txtNombreUsuario']);
				$nombreUsuario = trim($_POST['txtUsuario']);
				$contraUsuario = crypt($_POST['txtContraUsuario'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
				$idTipoUsuario = $_POST['cmbPerfil'];
				$dni = trim($_POST['txtDniUsuario']); 
				$verUsuario = new ModeloUsuario();
				$usuario = $verUsuario->mdlBuscarUsuario($dni);
				if (!empty($usuario)) {
					return 'existe';
					exit();
				}else if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoPaterno) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoMaterno) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombres) && 
					preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreUsuario) &&
					preg_match('/^[0-9]+$/', $dni) && (preg_match('/^[0-9]+$/', $_POST['txtCelularUsuario']) || empty($_POST['txtCelularUsuario'])) && 
					(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['txtCorreoUsuario']) || empty($_POST['txtCorreoUsuario'])) 
				){
					if (empty($_POST['idPersona'])) {
						$agregarPersona = new ModeloPersona();
						$idPersona = $agregarPersona->mdlRegistrarPersona($nombres, $apellidoPaterno, $apellidoMaterno, $dni, $_POST['txtCorreoUsuario'], $_POST['txtCelularUsuario']);
						if ($idPersona < 1) {
							return 'error';
							exit();
						}
					}else{
						$idPersona = $_POST['idPersona'];
					}
					$nuevoUsuario = new ModeloUsuario();
					$idUsuario = $nuevoUsuario->mdlAgregarUsuario($idPersona, $nombreUsuario, $contraUsuario, $idTipoUsuario);
 						if ($idUsuario > 0) {
 							return 'ok';
 						}else if($idUsuario == 'existe'){
 							return 'existe';
 						}else{
 							return 'error';
 						}
					
				}else{
					return 'no';
					
				}

			}
		}
		/*----------  Mostrar datos completos del usuario  ----------*/
		static public function ctrMostrarDatosUsuario($idUsuario){
			$respuesta = new ModeloUsuario();
			return $respuesta->mdlMostrarDatosUsuario($idUsuario);
		}
		/* editar usuario */
		public function ctrEditarUsuario(){
			if (isset($_POST['txtEditarUsuario']) && isset($_POST['cmbEditarPerfil']) && !empty($_POST['cmbEditarPerfil']) && !empty($_POST['txtEditarUsuario']) && isset($_POST['idUsuario']) && !empty($_POST['idUsuario']) && isset($_POST['idUsuarioPersona']) && !empty($_POST['idUsuarioPersona'])
			) {				
				$nombreUsuario = trim($_POST['txtEditarUsuario']);
				$idTipoUsuario = $_POST['cmbEditarPerfil'];
				$idUsuario = $_POST['idUsuario'];
				$idPersona = $_POST['idUsuarioPersona'];
				$verUsuario = new ModeloUsuario();
				$usuario = $verUsuario->mdlVerUsuarioId('nombreUsuario', $nombreUsuario, $idUsuario);
				if (!empty($usuario)) {
					return 'existe';
					
				}else if (preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombreUsuario) && 
					(preg_match('/^[0-9]+$/', $_POST['txtEditarCeluar']) || empty($_POST['txtEditarCeluar'])) && 
					(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['txtEditarCorreo']) || empty($_POST['txtEditarCorreo'])) 
				){
					$editarPersona = new ModeloPersona();
					$respuesta1 = $editarPersona->mdlEditarPersona($idPersona, $_POST['txtEditarCeluar'], $_POST['txtEditarCorreo']);
					if ($respuesta1) {
						$editarUsuario = new ModeloUsuario();
						$respuesta = $editarUsuario->mdlEditarUsuario($nombreUsuario, $idTipoUsuario, $idUsuario);
 						if ($respuesta) {
 							return 'ok';
 						}else{
 							return 'error';
 						}
					}else{
						return "error";
					}
				}else{
					return 'novalido';					
				}

			}
		}
	}
