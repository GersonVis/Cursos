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
           $url = "models/".$modelo."Modelo.php";
           echo "url modelo $url";
           if(file_exists($url)){
               require_once $url;
               $modelo=ucfirst($modelo).'Modelo';
               $this->modelo=new $modelo();
               echo var_dump($this->modelo);
           }
       }
       function Renderizar($vista){
           $this->view->Renderizar("$vista");
       }
       function informacionPorUrl($posicion){
           echo "no existe la estraccion";
       }
   }
?>