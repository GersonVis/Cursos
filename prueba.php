<?php
require_once "vendor/autoload.php";
require_once "Documento.php";

define('nombrePlantilla', 'base.docx');
$nombreArchivo="nuevoDoc.docx";
$datos=array("nombre"=>"gerson", "accion"=>"impartio curso");
$nuevoDocumento=new Documento(nombrePlantilla, $nombreArchivo, $datos);
$nuevoDocumento->cargarPlantilla();
$nuevoDocumento->actualizarDatos();
$nuevoDocumento->GuardarDocumento();

?>