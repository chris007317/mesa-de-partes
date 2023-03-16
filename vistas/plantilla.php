<?php
	session_start();
	$rutaSistema= ControladorRuta::ctrRuta();
?>
<!DOCTYPE html>
<html>

	<?php  
		if (!isset($_SESSION['usuarioLogin'])) {
			include "paginas/login.php";
		}else{
			if (isset($_GET['pagina'])) {
				if ($_GET['pagina'] == 'pdfview') {
					include "paginas/".$_GET['pagina'].".php";
					return;
				}
				include "paginas/modulos/header.php";
				include "paginas/modulos/menu.php";
				if ($_GET['pagina'] == 'inicio' || $_GET['pagina'] == 'mesa-partes' || $_GET['pagina'] == 'configuracion' 
						|| $_GET['pagina'] == 'usuarios' || $_GET['pagina'] == 'salir' || $_GET['pagina'] == 'enviados' || $_GET['pagina'] == 'recibidos') {
					include "paginas/".$_GET['pagina'].".php";
					include "paginas/modulos/footer.php";
					echo '<script type="text/javascript" src="vistas/js/'.$_GET['pagina'].'.js"></script>';
				}
			}else{
				include "paginas/modulos/header.php";
				include "paginas/modulos/menu.php";
				include "paginas/inicio.php";
				include "paginas/modulos/footer.php";
			}
				
		 	?>
			</body>
	 	<?php 
		}
	 	 ?>
</html>
