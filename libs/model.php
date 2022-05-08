<?php
   class Model{
       function __construct()
       {
           $this->bd = new Database();
           echo "modelo cargado";
       }
   }
?>