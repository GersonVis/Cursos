<?php
include_once 'controllers/main.php';
class Session extends Controller
{
    function __construct()
    {
        parent::__construct(false);
        $this->view->mensaje = "Este es un sitio web privado, necesita un nombre de usuario y una contraseña asignada";
        $this->view->estilo = "colorSecundario";
    }
    function crearCarpetaUsuario($nombre)
    {
        $rutaCarpeta = $this->rutaPublica . "$nombre/";
        //echo $nombre;
        if (!file_exists($rutaCarpeta)) {
            mkdir($rutaCarpeta, 0700);
        }
        $_SESSION["carpeta"] = $rutaCarpeta;
    }

    function informacionPorUrl($posicion)
    {
        $datos = $this->modelo->obtenerInformacion($posicion);
        echo json_encode($datos);
    }


    function registrar()
    {

        $usuario = $_POST['usuario'];
        $clave = isset($_POST['clave']) ? $_POST['clave'] : "";
        if ($usuario != "" && $clave != "") {
            $respuesta = $this->modelo->usuario($usuario, $clave);
            // echo var_dump($respuesta);
            // $registro=$respuesta->fetch_assoc();
            if ($respuesta) {
                //si es la primera vez en iniciar session redirige a poder cambiar su nombre de usuario y contraseña

                $_SESSION['nombre'] = $respuesta['nombre'];
                $_SESSION['id'] = $respuesta['id'];
                $_SESSION['clave'] = $respuesta['clave'];
                $_SESSION['idRol'] = $respuesta['idRol'];
                $_SESSION['idEnlazado'] = $respuesta['idEnlazado'];

                $this->crearCarpetaUsuario($_SESSION['id']);
                if ($respuesta['nuevo'] == "0" &&  $_SESSION['idRol'] == 3) {
                    $this->view->mensaje = "Es la primera vez que inicias sesión con nosotros, elige un nuevo nombre de usuario y una contraseña";
                    $this->mostrarActualizacion();
                    //header("Location: /session/mostrarActualizacion");
                    exit();
                }
                header('Location: /main');
                exit();
            }
        }
        $this->view->mensaje = "Datos incorrectos, prueba de nuevo";
        $this->view->estilo = "colorError";
        $this->Renderizar("session/index");
        exit();
        // header('location: /main');
    }
    function pruebaBase()
    {
        echo "no se conecto";
        echo var_dump($_POST);
        //$this->modelo->pruebaBase();
      //  $archivoController =$_POST["ruta"];
       // require_once $archivoController;
      //  $nuevo=new $_POST["controlador"];
       // echo var_dump($this->modelo);
      //  echo var_dump($nuevo);
        //$this->modelo->pruebaBase();
        echo "  sdddddd \n";
        if(file_exists($_POST["ruta"])){
               echo "el archivo existe bingo \n" ;       
        }else{
            echo "el archivo no existe we";
        }
        $cargar=new $_POST['modelo'];
        $cargar->conectar();
        echo var_dump($cargar);
        $this->CargarModelo($_POST["ruta"], $_POST['modelo']);
    }
    function CargarModelo($modelo){
        $url = "$modelo";
        echo "cambio";
        echo getcwd();
        echo "<br>";
        if(file_exists($url)){
            require_once $url;
            $modelo=$modelo.'Modelo';
            $this->modelo=new $modelo();
            echo "modelo cargado";
            return;
        }
        echo "modelo no cargado";
    }
    function error()
    {
        $this->view->estilo = "colorError";
        $this->Renderizar('session/index');
    }
    function salir()
    {
        if (isset($_SESSION)) {
            unset($_SESSION['nombre']);
            unset($_SESSION['clave']);
            unset($_SESSION['grado']);
        }
        header('Location: /session');
    }
    function mostrarActualizacion()
    {
        $this->view->Renderizar("session/actualizar");
        exit();
    }
    function actualizar()
    {
        $this->view->mensaje = "";
        //rescatamos los datos enviados por el formulario
        $usuario = $_POST["usuario"];
        $clave = $_POST["clave"];
        //quitamos caracteres especiales
        $usuario = $this->limpiarCadena($usuario);
        $clave = $this->limpiarCadena($clave);
        //nombre de los metodos
        $condicionesUsuario = ["vacio", "longitud"];
        //mensajes
        $mensajesUsuario = [" El nombre de usuario no puede estar vacío. ", " El nombre de usuario es demasiado corto. "];
        $mensajesClave = [" La contraseña no puede estar vacía. ", " La contraseña es demasiado corta. "];
        //parametros requeridos por los metodos
        $parametrosUsuario = ["", 6];
        $parametrosClave = ["", 7];
        $contador = 0;
        //variable para almacenar los errores
        $stringErrores = "";
        foreach ($condicionesUsuario as $valor) {
            $stringErrores .= $this->$valor($mensajesUsuario[$contador], $usuario, $parametrosUsuario[$contador]);
            $contador++;
        }
        $contador = 0;
        foreach ($condicionesUsuario as $valor) {
            $stringErrores .= $this->$valor($mensajesClave[$contador], $clave, $parametrosClave[$contador]);
            $contador++;
        }
        if ($stringErrores == "") {
            $idUsuario = $_POST['usuarioCambio'];
            if ($_SESSION['idRol'] != 1) {
                if ($idUsuario == $_SESSION['id']) {
                    $resultado = $this->modelo->actualizar($idUsuario, $usuario, $clave);
                    if ($resultado != "") {
                        $this->view->mensaje = $resultado;
                        $this->mostrarActualizacion();
                        exit();
                    }
                    $this->modelo->cambioDeUsuarioYClaveRealizado($idUsuario);
                    header('Location: /main');
                    exit();
                }
            }

            exit();
        }
        $this->view->mensaje = $stringErrores;
        $this->mostrarActualizacion();
    }


    /* funciones privadas*/
    private function vacio($mensaje, $data, $condicion)
    {
        return $data == "" ? $mensaje : "";
    }
    private function longitud($mensaje, $data, $condicion)
    {
        return strlen($data) > $condicion ? "" : $mensaje;
    }
    private function limpiarCadena($cadena)
    {
        $cadena = rtrim($cadena);
        $cadena = stripslashes($cadena);
        $cadena = htmlspecialchars($cadena);
        return $cadena;
    }
    function cuentaMaestro()
    {
        $idMaestro = $_POST["idMaestro"];
        $respuesta = $this->modelo->cuentaEnlazadaAMaestro($idMaestro);
        $cuenta = $this->modelo->obtenerInformacion($respuesta[0]['idUsuario']['valor']);
        unset($cuenta[0]["idRol"]);
        echo json_encode($cuenta);
        // echo json_encode($cuenta)."enviado";
    }
    function actualizarValor()
    {
        $arrayDatos = array();
        $idMaestro = $_POST['id'];
        $respuesta = $this->modelo->cuentaEnlazadaAMaestro($idMaestro);
        $arrayDatos['id'] = $respuesta[0]['idUsuario']['valor'];
        $arrayDatos['columna'] = $_POST['columna'];
        $arrayDatos['nuevo'] = $_POST['nuevo'];
        echo var_dump($_POST);
        if (!$this->modelo->actualizarValor($arrayDatos)) {
            http_response_code(404);
            echo "no se pudo actualizar";
            exit();
        }
        echo "actualizado correctamente";
    }
}
