<?php 
	require_once '../controlador/responsable.controlador.php';
	require_once '../modelo/responsable.modelo.php';
	Class TablaSubGerentes{
		/*----------  mostrar planes  ----------*/
		public function mostrarTabla(){
			$gerencias = ControladorResponsable::ctrTablaSubGerencias();
			$datosJson = '{
				"data":[';
			foreach ($gerencias as $key => $value) {
	            $acciones = "<div class='btn-group'><button class='btn btn-warning btn-sm' idSubGerencia='".$value['idSubGerencia']."'><i class='fas fa-edit'></i></button><button class='btn btn-info btn-sm' idResponsable='".$value['idResponsable']."' idSubGerencia='".$value['idSubGerencia']."'><i class='fas fa-user-edit'></i></button></div>";
				$datosJson .='[
						"'.($key+1).'",
						"'.$value['nombreGerencia'].'",
						"'.$value['nombreSubGerencia'].'",
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

	$planes = new TablaSubGerentes();
	$planes->mostrarTabla();