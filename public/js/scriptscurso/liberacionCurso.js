botonLiberacionCurso.addEventListener("click", function(){
    opcionSubMenu = seleccionarOpcion(botonLiberacionCurso, opcionSubMenu, "textoSeleccionado")
    listaDatosIndividuo.innerHTML=""
    listaDatosIndividuo.innerHTML=`<panel-subir-archivo titulo="CVV" idMaestro="${idIdentificador}" rol="Administrador" urlInformacion="/archivo/registroArchivosSubidos"urlEnviar="/archivo/liberacionCurso" idConjunto="2" idsql="${opcionSeleccionada.attributes.idsql.value}"></panel-subir-archivo>
    <panel-subir-archivo titulo="Ficha técnica" idMaestro="${idIdentificador}" rol="Administrador" urlInformacion="/archivo/registroArchivosSubidos"urlEnviar="/archivo/liberacionCurso" idConjunto="7" idsql="${opcionSeleccionada.attributes.idsql.value}"></panel-subir-archivo>
    <panel-subir-archivo titulo="Evidencias" idMaestro="${idIdentificador}" rol="Administrador" urlInformacion="/archivo/registroArchivosSubidos"urlEnviar="/archivo/liberacionCurso" idConjunto="8" idsql="${opcionSeleccionada.attributes.idsql.value}"></panel-subir-archivo>`
    
})