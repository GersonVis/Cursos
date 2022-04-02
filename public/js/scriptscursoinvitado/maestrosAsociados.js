
botonMaestrosAsociados.addEventListener("click", function(){
    informacion = new FormData();
    informacion.append('curso', opcionSeleccionada.attributes.idsql.value)
    solicitarDatosJSON(urlBase + "/maestrosEnlazados", informacion)
        .then(datosJSON => {
            opcionSubMenu=seleccionarOpcion(botonMaestrosAsociados, opcionSubMenu, "textoSeleccionado")
            
            actualizarInformacionIndividual(datosJSON, listaDatosIndividuo, interfazMaestroAsociado)
        })
})
/*async function obtenerMaestrosAsociados(){
    let informacion, respusta
    informacion=new FormData()
    informacion.append(identificadorEnBase, opcionSeleccionada.attributes.idsql.value)
    respuesta=await solicitarDatosJSON(urlBase+'/instructoresEnlazados')
    return respuesta.json()
}
function recorrerJSON(contenidoJSON, funInterfazPorDato){
    contenidoJSON.forEach(datos=>{
          funInterfazPorDato(datos)
    })
}
function crearInterfazElementoAsociado(informacion){
    id=informacion.id.valor
    nombre=informacion.nombre.valor
    rfc=informacion.rfc.valor
    let elemento = document.createElement("li")
    let botonEliminar
    elemento.id="opcionAsociada"+id
    elemento.classList.add("opcion")
    elemento.classList.add("displayFlexC")
   
    atributo=crearAtributo("idsql", id)
    agregarAtributo(elemento, atributo)
    elemento.innerHTML = `<div idSql="${id}" class="conArribaOpcion FlexCentradoR posicionRelativa expandirW flexCentradoR">
    <div class="cuadroOpcion sombra colorPrimario redondear flexCentradoR" style="position: relative">
        <img src="public/iconos/perfil-del-usuario.png" class="mitad" alt="">
        <div idSql="${id}" class="opcionesDentro sombra opcionAsociadaEliminar posicionAbsoluta circulo colorQuinto flexCentradoR">
            <img src="public/iconos/basura.png" class="expandirSetenta" alt="">
        </div>
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
    botonEliminar=elemento.getElementsByClassName('opcionesDentro')[0]
    "elemento.childNodes[0].childNodes[1].childNodes[3]"
    return {interfaz: elemento, botonEliminar: botonEliminar}
}*/