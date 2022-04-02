async function actualizarRegistro(url, id, nombreColumna, valorNuevo){
    let data=new FormData()
    let respuesta=""
    data.append('id', id)
    data.append('columna', nombreColumna)
    data.append('nuevo', valorNuevo)
    respuesta=await consulta(url, data)
    console.log(respuesta.text())
    if(respuesta.status=="200"){
        alert("Registro actualizado")
        return true
    }
    alert("No se pudo actualzar")
    return false
}