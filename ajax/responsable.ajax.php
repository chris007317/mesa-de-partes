<?php 
	require_once "../controlador/responsable.controlador.php";
	require_once "../modelo/responsable.modelo.php";
	require_once "../controlador/persona.controlador.php";
	require_once "../modelo/persona.modelo.php";	

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDni') {
		$existeGerente = ControladorResponsable::ctrBuscarResponsable($_POST['dni']);
		if ($existeGerente) {
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

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'agregarSubGerencia') {
		$agregarResponsable = ControladorResponsable::ctrAgregarResponsable();
		echo $agregarResponsable;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'mostrarSubGerencias') {
		$subGerencias = ControladorResponsable::ctrMostrarSubGerencia($_POST['idGerencia']);
		echo json_encode($subGerencias);
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarResponsable') {
		$persona = ControladorResponsable::ctrMostrarResponsable('idResponsableSubGerencia', $_POST['idSubGerencia']);
		echo json_encode($persona);
	}