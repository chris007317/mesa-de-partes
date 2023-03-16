<?php 
	require_once "../controlador/persona.controlador.php";
	require_once "../modelo/persona.modelo.php";

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'buscarDni') {
		$dni = $_POST['dni'];
		$persona = ControladorPersona::ctrMostrarPersona('dniPersona', $dni);
		if (!$persona) {
			echo "noexiste";
		}else{
			echo json_encode($persona);
		}
	}

	if (isset($_POST['funcion']) && !empty($_POST['funcion']) && $_POST['funcion'] == 'agregarPersona') {
		$persona = ControladorPersona::ctrAgregarPersona();
		echo $persona;
	}