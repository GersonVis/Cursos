<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar</title>
    <link rel="stylesheet" href="/public/css/actualizarCuenta.css">
    <link rel="stylesheet" href="/public/css/estilosPorDefecto.css">
</head>

<body>

    <div class="divActualizarCuentaPadre">
        <div class="divActualizarCuentaDebajo">
            <div id="divImagenAnimadaADAC">
                <img src="/public/imagenes/personaAsomandose.png" id="imagenAsomandoseDAC">
            </div>
            
           
            <div id="divImagenAnimadaADACAmarilla">
                <img src="/public/imagenes/personaAsomandoseAzul.png" id="imagenAsomandoseDAC">
            </div>
            <div id="divImagenAnimadaADACAzul">
                <img src="/public/imagenes/personaAsomandoseAzul.png" id="imagenAsomandoseDAC">
            </div>
            <div id="divImagenAnimadaADACRoja">
                <img src="/public/imagenes/personaAsomandose.png" id="imagenAsomandoseDAC">
            </div>
        </div>
        <div class="divActualizarCuenta" id="divActualizarCuenta">

            <div class="contenedorDAC parteA">
            </div>
            <div class="contenedorDAC parteB">
                <h1>Bienvenido</h1>
                <p class="subtituloDAC"><?php echo $this->mensaje;?></p>
            </div>
            <form action="/session/actualizar" method="post" class="contenedorDAC parteC">
                <input type="hidden" name="usuarioCambio" value="<?php echo $_SESSION["id"];?>">
                <div class="divEntradaTextoDAC">
                    <input name="usuario" type="text" class="inputDAC" placeholder="Nombre de usuario">
                    <img src="/public/iconos/user.png" class="imagenDAC">
                </div>
                </input>
                <div class="divEntradaTextoDAC">
                    <input name="clave" type="password" type="text" class="inputDAC" placeholder="Contraseña">
                    <img src="/public/iconos/desbloquear.png" class="imagenDAC">
                </div>
                <button class="buttonDAC">
                    <img style="position: relative; right: 0" src="/public/iconos/enter.png" class="imagenDAC">
                </button>
            </form>
            <div class="contenedorDAC parteD">
                <div class="divEntradaTextoDAC" id="botonAdelante">
                    <img src="/public/iconos/flecha-derecha.png" class="imagenDAC">
                </div>
            </div>
        </div>
    </div>

    <script>
        /*   const idMaestro = <?php echo "";// echo $_SESSION['idEnlazado']; ?>;
        let botonesAnteriores, informacionAnterior, transitorioBotones, transitorioInformacion;
        let numeroDeInterfaz = 0;
        let botonAtras = document.createElement("button")
        botonAtras.className = "botonDACDos"
        botonAtras.innerHTML = `<img src="/public/iconos/flecha-izquierda.png" class="imagenDAC DACDos" alt="">`
        let botonDelante = document.createElement("button")
        botonDelante.className = "botonDACDos"
        botonDelante.innerHTML = `<img src="/public/iconos/flecha-derecha.png" class="imagenDAC DACDos" alt="">`

        let interfaces = []
        interfaces.push(` <div class="contenedoresDivActualizarCuenta parteDentroArriva">
                <h1 id="tituloDivActualizar">Bienvenido</h1>
            </div>
            <div class="contenedoresDivActualizarCuenta parteDentroAbajo">
                <h3 id="mensajeDivActualizar" >Es la primera vez que inicias sesión con nosotros</h3>
            </div>`)
        interfaces.push(` <div class="contenedoresDivActualizarCuenta parteDentroArriva">
                <h1 id="tituloDivActualizar">Actualizar datos</h1>
            </div>
            <div class="contenedoresDivActualizarCuenta parteDentroAbajo">
                <h3 id="mensajeDivActualizar">Por favor elige un nuevo nombre de usuario y contraseña</h3>
            </div>`)
        interfaces.push(` <div class="contenedoresDivActualizarCuenta parteDentroArriva">
                <h1 id="tituloDivActualizar">Actualizando datos</h1>
            </div>
            <div class="contenedoresDivActualizarCuenta parteDentroAbajo">
                <h3 id="mensajeDivActualizar">Por favor elige un nuevo nombre de usuario y contraseña</h3>
            </div>`)
        // contendorInformacion.innerHTML = interfaces[0]
        const primerVista = () => {
            // contendorInformacion.innerHTML = interfaces[numeroDeInterfaz]
            divBotonesDAC.innerHTML = `<button id="botonAdelanteDACA" class="botonDAC">
                    <img src="/public/iconos/flecha-derecha.png" class="imagenDAC" alt="">
                </button>`
            botonAdelanteDACA.addEventListener("click", function() {
                numeroDeInterfaz++;
                contendorInformacion.innerHTML = interfaces[numeroDeInterfaz]
                divBotonesDAC.innerHTML = ""
                divBotonesDAC.appendChild(botonAtras)
                divBotonesDAC.appendChild(botonDelante)
            })
        }
        const finalVista = () => {
            contendorInformacion.innerHTML = interfaces[numeroDeInterfaz]
            divBotonesDAC.innerHTML = ""
            divBotonesDAC.appendChild(botonAtras)
        }
        primerVista()
        botonAtras.addEventListener("click", function() {
            numeroDeInterfaz--;
            contendorInformacion.innerHTML = interfaces[numeroDeInterfaz]
            if (numeroDeInterfaz == 0) {
                primerVista()
                return;
            }
            if (numeroDeInterfaz == interfaces.length - 2) {
                divBotonesDAC.appendChild(botonDelante)
            }
        })
        botonDelante.addEventListener("click", function() {
            numeroDeInterfaz++
            contendorInformacion.innerHTML = interfaces[numeroDeInterfaz]
            if (numeroDeInterfaz == interfaces.length - 1) {
                divBotonesDAC.innerHTML = `<button id="botonFinalDACA" class="botonDAC">
                    <img src="/public/iconos/flecha-izquierda.png" class="imagenDAC" alt="">
                </button>`
                botonFinalDACA.addEventListener("click", function() {
                    numeroDeInterfaz--;
                    contendorInformacion.innerHTML = interfaces[numeroDeInterfaz]
                    divBotonesDAC.innerHTML = ""
                    divBotonesDAC.appendChild(botonAtras)
                    divBotonesDAC.appendChild(botonDelante)
                })
                return;
            }
        })*/
    </script>
</body>

</html>