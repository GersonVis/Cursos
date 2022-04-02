function agregarClase(elemento, clase) {
    elemento.classList.add(clase)
}
function quitarClase(elemento, clase) {
    elemento.classList.remove(clase)
}
function mostrarInformacion(elemento) {
    cambiarAtributo(elemento, "visibility", "visible")
}
function cambiarAtributo(elemento, atributo, nuevoAtributo) {
    elemento.style = `${atributo}: ${nuevoAtributo}`
}
function aplicarCambioAVarios(elementos, atributo, nuevoAtributo) {
    elementos.forEach(elemento => {
        cambiarAtributo(elemento, atributo, nuevoAtributo)
    })
}
function animacionHacerVertical(elementos) {
    elementos[0].style = "animation: 3s forwards alternate animacionRotar;"
}
function ocultarInformacion(elemento) {
    cambiarAtributo(elemento, "visibility", "hidden")
}
function mostrarElemento(elemento){
    cambiarAtributo(elemento, "visibility", "visible")
}
function ocultarElemento(elemento){
    cambiarAtributo(elemento, "visibility", "hidden")
}
async function solicitarDatosJSON(url) {
    resultado = await fetch(url)
    return resultado.json()
}
async function consulta(url, data, metodo="POST"){
    respuesta=await fetch(url,{
        method: metodo,
        data: data
    })
    return respuesta
}
async function enviarFormulario(idFormulario){
    formulario=document.getElementById(idFormulario)
    data=new FormData(formulario)
    let respuesta =await fetch(formulario.action, {
        method: formulario.method,
        body:data
    })
    
    return respuesta
}
function crearAtributo(nombre, valor){
     atributo=document.createAttribute(nombre)
     atributo.value=valor
     return atributo
}
function agregarAtributo(elemento, atributo){
    elemento.attributes.setNamedItem(atributo)
}