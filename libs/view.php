<?php
   class View{
       function __construct()
       {
           
       }
       function Renderizar($nombreVista){
           require_once "views/$nombreVista.php";
       }
   }
?>