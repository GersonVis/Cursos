const urlBase="/instructor"//url a donde se harán todas las peticiones
const urlEnlace="/curso"
const etiquetasRequeridas=['id', 'nombreCurso', 'claveCurso']
const identificardorEnlace="idsCursos"
const identificadorPrincipal='idInstructor'
const idEnlace="idCurso"
//variables globales
var opcionSeleccionada = ""
var textoEditarAnterior = ""
var opcionesEnlazadasAnterior = ""
var prueba = ""
var idOpcionSeleccionada = ""
var opcionSubMenu=""
var instructoresSeleccionados={}
var urlEnlazada="/curso"
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
              <img src="public/iconos/perfil-del-usuario.png" style="background: #fff0f0;border-radius: 50% 50%;" class="mitad" alt="">
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
    nombre=informacion.nombreCurso.valor
    rfc=informacion.claveCurso.valor
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


