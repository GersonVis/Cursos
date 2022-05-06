botonCuentaDeUsuario.addEventListener('click', function () {//evento del submenu actualiza el formulario
    opcionSubMenu=seleccionarOpcion(botonCuentaDeUsuario, opcionSubMenu, "textoSeleccionado")
    clickMostrarDatosCuenta(this, opcionSeleccionada.attributes.idsql.value)
    alert("hola")
})
async function actualizarCuenta(id) {
    listaDatosIndividuo.innerHTML = ""
    datos = await solicitarPorCuenta(id)
    elementosCreados=[]
    dato=datos[0]
    Object.entries(dato).forEach(([etiqueta, objeto]) => {
       
        elemento = interfazDatoIndividuo(etiqueta, objeto.valor, etiqueta, objeto.tipo, "", objeto.tablaEnlazada)
        listaDatosIndividuo.appendChild(elemento)
        elementosCreados.push(elemento)
    })
   return elementosCreados
}
async function solicitarPorCuenta(id) {
    let data=new FormData();
    data.append("idMaestro", id)
    datos = await fetch("session/cuentaMaestro",{
        method: "POST",
        body: data
    })
    console.log(datos.text())
    return datos.json()
}

function interfazDatoIndividuo(etiqueta, dato, identificadorFormulario, tipo, accion, datosEnlazados) {
    let elemento = document.createElement("cambios-input")
    elemento.setAttribute("etiqueta", etiqueta)
    elemento.setAttribute("valor", dato)
    elemento.setAttribute("tipo", tipo)
    elemento.setAttribute("accederAJSON", JSON.stringify({0:["id", "valor"], 1:["nombreCarrera", "valor"]}))
    elemento.setAttribute("opciones", JSON.stringify(datosEnlazados))
    elemento.id=opcionSeleccionada.attributes.idsql.value
    elemento.accion=function (datos){
        actualizarRegistro(urlBase+"/actualizar", datos.id, datos.nombreColumna, datos.valorNuevo)
    }
    prue=elemento
    return elemento
}

async function clickMostrarDatosCuenta(elemento, id) {
    let datosCargados=await actualizarCuenta(id)
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