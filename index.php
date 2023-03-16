<?php 
	require_once "controlador/plantilla.controlador.php";
	require_once "controlador/ruta.controlador.php";

	require_once "controlador/gerente.controlador.php";
	require_once "modelo/gerente.modelo.php";

	require_once "controlador/documento.controlador.php";
	require_once "modelo/documento.modelo.php";

	$plantilla = new ControladorPlantilla();
	$plantilla -> ctrPlantilla();
 ?>