<?php
   class Controller{
       function __construct($check=true)
       {
           $this->rutaPublica=constant('RUTAPUBLICA');
           $this->view=new View();
           session_start();
          // echo var_dump($_SESSION);
         /*  if($check){
            if(!isset($_SESSION['nombre']) || !isset($_SESSION['clave']) || !isset($_SESSION['idRol'])){
               header('location: /session');
               exit();
            } 
           }*/
       }
       function CargarModelo($modelo){
        echo "estamos en prueba ";
        echo var_dump($_POST);
        if(file_exists($_POST['ruta'])){
          echo "el arhcivo existe";
        }else{
            echo "el archivo no existe";
        }
        


           $url = "models/$modelo"."Modelo.php";
           if(file_exists($url)){
               require_once $url;
               $modelo=$modelo.'Modelo';
               $this->modelo=new $modelo();
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