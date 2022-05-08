<?php
   class Controller{
       function __construct($check=true)
       {
           $this->rutaPublica=constant('RUTAPUBLICA');
           $this->view=new View();
           session_start();
          // echo var_dump($_SESSION);
           if($check){
            if(!isset($_SESSION['nombre']) || !isset($_SESSION['clave']) || !isset($_SESSION['idRol'])){
               header('location: /session');
               exit();
            } 
           }
       }
       function CargarModelo($modelo){
          /* $prueba=$_POST["ruta"];
           if(file_exists($prueba)){
               echo "el archivo existe";
               require_once $prueba;
               $nom=$_POST["modelo"];
               //echo var_dump($_POST);
               echo $nom;
               $mo=new $nom();
               echo var_dump($mo);
               $this->modelo=new $mo();
           }else{
               echo "el archivo no existe";
           }*/
           $url = "models/$modelo"."Modelo.php";
           echo $url;
           if(file_exists($url)){
               echo "el modelo existe";
               require_once $url;
               echo "modelo todavia no enlazado";
               $modelo=$modelo.'Modelo';
               $this->modelo=new $modelo();
               echo "modelo enlazado";
               echo var_dump($this->modelo);
           }else{
               echo "el archivo no existe";
            echo "el modelo no exisste";
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