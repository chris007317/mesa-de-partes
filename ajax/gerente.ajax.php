<?php 
	require_once "../controlador/gerente.controlador.php";
	require_once "../modelo/gerente.modelo.php";
	require_once "../controlador/persona.controlador.php";
	require_once "../modelo/persona.modelo.php";	

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDni') {
		$existeGerente = ControladorGerente::ctrBuscarGerente($_POST['dni']);
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

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'agregarGerente') {
		$agregarGerente = ControladorGerente::ctrAgregarGerente();
		echo $agregarGerente;
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarGerente') {
		$persona = ControladorGerente::ctrMostrarGerente('idGerenteGerencia', $_POST['idGerencia']);
		echo json_encode($persona);
	}