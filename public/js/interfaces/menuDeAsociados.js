function menuDeAsociados(elementosDentro){
      interfaz=document.createElement('div')
      interfaz.classList.add("colorPrimario")
      interfaz.classList.add("expandirAmbos")
      for(elemento of elementosDentro){
            interfaz.appendChild(elemento)
      }
      return interfaz
}
function crearFormularioInstructor(nombresLabels) {
      elementos = []
      for (columna of nombresLabels) {
          elemento = interfazDatoIndividuo(columna, "", identificadorFormulario)
          elementos.push(elemento)
      }
      return elementos
  }
async function crearFormularioConsulta(elemento) {//crea un formulario pidiendo los datos de las columnas para ser rellenadas
      let columnas = await solicitarDatosJSON('/instructor/columnas')
      let formularioElementos = crearFormularioInstructor(columnas)
      formularioElementos.forEach(elemento => {
            elemento.append(elemento)
      })
  }

function inputFormulario(etiqueta, tipo) {
      elemento = document.createElement("li")
      elemento.classList.add("datoPanelIndividuo")
      elemento.classList.add("flexCentradoR")
      elemento.innerHTML = `<p class="etiquetaDato">${etiqueta}</p>
      <div class="contenedorEditar colorCuarto redondearDos ocuparDisponible">
          <input name="${etiqueta}" type="${tipo}" class="textoIndividuo colorCuarto redondearDos " value="">
         
      </div>`
      return elemento
  }
  function opcionAsociada(informacion){
        return interfazInstructor(informacion)
  }
  function interfazInstructorEnlace(informacion, etiquetas=['id', 'nombre', 'rfc']){
      let id=informacion[etiquetas[0]].valor
      let nombre=informacion[etiquetas[1]].valor
      let rfc=informacion[etiquetas[2]].valor
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
      botonEliminar=elemento.childNodes[0].childNodes[1].childNodes[3]
      return {interfaz: elemento, botonEliminar: botonEliminar}
  }