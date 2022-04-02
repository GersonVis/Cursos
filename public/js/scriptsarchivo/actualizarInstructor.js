function clickEnEditar(elemento) {
    textoEnlazado = extraerHijo(elemento.parentElement, 1)
    opcionesEnlazadas = extraerHijo(elemento.parentElement, 5)
    if (textoEditarAnterior != textoEnlazado && textoEditarAnterior != "") {
        cambiarValorEdicion(textoEditarAnterior, true)
        quitarClase(textoEditarAnterior, "textoSeleccionado")
        agregarClase(textoEnlazado, "textoSeleccionado")
        cambiarAtributo(opcionesEnlazadas, "visibility", "visible")
        cambiarAtributo(opcionesEnlazadasAnterior, "visibility", "hidden")
        textoEditarAnterior = textoEnlazado
        opcionesEnlazadasAnterior = opcionesEnlazadas
    } else {
        agregarClase(textoEnlazado, "textoSeleccionado")
        cambiarAtributo(opcionesEnlazadas, "visibility", "visible")
        textoEditarAnterior = textoEnlazado
        opcionesEnlazadasAnterior = opcionesEnlazadas
    }
    cambiarValorEdicion(textoEnlazado, false)
    seleccionar(textoEnlazado)
}

async function  clickAceptarCambio(elemento){   //proceso a realizar
    let cajaDeTexto=elemento.parentElement.parentElement.childNodes[1]//se accede la informacion del campo de texto
    let nuevoDato=cajaDeTexto.value
    let columna=cajaDeTexto.name//manda el dato de cual columna se actualizara
    respuesta= await actualizarRegistroPR('/instructor/actualizar', opcionSeleccionada.attributes.idsql.value, columna, nuevoDato)
    if(respuesta){
        alert("Registro actualizado")
    }else{
        alert("No se pudo actualizar")
    }
}
function clickCancelarCambio(){

}
pr=""

async function actualizarRegistroPR(url, id, columna, nuevoDato){
    /*realiza cambios en el registro, los envia a la api, la api requiere la columna, el id del registro y el nuevo valor*/
    data=new FormData()
    data.append('id', id)
    data.append('columna', columna)
    data.append('nuevo', nuevoDato)
 
    let respuesta = await fetch( urlBase+ "/actualizar", {
        method: "POST",
        body: data}
    )
    pr=respuesta
    console.log(respuesta)
    console.log(respuesta.status)
    return respuesta.status=="200"
}

//actualizarRegistroPR("", 32, "rfc", "chrome")
//172.168.32.1