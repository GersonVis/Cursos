const urlBase="/curso"//url a donde se harán todas las peticiones
const urlEnlazar="/instructor"
const identificadorEnBase="idCurso"
//variables globales
var opcionSeleccionada = ""
var textoEditarAnterior = ""
var opcionesEnlazadasAnterior = ""
var prueba = ""
var idOpcionSeleccionada = ""
var opcionSubMenu=""
var instructoresSeleccionados={}
var maestroSeleccionado=""
var liberado=""
var dataCursoMaestro=""
var cursoSeleccionado=""


//fin variables globales
function metodoActualizarPanel(){
    contenedorOpcionesDirecto.innerHTML=""
    solicitarDatosJSON(urlBase + "/todos")
        .then(datos => {
            actualizarPanel(datos, crearPrincipal)
        })
}

function crearPrincipal(informacion){
   
      id=informacion.id.valor
      nombre=informacion.nombreCurso.valor
      rfc=informacion.claveCurso.valor
      let elemento = document.createElement("li")
      let botonEliminar
      elemento.id="opcion"+id
      elemento.classList.add("opcion")
      elemento.classList.add("displayFlexC")
      
      atributo=crearAtributo("idsql", id)
      agregarAtributo(elemento, atributo)
      elemento.innerHTML = `<div idSql="${id}" class="conArribaOpcion FlexCentradoR posicionRelativa expandirW flexCentradoR">
          <div class="cuadroOpcion sombra colorPrimario redondear flexCentradoR" style="position: relative">
              <img src="public/imagenes/libros.png" style="background: #fff0f0;border-radius: 50% 50%;" class="mitad" alt="">
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
      botonEliminar=elemento.childNodes[0].childNodes[1].childNodes[3]
      return {interfaz: elemento, botonEliminar: botonEliminar}
}
function interfazInstructor(informacion){
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
}
function interfazInstructorAsociado(informacion){
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
}
function interfazMaestroAsociado(informacion){
    let id=informacion.id.valor
    let nombre=informacion.nombre.valor
    let rfc=informacion.rfc.valor
    let elemento = document.createElement("li")
    let botonEliminar
    elemento.id="opcionAsociada"+id
    elemento.classList.add("opcion")
    elemento.classList.add("displayFlexC")
    atributo=crearAtributo("idsql", id)
    agregarAtributo(elemento, atributo)
    elemento.innerHTML = `<div idSql="${id}" class="conArribaOpcion FlexCentradoR posicionRelativa expandirW flexCentradoR">
    <div class="cuadroOpcion sombra colorPrimario redondear flexCentradoR" style="position: relative">
        <img src="public/iconos/instructor.png" class="mitad" alt="">
        <div idSql="${id}" class="opcionesDentro sombra opcionAsociadaEliminar posicionAbsoluta circulo colorQuinto flexCentradoR">
            <img src="public/iconos/basura.png" class="expandirSetenta" alt="">
        </div>
        <div idSql="${id}" class="asociado asociadoID posicionAbsoluta redondear sombra colorCuarto flexCentradoR">
           <p>${id}</p>
        </div>
        <div idSql="${id}" class="asociado asociadoRFC posicionAbsoluta sombra colorCuarto textoSeleccionado">
        <p>${rfc}</p>
        
       </div>
       <div id="irAMaestroAsociado${id}" idSql="${id}" class="irAMaestroAsociado opcionesDentro sombra posicionAbsoluta circulo colorQuinto flexCentradoR">
            <img src="public/iconos/ver.png" class="expandirSetenta" alt="">
        </div>
    </div>
</div>
<div class="conAbajoOpcion displayFlexR ocuparDisponible">
    <p>${nombre}</p>
</div>`
    //modificacion de botoneliminar
    botonEliminar=elemento.getElementsByClassName('opcionesDentro')[0]
    botonIrAMaestroAsociado=elemento.querySelector("#irAMaestroAsociado"+id)
    botonIrAMaestroAsociado.addEventListener("click", function(){
        document.cookie="opcionSeleccionada=opcion"+id
        window.location.href="/maestro"
    })
    
    estilo=".irAMaestroAsociado{left: -5px; bottom: 6px; background-color: white}"
    
    crearEstilo(estilo)

    "elemento.childNodes[0].childNodes[1].childNodes[3]"
    elemento.addEventListener('click', function(){
        sectionEnlazadoPrincipal.style.visibility="visible"
        divInformacionPrincipalEnlazado.innerHTML=""
        divInformacionPrincipalEnlazado.appendChild(divEnlazadoPrincipal)
        maestroSeleccionado=id
        let idIdentificador=maestroSeleccionado
        divInformacionPrincipalEnlazado.innerHTML=`<panel-subir-archivo titulo="CVV"
         idMaestro="${maestroSeleccionado}" modo="administrador" 
         urlInformacion="/archivo/registroArchivosSubidos"
         urlEnviar="/archivo/liberacionCurso" idConjunto="2" 
         idsql="${opcionSeleccionada.attributes.idsql.value}"></panel-subir-archivo>
        <panel-subir-archivo titulo="Ficha técnica" idMaestro="${maestroSeleccionado}" modo="administrador" urlInformacion="/archivo/registroArchivosSubidos"urlEnviar="/archivo/liberacionCurso" idConjunto="7" 
        idsql="${opcionSeleccionada.attributes.idsql.value}"></panel-subir-archivo>
        <panel-subir-archivo titulo="Evidencias" idMaestro="${maestroSeleccionado}" modo="administrador" urlInformacion="/archivo/registroArchivosSubidos"urlEnviar="/archivo/liberacionCurso" idConjunto="8" 
        idsql="${opcionSeleccionada.attributes.idsql.value}"></panel-subir-archivo>`
        divInformacionPrincipalEnlazado.appendChild(divEnlazadoPrincipal)
        
        actualizarMaestroCurso()
    })
    return {interfaz: elemento, botonEliminar: botonEliminar, botonIr: botonIrAMaestroAsociado}
}

function actualizarMaestroCurso(){
    dataCursoMaestro=new FormData()
    dataCursoMaestro.append("idCurso", opcionSeleccionada.attributes.idsql.value)
    dataCursoMaestro.append("idMaestro", maestroSeleccionado)
    cursoSeleccionado=opcionSeleccionada.attributes.idsql.value
    liberado=""
    solicitarDatosJSON(urlBase+"/constanciaLiberada", dataCursoMaestro)
    .then(datosJSON=>{
        liberado=datosJSON.liberado
        botonLiberar.childNodes[0].src=(liberado.valor=="liberado")?"/public/iconos/candado-abierto.png":"/public/iconos/cerrado.png"
        secundario.innerHTML=""//limpieamos contenedor
      /*  solicitarDatosJSON(urlBase+"/asistencia", dataCursoMaestro)
        .then(
           respuestaJSON=>{
            actualizarAsistencia(respuestaJSON, secundario)
           }   
        )*/
    })
} 
actualizarAsistencia=(datosJSON, elementoContenedor)=>{
    datosJSON.forEach(dataIndividual=>{
        interfaz=interfazAsistencia(dataIndividual)
        elementoContenedor.appendChild(interfaz)
    })
}
interfazAsistencia=(dataIndividual)=>{
     let fecha=dataIndividual.fecha.valor
     let bitacora=dataIndividual.bitacora.valor
     divAsistencia=document.createElement("div")
     divAsistenciaClases=["divAsistencia", "flexCentradoC", "redondear" ]
     agregarClases(divAsistencia, divAsistenciaClases)
     divAsistencia.innerHTML=`
      <div class="asitenciaFecha expandirAmbos colorPrimario redondear colorTercero">${fecha}</div>
      <div class="asistenciaBitacora expandirAmbos colorCuarto">${bitacora}</div> 
     `
     return divAsistencia
     
}