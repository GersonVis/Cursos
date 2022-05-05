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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   
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
        $herramienta1 = $herramienta->codigoHTML("/public/iconos/enlace.png", "crearLink", "Crear link");
        echo $menuLateral->codigoHTML($this->nombre, $_SESSION["idRol"] == 1 ? $herramienta1 : "");
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
        <?php
        if ($_SESSION["idRol"] == 1) {
        ?>
            <section id="sectionCrearInstructor" class="expandirAmbos posicionAbsoluta flexCentradoR colorCuarto">
                <section id="sectionCrear" class=" flexCentradoR colorSecundario redondearDos posicionRelativa">
                    <div id="individuoCrear" class="individuoDivision ocuparDisponible colorSecundario redondearDos barraDeDesplazamiento">
                        <div id="divPadreArchivo" class="expandirAmbos flexCentradoC">
                            <div class="divFormularioEnviarArchivo">
                                <form id="formularioCrearEnlace" method="POST" enctype="multipart/form-data" action="/links/crear" class="formularioEnviarArchivo expandirAmbos flexCentradoC">
                                    <div class="divFormularioInput">
                                        <div class="divAjustarFormulario">
                                            <label for="titulo">Titulo</label>
                                            <input placeholder="Temario" id="titulo" name="titulo" type="text"></input>
                                        </div>
                                    </div>
                                    <div class="divFormularioInput">
                                        <div class="divAjustarFormulario">
                                            <label for="link">Enlace</label>
                                            <input placeholder="wwww.link.com" id="link" name="link" type="text"></input>
                                        </div>
                                    </div>
                                    <div class="divFormularioInput">
                                        <div style="height: auto" class="divAjustarFormulario">
                                            <label for="Description">Descripción</label>
                                            <textarea placeholder="Es un link que redirige a..." id="descripcionEnlace" name="descripcion" style="height: 100px; margin-bottom:4px" name="Descripcion" type="text"></textarea>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="divBotonEnviarArchivo ocuparDisponible flexCentradoC">
                                <button id="botonSubirArchivo" class="colorPrimario redondear">Crear enlace</button>
                            </div>
                        </div>
                        <button type="button" value="cerrar" id="botonCerrarCrear" class="botonCerrar redondearDos colorPrimario posicionAbsoluta">Cerrar</button>
                </section>
            </section>

        <?php }
        ?>

        <?php
        echo $botonSalir->codigoHTML();
        ?>
    </div>
    <script src="/public/js/ComponentWeb/InterfazLink.js"></script>
    <script>
        //solicitar los links registrados
        const actualizar = () => {
            fetch("links/todos")
                .then(respuesta => respuesta.json())
                .then(data => {
                    let contenido = ""
                    const hijo = contenedorOpcionesDirecto
                    const padre = hijo.parentElement
                    data.forEach(dato => {

                        contenido += `<interfaz-link titulo="${dato.titulo.valor}" 
                descripcion="${dato.descripcion.valor}"
                enlace="${dato.link.valor}"
                idsql="${dato.id.valor}"
                
                accionBotonEliminar="${functionEliminar.toString()}"
                ></interfaz-link>`
                    })
                    hijo.innerHTML = contenido
                })
                .catch(error => {
                    console.log(error)
                })
        }
        actualizar()
        <?php
        if ($_SESSION["idRol"] == 1) {
        ?>
            //crear un nuevo link
            crearLink.addEventListener("click", function() {
                sectionCrearInstructor.style.visibility = "visible"
            })
            //enviar formulario crear enlace

            botonSubirArchivo.addEventListener("click", function() {
                let data = new FormData(formularioCrearEnlace)
                fetch(formularioCrearEnlace.action, {
                        method: formularioCrearEnlace.method,
                        body: data
                    })
                    .then(respuesta => {
                        if (respuesta.status == "200") {
                            actualizar()
                        }
                        return respuesta.text()
                    })
                    .then(texto => {
                        console.log(texto)
                        alert(texto)
                    })
                    .catch(e => {
                        alert("Ocurrío un error" + e);
                    })
            })

            //ocultar ventana crear
            botonCerrarCrear.addEventListener("click", function() {
                sectionCrearInstructor.style.visibility = "hidden"
            })
        <?php
        }
        ?>
        //solicitud de eliminacion
        let functionEliminar = (id, elemento) => {
            let data = new FormData()
            data.append('id', id)
            fetch('/links/eliminar', {
                    method: 'POST',
                    body: data
                })
                .then(respuesta => {
                    if (respuesta.status == '200') {
                        let padre = elemento.parentElement
                        padre.parentElement.removeChild(padre)
                        actualizar()
                    }
                    return respuesta.text()
                })
                .then(texto => {
                    alert(texto)
                })
                .catch(e => {
                    alert('Ocurrío un error' + e);
                })
        }
    </script>
</body>

</html>