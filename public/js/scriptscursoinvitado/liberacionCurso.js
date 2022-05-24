botonLiberacionCurso.addEventListener("click", function(){
    
    opcionSubMenu = seleccionarOpcion(botonLiberacionCurso, opcionSubMenu, "textoSeleccionado")
    listaDatosIndividuo.innerHTML=""
    listaDatosIndividuo.innerHTML=`<panel-subir-archivo titulo="CVV" idMaestro="${idMaestro}" modo="invitado" urlInformacion="/archivo/registroArchivosSubidos"urlEnviar="/archivo/liberacionCurso" idConjunto="2" idsql="${opcionSeleccionada.attributes.idsql.value}"></panel-subir-archivo>
    <panel-subir-archivo titulo="Ficha técnica" idMaestro="${idMaestro}" modo="invitado" urlInformacion="/archivo/registroArchivosSubidos"urlEnviar="/archivo/liberacionCurso" idConjunto="7" idsql="${opcionSeleccionada.attributes.idsql.value}"></panel-subir-archivo>
    <panel-subir-archivo titulo="Evidencias" idMaestro="${idMaestro}" modo="invitado" urlInformacion="/archivo/registroArchivosSubidos"urlEnviar="/archivo/liberacionCurso" idConjunto="8" idsql="${opcionSeleccionada.attributes.idsql.value}"></panel-subir-archivo>
    <boton-accion titulo="Descargar constancia" accionBoton="obtenerConstancia" accionInicio="estadoDeLiberacion"></boton-accion>
    `    
})

function estadoDeLiberacion(elemento){
    let dataCursoMaestro=new FormData()
    dataCursoMaestro.append("idCurso", opcionSeleccionada.attributes.idsql.value)
    dataCursoMaestro.append("idMaestro", idMaestro)

    fetch("curso/constanciaLiberada",{
        method:"POST",
        body: dataCursoMaestro
    })
    .then(respuesta=>respuesta.json())
    .then(data=>{
        console.log(data)
        liberado=data.liberado||undefined
        console.log(data)
        elemento.style.display=liberado.valor=="liberado"?"visible":"none"
    })
    .catch(e=>{
        console.log(e)
        alert("Error: "+e)
    })
} 
function obtenerConstancia(elemento){
    formulario=document.createElement("form")
    formulario.method="POST"
    formulario.action="curso/solicitarConstancia"
    formulario.id="formularioMaestroCurso"
    valores='<input type="hidden" name="idMaestro" value="'+idMaestro+'">'
    valores+='<input type="hidden" name="idCurso" value="'+ opcionSeleccionada.attributes.idsql.value+'">'
    formulario.innerHTML=valores
    formulario.target="_blank"
    document.getElementsByTagName("body")[0].appendChild(formulario)
    formulario.submit()
}
