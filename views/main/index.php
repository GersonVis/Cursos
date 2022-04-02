<?php
include 'Elementos/opcionMenu.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <link rel="stylesheet" href="/public/css/estilosPorDefecto.css">
    <link rel="stylesheet" href="/public/css/estilosMenu.css">
    <title>Document</title>
</head>

<body class="expandirAmbos centrar colorBase colorDegradadoBase">
    <div class="expandirAmbos colorDegradadoBase centrar">
        <div id="contenedorMenu" class="flexCentrado">
            <div id="ContenedorOpciones" class="mitadTodoHW sinBarra">
                <ul id="listaMenu" class="expandirAmbos flexCentradoR">

                    <?php
                    $opcionesMenu = array(
                      //  "perfil" => array("/public/imagenes/instructor.png", "Perfil", "Muestra detalles del perfil con el que se esta accediendo", "/public/imagenes/instructor.png"),
                        "instructores" => array("/public/imagenes/instructor.png", "Instructores", "Despliega una lista de instructores registrados", "/public/imagenes/instructorAbajo.png", "/instructor"),
                        "cursos" => array("/public/imagenes/libros.png", "Cursos", "Despliega una lista de cursos disponibles o registrados", "/public/imagenes/cursosImagenAbajo.png", "/curso"),
                        "cursostomados" => array("/public/imagenes/cursos-tomados.png", "Cursos tomados", "Despliega una lista de personas inscristas con el curso en el cual están inscritos", "/public/imagenes/cursostomadosAbajo.png", "/curso/tomados"),
                        "listas" => array("/public/imagenes/listas.png", "Listas", "Muestra la listas de cada curso con las personas registradas", "/public/imagenes/listasAbajo.png", "/listas")
                    );
                    $contador = 0;
                    foreach ($opcionesMenu as $valor) {
                        crearOpcionMenu($contador++, $valor[0], $valor[1]);
                    }
                    ?>
            </div>
            <div id="contenedorAbajo" class="mitadTodoHW colorSecundario flexCentradoR">
                <div id="contenedorOpcionAbajo" class="flexCentradoR">
                    <li id="opcionAbajo" class="opcionMenuSinEvento posicionRelativa flexCentradoC">
                        <div class="contenedorImagen cuadrado colorPrimario redondear flexCentradoR">
                            <img id="imagenAbajo" src="<?php echo $opcionesMenu["instructores"][0]; ?>" class="imagenOpcion unTercio">
                        </div>
                        <div class="ocuparDisponible centrar flexCentradoR ">
                            <p class="textoTipoC" id="textoAbajo"></p>
                        </div>
                    </li>
                </div>
                <div id="contenedorInformacion">
                    <p class="textoTipoA" id="titulo">Descripción: </p>
                    <p id="descripcion" class="textoTipoB"><?php echo $opcionesMenu["instructores"][2]; ?></p>
                    <div id="conImagenDescripcion" class="">
                        <img src="<?php echo $opcionesMenu["instructores"][3]; ?>" class="" id="imagenDescripcion">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        datosOpciones={<?php
            $contador=0;
            foreach ($opcionesMenu as $valor) {
              echo "opcion".$contador++.": {titulo:\"$valor[1]\", descripcion: \"$valor[2]\", imagen:\"$valor[3]\", redireccion:\"$valor[4]\"}, ";     
            }
           
        ?>}
    </script>

    <script src="/public/js/menu.js"></script>
    <script scrc="public/js/mostrarMenu.js"></script>
</body>

</html>