<?php
function crearOpcionMenu($id, $rutaImagen = "", $textoInformacion = "")
{
 echo '<li id="opcion'.$id.'" class="opcionMenu posicionRelativa flexCentradoC">

  <div class="contenedorImagen cuadrado colorPrimario redondear flexCentradoR">
     <img src="' . $rutaImagen . '" class="imagenOpcion unTercio">
  </div>
  <div class="ocuparDisponible centrar flexCentradoR ">
        <p class="textoTipoC">' . $textoInformacion . '</p>
  </div>
</li>';
}
/*<div class="opcionMenuDentro flexCentradoR columna">
                  <img src="' . $rutaImagen . '" alt="" class="imagenOpcion">
                  <div class="ocuparDisponible centrar">
                     <p>' . $textoInformacion . '</p>
                  </div>
                  
                  
    echo '<li id="opcion'.$id.'" class="opcionMenu posicionRelativa flexCentradoC">
                  <div class="contenedorImagen cuadrado colorSecundario redondear flexCentradoR">
                     <img src="' . $rutaImagen . '" class="imagenOpcion unTercio">
                  </div>
                  <div class="ocuparDisponible centrar flexCentradoR ">
                        <p class="textoTipoC">' . $textoInformacion . '</p>
                  </div>
               </li>';
                  */
