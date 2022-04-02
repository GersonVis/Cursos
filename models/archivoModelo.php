<?php
class ArchivoModelo extends Model
{
  function __construct()
  {
    parent::__construct();
  }
  function Renderizar($vista)
  {
    $this->view->Renderizar("archivo/index");
    exit();
  }
  function registrarCarga($ruta, $descripcion, $nombre, $propietario, $idConjunto)
  {
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("insert into archivo values(null, ?, ?, ?)")) {
      echo "error";
      return false;
    }
    $consulta->bind_param("sss", $ruta, $descripcion, $nombre);
    //$idInsertado=$this->mysqli->insert_id;
    $consulta->execute();
    $idArchivo=$consulta->insert_id;
    if (!$consulta = $conexion->prepare("insert into cuentaArchivo values(null, ?, ?, ?)")) {
      echo "error al relacionar";
      return false;
    }
    $consulta->bind_param("sss", $propietario, $idArchivo, $idConjunto);
    $consulta->execute();
    return true;
  }
  function todos()
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from archivo";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return $informacion;
  }
  function obtenerInformacion($idArchivo)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "SELECT ca.id as id, ar.id as idArchivo, ar.ruta as ruta, ar.descripcion as descripcion, ar.nombre as nombre from cuentaarchivo as ca JOIN archivo as ar on ca.idArchivo=ar.id where ar.id=$idArchivo;";
 //   echo $sqlConsulta;
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return $informacion;
  }
  function actualizar($datos)
  {
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("update curso set {$datos['columna']}=? where id=?")) {
      echo "error";
      return false;
    }
    $consulta->bind_param("ss", $datos['nuevo'], $datos['id']);
    $consulta->execute();
    return true;
  }

  function eliminar($id, $idCuenta)
  {
    $conexion = $this->bd->conectar();

    $sqlConsulta = "delete from solicitudliberacion where idCuentaArchivo=$idCuenta";
    $respuesta = $this->bd->consulta($conexion, $sqlConsulta);
  //  echo $sqlConsulta."<br>";
  //  echo var_dump($respuesta);
    
    $sqlConsulta = "delete from permiso where idArchivo=$id";
    $respuesta = $this->bd->consulta($conexion, $sqlConsulta);
 //   echo $sqlConsulta."<br>";
  //  echo var_dump($respuesta);

    $sqlConsulta = "delete from cuentaarchivo where id=$idCuenta";
    $respuesta = $this->bd->consulta($conexion, $sqlConsulta);
   // echo $sqlConsulta."<br>";
   // echo var_dump($respuesta);

    $sqlConsulta = "delete from archivo where id=$id";
    $respuesta = $this->bd->consulta($conexion, $sqlConsulta);
  //  echo $sqlConsulta."<br>";
  //  echo var_dump($respuesta);
    return $respuesta;
  }
  function columnas() ///regresa los datos de las columnas que contiene la tabla
  {
    $con = $this->bd->conectar();
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM curso");
    $etiquetas = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $etiquetas[] = $item['Field'];
    }
    return $etiquetas;
  }
  function registrarSolicitudLiberacion($ruta, $descripcion, $nombre, $cuenta, $idCurso, $idConjunto){
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("insert into archivo values(null, ?, ?, ?)")) {
      echo "error al registrar carga";
      return false;
    }
    $consulta->bind_param("sss", $ruta, $descripcion, $nombre);
    //$idInsertado=$this->mysqli->insert_id;
    $consulta->execute();
    $idArchivo=$consulta->insert_id;
    if (!$consulta = $conexion->prepare("insert into cuentaArchivo values(null, ?, ?)")) {
      echo "error al relacionar";
      return false;
    }
    $consulta->bind_param("ss", $cuenta['id'], $idArchivo);
    $consulta->execute();
    $idCuentaArchivo=$consulta->insert_id;
    if (!$consulta = $conexion->prepare("insert into solicitudliberacion values(null, ?, ?, ?)")) {
      echo "error al solicitar liberacion";
      return false;
    }
    $consulta->bind_param("sss", $idCuentaArchivo, $idConjunto, $idCurso);
    $consulta->execute();
  //  $this->registrarPermiso($idArchivo, $idCuenta['idRol']);
    return $this->registrarPermiso($idArchivo, $cuenta['idRol']);
  }
  function registrarEstadoDelConjunto($idConjunto, $idCurso, $idUsuario, $estado){
    $conexion = $this->bd->conectar();
    $sqlConsulta = "delete from estadoConjunto where  idConjunto=$idConjunto and idUsuario=$idUsuario and idCurso=$idCurso";
    $respuesta = $this->bd->consulta($conexion, $sqlConsulta);
    if (!$consulta = $conexion->prepare("insert into estadoConjunto values(null, ?, ?, ?, ?)")) {
      echo "error al registrar estado de conjunto";
      return false;
      exit();
    }
    $consulta->bind_param("ssss", $idConjunto, $idCurso, $idUsuario, $estado);
    $consulta->execute();
    return $consulta;
  }
  function consultarArchivosGrupo($usuario, $idCurso, $idConjunto){
    //trae los datos que coincidan en curso, usuario, conjunto
    $conexion = $this->bd->conectar();
    $sqlConsulta = 'SELECT ar.nombre, ar.id FROM solicitudliberacion as sl inner JOIN  cuentaarchivo as ca on sl.idCuentaArchivo=ca.id
    inner join archivo ar on ca.idArchivo=ar.id where sl.idCurso="'.$idCurso.'" and sl.idConjunto="'.$idConjunto.'" and ca.idCuenta="'.$usuario.'"';
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return  $informacion;
  }
  function registrarPermiso($idArchivo, $idRol){
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("insert into permiso values(null, ?, ?)")) {
     // echo "error al registrar permiso";
      return false;
    }
  //  echo "insert into permiso values(null, $idArchivo, $idRol)";
    $consulta->bind_param("ss", $idArchivo, $idRol);
    $consulta->execute();
    return true;
  }
  function consultarPermiso($idArchivo, $idRol){
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from permiso where idArchivo=$idArchivo and idRol=$idRol";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return  $informacion;
  }
  function estadoDelConjunto($idUsuario, $idConjunto, $idCurso){
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select tp.id, tp.estado from estadoconjunto as ec JOIN tipoestado as tp ON ec.idEstado=tp.id where ec.idUsuario=$idUsuario and ec.idCurso=$idCurso and idConjunto=$idConjunto;";
   // echo $sqlConsulta;
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return  $informacion;
  }
  function listaDeEstadosDelConjunto(){
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from tipoestado";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return  $informacion;
  }
  function consultarCuenta($idMaestro){
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from maestrocuenta where idMaestro='$idMaestro'";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return  $informacion;
  }
 
}
