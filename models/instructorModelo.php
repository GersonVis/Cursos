<?php
class InstructorModelo extends Model
{
  function __construct()
  {
    parent::__construct();
  }
  function obtenerInformacion($posicion)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from instructor where id='$posicion'";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    unset($informacion[0]['id']);
    return $informacion;
  }

  function todos()
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from instructor";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return $informacion;
  }


  
  function eliminar($id)
  {
    $conexion = $this->bd->conectar();

    $sqlConsultaEliminarEnlaces = "delete from impartio where idInstructor=$id;";
    $respuesta = $this->bd->consulta($conexion, $sqlConsultaEliminarEnlaces);
    $sqlConsulta = "delete from instructor where id=$id";
    $respuesta = $this->bd->consulta($conexion, $sqlConsulta);
    return $respuesta;
  }
  function columnas()
  {
    $con = $this->bd->conectar();
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM instructor");
    $etiquetas = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $etiquetas[] = $item['Field'];
    }
    return $etiquetas;
  }
  function convertirdorIipo($entrada)
  {
    $tipoEnBruto = substr($entrada, 0, strpos($entrada, '('));
    $tipoEnBruto = $tipoEnBruto == "" ? $entrada : $tipoEnBruto;
    switch ($tipoEnBruto) {
      case "bigint":
      case "int":
        return "number";
        break;
      case "date":
        return "date";
        break;
      case "varchar":
        return "text";
        break;
      default:
        return "text";
        break;
    }
  }
  function columnasTipo()
  {
    $con = $this->bd->conectar();
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM instructor");
    $etiquetas = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $etiquetas[$item['Field']] = array("valor" => "",  "tipo" => $this->convertirdorIipo($item['Type']));
    }
    unset($etiquetas['id']);
    return $etiquetas;
  }
  function columnasJSON()
  {
    $con = $this->bd->conectar();
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM instructor");
    $etiquetas = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $etiquetas[] = $item['Field'];
    }
    echo json_encode($etiquetas);
  }
  function crear($datos, $cusosAEnlazar)
  {
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("INSERT INTO instructor VALUES (NULL, ?,?,?,?,?,?,?,?,?);")) {
      echo "error";
      return false;
    }
    $consulta->bind_param("sssssssss", $datos['rfc'], $datos['psw'], $datos['nombre'], $datos['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['telefono'], $_POST['sexo'], $_POST['correo'], $_POST['domicilio']);
    $consulta->execute();
    $idInsertado = $consulta->insert_id;
    foreach ($cusosAEnlazar as $idCurso => $valor) {
      $this->bd->consulta($conexion, "insert impartio valueS(NULL,  '$idCurso', '$idInsertado')");
    }
    $conexion->close();
    return true;
  }
  function actualizar($datos)
  {
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("update instructor set {$datos['columna']}=? where id=?")) {
      echo "error";
      return false;
    }
    $consulta->bind_param("ss", $datos['nuevo'], $datos['id']);
    $consulta->execute();
    return true;
  }
  function buscar($valor, $condicionales)
  {//buscara las partes que inicien con las coincidencias
    $sqlConsulta = "select * from instructor where ";
    $sqlCondicional = "";
    foreach ($condicionales as $etiqueta => $valorArray) {//se crea la consulta sql en base a la informacion mandada por $_POST
      if ($valorArray == "1") {
        $sqlCondicional .= "$etiqueta like '$valor%' or ";//like es para que inicien con
      }
    }
    $etiquetas = array();
    if ($sqlCondicional != "") {
      $sqlCondicional = substr($sqlCondicional, 0, -4); //removemos la parte or que queda sobrande poner "or "
      $sqlConsulta = $sqlConsulta . $sqlCondicional;
      $con = $this->bd->conectar();
      $etiquetas = $this->bd->tiposDeDatoConsulta($con, $sqlConsulta);
     
    }
    return $etiquetas; //si no se recivio ninguna condición se retorna un array vacio
  }

  function cursosEnlazados($id)
  {
    $sqlConsulta = "SELECT curso.id, curso.claveCurso, curso.nombreCurso from curso join impartio on impartio.idCurso=curso.id where impartio.idInstructor=$id;";
    $conexion = $this->bd->conectar();
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return $informacion;
  }

  function desenlazar($idCurso, $idInstructor)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "delete from impartio where idCurso=$idCurso and idInstructor=$idInstructor";
    $resultado = $this->bd->consulta($conexion, $sqlConsulta);
    return $resultado;
  }
  function cursosDisponibles($idInstructor)
  {
    /*obtenemos los ids de los instructores que tiene el curso
  luego solicitamos los instructores que no tengan ese id*/
    $conexion = $this->bd->conectar();
    $respuesta = $this->bd->consulta($conexion, $sql = "SELECT curso.id FROM curso INNER JOIN impartio
     ON impartio.idCurso=curso.id where impartio.idInstructor=$idInstructor");
    $idsRechazados = "";
    $sqlConsulta="";
    if ($respuesta->num_rows != 0) {
      while ($idEnlazado = mysqli_fetch_assoc($respuesta)) {
        $idsRechazados .= $idEnlazado['id'] . ", ";
      }
      $idsRechazados = substr($idsRechazados, 0, -2);
      $sqlConsulta="select * from curso where id not in($idsRechazados);";
    }else{
      $sqlConsulta = "select * from curso";
    }
    
   // echo $sqlConsulta;
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);

    return $informacion;
  }
  function enlazar($idInstructor, $idsCursos)
  {
    $con = $this->bd->conectar();
    echo var_dump($idsCursos);
    foreach ($idsCursos as $idCurso => $valor) {
      $resultado = $this->bd->consulta($con, "insert into impartio values(null, $idCurso, $idInstructor)");
      echo $idInstructor;
      //printf("%s %s\n", $idInstructor, $idsInstructores);
    }
    return true;
  }
}
