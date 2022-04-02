<?php
class Conjunto extends Controller{
    function __construct()
    {
        parent::__construct();
        $this->view->nombre="conjunto";
    }
    function tiposDeConjunto(){
        try{
            echo json_encode($this->modelo->tiposDeConjunto());
        }catch(Error $e){
            http_response_code(404);
            echo "{error: "."Error $e"."}";
            exit();
        }

    }
    function cambiarEstado(){
        $idMaestro=$_POST['idMaestro'];
        $idCurso=$_POST['idCurso'];
        $idConjunto=$_POST['idConjunto'];
        $idEstado=$_POST['idEstado'];
        $respuesta=$this->modelo->consultarCuenta($idMaestro);
        try{
            if(count($respuesta)>0){
                $idCuenta=$respuesta[0]['idUsuario']['valor'];
                $respuesta=$this->modelo->cambiarEstadoDelConjunto($idCuenta, $idConjunto, $idCurso, $idEstado);
                echo json_encode(array("respuesta"=>$respuesta?"Se realizo el cambio correctamente":"Error al hacer el cambio"));
                exit();
        }
        }catch(Error $error){
            http_response_code(404);
            echo json_encode(array("respuesta"=>"Error, $error"));
            exit();
        }
    }
    function estadoDelConjunto(){
        /* 
           Solicitar a la base de datos si el conjunto CVV o evidencias esta liberado
        */
        $idMaestro=$_POST['idMaestro'];
        $idCurso=$_POST['idCurso'];
        $idConjunto=$_POST['idConjunto'];
        $respuesta=$this->modelo->consultarCuenta($idMaestro);
      //  echo var_dump($_POST);
        try{
            if(count($respuesta)>0){
           //     echo "entro";
                $idCuenta=$respuesta[0]['idUsuario']['valor'];
                $respuestaConsulta=$this->modelo->estadoDelConjunto($idCuenta, $idConjunto, $idCurso);
                //echo json_encode($respuestaConsulta);
                echo json_encode($respuestaConsulta?$respuestaConsulta[0]:array("respuesta"=>"Error al hacer consulta"));
                exit();
           }else{
            echo json_encode(array("respuesta"=>"No se encontro cuenta asociada"));
            exit();
           }
        }catch(Error $error){
            http_response_code(404);
            echo json_encode(array("respuesta"=>"Error, $error"));
            exit();
        }
        
    }
}
?>