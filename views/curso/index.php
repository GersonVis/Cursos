<?php
include "libs/elemento.php";
include "views/compartido/menuLateral.php";
include "views/compartido/opcion.php";
include "views/compartido/herramienta.php";
include "views/compartido/datoIndividuo.php";
include "views/compartido/botonSalir.php";
$menuLateral = new MenuLateral();
$opcion = new Opcion();
$herramienta = new Herramienta();
$datoIndividuo = new DatoIndividuo();
$botonSalir = new BotonSalir();
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
    echo $botonSalir->estiloCSS();
    ?>
    <link rel="stylesheet" href="/public/css/estilosPorDefecto.css">
    <link rel="stylesheet" href="/public/css/estilosInstructor.css">
    <link rel="stylesheet" href="/public/css/estilosInformacionIndividual.css">
    <link rel="stylesheet" href="/public/css/estilosCrear.css">
    <link rel="stylesheet" href="/public/css/estilosBusqueda.css">
    <link rel="stylesheet" href="/public/css/estilosInstructoresAsociados.css">
    <link rel="stylesheet" href="/public/css/estilosenlazarInstructoresDisponibles.css">
    <link rel="stylesheet" href="/public/css/listaSecciones.css">
    <link rel="stylesheet" href="/public/css/estilosPanelSubirArchivo.css">
    <link rel="stylesheet" href="/public/css/CambiosInput/CambiosInput.css">
</head>

<body>
    <div id="contenedorPrincipal" class="expandirAmbos">
        <?php
        $herramienta1 = $herramienta->codigoHTML("/public/iconos/agregar-usuario.png", "crearInstructor");
        echo $menuLateral->codigoHTML($this->nombre, $herramienta1);
        ?>

        <div class="ocuparDisponible displayFlexC cuartoColor">
            <footer id="arribaParte" class="expandirW flexCentradoR posicionRelativa">

                <div class="divBusqueda expandirAmbos flexCentradoR">
                    <form action="/curso/busqueda" id="formularioBusqueda" class="expandirAmbos flexCentradoC" method="POST">
                        <div class="busquedaBarra flexCentradoR">
                            <input id="buscar" type="text" name="valor" class="colorCuarto redondear">
                            <input id="botonEnviar" type="button" class="colorPrimario redondear" value="">
                        </div>
                        <div class="busquedaOpciones flexCentradoR">
                            <input id="rfc" name="nombreCurso" type="checkbox" value="1"><label for="rfc">Nombre</label></input>
                            <input id="id" name="id" type="checkbox" value="1"><label for="id">ID</label></input>
                            <input id="nombre" name="claveCurso" type="checkbox" value="1" checked><label for="rfc">Clave</label></input>
                        </div>
                    </form>
                </div>
                <div id="divSecciones" class="posicionAbsoluta redondear">
                    <select id="listaSecciones" class="colorPrimario redondear">

                    </select>
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
                <p id="" class="subMenu">Información del <?php echo $this->nombre; ?></p>
                <li id="contenedorSubMenu" class="ocuparDisponible listaSinEstilo flexCentradoC">
                    <ul id="botonMostrarDatos" class="subMenuOpcion subMenu opcionIndividuo flexCentradoR redondearDos">
                        <p>Datos del <?php echo $this->nombre; ?> </p>
                    </ul>
                    <ul id="botonInstructoresAsociados" class="subMenuOpcion subMenu opcionIndividuo flexCentradoR redondearDos">
                        <p>Instructores asociados</p>
                    </ul>
                    <ul id="botonAsociarInstructores" class="subMenuOpcion subMenu opcionIndividuo flexCentradoR redondearDos">
                        <p>Asociar instructores</p>
                    </ul>
                    <ul id="botonMaestrosAsociados" class="subMenuOpcion subMenu opcionIndividuo flexCentradoR redondearDos">
                        <p>Maestros registrados en curso</p>
                    </ul>
                </li>
            </div>
            <div id="informacionIndividuo" style="padding: 0 0 0 0;" class="individuoDivision posicionRelativa ocuparDisponible colorSecundario redondearDos barras">
                <div></div>
                <ul id="listaDatosIndividuo" class="flexCentradoC listaSinEstilo">
                    <?php
                    for ($t = 0; $t < 5; $t++) {
                        echo $datoIndividuo->codigoHTML();
                    }
                    ?>
                </ul>
                <!--    <input type="submit" value="Guardar">-->
                <div style="height: 2%"></div>
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
        <section id="sectionEnlazadoPrincipal" style="visibility: hidden;" class="expandirAmbos posicionAbsoluta flexCentradoR colorCuarto">
            <section id="sectionCrear" class=" flexCentradoR colorSecundario redondearDos posicionRelativa">
                <div id="divInformacionPrincipalEnlazado" class="individuoDivision ocuparDisponible colorSecundario redondearDos barraDeDesplazamiento">
                </div>
                <button type="button" value="cerrar" id="botonCerrarEnlazadoPrincipal" class="botonCerrar redondearDos colorPrimario posicionAbsoluta">Cerrar</button>
            </section>
        </section>
        <?php
        echo $botonSalir->codigoHTML();
        ?>
    </div>
    <script src="/public/js/ComponentWeb/PanelSubirArchivo.js"></script>
    <script src="/public/js/ComponentWeb/CambiosInput.js"></script>
    <script src="/public/js/metodos/actualizarRegistro.js"></script>
    <script src="/public/js/scriptscurso/funcionesUtiles.js"></script>
    <script src="/public/js/interfaces/elementos.js"></script>

    <!--en este script se encuentran las bases para adaptar la vista sin cambiar la logica-->
    <script src="/public/js/scriptscurso/instructorBases.js"></script>
    <!--fin-->
    <script src="/public/js/interfaces/menuDeAsociados.js"></script>
    <script src="/public/js/scriptscurso/actualizarPanel.js"></script>
    <!--script con evento cuando se hace click en los elementos principales-->
    <script src="/public/js/scriptscurso/mostrarInformacion.js"></script>
    <script src="/public/js/scriptscurso/eliminarIndividuo.js"></script>
    <script src="/public/js/scriptscurso/crearInstructor.js"></script>
    <script src="/public/js/scriptscurso/actualizarInstructor.js"></script>
    <script src="/public/js/scriptscurso/busquedaInstructor.js"></script>
    <script src="/public/js/scriptscurso/mostrarInstructoresAsociados.js"></script>
    <script src="/public/js/scriptscurso/asociarInstructores.js"></script>
    <!--  <script src="/public/js/scriptscurso/panelDeElementos.js"></script>-->
    <script src="/public/js/scriptscurso/maestrosAsociados.js"></script>
    <script src="/public/js/scriptscurso/enlazadoPrincipal.js"></script>
    <script src="/public/js/scriptsMaestro/listaSeccionesMaestro.js"></script>
    <script>

    </script>

</body>

</html>