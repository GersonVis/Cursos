<?php
class SessionModelo extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function obtenerInformacion($posicion)
    {
     /* $conexion = $this->bd->conectar();
      $sqlConsulta = "select * from $this->tablaPrincipal where id='$posicion'";
      $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
      unset($informacion[0]['id']);
      return $informacion;*/
  
      $conexion = $this->bd->conectar();
      $sqlConsulta = "select * from usuario where id='$posicion'";
      $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
      unset($informacion[0]['id']);
      $columnasConEnlaces = $this->columnasTipo();
      $conexion = $this->bd->conectar();
     /* $sqlConsulta = "select * from rol";
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
    function columnasTipo()
    {
      $con = $this->bd->conectar();
      $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM usuario");
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
    function usuario($usuario, $clave)
    {
        $sqlConsulta = "select * from usuario where usuario.nombre='$usuario' and usuario.clave='$clave';";
        $conexion = $this->bd->conectar();
        echo "consulta finconsulta";
        echo var_dump($conexion);
        echo "fin conexion";
        $consulta = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
        echo "usuario cosultado";
        echo var_dump($consulta);
        echo "fin usuario consultado";
        //  echo var_dump($consulta);
        $retorno = array("nombre" => "", "clave" => "", "idEnlazado" => "", "grado" => "", "nuevo" => "");
        if (count($consulta) != 0) {
            $registroUsuario = $consulta[0];

            $conexion = $this->bd->conectar();
            $usuario = $registroUsuario["id"]["valor"];
            /*   $sqlConsultaEliminarEnlaces = "UPDATE usuario set primeraVez=1 where id=$usuario";
            $respuesta = $this->bd->consulta($conexion, $sqlConsultaEliminarEnlaces);
*/

            // echo var_dump($registroUsuario);
            if ($registroUsuario["idRol"]['valor'] == "3") {
                //si es maestro revisa la cuenta enlazada del maestro no solo del usuario
                $sqlConsulta = "SELECT maestro.nombre, maestro.id FROM maestrocuenta inner join maestro ON maestrocuenta.idMaestro=maestro.id where maestrocuenta.idUsuario=$usuario;";
                $consulta = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
                //     echo $sqlConsulta;
                $registroMaestro = $consulta[0];
                //   echo var_dump($registroMaestro);
                $retorno["nombre"] = $registroMaestro['nombre']['valor'];
                $retorno["idEnlazado"] = $registroMaestro['id']['valor'];
            } else { //si no es un maestro registra los datos directamente
                $retorno["nombre"] = $registroUsuario['nombre']['valor'];
                $retorno["idEnlazado"] = $registroUsuario['id']['valor'];
            }
            $retorno["id"] = $registroUsuario['id']['valor'];
            $retorno["clave"] = $registroUsuario['clave']['valor'];
            $retorno["idRol"] = $registroUsuario['idRol']['valor'];
            $retorno["nuevo"] = $registroUsuario['primeraVez']['valor'];
            return $retorno;
        }
        return false;
    }
    function maestro($id)
    {
        $sqlConsulta = "select * from maestro where id=$id";
        $conexion = $this->bd->conectar();
        $consulta = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
        return $consulta;
    }
    function actualizar($id, $usuario, $clave)
    {
        $conexion = $this->bd->conectar();
        if (!$consulta = $conexion->prepare("update usuario set nombre=?, clave=? where id=?")) {
            echo "error";
            return "Error";
        }
        $consulta->bind_param("sss", $usuario, $clave, $id);
        $consulta->execute();
        if($consulta->error!=""){
            return $this->bd->codigosDeError($consulta->errno);
        }
        return "";
        
    }
    function cambioDeUsuarioYClaveRealizado($id){
        $conexion = $this->bd->conectar();
        if (!$consulta = $conexion->prepare("update usuario set primeraVez=1 where id=?")) {
            echo "error";
            return false;
        }
        $consulta->bind_param("s", $id);
        $consulta->execute();
        return true;
    }
    function cuentaEnlazadaAMaestro($idMaestro){
      $sqlConsulta = "select maestrocuenta.idUsuario from maestro join maestrocuenta on maestro.id=maestrocuenta.idMaestro where maestro.id=$idMaestro;";
      $conexion = $this->bd->conectar();
      $consulta = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
      return $consulta;
    }
    
    function actualizarValor($datos)
    {
      $conexion = $this->bd->conectar();
      if (!$consulta = $conexion->prepare("update usuario set {$datos['columna']}=? where id=?")) {
        echo "error";
        return false;
      }
      $consulta->bind_param("ss", $datos['nuevo'], $datos['id']);
      $consulta->execute();
      return true;
    }
}
