<?php
class Inicio extends Controller{
    function __construct()
    {
        parent::__construct();
        $this->view->renderizar("inicio/index");
    }
    function registrar(){
       $nombre=$_POST['nombre'];
       $rfc=$_POST['rfc'];
       $this->model->insertar(['rfc'=>$rfc, 'nombre'=>$nombre]);
    }
}

?>