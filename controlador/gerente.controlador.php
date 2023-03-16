<?php 
	Class ControladorGerente{
		/* buscar si existe un usuario */
		static public function ctrBuscarGerente($dni){
			$modeloGerente = new ModeloGerente();
			$respuesta  = $modeloGerente->mdlBuscarGerente($dni);
			if (!empty($respuesta)) {
				return true;
			}
			return false;
		}

		/*----------  Agregar nuevo gerente  ----------*/
		public function ctrAgregarGerente(){
			if (isset($_POST['txtDniGerente']) && isset($_POST['txtApellidoPaternoGerente']) &&
				isset($_POST['txtApellidoMaternoGerente']) && isset($_POST['txtNombreGerente']) &&
				isset($_POST['txtGerencia']) && !empty($_POST['txtDniGerente']) && 
				!empty($_POST['txtApellidoPaternoGerente']) && !empty($_POST['txtApellidoMaternoGerente']) && 
				!empty($_POST['txtNombreGerente']) && !empty($_POST['txtGerencia'])
			) {
				$apellidoPaterno = trim($_POST['txtApellidoPaternoGerente']);
				$apellidoMaterno = trim($_POST['txtApellidoMaternoGerente']);
				$nombres = trim($_POST['txtNombreGerente']);
				$dni = trim($_POST['txtDniGerente']); 
				$gerencia = $_POST['txtGerencia'];
				$verGerente = new ModeloGerente();
				$gerente = $verGerente->mdlBuscarGerencia($gerencia);
				if (!empty($gerente)) {
					return 'existe';
					exit();
				}else if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoPaterno) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoMaterno) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombres) && 
					preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $gerencia) &&
					preg_match('/^[0-9]+$/', $dni) && (preg_match('/^[0-9]+$/', $_POST['txtCelularGerente']) || empty($_POST['txtCelularGerente'])) && 
					(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['txtCorreoGerente']) || empty($_POST['txtCorreoGerente'])) 
				){
					$persona = new ModeloPersona();
					if (empty($_POST['idGerentePersona'])) {
						$idPersona = $persona->mdlRegistrarPersona($nombres, $apellidoPaterno, $apellidoMaterno, $dni, $_POST['txtCorreoGerente'], $_POST['txtCelularGerente']);
						if ($idPersona < 1) {
							return 'error';
							exit();
						}
					}else{
						$idPersona = $_POST['idGerentePersona'];
						$respuesta1 = $persona->mdlEditarPersona($idPersona, $_POST['txtCelularGerente'], $_POST['txtCorreoGerente']);
					}
					$idGerencia = $verGerente->mdlAgregarGerencia($gerencia);
 						if ($idGerencia > 0) {
 							$idGerente = $verGerente->mdlAgregarGerente($idPersona, $idGerencia);
 							if ($idGerente > 0) {
 							 	return 'ok';
 							 }
 							 return 'error'; 
 						}
 						return 'error';
					
				}else{
					return 'no';
					
				}

			}
		}
		/* mostrar gerencias */
		static public function crtrMostrarGerencias(){
			$gerencias = new ModeloGerente();
			return $gerencias->mdlMostrarGerencias(1);
		}

		static public function ctrMostrarGerente($item, $valor){
			$gerente = new ModeloGerente();
			return $gerente->mdlMostrarGerente($item, $valor);
		}

		static public function ctrTablaGerencias(){
			$gerentes = new ModeloGerente();
			return $gerentes->mdlTablaGerencias();
		}
	}