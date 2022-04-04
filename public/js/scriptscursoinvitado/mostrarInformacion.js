
const totalOpciones = document.querySelectorAll('.opcion')
const filasOpciones = document.querySelectorAll('.opcionesHorizontal')
var botonesEditar = document.querySelectorAll('.botonEditarInformacion')
//const botonesMenuIndividuo=document.querySelectorAll('.')

botonCerrarInformacion.addEventListener('click', function () {
    cerrarInformacion(this)
})
opcionSubMenu=seleccionarOpcion(botonMostrarDatos, opcionSubMenu, "textoSeleccionado")

botonMostrarDatos.addEventListener('click', function () {//evento del submenu actualiza el formulario
    opcionSubMenu=seleccionarOpcion(botonMostrarDatos, opcionSubMenu, "textoSeleccionado")
    clickMostrarDatos(this, opcionSeleccionada.attributes.idsql.value)
})
async function clickMostrarDatos(elemento, id) {
    let datosCargados=await actualizarInformacion(id)
    if(datosCargados){
        let botonesEditar = document.querySelectorAll('.botonEditarInformacion')
        let botonesAceptar = document.querySelectorAll('.aceptarCambio')
        let botonesCancelar = document.querySelectorAll('.cancelarCambio')
        agregarEvento(botonesEditar, clickEnEditar)
       // agregarEvento(botonesAceptar, clickAceptarCambio)//agrega el evento para cambiar la informacion hace uso de un fetch
     //   agregarEvento(botonesCancelar, clickCancelarCambio)
     botonesAceptar.forEach(elemento => {
            elemento.addEventListener('click', function () {
               clickAceptarCambio(this)
            })
        })
    }
}
function agregarEvento(elementos, funcionAgregar, evento="click"){
    elementos.forEach(elemento => {
        elemento.addEventListener(evento, function () {
            funcionAgregar(this)
        })
    })
}
async function solicitarPorId(id) {
    datos = await fetch( "curso/"+id)
    return datos.json()
}
async function actualizarInformacion(id) {
    listaDatosIndividuo.innerHTML = ""
    datos = await solicitarPorId(id)
    elementosCreados=[]
    dato=datos[0]
    Object.entries(dato).forEach(([etiqueta, objeto]) => {
       
        elemento = interfazDatoIndividuo(etiqueta, objeto.valor, etiqueta, objeto.tipo, "", objeto.tablaEnlazada)
        listaDatosIndividuo.appendChild(elemento)
        elementosCreados.push(elemento)
    })
   return elementosCreados

}

prue=""
function interfazDatoIndividuo(etiqueta, dato, identificadorFormulario, tipo, accion, datosEnlazados) {
    let elemento = document.createElement("cambios-input")
    elemento.setAttribute("etiqueta", etiqueta)
    elemento.setAttribute("valor", dato)
    elemento.setAttribute("tipo", tipo)
    elemento.setAttribute("nivel", "invitado")
    elemento.setAttribute("accederAJSON", JSON.stringify({0:["id", "valor"], 1:["nombreCarrera", "valor"]}))
    elemento.setAttribute("opciones", JSON.stringify(datosEnlazados))
    elemento.id=opcionSeleccionada.attributes.idsql.value
    elemento.accion=function (datos){
        actualizarRegistro(urlBase+"/actualizar", datos.id, datos.nombreColumna, datos.valorNuevo)
    }

    prue=elemento
    return elemento
}
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

function extraerHijo(padre, posicion) {
    return padre.childNodes[posicion]
}
function cambiarValorEdicion(elemento, valor) {
    elemento.disabled = valor
}
function seleccionar(elemento) {
    elemento.focus()
}
function cerrarInformacion(elemento) {//eventos lanzados al hacer click a cerrar informacion
    ocultarInformacion(informacionIndividual)
    quitarClase(opcionSeleccionada, "opcionSeleccionada")
    cambiarAtributo(opcionesEnlazadasAnterior, 'hidden')
    if(textoEditarAnterior!="")quitarClase(textoEditarAnterior, "textoSeleccionado")
    instructoresSeleccionados={}
}

function opcionClick(elemento, hacer) {//eventos lanzados al hacer click en la opcion
    if (opcionSeleccionada != elemento && opcionSeleccionada != "") {
        quitarClase(opcionSeleccionada, "opcionSeleccionada")
        mostrarInformacion(informacionIndividual)
        agregarClase(elemento, "opcionSeleccionada")
        opcionSeleccionada = elemento
        opcionSubMenu=seleccionarOpcion(botonMostrarDatos, opcionSubMenu, "textoSeleccionado")
        clickMostrarDatos(botonMostrarDatos, opcionSeleccionada.attributes["idsql"].value)//botonMostrarDatos es la opcion del submenu
    }else{
        clickMostrarDatos(botonMostrarDatos, elemento.attributes["idsql"].value)
        mostrarInformacion(informacionIndividual)
        agregarClase(elemento, "opcionSeleccionada")
        opcionSeleccionada = elemento
        opcionSubMenu=seleccionarOpcion(botonMostrarDatos, opcionSubMenu, "textoSeleccionado")
    }
}
