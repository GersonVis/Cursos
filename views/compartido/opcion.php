<?php
class Opcion extends Elemento{
    function __construct()
    {
        
    }
    function estiloCSS(){
        return '<link rel="stylesheet" href="/public/css/estilosOpcion.css">';
    }
    function codigoHTML($id, $nombre){
        return ' <li id="opcion'.$id.'" idSql="'.$id.'" class="opcion displayFlexC" >
        <div class="conArribaOpcion FlexCentradoR posicionRelativa expandirW flexCentradoR">
            <div class="cuadroOpcion colorPrimario redondear flexCentradoR">
                <img src="public/iconos/perfil-del-usuario.png" class="mitad" alt="">
                <div idSql="'.$id.'" class="opcionesDentro opcionEliminar posicionAbsoluta circulo colorQuinto flexCentradoR">
                    <img src="public/iconos/basura.png" class="expandirSetenta" alt="">
                </div>
                <div idSql="'.$id.'" class="opcionesDentro opcionEditar posicionAbsoluta circulo colorCuarto flexCentradoR">
                    <img src="public/iconos/configuracion.png" class="expandirSetenta" alt="">
                </div>
            </div>
        </div>
        <div class="conAbajoOpcion displayFlexR ocuparDisponible">
            <p>'.$nombre.'</p>
        </div>
    </li>';
    }
}
?>