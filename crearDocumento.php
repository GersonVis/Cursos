<?php
require_once "vendor/autoload.php";
require_once "Documento.php";

define('nombrePlantilla', 'base.docx');

$datosJSON=json_decode($_GET['datos']);

$nombreArchivo="$datosJSON->nombreArchivo.docx";
$datos=(array) $datosJSON->datosActualizar;


$nuevoDocumento=new Documento(nombrePlantilla, $nombreArchivo, $datos);
$nuevoDocumento->cargarPlantilla();
$nuevoDocumento->actualizarDatos();
$nuevoDocumento->GuardarDocumento();
$nuevoDocumento->descargarArchivo();


?>