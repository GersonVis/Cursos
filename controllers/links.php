<?php
class Links extends Controller{
    function __construct()
    {
        parent::__construct();
        $this->view->nombre="links";
    }
    function Renderizar($vista){
     /*   $this->view->instructores=$this->modelo->todos();
        $this->view->columnas=$this->modelo->columnas();*/
        unset($this->view->columnas[0]);
        $this->view->Renderizar("$vista");
    }
    function informacionPorUrl($posicion){
        $datos = $this->modelo->obtenerInformacion($posicion);
        echo json_encode($datos);
    }
    function todos(){
        $datos = $this->modelo->todos();
        echo json_encode($datos);
    }
    function eliminar()
    {
        if ($_SESSION['idRol'] == 1) {
            $respuesta = $this->modelo->eliminar($_POST['id']);
            if (!$respuesta) {
                echo $respuesta->error;
                http_response_code(404);
                exit();
            }
            $informacion = $this->modelo->obtenerInformacion($_POST['id']);
            //echo $informacion;
            //echo count($informacion);
            if (count($informacion) != 0) {
                http_response_code(404);
                exit();
            }
            echo "Borrado Exitosamente";
        }else{
            echo "No tienes permiso para realizar esta acción";
            http_response_code(404);
           
        }
        exit();
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
        if ($_SESSION['idRol'] == 1) {
            $datos['titulo']=$_POST['titulo']; 
            $datos['link']=$_POST['link'];
            $datos['descripcion']=$_POST['descripcion'];
            if (!$this->modelo->crear($datos)) {
                http_response_code(404);
            }
            echo "creado correctamente";
            exit();
        }
        http_response_code(404);
        echo "no tienes permiso para realizar esta acción";
        exit();
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

}
