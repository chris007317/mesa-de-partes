<?php 
	Class ControladorResponsable{
		/* buscar si existe un usuario */
		static public function ctrBuscarResponsable($dni){
			$modeloResponsable = new ModeloResponsable();
			$respuesta  = $modeloResponsable->mdlBuscarResponsable($dni);
			if (!empty($respuesta)) {
				return true;
			}
			return false;
		}

		/*----------  Agregar nuevo responsable  ----------*/
		public function ctrAgregarResponsable(){
			if (isset($_POST['txtDniResponsable']) && isset($_POST['txtApellidoPaternoResponsable']) &&
				isset($_POST['txtApellidoMaternoResponsable']) && isset($_POST['txtNombreResponsable']) &&
				isset($_POST['txtSubGerencia']) && !empty($_POST['txtDniResponsable']) && 
				!empty($_POST['txtApellidoPaternoResponsable']) && !empty($_POST['txtApellidoMaternoResponsable']) && 
				!empty($_POST['txtNombreResponsable']) && !empty($_POST['txtSubGerencia']) &&
				isset($_POST['cmbGerencias']) && !empty($_POST['cmbGerencias'])
			) {
				$apellidoPaterno = trim($_POST['txtApellidoPaternoResponsable']);
				$apellidoMaterno = trim($_POST['txtApellidoMaternoResponsable']);
				$nombres = trim($_POST['txtNombreResponsable']);
				$dni = trim($_POST['txtDniResponsable']); 
				$gerencia = $_POST['txtSubGerencia'];
				$idGerencia = intval($_POST['cmbGerencias']);
				$verSubGerencia = new ModeloResponsable();
				$subGerencia = $verSubGerencia->mdlBuscarSubGerencia($gerencia);
				if (!empty($subGerencia)) {
					return 'existe';
					exit();
				}else if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoPaterno) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $apellidoMaterno) &&
					preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $nombres) && 
					preg_match('/^[0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $gerencia) &&
					preg_match('/^[0-9]+$/', $dni) && (preg_match('/^[0-9]+$/', $_POST['celularResponsable']) || empty($_POST['celularResponsable'])) && 
					(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['txtCorreoResponsable']) || empty($_POST['txtCorreoResponsable'])) 
				){
					$persona = new ModeloPersona();
					if (empty($_POST['idResponsablePersona'])) {
						$idPersona = $persona->mdlRegistrarPersona($nombres, $apellidoPaterno, $apellidoMaterno, $dni, $_POST['txtCorreoResponsable'], $_POST['celularResponsable']);
						if ($idPersona < 1) {
							return 'error';
							exit();
						}
					}else{
						$idPersona = $_POST['idResponsablePersona'];
						$respuesta1 = $persona->mdlEditarPersona($idPersona, $_POST['celularResponsable'], $_POST['txtCorreoResponsable']);
					}
					$idSubGerencia = $verSubGerencia->mdlAgregarSubGerencia($idGerencia, $gerencia);
 						if ($idSubGerencia > 0) {
 							$idResponsable = $verSubGerencia->mdlAgregarResponsable($idPersona, $idSubGerencia);
 							if ($idResponsable > 0) {
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

		static public function ctrMostrarSubGerencia($idGerencia){
			$subGerencias = new ModeloResponsable();
			return $subGerencias->mdlMostrarSubGerencia($idGerencia);;
		}

		static public function ctrMostrarResponsable($item, $valor){
			$responsable = new ModeloResponsable();
			return $responsable->mdlMostrarResponsable($item, $valor);;
		}

		static public function ctrTablaSubGerencias(){
			$responsable = new ModeloResponsable();
			return $responsable->mdlTablaSubGerencias();
		}
	}