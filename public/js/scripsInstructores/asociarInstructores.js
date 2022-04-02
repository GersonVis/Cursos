botonAsociarInstructores.addEventListener('click', function () {
    clickBotonAsociarInstructores()
})
clickBotonAsociarInstructores=()=>{
    informacion = new FormData();
    informacion.append('idInstructor', opcionSeleccionada.attributes.idsql.value)
    solicitarDatosJSON(urlBase + "/cursosDisponibles", informacion)
        .then(datosJSON => {
            opcionSubMenu = seleccionarOpcion(botonAsociarInstructores, opcionSubMenu, "textoSeleccionado")
            verInstructoresDisponibles(datosJSON, listaDatosIndividuo, interfazInstructorEnlace)
        })
}

var contenedorInstructoresDisponibles, padreInstructuctoresDisponibles
[padreInstructuctoresDisponibles, contenedorInstructoresDisponibles] = enlazarInstructoresDisponibles()

var estiloDeSeleccion="seleccionarTipoDos"//clase de css que se aplica al hacer click
verInstructoresDisponibles = (datosJSON, contenedorPadre, crearInterfaz) => {
    contenedorPadre.innerHTML = ""
    contenedorInstructoresDisponibles.innerHTML = ""
    datosJSON.forEach(elemento => {
        ({ interfaz, botonEliminar } = crearInterfaz(elemento, etiquetasRequeridas))
        if(instructoresSeleccionados[elemento.id.valor]!=undefined){
            interfaz.classList.add(estiloDeSeleccion)
        }
        contenedorInstructoresDisponibles.appendChild(interfaz)
        interfaz.addEventListener('click', function(){
            if(seleccionMultiple(instructoresSeleccionados, this.attributes.idsql.value)){
                this.classList.add(estiloDeSeleccion)
            }else{
                this.classList.remove(estiloDeSeleccion)
            }
        })
    })

    contenedorPadre.appendChild(padreInstructuctoresDisponibles)
}
function enlazarInstructoresDisponibles() {
    let elemento = document.createElement('div')
    let imagenBoton= document.createElement('img')
    let elementoPadre = document.createElement('div')
    let botonEnviar = document.createElement('button')
   //clases css
   imagenBotonClases=['imagenBoton', 'centrarAbsoluto']
   elementoClases=['gridTres', 'flexCentradoR', "elementoEnlazarInstructor", "barras"]
   botonEnviarClases=[ 'botonEnviarInstructor', 'redondear', 'colorPrimario', 'sombra']
   elementoPadreClases=[ 'barras']


   agregarClases(imagenBoton, imagenBotonClases)
   agregarClases(botonEnviar, botonEnviarClases)
   agregarClases(elemento, elementoClases)
   agregarClases(elementoPadre, elementoPadreClases)
   //enlaces de elementos
    elementoPadre.appendChild(elemento)
    elementoPadre.appendChild(botonEnviar)
    botonEnviar.appendChild(imagenBoton)

    //edificion de propiedades
    
    botonEnviar.value = "Enlazar"
    imagenBoton.src="/public/iconos/enchufe.png"

    

    //estilos
    estilosImagen = {
        width: "70%",
        height: "auto"
    }
    estilosBoton = {
        position: "absolute",
        width: "50px",
        height: "50px",
        right: "30px",
        bottom: "100px",
        "border-radius": "50%",
    }
    estilosPadre = {

        width: "100%"
    }
    agregarEstilos(imagenBoton, estilosImagen)
    agregarEstilos(botonEnviar, estilosBoton)
    agregarEstilos(elementoPadre, estilosPadre)

    //eventos js
    puerta=true
    botonEnviar.addEventListener('click', function(){
        if(Object.keys(instructoresSeleccionados).length==0){
             alert("No hay instructores seleccionados")
        }else if(confirm("Se enlazaran estos instructores al curso") && puerta){
            let data=new FormData()
            data.append(identificardorEnlace, JSON.stringify(instructoresSeleccionados))
            data.append(identificadorPrincipal, opcionSeleccionada.attributes.idsql.value)
            puerta=false
            consulta(urlBase+"/enlazar", data)
            .then(respuesta=>{
                    console.log("actualizando")
                    clickBotonAsociarInstructores()
                    instructoresSeleccionados={}
                    puerta=true
            })
        }
    })
    return [elementoPadre, elemento]
}
info=""
function seleccionMultiple(guardados, identificador, guardar=""){
    if(guardados[identificador]==undefined){
        guardados[identificador]=guardar
        return true
    }
    delete guardados[identificador]
    return false
}
function interfazInstructorSinBoton(informacion){
    id=informacion.id.valor
    nombre=informacion.nombre.valor
    rfc=informacion.rfc.valor
    let elemento = document.createElement("li")
    let botonEliminar
    elemento.id="opcion"+id
    elemento.classList.add("opcion")
    elemento.classList.add("displayFlexC")
   
    atributo=crearAtributo("idsql", id)
    agregarAtributo(elemento, atributo)
    elemento.innerHTML = `<div idSql="${id}" class="conArribaOpcion FlexCentradoR posicionRelativa expandirW flexCentradoR">
    <div class="cuadroOpcion sombra colorPrimario redondear flexCentradoR" style="position: relative">
        <img src="public/iconos/perfil-del-usuario.png" class="mitad" alt="">
        
        <div idSql="${id}" class="asociado asociadoID posicionAbsoluta redondear sombra colorCuarto flexCentradoR">
           <p>${id}</p>
        </div>
        <div idSql="${id}" class="asociado asociadoRFC posicionAbsoluta sombra colorCuarto textoSeleccionado">
        <p>${rfc}</p>
        
     </div>
    </div>
</div>
<div class="conAbajoOpcion displayFlexR ocuparDisponible">
    <p>${nombre}</p>
</div>`
    //modificacion de botoneliminar
   // botonEliminar=elemento.getElementsByClassName('opcionesDentro')[0]
    "elemento.childNodes[0].childNodes[1].childNodes[3]"
    return {interfaz: elemento, botonEliminar: ""}
}