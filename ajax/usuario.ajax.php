<?php
	require_once "../controlador/usuario.controlador.php";
	require_once "../modelo/usuario.modelo.php";
	require_once "../controlador/persona.controlador.php";
	require_once "../modelo/persona.modelo.php";
	session_start();

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'inciarSesion') {
		$respuesta = ControladorUsuario::ctrIngresoUsuario($_POST['txtUser'], $_POST['txtContra']);
		echo $respuesta;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDni') {
		$existeUsuario = ControladorUsuario::ctrBuscarUsuario($_POST['dni']);
		if ($existeUsuario) {
			echo 'existe';
		}else{
			$persona = ControladorPersona::ctrMostrarPersona('dniPersona', $_POST['dni']);
			if (!$persona) {
				echo 'noexiste';
			}else{
				echo json_encode($persona);
			}
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'agregarUsuario') {
		$agregarUsuario = ControladorUsuario::ctrAgregarUsuario();
		echo $agregarUsuario;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarUsuario') {
		$mostrarUsuario = ControladorUsuario::ctrMostrarDatosUsuario($_POST['idUsuario']);
		echo json_encode($mostrarUsuario);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'editarUsuario') {
		$editarUsuario = ControladorUsuario::ctrEditarUsuario();
		echo $editarUsuario;
	}
 ?>