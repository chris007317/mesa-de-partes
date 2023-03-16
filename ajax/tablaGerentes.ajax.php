<?php 
	require_once '../controlador/gerente.controlador.php';
	require_once '../modelo/gerente.modelo.php';
	Class TablaGerentes{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$gerencias = ControladorGerente::ctrTablaGerencias();
			$datosJson = '{
				"data":[';
			foreach ($gerencias as $key => $value) {
	            $acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm' idGerencia='".$value['idGerencia']."'><i class='fas fa-edit'></i></button><button class='btn btn-info btn-sm' idGerente='".$value['idGerente']."' idGerencia='".$value['idGerencia']."'><i class='fas fa-user-edit'></i></button></div>";
				$datosJson .='[
						"'.($key+1).'",
						"'.$value['nombreGerencia'].'",
						"'.$value['nombresPersona'].' '.$value['apellidoPaternoPersona'].' '.$value['apellidoMaternoPersona'].'",
						"'.$value['celularPersona'].'",
						"'.$acciones.'"
				],';			                      	
			}
			$datosJson = substr($datosJson, 0, -1);
			$datosJson .= ']}';
			echo $datosJson;
			
		}
	}

	$planes = new TablaGerentes();
	$planes->mostrarTabla();