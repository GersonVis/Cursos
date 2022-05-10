<?php

class Maestro extends Controller{
    function __construct()
    {
        parent::__construct();
        $this->view->nombre="maestro";
       
    }
    function Renderizar($vista){
       /* $this->view->instructores=$this->modelo->todos();
        $this->view->columnas=$this->modelo->columnas();*/
       // unset($this->view->columnas[0]);
        $this->view->Renderizar("$vista");
    }
    function informacionPorUrl($posicion){
        $datos = $this->modelo->obtenerInformacion($posicion);
        echo json_encode($datos);
    }
    function todos(){
       /* echo "estamos en maestro";
        echo var_dump($this->modelo);*/
        $posicion=$_POST["posicion"];
        
        $datos = $this->modelo->todos($posicion);
       // echo var_dump($datos);
        //echo var_dump($datos);
        //echo json_encode(array("e"=>"momom"));
        echo json_encode($datos, JSON_INVALID_UTF8_IGNORE);
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
    function columnas(){
        echo $this->modelo->columnasJSON();
    }
    function columnasTipo()
    {
      $respuesta = $this->modelo->columnasTipo();
      echo json_encode($respuesta);
    }
    function crear(){
        $instructor=array();
        $datos['rfc']=$_POST['rfc']; 
        $datos['psw']=$_POST['psw'];
        $datos['nombre']=$_POST['nombre'];
        $datos['apellidoPaterno']=$_POST['apellidoPaterno'];
        $datos['apellidoMaterno']=$_POST['apellidoMaterno'];
        $datos['telefono']=$_POST['telefono'];
        $datos['sexo']=$_POST['sexo'];
        $datos['correo']=$_POST['correo'];
        $datos['domicilio']=$_POST['domicilio'];
        $datos['idCarrera']=$_POST['idCarrera'];
        $cursosAEnlazar = isset($_POST['cursos'])?json_decode($_POST['cursos']):array();
        echo var_dump($cursosAEnlazar);
        if (!$this->modelo->crear($datos, $cursosAEnlazar)) {
            http_response_code(404);
            exit();
        }
        echo "creado correctamente";
    }
    function actualizar(){
        $arrayDatos=array();
        $arrayDatos['id']=$_POST['id'];
        $arrayDatos['columna']=$_POST['columna'];
        $arrayDatos['nuevo']=$_POST['nuevo'];
        if(!$this->modelo->actualizar($arrayDatos)){
            http_response_code(404);
            echo "no se pudo actualizar";
            exit();
        }
        echo "actualizado correctamente";
    }
    function busqueda(){
        $valor=$_POST['valor'];
        $datos=$_POST;
        unset($datos['valor']);
        $resultadoConsulta=array();
        if(count($datos)!=0){
            $resultadoConsulta=$this->modelo->buscar($valor, $datos);
        }
        echo json_encode($resultadoConsulta);
    }
    function cursosEnlazados()
    {
        $idInstructor = $_POST['idInstructor'];
        $respuesta = $this->modelo->cursosEnlazados($idInstructor);
        echo json_encode($respuesta);
    }
    function desenlazar(){
        $idCurso=$_POST['idCurso'];
        $idInstructor=$_POST['idInstructor'];
        $respuesta=$this->modelo->desenlazar($idCurso, $idInstructor);
        if(!$respuesta){
            http_response_code(404);
            exit();
        }
    }
    function cursosDisponibles()
    {
        $idInstructor = $_POST['idInstructor'];
        $respuesta=$this->modelo->cursosDisponibles($idInstructor);
        echo json_encode($respuesta);
    }
    function enlazar()
    {
        
        $idsCursos = json_decode($_POST['idsCursos']);
        $idInstructor = $_POST['idInstructor'];
        $respuesta=$this->modelo->enlazar($idInstructor, $idsCursos);
        
    }
    function carreras(){
        $posicion=$_POST["posicion"];
        $respuesta=$this->modelo->carreras($posicion);
        if($respuesta){
           // echo var_dump($respuesta);
            echo json_encode($respuesta, JSON_INVALID_UTF8_IGNORE);
            exit();
        }
        http_response_code(404);
        exit();
    }
}

?>