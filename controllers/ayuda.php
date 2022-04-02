<?php
class Ayuda extends Controller{
    function __construct()
    {
        parent::__construct();
        $this->view->mensaje="mensaje de ayuda enviado";
        $this->view->renderizar('ayuda/index');
    }
}
?>