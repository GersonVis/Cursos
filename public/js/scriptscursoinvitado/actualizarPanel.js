instructoresEnlace = {}

document.addEventListener("DOMContentLoaded", function () {//se crea la interfaz para poder crear un curso o instructor
    metodoActualizarPanel()
    individuoCrear.innerHTML = ""
    /*interfaz del formulario*/
    //  parteFormularioTexto = parteFormulario()
    var parteFormularioInstructores, dentroInstructores
    var botonFormulario
    [parteFormularioInstructores, dentroInstructores] = contenedorConTitulo("Cursos disponibles")


    var idFormulario = "formularioCrear"
    var textoFormulario, textoDentro
    [textoFormulario, textoDentro] = contenedorConTitulo("Datos curso")


    textoDentro.style.display = "flex"
    textoDentro.style.flexDirection = "column"


    botonFormulario = interfazBoton("Tomar cursos")
    /* botonFormulario.addEventListener('click', function(){
          crearCurso(idFormulario)
     })*/

    formulario = document.createElement('form')
    formulario.id = idFormulario
    formulario.action = urlBase + "/crear"
    formulario.method = "POST"

    // textoFormulario.appendChild(formulario)
    // individuoCrear.appendChild(textoFormulario)
    individuoCrear.appendChild(parteFormularioInstructores)
    individuoCrear.appendChild(botonFormulario)
    /* solicitarDatosJSON(urlBase + "/columnasTipo").then(
         datosJSON => {
             Object.entries(datosJSON).forEach(([etiqueta, valor]) => {
                 formulario.appendChild(inputFormulario(etiqueta, valor.tipo))
             })
             
            
            
         }
     )*/
    var datosSolicitudCursos = new FormData()
    datosSolicitudCursos.append("idMaestro", idMaestro)
    fetch('/curso/' + "cursosDisponiblesDeTomar", {
        method: "POST",
        body: datosSolicitudCursos
    })
        .then(respuesta => respuesta.json())
        .then(datosJSON => {
            datosJSON.forEach(datos => {
                ({ interfaz, botonEliminar } = interfazInstructorEnlace(datos, ['id', 'nombreCurso', 'claveCurso']))
                interfaz.addEventListener('click', function () {

                    clickOpcionEnlace(this)
                })
                dentroInstructores.appendChild(interfaz)
            })
        })
        .catch(error => {
            alert("Error: " + error)
        })
    botonFormulario.addEventListener("click", function () {
        let idCursos=JSON.stringify(instructoresEnlace)
        if (idCursos != "{}") {
            let informacionEnlazar = new FormData()
            informacionEnlazar.append("idsCursos", JSON.stringify(instructoresEnlace))
            informacionEnlazar.append("idInstructor", idMaestro)
            fetch("/maestro/enlazar", {
                method: "POST",
                body: informacionEnlazar
            })
                .then(respuesta => respuesta.text())
                .then(texto => {
                    alert(texto)
                    console.log(texto)
                })
                .catch(error => {
                    alert("Error: " + error)
                })
            ocultarElemento(sectionCrearInstructor)
            metodoActualizarPanel()
        }else{
            alert("no hay cursos seleccionados")
        }
        
        /* */
    })
})
async function crearCurso(idFormulario) {
    let formulario = document.getElementById(idFormulario)
    let data = new FormData(formulario)
    data.append('instructores', JSON.stringify(instructoresEnlace))
    let respuesta = await fetch(formulario.action, {
        method: formulario.method,
        body: data
    })

    metodoActualizarPanel()
    alert("creado")
    return respuesta
}
function interfazBoton(textoBoton = "Crear") {
    elemento = document.createElement('input')
    elemento.value = textoBoton
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
    // console.log(datos)
    datos.forEach(elemento => {
        const { interfaz, botonEliminar } = funcionCrear(elemento)
        contenedorOpcionesDirecto.appendChild(interfaz)
        interfaz.addEventListener('click', function () {
            opcionClick(this)
            opcionSeleccionada = interfaz//.attributes.idsql.value
        })

    })

}