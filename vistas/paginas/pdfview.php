<?php 
/* 


$file = 'archivos/principal/72884584-28-02-2022-621c7af7e4b64.pdf';
$filename = 'archivos/principal/72884584-28-02-2022-621c7af7e4b64.pdf';
  
// Header content type
header('Content-type: application/pdf');
  
header('Content-Disposition: inline; filename="' . $filename . '"');
  
header('Content-Transfer-Encoding: binary');
  
header('Accept-Ranges: bytes');
  
// Read the file

@readfile($file);

 */

$url= $_SERVER["REQUEST_URI"];
$components = parse_url($url);
parse_str($components['query'], $archivo);
if(!preg_match('/^[A-Za-z0-9-]+\.pdf$/', $archivo['archivo'])){
   echo "<p>Nombre de archivo invalido</p>";
   exit;
}
$mi_pdf = fopen ("archivos/".$archivo['tipo']."/".$archivo['archivo'], "r");
if (!$mi_pdf) {
    echo "<p>No puedo abrir el archivo para lectura</p>";
    exit;
}

header('Content-type: application/pdf');


fpassthru($mi_pdf);  
fclose ($archivo);

?>