<?php 
	Class ControladorPersona{
						/*----------  mostrar todos los usuarios  ----------*/
		static public function ctrMostrarPersona($item, $valor){
			$modeloPersona = new modeloPersona();
			$respuesta = $modeloPersona->mdlMostrarPersona($item, $valor);
			if (!empty($respuesta)) {
				return $respuesta;
			}
			return false;
		}

		/*----------  Agregar remitente  ----------*/
		public function ctrAgregarPersona(){
			if (isset($_POST['txtDniRemitente']) && isset($_POST['txtApellidoPaternoRemitente']) &&
				isset($_POST['txtApellidoMaternoRemitente']) && isset($_POST['txtNombreRemitente']) &&
				!empty($_POST['txtDniRemitente']) && !empty($_POST['txtApellidoPaternoRemitente']) && 
				!empty($_POST['txtApellidoMaternoRemitente']) && !empty($_POST['txtNombreRemitente'])
			) {
				$apellidoPaterno = trim($_POST['txtApellidoPaternoRemitente']);
				$apellidoMaterno = trim($_POST['txtApellidoMaternoRemitente']);
				$nombres = trim($_POST['txtNombreRemitente']);
				$dni = trim($_POST['txtDniRemitente']); 
				
				if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoPaterno) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoMaterno) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombres) && 
					preg_match('/^[0-9]+$/', $dni) && (preg_match('/^[0-9]+$/', $_POST['txtCelularRemitente']) || empty($_POST['txtCelularRemitente'])) && 
					(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['txtCorreoRemitente']) || empty($_POST['txtCorreoRemitente'])) 
				){
					$persona = new ModeloPersona();
					if (empty($_POST['idRecurrente'])) {
						$idPersona = $persona->mdlRegistrarPersona($nombres, $apellidoPaterno, $apellidoMaterno, $dni, $_POST['txtCorreoRemitente'], $_POST['txtCelularRemitente']);
						if ($idPersona < 1) {
							return 'error';
						}else{
							return $idPersona;
						}
					}else{
						$idPersona = $_POST['idRecurrente'];
						$respuesta1 = $persona->mdlEditarPersona($idPersona, $_POST['txtCelularRemitente'], $_POST['txtCorreoRemitente']);
						if ($respuesta1) {
							return $idPersona;
						}else{
							return 'error';
						}
					}					
				}else{
					return 'no';
					
				}

			}
		}
	}
 

