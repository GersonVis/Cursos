<?php
class MenuLateral 
{
    function __construct()
    {
        $claseNoSeleccion="colorPrimario";
        $this->opciones = array(
           
            "instructor" => array("etiqueta"=>"Instructores","href" => "href=\"/instructor\"", "clase" =>$claseNoSeleccion),
            "curso" => array("etiqueta"=>"Cursos","href" => "href=\"/curso\"", "clase" => $claseNoSeleccion),
            "maestro" => array("etiqueta"=>"Maestro","href" => "href=\"/maestro\"", "clase" => $claseNoSeleccion),
            "archivo" => array("etiqueta"=>"Archivos","href" => "href=\"/archivo\"", "clase" => $claseNoSeleccion),
        );
    }
    function estiloCSS()
    {
        return '<link rel="stylesheet" href="/public/css/estilosMenuLateral.css">';
    }
    function codigoHTML($opcion, $herramienta = "")
    {
        $htmlOpciones = '';
        $this->opciones[$opcion]['href'] = "";
        $this->opciones[$opcion]['clase'] = "colorCuarto";
        foreach ($this->opciones as $etiqueta => $datosOpciones) {
            $htmlOpciones .= '
               <li class="opcionMenu flexCentradoR"><a '.$datosOpciones['href'].' class="textoTipoB redondear '.$datosOpciones['clase'].' expandirAmbos flexCentradoR">
                  <p>'.$datosOpciones['etiqueta'].'</p>
               </a></li>
               ';
        }
        return '<section id="menuLateral" class="colorSecundario expandirH flexCentradoC">
           <div id="menuLateralArriba" class="expandirAmbos ">
               <p class="indicador textoTipoA">MENÚ</p>
               <ul id="menu" class="expandirAmbos listaSinEstilo displayFlexC">
                   '.$htmlOpciones.'
               </ul>
           </div>
           <div id="menuLateralAbajo" class="expandirAmbos">
               <p class="indicador textoTipoA">HERRAMIENTAS</p>
               <ul id="menu" class="expandirAmbos listaSinEstilo displayFlexC">
                  ' . $herramienta . '
               </ul>
           </div>
       </section>';
    }
}