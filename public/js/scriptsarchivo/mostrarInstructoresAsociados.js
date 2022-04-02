botonInstructoresAsociados.addEventListener("click", function () {
    informacion = new FormData();
    informacion.append('curso', opcionSeleccionada.attributes.idsql.value)
    solicitarDatosJSON(urlBase + "/instructoresEnlazados", informacion)
        .then(datosJSON => {
            opcionSubMenu=seleccionarOpcion(botonInstructoresAsociados, opcionSubMenu, "textoSeleccionado")
            
            actualizarInformacionIndividual(datosJSON, listaDatosIndividuo, interfazInstructorAsociado)
        })
})
var contenedorInstructoresEnlazados=contenedorIntructoresAsociados()
listaDatosIndividuo.appendChild(contenedorInstructoresEnlazados)
actualizarInformacionIndividual = (datosJSON, contenedorPadre, crearInterfaz) => {
    contenedorPadre.innerHTML = ""
    contenedorInstructoresEnlazados.innerHTML=""
    datosJSON.forEach(elemento => {
        let interfaz, botonEliminar, botonIr
        ({interfaz, botonEliminar, botonIr} = crearInterfaz(elemento))
        contenedorInstructoresEnlazados.appendChild(interfaz)
        botonEliminar.addEventListener('click', function (){
            eventoBotonEliminarInstructor(this, interfaz)
        })
        
       
    });
    contenedorPadre.appendChild(contenedorInstructoresEnlazados)
}
eventoBotonEliminarInstructor=(elemento, padre)=>{
    let data=new FormData();
    data.append('idInstructor', elemento.attributes.idsql.value)
    data.append('idCurso', opcionSeleccionada.attributes.idsql.value)
    consulta(urlBase+"/desenlazar", data)
    .then(respuesta=>{
        if(respuesta.status=="200"){
            alert("Se ha quitado el instructor correctamente")
            
            contenedorInstructoresEnlazados.removeChild(padre)
            return true
        }
        alert("Algo salio mal!")
        return ""
    })
}
function contenedorIntructoresAsociados(){
    let elemento=document.createElement('div')
    elemento.classList.add('gridTres')
    elemento.classList.add('flexCentradoR')
    let estilosElemento={
        width: "100%"
    }
    agregarEstilos(elemento, estilosElemento)
   // elementoHijo.style.paddingBottom="20px"
    return elemento
}