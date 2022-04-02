
const totalOpciones = document.querySelectorAll('.opcion')
const filasOpciones = document.querySelectorAll('.opcionesHorizontal')
var botonesEditar = document.querySelectorAll('.botonEditarInformacion')
//const botonesMenuIndividuo=document.querySelectorAll('.')
var opcionSeleccionada = ""
var textoEditarAnterior = ""
var opcionesEnlazadasAnterior = ""
var prueba = ""
var idOpcionSeleccionada = ""

botonCerrarInformacion.addEventListener('click', function () {
    cerrarInformacion(this)
})
totalOpciones.forEach(elemento => {
    elemento.addEventListener('click', function () {
        opcionClick(this)
    })
})
botonMostrarDatos.addEventListener('click', function () {
    clickMostrarDatos(this, opcionSeleccionada.attributes.idsql.value)
})
async function clickMostrarDatos(elemento, id) {
    elemento.classList.add("textoSeleccionado")
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
    datos = await fetch('/instructor/' + id)
    return datos.json()
}
async function actualizarInformacion(id) {
    listaDatosIndividuo.innerHTML = ""
    datos = await solicitarPorId(id)
    elementosCreados=[]
    for (dato of datos) {
        Object.entries(dato).forEach(([etiqueta, valor]) => {
            elemento = interfazDatoIndividuo(etiqueta, valor, etiqueta)
            listaDatosIndividuo.appendChild(elemento)
            elementosCreados.push(elemento)
        })
    }
   return elementosCreados

}


function interfazDatoIndividuo(etiqueta, dato, identificadorFormulario) {
    elemento = document.createElement("li")
    elemento.classList.add("datoPanelIndividuo")
    elemento.classList.add("flexCentradoR")
    elemento.innerHTML = `<p class="etiquetaDato">${etiqueta}</p>
    <div class="contenedorEditar colorCuarto redondearDos ocuparDisponible">
        <input name="${identificadorFormulario}" type="text" class="textoIndividuo colorCuarto redondearDos " disabled value="${dato}">
        <button class="botonEditarInformacion circulo colorPrimario flexCentradoR" onclick="hola()">
            <img src="/public/iconos/editar.png" alt="" class="imagenEditar ">
        </button>
        <div class="cajaOpcionesEdicion flexCentradoR">
            <button class="aceptarCambio botonAccion circulo colorPrimario flexCentradoR">
               <img src="/public/iconos/cheque.png" alt="" class="imagenEditar ">
             </button>
            <button class="cancelarCambio botonAccion circulo colorPrimario flexCentradoR">
               <img src="/public/iconos/cerrar.png" alt="" class="imagenEditar ">
            </button>
        </div>  
    </div>`
    return elemento
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
    quitarClase(textoEditarAnterior, "textoSeleccionado")

   
}

function opcionClick(elemento, hacer) {//eventos lanzados al hacer click en la opcion
    if (opcionSeleccionada != elemento && opcionSeleccionada != "") {
        quitarClase(opcionSeleccionada, "opcionSeleccionada")
        mostrarInformacion(informacionIndividual)
        agregarClase(elemento, "opcionSeleccionada")
        opcionSeleccionada = elemento
        clickMostrarDatos(botonMostrarDatos, opcionSeleccionada.attributes["idsql"].value)
    }else{
        clickMostrarDatos(botonMostrarDatos, elemento.attributes["idsql"].value)
        mostrarInformacion(informacionIndividual)
        opcionSeleccionada = elemento
    }
}
