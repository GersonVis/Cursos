<?php
include "libs/elemento.php";
include "views/compartido/menuLateral.php";
include "views/compartido/opcion.php";
include "views/compartido/herramienta.php";
include "views/compartido/datoIndividuo.php";
$menuLateral = new MenuLateral();
$opcion = new Opcion();
$herramienta = new Herramienta();
$datoIndividuo = new DatoIndividuo();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    echo $menuLateral->estiloCSS();
    echo $opcion->estiloCSS();
    echo $herramienta->estiloCSS();
    echo $datoIndividuo->estiloCSS();
    ?>
    <link rel="stylesheet" href="/public/css/estilosPorDefecto.css">
    <link rel="stylesheet" href="/public/css/estilosInstructor.css">
    <link rel="stylesheet" href="/public/css/estilosInformacionIndividual.css">
    <link rel="stylesheet" href="/public/css/estilosCrear.css">
    <link rel="stylesheet" href="/public/css/estilosBusqueda.css">
    <link rel="stylesheet" href="/public/css/estilosInstructoresAsociados.css">
    <link rel="stylesheet" href="/public/css/estilosenlazarInstructoresDisponibles.css">
</head>

<body>
    <div id="contenedorPrincipal" class="expandirAmbos">
        <?php
        $herramienta1 = $herramienta->codigoHTML("/public/iconos/agregar-usuario.png", "crearInstructor");
        echo $menuLateral->codigoHTML($this->nombre, $herramienta1);
        ?>
        </section>

        <div class="ocuparDisponible displayFlexC cuartoColor">
            <footer id="arribaParte" class="expandirW flexCentradoR">

                <div class="divBusqueda expandirAmbos flexCentradoR">
                    <form action="/instructor/busqueda" id="formularioBusqueda" class="expandirAmbos flexCentradoC" method="POST">
                        <div class="busquedaBarra flexCentradoR">
                            <input id="buscar" type="text" name="valor" class="colorCuarto redondear">
                            <input id="botonEnviar" type="button" class="colorPrimario redondear" value="">
                        </div>
                        <div class="busquedaOpciones flexCentradoR">
                            <input id="rfc" name="rfc" type="checkbox" value="1"><label for="rfc">RFC</label></input>
                            <input id="id" name="id" type="checkbox" value="1"><label for="rfc">ID</label></input>
                            <input id="nombre" name="nombre" type="checkbox" value="1" checked><label for="rfc">NOMBRE</label></input>
                        </div>
                    </form>
                </div>

            </footer>



            <section id="contenedorOpciones" class="ocuparDisponible barras">

                <?php
                $c = 0;
                $puerta = true;
                //    while($puerta){
                ?>
                <div id="contenedorOpcionesDirecto" class="opcionesHorizontal expandirW flexCentradoR gridCuatro">
                    <?php
                    //    <!--<ul id="ulListaOpciones" class="expandirAmbos displayFlexC">
                    // while($c++<4) {
                    //     while ($item = mysqli_fetch_assoc($this->instructores)) {
                    // $item=mysqli_fetch_assoc($this->instructores);
                    //       if(!$item){
                    //    $puerta=false;
                    //   break;
                    //    }
                    //         echo $opcion->codigoHTML($item['id'], $item['nombre']);
                    //          }
                    //
                    //   $c=0;
                    ?>
                </div>
                <?php //echo ""; // </ul>-->} 
                ?>

            </section>
        </div>
        <section id="informacionIndividual" class="centrarAbsoluto posicionAbsoluta flexCentradoR colorSecundario redondearDos posicionRelativa">
        <div id="menuIndividuo" class="individuoDivision colorCuarto redondearDos flexCentradoC">
                <p id="" class="subMenu">Informaci??n del curso</p>
                <li id="contenedorSubMenu" class="ocuparDisponible listaSinEstilo flexCentradoC">
                    <ul id="botonMostrarDatos" class="subMenuOpcion subMenu opcionIndividuo flexCentradoR redondearDos">
                        <p>Datos del curso</p>
                    </ul>
                    <ul id="botonInstructoresAsociados" class="subMenuOpcion subMenu opcionIndividuo flexCentradoR redondearDos">
                        <p>Instructores asociados</p>
                    </ul>
                    <ul id="botonAsociarInstructores" class="subMenuOpcion subMenu opcionIndividuo flexCentradoR redondearDos">
                        <p>Asociar instructores</p>
                    </ul>
                </li>
            </div>
            <div id="informacionIndividuo" class="individuoDivision ocuparDisponible colorSecundario redondearDos">

                <ul id="listaDatosIndividuo" class="expandirAmbos flexCentradoC listaSinEstilo">
                    <?php
                    for ($t = 0; $t < 5; $t++) {
                        echo $datoIndividuo->codigoHTML();
                    }
                    ?>
                </ul>
                <input type="submit" value="Guardar">

            </div>
            <button type="button" value="cerrar" id="botonCerrarInformacion" class="botonCerrar redondearDos colorPrimario posicionAbsoluta">Cerrar</button>
        </section>
        <section id="sectionCrearInstructor" class="expandirAmbos posicionAbsoluta flexCentradoR colorCuarto">
            <section id="sectionCrear" class=" flexCentradoR colorSecundario redondearDos posicionRelativa">

                <div id="individuoCrear" class="individuoDivision ocuparDisponible colorSecundario redondearDos barraDeDesplazamiento">




                </div>
                <button type="button" value="cerrar" id="botonCerrarCrear" class="botonCerrar redondearDos colorPrimario posicionAbsoluta">Cerrar</button>
            </section>
        </section>
    </div>

    <script src="/public/js/scripsInstructores/funcionesUtiles.js"></script>
    <script src="/public/js/interfaces/menuDeAsociados.js"></script>
    <!--en este script se encuentran las bases para adaptar la vista sin cambiar la logica-->
    <script src="/public/js/scripsInstructores/instructorBases.js"></script>
    <!--fin-->
    <script src="/public/js/scripsInstructores/actualizarPanel.js"></script>
    <script src="/public/js/scripsInstructores/mostrarInformacion.js"></script>
    <script src="/public/js/scripsInstructores/eliminarIndividuo.js"></script>
    <script src="/public/js/scripsInstructores/crearInstructor.js"></script>
    <script src="/public/js/scripsInstructores/actualizarInstructor.js"></script>
    <script src="/public/js/scripsInstructores/busquedaInstructor.js"></script>
    <script src="/public/js/scripsInstructores/mostrarInstructoresAsociados.js"></script>
    <script src="/public/js/scripsInstructores/asociarInstructores.js"></script>
    
    
</body>

</html>
