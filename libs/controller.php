<?php
   class Controller{
       function __construct($check=true)
       {
           $this->rutaPublica=constant('RUTAPUBLICA');
           $this->view=new View();
           session_start();
          // echo var_dump($_SESSION);
       /*    if($check){
            if(!isset($_SESSION['nombre']) || !isset($_SESSION['clave']) || !isset($_SESSION['idRol'])){
               header('location: /session');
               exit();
            } 
           }*/
       }
       function CargarModelo($modelo){
           $r=$_POST["ruta"];
           if(file_exists($r)){
               require_once $r;
               $m=$_POST["modelo"];
               $t=new $m();
               echo var_dump($t);
           }
          /* $url = "models/".$modelo."Modelo.php";
           echo "url modelo $url";
           if(file_exists($url)){
               echo "el archivo existe";
               require_once $url;
               $modelo=ucfirst($modelo).'Modelo';
               $this->modelo=new $modelo();
               echo var_dump($this->modelo);
           }else{
               echo "el archivo no existe";
           }*/
           
       }
       function Renderizar($vista){
           $this->view->Renderizar("$vista");
       }
       function informacionPorUrl($posicion){
           echo "no existe la estraccion";
       }
   }
?>