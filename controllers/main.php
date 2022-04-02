<?php
class Main extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function Renderizar($nombreVista){
       if($_SESSION['grado']=="1"){
          require_once "views/$nombreVista.php";
          exit();
       }
       header('Location: /curso'); 
    }
}
?>