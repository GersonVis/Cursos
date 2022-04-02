<?php
class Archivo extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->view->nombre = "archivo";
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
    function subirArchivo()
    {
        $propietario =$_SESSION['id'];
        //los tipos de archivo es para saber a que conjunto pertenece, los conjuntos disponibles
        //estan en la tabla conjuntoarchivo el id 1 es para conjunto libre
        $tipoArchivo = isset($_POST["tipo"])?$_POST["tipo"]:"1";
        $errores=0;
        foreach($_FILES as $identificador=>$archivo){
            $archivo = $archivo;
            $rutaLocal = $_SESSION["carpeta"];
            $nombre=basename($archivo["name"]);
            $ruta = $rutaLocal . $nombre;
            $descripcion = isset($_POST['descripcion'])?$_POST['descripcion']:"";
            if(!file_exists($ruta)){
                if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
                     if ($this->modelo->registrarCarga($ruta, $descripcion, $nombre, $propietario, $tipoArchivo)) {
                        continue;  
                       }
                   }
            }
            $errores++;
        }
        echo "han ocurrido ".$errores." Errores";
    }
    function liberacionCurso(){
      //Recive archivos por metodo post, luego los registra en la base de datos
      //conjunto es el apartado de archivos para la liberación, se puede consultar en conjuntoArchivo
        $cuenta=array('id'=>$_SESSION['id'],'idRol'=>"1");//el unico que tiene permisos para elimiar archivo es el administrador ver tabla permiso
        $idCurso=$_POST['idCurso'];
        $idConjunto=$_POST['idConjunto'];
        $errores=0;
        $rutaCurso = $_SESSION["carpeta"].$idCurso;
        $rutaConjunto="";
        
        if(!file_exists($rutaCurso)){
            mkdir($rutaCurso, 0700);
        }
        $rutaConjunto=$rutaCurso."/$idConjunto";
        if(!file_exists($rutaConjunto)){
            mkdir($rutaConjunto, 0700);
        }
        if($this->modelo->registrarEstadoDelConjunto($idConjunto, $idCurso, $cuenta['id'], 2)){
            foreach($_FILES as $identificador=>$archivo){
                //recorre todos los archivos enviados en el formulario y guarda un  registro en la base de datos
                //cada regsitro lleva el usuario que lo subio, nombre del archivo y ruta
                $archivo = $archivo;
               
                $nombre=basename($archivo["name"]);
                $ruta = $rutaConjunto . "/$nombre";
                $descripcion = isset($_POST['descripcion'])?$_POST['descripcion']:"";
                if(!file_exists($ruta)){
                    if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
                         if ($this->modelo->registrarSolicitudLiberacion($ruta, $descripcion, $nombre, $cuenta, $idCurso, $idConjunto)) {
                            continue;  
                           }
                       }
                }
                $errores++;
            }
            echo "Han ocurrido ".$errores.($errores==1?" Error": " Errores"); 
        }
    }

    function actualizar()
    {
        $arrayDatos = array();
        $arrayDatos['id'] = $_POST['id'];
        $arrayDatos['columna'] = $_POST['columna'];
        $arrayDatos['nuevo'] = $_POST['nuevo'];
        if (!$this->modelo->actualizar($arrayDatos)) {
            http_response_code(404);
            echo " no se pudo actualizar";
            exit();
        }
        echo "actualizado correctamente";
    }
    function eliminar()
    {
        $id=$_POST['idArchivo'];
        $datos = $this->modelo->obtenerInformacion($id);
        if(count($datos)>0){
            $archivo=$datos[0];
            $rutaArchivo=$archivo['ruta']['valor'];
            $idCuenta=$archivo['id']['valor'];
            echo var_dump($idCuenta);
            if(unlink($rutaArchivo) && $this->modelo->eliminar($id, $idCuenta)){
                echo json_encode(array("respuesta"=>"Eliminado correctamente"));
                exit();
            }
        }
        http_response_code(404);
    }
    private function informacionArchivos($usuario, $idCurso, $idConjunto, $idRol){
        $registroArchivos=$this->modelo->consultarArchivosGrupo($usuario, $idCurso, $idConjunto);
        foreach($registroArchivos as $etiqueta=>$datos){
             $idArchivo=$datos['id']['valor'];
             $permisos=$this->modelo->consultarPermiso($idArchivo, $idRol);
             $datos["permisoEliminar"]=array("valor"=>count($permisos)==true);
             $datos["permisoModificar"]=array("valor"=>($idRol)==1);
             $registroArchivos[$etiqueta]=$datos;
           
        }
        echo json_encode($registroArchivos);
        exit();
    }
    function registroArchivosSubidos(){
        $usuario=$_SESSION['id'];
        $idCurso=$_POST['idCurso'];
        $idConjunto=$_POST['idConjunto'];
        $idRol=$_SESSION['idRol'];
        if($idRol!=1){//cuando hace la peticion alguien que no es administrador
            try{
               $this->informacionArchivos($usuario, $idCurso, $idConjunto, $idRol);
             } catch(ValueError $e){
                 http_response_code(404);
                 echo "{error:\"ocurrio un error, con la peticion\"}";
             }
             exit();
        }
        $idMaestro=$_POST['idMaestro'];
        try{
            /*Extraemos el id asociado a maestro para poder hacer una consulta */
            $respuesta=$this->modelo->consultarCuenta($idMaestro);
            if(count($respuesta)>0){
                $idCuenta=$respuesta[0]['idUsuario']['valor'];
                echo json_encode($this->informacionArchivos($idCuenta, $idCurso, $idConjunto, $idRol));
                exit();
            }
         } catch(ValueError $e){
             http_response_code(404);
         }
         echo "{error:\"ocurrio un error, con la peticion\"}";
         exit();
    }
    function estadoDelConjunto(){
        /* 
           Solicitar a la base de datos si el conjunto CVV o evidencias esta liberado
        */
        $idMaestro=$_POST['idMaestro'];
        $idCurso=$_POST['idCurso'];
        $idConjunto=$_POST['idConjunto'];
        $respuesta=$this->modelo->consultarCuenta($idMaestro);
        try{
            if(count($respuesta)>0){
                $idCuenta=$respuesta[0]['idUsuario']['valor'];
                $respueta=$this->modelo->estadoDelConjunto($idCuenta, $idConjunto, $idCurso);
                echo var_dump($respuesta);
                echo json_encode(count($respueta)!=0?$respueta[0]:array());
                exit();
        }
        }catch(Error $error){
            http_response_code(404);
            echo "{error: \"Error al solicitar\"}";
            exit();
        }
        
    }
    function listaDeEstadosDelConjunto(){
        try{
            echo json_encode($this->modelo->listaDeEstadosDelConjunto());
        }catch(Error $error){
            http_response_code(404);
            echo "{error: \"Error al solicitar$error\"}";
            exit();
        }
        
    }
   
}
