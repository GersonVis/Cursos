<?php
class ConjuntoModelo extends Model
{
  function __construct()
  {
    parent::__construct();
  }
  function tiposDeConjunto()
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from tipoestado";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return $informacion;
  }
  function consultarCuenta($idMaestro)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from maestrocuenta where idMaestro='$idMaestro'";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return  $informacion;
  }
  function cambiarEstadoDelConjunto($idUsuario, $idConjunto, $idCurso, $idEstado)
  {
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("UPDATE estadoconjunto SET idEstado = ? WHERE idConjunto=? and idCurso=? and idUsuario=?;")) {
      echo json_encode(array("respuesta"=>"Error, error al hacer la cosulta"));
      exit();
      return false;
    }
    $consulta->bind_param("ssss", $idEstado, $idConjunto, $idCurso, $idUsuario);
    $consulta->execute();
    return true;
  }
  function estadoDelConjunto($idUsuario, $idConjunto, $idCurso){
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select tp.id, tp.estado from estadoconjunto as ec JOIN tipoestado as tp ON ec.idEstado=tp.id where ec.idUsuario=$idUsuario and ec.idCurso=$idCurso and idConjunto=$idConjunto;";
   // echo $sqlConsulta;
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return  $informacion;
  }
}
