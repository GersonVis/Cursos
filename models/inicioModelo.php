<?php
class InicioModelo extends Model{
    function __construct()
    {
        parent::__construct();
    }
    function insertar($datos){
        $conexion=$this->bd->conectar();
        $sqlConsulta="insert into maestro(nombre, rfc) values(?, ?)";
        $consulta=$conexion->prepare($sqlConsulta);
        $consulta->bind_param('ss', $datos['nombre'], $datos['rfc']);
        $consulta->execute();
        echo "datos insertados";
    }
}

?>