botonCerrarEnlazadoPrincipal.addEventListener("click", function () {
    sectionEnlazadoPrincipal.style.visibility = "hidden"

})
var divEnlazadoPrincipal, secundario
[divEnlazadoPrincipal, secundario] = crearInterfazEnlazadoPrincipal()



divInformacionPrincipalEnlazado.appendChild(divEnlazadoPrincipal)


function crearInterfazEnlazadoPrincipal() {
    let elemento = document.createElement('div')
    let elementoPadre = document.createElement('div')
    let parteBotones = document.createElement('div')

    let elementoPadreClases = ['barras']
    let parteBotonesClases = ['flexCentradoR']
    let elementoClases=["flexCentradoC"]
    agregarClases(elemento, elementoClases)
    agregarClases(elementoPadre, elementoPadreClases)
    agregarClases(parteBotones, parteBotonesClases)
    //enlaces de elementos
    elementoPadre.appendChild(elemento)



    elementoPadre.appendChild(parteBotones)
    //edificion de propiedades
    parteBotones.id = "botonesPrincipalEnlazado"


    //estilos

    estilosPadre = {

        width: "100%"
    }
    estilosParteBotones = {
        position: "absolute",
        width: "125px",
        height: "50px",
        bottom: "24px",
        right: "23px"
    }
    estilosElemento = {
        "padding-top": "40px"
    }
    agregarEstilos(elemento, estilosElemento)
    agregarEstilos(elementoPadre, estilosPadre)
    agregarEstilos(parteBotones, estilosParteBotones)

    //eventos js
    puerta = true
    let botonConstancia = botonAccionEnlazado("/public/iconos/diploma.png", "/public/iconos/diploma.png")
    let botonLiberar = botonAccionEnlazado("/public/iconos/candado-abierto.png", "/public/iconos/cerrado.png")
    botonConstancia.id = "botonConstancia"
    botonLiberar.id = "botonLiberar"
    elemento.id = "maestroCurso"


    parteBotones.appendChild(botonConstancia)
    parteBotones.appendChild(botonLiberar)

    estilosParteBotones = ".parteBotones{"
    estilosParteBotones += ""
    estilosParteBotones += "}"
    parteBotones.classList.add("parteBotones")
    crearEstilo(estilosParteBotones)
    

    botonLiberar.addEventListener("click", checarLiberar)
    botonConstancia.addEventListener("click", function(){
        formulario=document.createElement("form")
        formulario.method="POST"
        formulario.action=urlBase+"/solicitarConstancia"
        formulario.id="formularioMaestroCurso"
        valores='<input type="hidden" name="idMaestro" value="'+maestroSeleccionado+'">'
        valores+='<input type="hidden" name="idCurso" value="'+cursoSeleccionado+'">'
        formulario.innerHTML=valores
        formulario.target="_blank"
        document.getElementsByTagName("body")[0].appendChild(formulario)
        formulario.submit()
        
    })

    return [elementoPadre, elemento]

}

function checarLiberar() {
    solicitarDatosJSON(urlBase + "/invertirLiberacion", dataCursoMaestro)
        .then(respuestaJSON => {
            liberado=respuestaJSON.liberado
            alert((liberado.valor=="liberado")? "Constancia liberada":"Constancia no liberada")
            botonLiberar.childNodes[0].src = (liberado.valor == "liberado")?"/public/iconos/candado-abierto.png":"/public/iconos/cerrado.png"
        })
}