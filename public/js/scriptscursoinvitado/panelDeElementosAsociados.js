/*botonInstructoresAsociados.addEventListener("click", function () {
    informacion = new FormData();
    informacion.append('curso', opcionSeleccionada.attributes.idsql.value)
    solicitarDatosJSON(urlBase + "/instructoresEnlazados", informacion)
        .then(datosJSON => {
            opcionSubMenu = seleccionarOpcion(botonInstructoresAsociados, opcionSubMenu, "textoSeleccionado")

            actualizarInformacionIndividual(datosJSON, listaDatosIndividuo, interfazInstructorAsociado)
        })
})

function crearInterfazDatosAsociados(funPedirDatos, funTratarJSON, funInterfazPorDato) {//pedir datos es una funcion que debe retonar los datos a ocupar para crear interfaz
    let contenedorParaAsociadosElementos = contenedorElementosAsociados()
    funPedirDatos()
        .then(datosJSON => {
            funTratarJSON(datosJSON, funInterfazPorDato, contenedorParaAsociadosElementos)
            //contenedorPadre.appendChild(contenedorParaAsociadosElementos)
        })
    return contenedorParaAsociadosElementos
}

var contenedorInstructoresEnlazados = contenedorIntructoresAsociados()
listaDatosIndividuo.appendChild(contenedorInstructoresEnlazados)
actualizarInformacionIndividual = (datosJSON, contenedorPadre, crearInterfaz) => {
    contenedorPadre.innerHTML = ""
    contenedorInstructoresEnlazados.innerHTML = ""
    datosJSON.forEach(elemento => {

        ({ interfaz, botonEliminar } = crearInterfaz(elemento))
        contenedorInstructoresEnlazados.appendChild(interfaz)
        botonEliminar.addEventListener('click', function () {
            eventoBotonEliminarInstructor(this, document.getElementById('opcionAsociada' + this.attributes.idsql.value))
        })

    });
    contenedorPadre.appendChild(contenedorInstructoresEnlazados)
}
eventoBotonEliminarInstructor = (elemento, padre) => {
    let data = new FormData();
    data.append('idInstructor', elemento.attributes.idsql.value)
    data.append('idCurso', opcionSeleccionada.attributes.idsql.value)
    consulta(urlBase + "/desenlazar", data)
        .then(respuesta => {
            if (respuesta.status == "200") {
                alert("Se ha quitado el instructor correctamente")

                contenedorInstructoresEnlazados.removeChild(padre)
                return true
            }
            alert("Algo salio mal!")
            return ""
        })
}
function contenedorElementosAsociados() {
    let elemento = document.createElement('div')
    elemento.classList.add('gridTres')
    elemento.classList.add('flexCentradoR')
    let estilosElemento = {
        width: "100%"
    }
    agregarEstilos(elemento, estilosElemento)
    return elemento
}
class PanelElementosAsociados extends HTMLElement {
    constructor() {
        let elemento = document.createElement('div')
        elemento.classList.add('gridTres')
        elemento.classList.add('flexCentradoR')
        let estilosElemento = {
            width: "100%"
        }
        agregarEstilos(elemento, estilosElemento)
        return elemento
    }
 

}
/*/