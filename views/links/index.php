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
    <link rel="stylesheet" href="/public/css/estilosEnlazadoPrincipal.css">
    <link rel="stylesheet" href="/public/css/estilosAsistencia.css">
    <link rel="stylesheet" href="/public/css/estilosSubirArchivo.css">
    <link rel="stylesheet" href="/public/css/InterfazLink/InterfazLink.css">
</head>

<body>
    <div id="contenedorPrincipal" class="expandirAmbos">
        <?php
        $herramienta1 = $herramienta->codigoHTML("/public/iconos/subir-archivo.png", "crearInstructor", "Subir archivo");
        echo $menuLateral->codigoHTML($this->nombre, $herramienta1);
        ?>

        <div class="ocuparDisponible displayFlexC cuartoColor">
            <footer id="arribaParte" class="expandirW flexCentradoR">

                <div class="divBusqueda expandirAmbos flexCentradoR">
                    <form action="/curso/busqueda" id="formularioBusqueda" class="expandirAmbos flexCentradoC" method="POST">
                        
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
                <p id="" class="subMenu">Información del <?php echo $this->nombre; ?></p>
                <li id="contenedorSubMenu" class="ocuparDisponible listaSinEstilo flexCentradoC">
                    <ul id="botonMostrarDatos" class="subMenuOpcion subMenu opcionIndividuo flexCentradoR redondearDos">
                        <p>Datos del <?php echo $this->nombre; ?> </p>
                    </ul>


                </li>
            </div>
            <div id="informacionIndividuo" class="individuoDivision ocuparDisponible colorSecundario redondearDos">

                <ul id="listaDatosIndividuo" class="expandirAmbos flexCentradoC listaSinEstilo posicionRelativa">
                    <?php
                    for ($t = 0; $t < 5; $t++) {
                        echo $datoIndividuo->codigoHTML();
                    }
                    ?>
                </ul>
                <!--    <input type="submit" value="Guardar">-->

            </div>
            <button type="button" value="cerrar" id="botonCerrarInformacion" class="botonCerrar redondearDos colorPrimario posicionAbsoluta">Cerrar</button>
        </section>
        <section id="sectionCrearInstructor" class="expandirAmbos posicionAbsoluta flexCentradoR colorCuarto">
            <section id="sectionCrear" class=" flexCentradoR colorSecundario redondearDos posicionRelativa">
                <div id="individuoCrear" class="individuoDivision ocuparDisponible colorSecundario redondearDos barraDeDesplazamiento">
                    <div id="divPadreArchivo" class="expandirAmbos flexCentradoC">
                    <div class="divFormularioEnviarArchivo">
                        <form id="formularioSubirArchivo" method="POST" enctype="multipart/form-data" action="/archivo/subirArchivo" class="formularioEnviarArchivo expandirAmbos flexCentradoC">
                        <div id="divArchivo" class="divDescripcion espacioDisponible flexCentradoC">
                                <label id="labelArchivo" for="archivo">Archivo</label>
                                <input type="file" id="archivo" name="archivo"></input>
                            </div>    
                        <div id="divDescripcion" class="divDescripcion flexCentradoC">
                                <label for="descripcion" style="height: 13%" class="reondear colorSecundario">Descripcion:</label>
                                <textarea wrap="soft" id="descripcion" type="text" name="descripcion" class="redondearDos sombra"></textarea>
                            </div>
                            

                        </form>
                    </div>
                    <div class="divBotonEnviarArchivo ocuparDisponible flexCentradoC">
                        <button id="botonSubirArchivo" class="colorPrimario redondear">Subir archivo</button>
                    </div>
                    </div>



                    <button type="button" value="cerrar" id="botonCerrarCrear" class="botonCerrar redondearDos colorPrimario posicionAbsoluta">Cerrar</button>
            </section>
        </section>

        <?php
        echo $botonSalir->codigoHTML();
        ?>
    </div>
    <script src="/public/js/ComponentWeb/InterfazLink.js"></script>
    <script>
        //solicitar los links registrados
        fetch("links/todos")
        .then(respuesta=>respuesta.json())
        .then(data=>{
            const elementosCreados=[]
            const hijo=contenedorOpcionesDirecto
            const padre=hijo.parentElement
            data.forEach(dato=>{
                console.log(dato)
                let elementoCreado=document.createElement("interfaz-link")
                elementoCreado.id=dato.id.valor
                hijo.appendChild(elementoCreado)
            })
            
        })
        .catch(error=>{
            console.log(error)
        })
    </script>
</body>

</html>