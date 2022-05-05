<?php

class LinksModelo extends Model
{
  function __construct()
  {
    parent::__construct();
  }
  function obtenerInformacion($posicion)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from links where id='$posicion'";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
   // echo json_encode($informacion);
    unset($informacion[0]['id']);
    $columnasConEnlaces = $this->columnasTipo();
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from links where id='$posicion'";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    foreach ($columnasConEnlaces as $identificador => $contenido) {
      if ($contenido['tipo'] == "enlazada") {
        foreach ($informacion as $identificadorInfomamacion=>$contenidoInformacion) {
          $informacion[$identificadorInfomamacion][$identificador]['tipo']="select";
          $informacion[$identificadorInfomamacion][$identificador]['tablaEnlazada']=$contenido['tablaEnlazada'];
        }
      }
    }
  
    return $informacion;
  }
  function tiposDeDato($valor)
  {
    switch ($valor) {
      case MYSQLI_TYPE_DECIMAL:
      case MYSQLI_TYPE_NEWDECIMAL:
      case MYSQLI_TYPE_FLOAT:
      case MYSQLI_TYPE_DOUBLE:
      case MYSQLI_TYPE_BIT:
      case MYSQLI_TYPE_TINY:
      case MYSQLI_TYPE_SHORT:
      case MYSQLI_TYPE_LONG:
      case MYSQLI_TYPE_LONGLONG:
      case MYSQLI_TYPE_INT24:
      case MYSQLI_TYPE_YEAR:
      case MYSQLI_TYPE_ENUM:
        return 'number';

      case MYSQLI_TYPE_TIMESTAMP:
      case MYSQLI_TYPE_DATE:
      case MYSQLI_TYPE_TIME:
      case MYSQLI_TYPE_DATETIME:
      case MYSQLI_TYPE_NEWDATE:
      case MYSQLI_TYPE_INTERVAL:
        return "date";
      case MYSQLI_TYPE_SET:
      case MYSQLI_TYPE_VAR_STRING:
      case MYSQLI_TYPE_STRING:
      case MYSQLI_TYPE_CHAR:
      case MYSQLI_TYPE_GEOMETRY:
      case MYSQLI_TYPE_TINY_BLOB:
      case MYSQLI_TYPE_MEDIUM_BLOB:
      case MYSQLI_TYPE_LONG_BLOB:
      case MYSQLI_TYPE_BLOB:
        return 'text';

      default:
        return 'text';
    }
  }


  function todos()
  {
    $columnasConEnlaces = $this->columnasTipo();
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from links";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    foreach ($columnasConEnlaces as $identificador => $contenido) {
      if ($contenido['tipo'] == "enlazada") {
        foreach ($informacion as $identificadorInfomamacion=>$contenidoInformacion) {
          $informacion[$identificadorInfomamacion][$identificador]['tablaEnlazada']=$contenido['tablaEnlazada'];
        }
      }
    }
    return $informacion;
  }


  function eliminar($id)
  {
    
    $conexion = $this->bd->conectar();
    $sqlConsultaEliminarEnlaces = "delete from links where id=$id;";
    $respuesta = $this->bd->consulta($conexion, $sqlConsultaEliminarEnlaces);
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

  function columnasJSON()
  {
    $con = $this->bd->conectar();
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM curso");
    $etiquetas = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $etiquetas[] = $item['Field'];
    }
    unset($etiquetas['id']);
    return json_encode($etiquetas);
  }



  function crear($datos) //se crea el curso y se enlazan los ids de instructores en la tabla de impartio
  {
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("INSERT INTO links(titulo, link, descripcion) VALUES (?,?,?);")) {
      echo "error";
      return false;
    }
    $consulta->bind_param("sss", $datos['titulo'], $datos['link'], $datos['descripcion']);
    //$idInsertado=$this->mysqli->insert_id;
    $consulta->execute();
    $conexion->close();
    return true;
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
  function buscar($valor, $condicionales)
  {
    $sqlConsulta = "select * from curso where ";
    $sqlCondicional = "";
    foreach ($condicionales as $etiqueta => $valorArray) {
      if ($valorArray == "1") {
        $sqlCondicional .= "$etiqueta like '$valor%' or ";
      }
    }
    $informacion = array();
    if ($sqlCondicional != "") {
      $sqlCondicional = substr($sqlCondicional, 0, -4); //removemos la parte or que queda
      $sqlConsulta = $sqlConsulta . $sqlCondicional;

      $conexion = $this->bd->conectar();
      $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    }
    return $informacion; //si no se recivio ninguna condición se retorna un array vacio
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
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM links");
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
  function enlazar($idCurso, $idsInstructores)
  {
    $con = $this->bd->conectar();
    echo var_dump($idsInstructores);
    foreach ($idsInstructores as $idInstructor => $valor) {
      $resultado = $this->bd->consulta($con, "insert into impartio values(null, $idCurso, $idInstructor)");
      echo $idInstructor;
      //printf("%s %s\n", $idInstructor, $idsInstructores);
    }
    return true;
  }


  function instructoresDisponibles($idCurso)
  {
    /*obtenemos los ids de los instructores que tiene el curso
  luego solicitamos los instructores que no tengan ese id*/
    $conexion = $this->bd->conectar();
    $respuesta = $this->bd->consulta($conexion, "SELECT instructor.id FROM instructor INNER JOIN impartio
    ON impartio.idInstructor=instructor.id where impartio.idCurso=$idCurso");
    $idsRechazados = "";
    $sqlConsulta = "";

    if ($respuesta->num_rows != 0) {
      while ($idEnlazado = mysqli_fetch_assoc($respuesta)) {
        $idsRechazados .= $idEnlazado['id'] . ", ";
      }
      $idsRechazados = substr($idsRechazados, 0, -2);
      $sqlConsulta = "select * from instructor where id not in($idsRechazados);";
    } else {
      $sqlConsulta = "select * from instructor";
    }

    // echo $sqlConsulta;
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
  function constanciaLiberada($idCurso, $idMaestro)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from tomocurso where idCurso=$idCurso and idMaestro=$idMaestro";
    //echo $sqlConsulta;
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    $informacion = $informacion[0];
    return $informacion;
  }
  function liberar($idCurso, $idMaestro)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "UPDATE tomocurso set liberado='liberado' where idCurso=$idCurso and idMaestro=$idMaestro;";
    $informacion = $this->bd->consulta($conexion, $sqlConsulta);
    if ($informacion) {
      $array = array("liberado" => array("valor" => "liberado"));
      return $array;
    }
    return $informacion;
  }
  function noLiberar($idCurso, $idMaestro)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "UPDATE tomocurso set liberado='noliberado' where idCurso=$idCurso and idMaestro=$idMaestro;";
    $informacion = $this->bd->consulta($conexion, $sqlConsulta);

    if ($informacion) {
      $array = array("liberado" => array("valor" => "noliberado"));
      return $array;
    }
    return $informacion;
  }
  function invertirLiberacion($idCurso, $idMaestro)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from tomocurso where idCurso=$idCurso and idMaestro=$idMaestro";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    $informacion = $informacion[0];
    // echo var_dump($informacion);
    $valorLiberada = $informacion['liberado']['valor'];

    return $valorLiberada == "liberado" ? $this->noLiberar($idCurso, $idMaestro) : $this->liberar($idCurso, $idMaestro);
  }
  function datosConstancia($idMaestro, $idCurso)
  {
    $conexion = $this->bd->conectar();
    $informacionNecesaria = array();
    $sqlConsulta = "select * from maestro where id=$idMaestro";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    $informacionNecesaria["nombre"] = $informacion[0]["nombre"];
    $sqlConsulta = "select * from curso where id=$idCurso";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    $informacionNecesaria["curso"] = $informacion[0]["nombreCurso"];
    return $informacionNecesaria;
    //echo var_dump($informacionNecesaria);
    // $informacion=$informacion[0];
  }
  function asistencia($idMaestro, $idCurso)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "SELECT * from asistencia INNER JOIN tomocurso on asistencia.idTomoCurso=tomocurso.id WHERE tomocurso.idCurso=$idCurso and tomocurso.idMaestro=$idMaestro;";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return $informacion;
  }
  function cursosTomadosPorMaestro($idMaestro)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "SELECT * from tomocurso join curso on tomocurso.idCurso=curso.id where tomocurso.idMaestro=$idMaestro;";
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return $informacion;
  }
  function solicitarCursosDisponibles($idMaestro)
  {
    $cursosTomados = $this->cursosTomadosPorMaestro($idMaestro);
    $idCursosTomados = "";
    foreach ($cursosTomados as $datos) {
      $idCursosTomados .= $datos['id']['valor'] . ", ";
    }
    $idCursosTomados = substr($idCursosTomados, 0, -2);

    $sqlConsulta = ($idCursosTomados == "" ? "select * from curso" : "select * from curso where id NOT in($idCursosTomados)");
    $conexion = $this->bd->conectar();
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return $informacion;
  }
}
