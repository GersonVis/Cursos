<?php
require_once "config/configuraciones.php";
require_once "libs/database.php";
require_once "libs/controller.php";
require_once "libs/view.php";
require_once "libs/model.php";
require_once "controllers/errores/errorControlador.php";
require_once "controllers/errores/errorMetodo.php";
include "libs/elemento.php";
abstract class Elemento{
    abstract function estiloCSS();
    
}


class DatoIndividuo extends Elemento{
    function __construct()
    {
        
    }
    function estiloCSS(){
        return '<link rel="stylesheet" href="/public/css/estilosDatoIndividuo.css">';
    }
    function codigoHTML($imagenHerramienta="", $etiqueta="", $valor=""){
        return '  <li class="datoPanelIndividuo flexCentradoR">
        <p class="etiquetaDato">'.$etiqueta.'</p>
        <div class="contenedorEditar colorCuarto redondearDos ocuparDisponible">
            <input type="text" name="'.$etiqueta.'" class="textoIndividuo colorCuarto redondearDos" value="'.$valor.'" >
            <div class="cajaOpcionesEdicion flexCentradoR">
                <button class="botonAccion circulo colorPrimario flexCentradoR">
                   <img src="/public/iconos/cheque.png" alt="" class="imagenEditar ">
                 </button>
                <button class="botonAccion circulo colorPrimario flexCentradoR">
                   <img src="/public/iconos/cerrar.png" alt="" class="imagenEditar ">
                </button>
            </div>
        </div>
    </li>';
    }
 }
 class BotonSalir extends Elemento{
    function __construct()
    {
        
    }
    function estiloCSS(){
        return '<link rel="stylesheet" href="/public/css/estilosBotonSalir.css">';
    }
    function codigoHTML(){
        return '<button id="botonSalir" class=" redondear posicionAbsoluta colorQuinto botonSalir"><a href="/session/salir">SALIR<a></button>';
    }
 }
class Herramienta extends Elemento{
    function __construct()
    {
        
    }
    function estiloCSS(){
        return '<link rel="stylesheet" href="/public/css/estilosHerramienta.css">';
    }
    function codigoHTML($imagenHerramienta, $id, $texto="crear"){
        return ' <li id="'.$id.'" class="herramienta displayFlexC">
        <div class="conArribaOpcion FlexCentradoR posicionRelativa expandirW flexCentradoR">
            <div id="'.$id.'" class="cuadroOpcion colorPrimario redondear flexCentradoR">
                <img src="'.$imagenHerramienta.'" class="mitad" alt="">
            </div>
        </div>
        <div class="conAbajoOpcion displayFlexR ocuparDisponible">
            <p class="textoTipoD">'.$texto.'</p>
        </div>
    </li>';
    }
 }
class App
{
    function __construct()
    {
        $datos = $this->limpiarUrl();
    #    echo "   datos: ".var_dump($datos)."  ".$datos[0]."  d";
        $nombreControlador = $datos[0];
        $archivoController = "controllers/$nombreControlador.php";
        #si el archivo no existe nos carga la pantalla de error    
        if (file_exists($archivoController)) {
            require_once $archivoController;
            if ($nombreMetodo = (isset($datos[1])) ? $datos[1] : false) {
                $controlador = new $datos[0];
                if(intval($datos[1])){
                   $controlador->CargarModelo($datos[0]);
                   $controlador->informacionPorUrl($datos[1]);
                }
                else if (method_exists($controlador, $nombreMetodo)) {
                    $controlador->CargarModelo($datos[0]);
                    $controlador->{$nombreMetodo}();
                } else {
                    $errorMetodo = new ErrorMetodo();
                }
            } else {
                $controlador = new $datos[0];
                $controlador->CargarModelo($datos[0]);
                $controlador->Renderizar($datos[0].'/index');
            }
        } else {
            $error = new ErrorControlador();
        }
    }
    function limpiarUrl()
    {
        if (!isset($_GET['url'])) {
            return array(0=>"main");
        }
        $datos = rtrim($_GET['url']);
        $datos = explode('/', $datos);
        return $datos;
    }
}
