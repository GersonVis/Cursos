<?php
require_once "vendor/autoload.php";
require_once "Documento.php";
class Curso extends Controller
{
    function __construct()
    {
        echo "estamos en curso";

        parent::__construct();
        $this->view->nombre = "curso"; //declarar el nombre del controlador en el que estamos, se usa en las vistas
    }
    function Renderizar($vista)
    {
        $this->view->instructores = $this->modelo->todos();
        $this->view->columnas = $this->modelo->columnas();
        unset($this->view->columnas[0]);
        if(!isset($_SESSION['idRol'])){
            header("Location: /session");
            exit();
        }
        if($_SESSION['idRol']=="1"){
            $this->view->Renderizar("$vista");
            exit();
        }
        $this->view->Renderizar("curso/indexinvitado");
        exit();
    }
    function informacionPorUrl($posicion)
    {
        $datos = $this->modelo->obtenerInformacion($posicion);
        echo json_encode($datos);
    }
    function todos()
    {
        $datos = $this->modelo->todos();

        echo json_encode($datos);
    }
    function eliminar()
    {
        $respuesta = $this->modelo->eliminar($_POST['id']);
        if (!$respuesta) {
            echo $respuesta->error;
            http_response_code(404);
            exit();
        }
        $informacion = $this->modelo->obtenerInformacion($_POST['id']);
        if ($informacion->num_rows() != 0) {
            http_response_code(404);
            exit();
        }
    }
    function columnas()
    {
        echo $this->modelo->columnasJSON();
    }
    function crear()
    {
        $instructor = array();
        $datos['claveCurso'] = $_POST['claveCurso'];
        $datos['fechaInicial'] = $_POST['fechaInicial'];
        $datos['fechaFinal'] = $_POST['fechaFinal'];
        $datos['horas'] = $_POST['horas'];
        $datos['cupo'] = $_POST['cupo'];
        $datos['nombreCurso'] = $_POST['nombreCurso'];
        $datos['lugar'] = $_POST['lugar'];
        $datos['horario'] = $_POST['horario'];

        $instructoresEnlazados = json_decode($_POST['instructores']);
        if (!$this->modelo->crear($datos, $instructoresEnlazados)) {
            http_response_code(404);
        }
        echo "creado correctamente";
    }
    function actualizar()
    {
        $arrayDatos = array();
        $arrayDatos['id'] = $_POST['id'];
        $arrayDatos['columna'] = $_POST['columna'];
        $arrayDatos['nuevo'] = $_POST['nuevo'];
        if($arrayDatos['id']=="" || !is_numeric($arrayDatos['id'])){
            http_response_code(404);
            echo "error en el id";
            exit();
        }
        if (!$this->modelo->actualizar($arrayDatos)) {
            http_response_code(404);
            echo " no se pudo actualizar";
            exit();
        }
        echo "actualizado correctamente";
    }
    function busqueda()
    {
        $valor = $_POST['valor'];
        $datos = $_POST;
        unset($datos['valor']);

        $ar = fopen("errores.txt", "w");
        fwrite($ar, "escribiendo");
        $v = var_export($_POST, true);
        fwrite($ar, $v);
        $resultadoConsulta = array();
        if (count($datos) != 0) {
            $resultadoConsulta = $this->modelo->buscar($valor, $datos);
        }
        echo json_encode($resultadoConsulta);
    }


    //solicitar tablas realcionadas
    function instructoresEnlazados()
    {
        $idCurso = $_POST['curso'];
        $respuesta = array("datos" => $idCurso);
        $respuesta = $this->modelo->instructoresEnlazados($idCurso);
        echo json_encode($respuesta);
    }


    function maestrosEnlazados()
    {
        $idCurso = $_POST['curso'];
        $respuesta = array("datos" => $idCurso);
        $respuesta = $this->modelo->maestrosEnlazados($idCurso);
        echo json_encode($respuesta);
    }
    //retorna cada columna con el tipo de dato que es creando un json {nombreColumna:{tipo: "int", valor: 3}}
    function columnasTipo()
    {
        $respuesta = $this->modelo->columnasTipo();
        echo json_encode($respuesta);
    }
    function enlazar()
    {

        $idInstructores = json_decode($_POST['idsInstructores']);
        $idCurso = $_POST['idCurso'];
        $respuesta = $this->modelo->enlazar($idCurso, $idInstructores);
    }
    function instructoresDisponibles()
    {
        $idCurso = $_POST['idCurso'];
        $respuesta = $this->modelo->instructoresDisponibles($idCurso);
        echo json_encode($respuesta);
    }
    function desenlazar()
    {
        $idCurso = $_POST['idCurso'];
        $idInstructor = $_POST['idInstructor'];
        $respuesta = $this->modelo->desenlazar($idCurso, $idInstructor);
        if (!$respuesta) {
            http_response_code(404);
            exit();
        }
    }
    function constanciaLiberada()
    {
        $idCurso = $_POST['idCurso'];
        $idMaestro = $_POST['idMaestro'];
      
        $informacion = $this->modelo->constanciaLiberada($idCurso, $idMaestro);
        echo json_encode($informacion);
    }
    function liberar()
    {
        $idCurso = $_POST['idCurso'];
        $idMaestro = $_POST['idMaestro'];
        $informacion = $this->modelo->liberar($idCurso, $idMaestro);
        echo json_encode($informacion);
    }
    function noLiberar()
    {
        $idCurso = $_POST['idCurso'];
        $idMaestro = $_POST['idMaestro'];
        $informacion = $this->modelo->noLiberar($idCurso, $idMaestro);
        echo json_encode($informacion);
    }
    function invertirLiberacion()
    {
        $idCurso = $_POST['idCurso'];
        $idMaestro = $_POST['idMaestro'];
        $informacion = $this->modelo->invertirLiberacion($idCurso, $idMaestro);
        echo json_encode($informacion);
    }
    function solicitarConstancia()
    {
        $idMaestro=$_POST['idMaestro'];
        $idCurso=$_POST['idCurso'];
        $informacion=$this->modelo->datosConstancia($idMaestro, $idCurso);
      //  echo var_dump($informacion);

        define('nombrePlantilla', 'base.docx');
        $nombreArchivo = "nuevoDoc.docx";

        $datos = array("nombre" => $informacion['nombre']['valor'], "accion" => "Asistir al curso", "curso"=>$informacion['curso']['valor']);
       $nuevoDocumento = new Documento(nombrePlantilla, $nombreArchivo, $datos);
        $nuevoDocumento->cargarPlantilla();
        $nuevoDocumento->actualizarDatos();
        $nuevoDocumento->GuardarDocumento();
       $nuevoDocumento->descargarArchivo();
    }
    function asistencia(){
        $idMaestro=$_POST['idMaestro'];
        $idCurso=$_POST['idCurso'];
        $informacion=$this->modelo->asistencia($idMaestro, $idCurso);
        echo json_encode($informacion);
    }
    function cursosDisponiblesDeTomar(){
        $idMaestro=$_POST['idMaestro'];
        try{
            echo json_encode($this->modelo->solicitarCursosDisponibles($idMaestro));
        }catch(Error $e){
            echo "{Erorr: \"Error al solicitar\"}";
        }

    }
}
