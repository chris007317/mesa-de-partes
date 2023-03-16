<?php 
	require_once '../controlador/usuario.controlador.php';
	require_once '../modelo/usuario.modelo.php';
	Class TablaUsuarios{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$usuarios = ControladorUsuario::ctrMostrarUsuarios();
			if (count($usuarios) == 0) {
				$datosJson = '{"data":[]}';
				echo $datosJson;
				return;
			}else{
				$datosJson = '{
				"data":[';
				
				foreach ($usuarios as $key => $value) {
					if ($value['rolUsuario'] != 1) {
						$acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm editarUsuario' title='Editar usuario' idUsuario='".$value['idUsuario']."' data-toggle='modal' data-target='#editarUsuario'><i class='fas fa-user-edit'></i></button><button class='btn btn-success btn-sm cambiarContra' title='Cambiar contraseña' idUsuario='".$value['idUsuario']."' data-toggle='modal' data-target='#cambiarContra'><i class='fas fa-key'></i></button>";
						$nombreTipoUsuario = "<div class='text-center'><h5><span class='badge badge-info'>Usuario</span></h5></div>";
						if ($value['estado'] == 1) {
							$estado = "<div class='text-center'><button class='btn btn-info btn-sm text-white btnActivarUsuario' estadoUsuario='0' idUsuario='".$value['idUsuario']."'>Activo</button></div>";
						}else{
							$estado = "<div class='text-center'><button class='btn btn-secondary btn-sm text-white btnActivarUsuario' estadoUsuario='1' idUsuario='".$value['idUsuario']."'>Inactivo</button></div>";
						}
					}else{	
						$acciones = "<div class='btn-group'><button class='btn btn-success btn-sm cambiarContra' title='Cambiar contraseña' idUsuario='".$value['idUsuario']."' data-toggle='modal' data-target='#cambiarContra'><i class='fas fa-key'></i></button>";
						$estado = "<div class='text-center'><button class='btn btn-info btn-sm text-white'>Activo</button></div>";
						$nombreTipoUsuario = "<div class='text-center'><h5><span class='badge badge-danger'>Administrador</span></h5></div>";
					}
					$datosJson .='[
							"'.($key+1).'",
							"'.$value['nombreUsuario'].'",
							"'.$value['correoPersona'].'",
							"'.$value['nombresPersona'].' '.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].'",
							"'.$value['celularPersona'].'",
							"'.$nombreTipoUsuario.'",
							"'.$estado.'",
							"'.$acciones.'"
					],';
				}
				$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']}';
				echo $datosJson;
			}
		}
	}

	$planes = new TablaUsuarios();
	$planes->mostrarTabla();