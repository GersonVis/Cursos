<?php
include_once 'controllers/main.php';
 class Session extends Controller{
     function __construct()
     {
         parent::__construct(false);
         $this->view->estilo="colorSecundario";
         
     }
     function crearCarpetaUsuario($nombre){
         $rutaCarpeta=$this->rutaPublica."$nombre/";
         echo $nombre;
         if(!file_exists($rutaCarpeta)){
             mkdir($rutaCarpeta, 0700);
         }
         $_SESSION["carpeta"]=$rutaCarpeta;
     }
     function registrar(){
            $usuario=$_POST['usuario'];
            $clave=isset($_POST['clave'])?$_POST['clave']:"";
            
            if($usuario!="" && $clave!=""){
                $respuesta=$this->modelo->usuario($usuario, $clave);
                echo var_dump($respuesta);
               // $registro=$respuesta->fetch_assoc();
              if($respuesta){
                    
                     $_SESSION['nombre']=$respuesta['nombre'];
                     $_SESSION['id']=$respuesta['id'];
                     $_SESSION['clave']=$respuesta['clave'];
                     $_SESSION['idRol']=$respuesta['idRol'];
                     $_SESSION['idEnlazado']=$respuesta['idEnlazado'];
                     $this->crearCarpetaUsuario($_SESSION['id']);
                    header('Location: /main'); 
                     exit();
                }
            } 
            $this->view->estilo="colorError";
            $this->Renderizar("session/index");
            exit();
       
        
       // header('location: /main');
     }
     function error(){
         $this->view->estilo="colorError";
         $this->Renderizar('session/index');
     }
     function salir(){
         if(isset($_SESSION)){
             unset($_SESSION['nombre']);
             unset($_SESSION['clave']);
             unset($_SESSION['grado']);
         }
         header('Location: /session');
     }
 }
