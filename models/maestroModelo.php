<?php

class MaestroModelo extends Model
{
  function __construct()
  {
    parent::__construct();
    $this->tablaPrincipal = "maestro";
    $this->identificador = "idMaestro";
    $this->tablaEnlazada = "tomocurso";
  }
  function obtenerInformacion($posicion)
  {
   /* $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from $this->tablaPrincipal where id='$posicion'";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    unset($informacion[0]['id']);
    return $informacion;*/

    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from maestro where id='$posicion'";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    unset($informacion[0]['id']);
    $columnasConEnlaces = $this->columnasTipo();
    $conexion = $this->bd->conectar();
  /*  $sqlConsulta = "select * from maestro";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);*/
    foreach ($columnasConEnlaces as $identificador => $contenido) {
      if ($contenido['tipo'] == "enlazada") {
        foreach ($informacion as $identificadorInfomamacion => $contenidoInformacion) {
          $informacion[$identificadorInfomamacion][$identificador]['tipo'] = "select";
          $informacion[$identificadorInfomamacion][$identificador]['tablaEnlazada'] = $contenido['tablaEnlazada'];
        }
      }
    }
    return $informacion;
  }

  function todos()
  {
    try{
      $conexion = $this->bd->conectar();
      $sqlConsulta = "select * from $this->tablaPrincipal limit 10";
      $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
      return $informacion;
    }catch (Exception $e) {
      echo "error+ $e";
    }
  }



  function eliminar($id)
  {
    $conexion = $this->bd->conectar();

    $sqlConsultaEliminarEnlaces = "delete from $this->tablaEnlazada where $this->identificador=$id;";
    $respuesta = $this->bd->consulta($conexion, $sqlConsultaEliminarEnlaces);
    $sqlConsulta = "delete from  $this->tablaPrincipal where id=$id";
    $respuesta = $this->bd->consulta($conexion, $sqlConsulta);
    return $respuesta;
  }
  function columnas()
  {
    $con = $this->bd->conectar();
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM $this->tablaPrincipal");
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
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM maestro");
    $etiquetas = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $datosColumna = array("valor" => "",  "tipo" => $this->convertirdorIipo($item['Type']));
      $columna = $item['Field'];
      if ($item["Key"] == "MUL") {
        $datosColumna["tipo"] = "enlazada";
        $respuestaTablaEnlazada = $this->bd->tiposDeDatoConsulta($con, "select 
              group_concat(kcu.column_name) 
                    as nombreColumna,
              fks.referenced_table_name as tablaEnlazada
              from information_schema.referential_constraints fks
              join information_schema.key_column_usage kcu
              on fks.constraint_schema = kcu.table_schema
              and fks.table_name = kcu.table_name
              and fks.constraint_name = kcu.constraint_name
              where kcu.column_name=\"$columna\"
              group by fks.constraint_name;");
        $tablaEnlazada = $respuestaTablaEnlazada[0]['tablaEnlazada']['valor'];
        $datosTablaEnlazada = $this->bd->tiposDeDatoConsulta($con, "select * from $tablaEnlazada");
        $datosColumna["tablaEnlazada"] = $datosTablaEnlazada;
      }
      $etiquetas[$columna] = $datosColumna;
    }
    return $etiquetas;
  }
  function columnasJSON()
  {
    $con = $this->bd->conectar();
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM $this->tablaPrincipal");
    $etiquetas = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $etiquetas[] = $item['Field'];
    }
    echo json_encode($etiquetas);
  }
  function crear($datos, $cusosAEnlazar)
  {
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("INSERT INTO $this->tablaPrincipal VALUES (NULL, ?,?,?,?,?,?,?,?,?,?);")) {
      echo "error";
      return false;
    }
    $consulta->bind_param("ssssssssss", $datos['rfc'], $datos['psw'], $datos['nombre'], $datos['apellidoPaterno'], $datos['apellidoMaterno'], $datos['telefono'], $datos['sexo'], $datos['correo'], $datos['domicilio'], $datos['idCarrera']);
    $consulta->execute();
    $idInsertado = $consulta->insert_id;
    echo "   $idInsertado<br>";
    foreach ($cusosAEnlazar as $idCurso => $valor) {
      $sqlConsulta = "insert  $this->tablaEnlazada valueS(NULL,  '$idCurso', '$idInsertado', 'noliberado')";
      echo "<br>$sqlConsulta<br>";
      $this->bd->consulta($conexion, $sqlConsulta);
    }
    $conexion->close();
    return true;
  }
  function actualizar($datos)
  {
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("update $this->tablaPrincipal set {$datos['columna']}=? where id=?")) {
      echo "error";
      return false;
    }
    $consulta->bind_param("ss", $datos['nuevo'], $datos['id']);
    $consulta->execute();
    return true;
  }
  function buscar($valor, $condicionales)
  { //buscara las partes que inicien con las coincidencias
    $sqlConsulta = "select * from $this->tablaPrincipal where ";
    $sqlCondicional = "";
    foreach ($condicionales as $etiqueta => $valorArray) { //se crea la consulta sql en base a la informacion mandada por $_POST
      if ($valorArray == "1") {
        $sqlCondicional .= "$etiqueta like '$valor%' or "; //like es para que inicien con
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
    $sqlConsulta = "SELECT curso.id, curso.claveCurso, curso.nombreCurso from curso join $this->tablaEnlazada on $this->tablaEnlazada.idCurso=curso.id where $this->tablaEnlazada.$this->identificador=$id;";
    $conexion = $this->bd->conectar();
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);

    return $informacion;
  }

  function desenlazar($idCurso, $idInstructor)
  {
    $sqlConsulta = "select * from tomoCurso";
    $conexion = $this->bd->conectar();
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    $registro = $informacion[0];
    $idTC = $registro['id']['valor'];

    $sqlConsulta = "DELETE FROM asistencia WHERE asistencia.idTomoCurso = $idTC";
    echo $sqlConsulta;
    $resultado = $this->bd->consulta($conexion, $sqlConsulta);
    $sqlConsulta = "delete from $this->tablaEnlazada where idCurso=$idCurso and $this->identificador=$idInstructor";
    $resultado = $this->bd->consulta($conexion, $sqlConsulta);
    echo var_dump($resultado);



    return $informacion;


    /*  $conexion = $this->bd->conectar();
      $sqlConsulta = "select * from tomoCurso where idCurso=$idCurso and idInstructor=$idInstructor";
      $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
      $registro=$informacion[0];*/

    /*
      $idTomoCurso=$registro['id']['valor'];
      echo var_dump($idTomoCurso);

      $sqlConsulta = "delete from asistencia where idTomoCuso=$idTomoCurso";
      $resultado = $this->bd->consulta($conexion, $sqlConsulta);
      echo var_dump($registro);

      $sqlConsulta = "delete from $this->tablaEnlazada where idCurso=$idCurso and $this->identificador=$idInstructor";
      $resultado = $this->bd->consulta($conexion, $sqlConsulta);
      return $resultado;*/
  }
  function cursosDisponibles($idInstructor)
  {
    /*obtenemos los ids de los instructores que tiene el curso
    luego solicitamos los instructores que no tengan ese id*/
    $conexion = $this->bd->conectar();
    $sqlConsulta = "SELECT curso.id FROM curso INNER JOIN $this->tablaEnlazada ON $this->tablaEnlazada.idCurso=curso.id where $this->tablaEnlazada.$this->identificador=$idInstructor";
    $respuesta = $this->bd->consulta($conexion, $sqlConsulta);
    // echo $sqlConsulta;
    $idsRechazados = "";
    $sqlConsulta = "";
    if ($respuesta->num_rows != 0) {
      while ($idEnlazado = mysqli_fetch_assoc($respuesta)) {
        $idsRechazados .= $idEnlazado['id'] . ", ";
      }
      $idsRechazados = substr($idsRechazados, 0, -2);
      $sqlConsulta = "select * from curso where id not in($idsRechazados);";
    } else {
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
      $resultado = $this->bd->consulta($con, "insert into $this->tablaEnlazada values(null, $idCurso, $idInstructor, \"noliberado\")");
      echo $idInstructor;
      //printf("%s %s\n", $idInstructor, $idsInstructores);
    }
    return true;
  }
  function carreras()
  {
    $sqlConsulta = "select * from carrera";
    $conexion = $this->bd->conectar();
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);

    return $informacion;
  }
  
}
