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
async function solicitarDatosJSON(url, data="") {
    resultado = await fetch(url,{
        method: "POST",
        body: data
    })
   
    return resultado.json()
}
async function consulta(url, data, metodo="POST"){
    let respuesta=await fetch(url,{
        method: metodo,
        body: data
    })
    return respuesta
}
async function enviarFormulario(idFormulario){
    let formulario=document.getElementById(idFormulario)
    let data=new FormData(formulario)
    let respuesta =await fetch(formulario.action, {
        method: formulario.method,
        body:data
    })
    
    return respuesta
}
function crearAtributo(nombre, valor){
     let atributo=document.createAttribute(nombre)
     atributo.value=valor
     return atributo
}
function agregarAtributo(elemento, atributo){
    elemento.attributes.setNamedItem(atributo)
}
function seleccionarOpcion(opcionNueva, opcionAnterior, claseAplicar){
   if(opcionNueva!=opcionAnterior && opcionAnterior!=""){
      agregarClase(opcionNueva, claseAplicar)
      quitarClase(opcionAnterior, claseAplicar)
      opcionAnterior=opcionNueva
   }else{
      agregarClase(opcionNueva, claseAplicar)
      opcionAnterior=opcionNueva
   }
  

  /* opcionAnterior = opcionAnterior == "" ? opcionNueva : opcionAnterior
   if (opcionAnterior != opcionNueva) {
        console.log("opcionAnterior: ")
        console.log(opcionAnterior)
        console.log("opcionNuevar: ")
        console.log(opcionNueva)

        quitarClase(opcionAnterior, claseAplicar)
        opcionAnterior.classList.remove("textoSeleccionado")
        agregarClase(opcionNueva, claseAplicar)
        opcionAnterior = opcionNueva
    }*/
    return opcionAnterior
}

function agregarEstilos(elemento, estilo){
    Object.entries(estilo).forEach(([a, b])=>{
        elemento.style[a]=b
    })
}
function agregarClases(elemento, clases=[]){
    clases.forEach(clase=>{
        elemento.classList.add(clase)
    })
}