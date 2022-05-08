instructoresEnlace = {}

document.addEventListener("DOMContentLoaded", function () {//se crea la interfaz para poder crear un curso o instructor
    metodoActualizarPanel()
    individuoCrear.innerHTML = ""
    /*interfaz del formulario*/
    //  parteFormularioTexto = parteFormulario()
    var parteFormularioInstructores, dentroInstructores
    var botonFormulario
    [parteFormularioInstructores, dentroInstructores] = contenedorConTitulo("Enlazar cursos")


    var idFormulario = "formularioCrear"
    var textoFormulario, textoDentro
    [textoFormulario, textoDentro] = contenedorConTitulo("Datos Maestro")


    textoDentro.style.display = "flex"
    textoDentro.style.flexDirection = "column"


    botonFormulario = interfazBoton()
    botonFormulario.addEventListener('click', function () {
        crearCurso(idFormulario)
    })

    formulario = document.createElement('form')
    formulario.id = idFormulario
    formulario.action = urlBase + "/crear"
    formulario.method = "POST"

    textoFormulario.appendChild(formulario)
    individuoCrear.appendChild(textoFormulario)
    individuoCrear.appendChild(parteFormularioInstructores)
    individuoCrear.appendChild(botonFormulario)
    solicitarDatosJSON( "maestro/columnasTipo").then(
        datosJSON => {
            delete(datosJSON.id)
            Object.entries(datosJSON).forEach(([etiqueta, valor]) => {
                if (valor.tipo != "enlazada") {
                    formulario.appendChild(inputFormulario(etiqueta, valor.tipo))
                }else{
                    formulario.appendChild(crearInputOpciones(etiqueta, valor))
                }
            })
        }
    )
    solicitarDatosJSON(urlEnlace + "/todos", "")
        .then(datosJSON => {

            datosJSON.forEach(datos => {
                ({ interfaz, botonEliminar } = interfazInstructorEnlace(datos, etiquetasRequeridas))
                interfaz.addEventListener('click', function () {
                    clickOpcionEnlace(this)
                })
                dentroInstructores.appendChild(interfaz)
            })
            hacerPorCookie();
            //  parteFormularioInstructores.appendChild(interfazInstructor())
        })
})
function crearInputOpciones(etiqueta, valor) {
    let opciones, opcionesHTMl=""
    let elemento = document.createElement("li")
    elemento.classList.add("datoPanelIndividuo")
    elemento.classList.add("flexCentradoR")
    opciones=valor.tablaEnlazada
    
    opciones.forEach((registro)=>{
       opcionesHTMl+="<option value=\""+Object.values(registro)[0].valor+"\">"+Object.values(registro)[1].valor+"</option>"
      })
    elemento.innerHTML = `<p class="etiquetaDato">${etiqueta}</p>
      <div class="contenedorEditar colorCuarto redondearDos ocuparDisponible">
          <select name="${etiqueta}" class="textoIndividuo colorCuarto redondearDos " value="">
         ${opcionesHTMl}
          </select>
      </div>`
    return elemento
}

async function crearCurso(idFormulario) {
    let formulario = document.getElementById(idFormulario)
    let data = new FormData(formulario)
    data.append('cursos', JSON.stringify(instructoresEnlace))
    let respuesta = await fetch(formulario.action, {
        method: formulario.method,
        body: data
    })
    metodoActualizarPanel()
    console.log(respuesta.text())
    if(respuesta.status=="200"){
        alert("Creado correctamente")
        return respuesta
    }
    alert("Error al crear")
    return respuesta
}
function interfazBoton() {
    elemento = document.createElement('input')
    elemento.value = "Crear"
    elemento.type = "button"
    elemento.style.width = "60%"
    elemento.style.height = "40%"
    elemento.classList.add("colorPrimario")
    elemento.classList.add("redondear")
    elementoPadre = document.createElement('div')
    elementoPadre.appendChild(elemento)
    elementoPadre.style.width = "100%"
    elementoPadre.style.height = "100px"
    elementoPadre.classList.add("flexCentradoR")
    return elementoPadre
}
function clickOpcionEnlace(elemento) {

    if (instructoresEnlace[elemento.attributes.idsql.value] == undefined) {
        elemento.classList.add("opcionSeleccionada")
        instructoresEnlace[elemento.attributes.idsql.value] = ""
    } else {
        elemento.classList.remove("opcionSeleccionada")
        delete instructoresEnlace[elemento.attributes.idsql.value]

    }
}
function parteFormulario() {
    elemento = document.createElement('div')
    return elemento
}
function contenedorConTitulo(titulo = "titulo") {
    let elemento = document.createElement('div')
    elemento.innerHTML = `
       <p class="textoTipoA" style="padding: 10px 10px 25px 0px; textTransform: none;">${titulo}</p>
    `
    let elementoHijo = document.createElement('div')
    elementoHijo.classList.add('gridTres')
    elementoHijo.classList.add('flexCentradoR')
    // elementoHijo.style.paddingBottom="20px"
    elemento.appendChild(elementoHijo)

    return [elemento, elementoHijo]
}
function actualizarPanel(datos, funcionCrear) {

    datos.forEach(elemento => {
        const { interfaz, botonEliminar } = funcionCrear(elemento)
        contenedorOpcionesDirecto.appendChild(interfaz)
        interfaz.addEventListener('click', function () {
            opcionClick(this)
        })
        botonEliminar.addEventListener('click', function (e) {
            e.stopPropagation()
            res = this
            let resultado = confirm("eliminar")
            if (resultado) {
                procesoDeEliminacion(this)
            }
        })
    })

}