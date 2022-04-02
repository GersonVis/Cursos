<?php
require_once "vendor/autoload.php";

use PhpOffice\PhpWord\Style\Language;
use PhpOffice\PhpWord\TemplateProcessor;

class Documento
{
    /*ESTA CLASE CARGA UNA PLANTILLA DE WORD Y ACTUALIZA LA PLANTILLA CON LOS 
    DATOS CONTENIDOS DENTRO DE UN ARRY*/
    private $nombreArchivo;
    private $nombrePlantilla;
    private $plantilla;
    private $datos;
    function __construct($nombrePlantilla, $nombreArchivo, array $datos)
    {
        $this->nombreArchivo = $nombreArchivo;
        $this->nombrePlantilla = $nombrePlantilla;
        $this->datos = $datos;
    }
    function setNombrePlantilla($nuevoNombre)
    {
        $this->nombrePlantilla = $nuevoNombre;
    }
    function setDatos($nuevosDatos)
    {
        $this->datos = $nuevosDatos;
    }
    function setNombreArchivo($nuevoNombre)
    {
        $this->nombreArchivo = $nuevoNombre;
    }
    function cargarPlantilla()
    {
        $this->plantilla = new TemplateProcessor($this->nombrePlantilla);
        return $this->plantilla;
    }
    function actualizarDatos()
    {
        foreach ($this->datos as $referencia => $valor) {
            $this->plantilla->setValue($referencia, $valor);
        }
    }
    function guardarDocumento()
    {
        $this->plantilla->saveAs($this->nombreArchivo);
    }
    function descargarArchivo()
    {
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $this->nombreArchivo . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        readfile($this->nombreArchivo);
    }
}
