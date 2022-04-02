
var opd
class PanelSubirArchivo extends HTMLElement {
    constructor() {
        super()
        this.parteTitulo = ""
        this.renderizado = false
        this.contenedorPrincipal()
        this.contadorArchivos = 0
        this.informacion=new FormData()
    }
    //funciones reutilizables
    crearImagen(rutaImagen) {
        let imagenIcono = document.createElement("img")
        imagenIcono.src = rutaImagen
        agregarClases(imagenIcono, ["imgPSAImagen", "expandirSetenta"])
        return imagenIcono
    }
    //este contenedor es el contenedor principal
    contenedorPrincipal() {
        this.padre = document.createElement('div')
        this.padre.style.width = "90%"
        agregarClases(this.padre, ['divPSAPadre', 'flexCentradoC'])
        this.appendChild(this.padre)
    }
    //hijos de contenedorPrincipal
    crearTitulo(titulo) {
        let padre
        padre = document.createElement('div')
        padre.innerHTML = `<label class="textoTipoD">${titulo}</label>`
        this.crearMenuOpciones(padre)
        agregarClases(padre, ['divPSAPadreTitulo','posicionRelativa', 'flexCentradoR', 'redondearDos', 'colorCuarto'])
        return padre
    }
    crearMenuOpciones(contenedorTitulo){
        this.informacion.append("idMaestro", this.getAttribute('idMaestro'))
        this.informacion.append("idCurso", this.getAttribute('idsql'))
        this.informacion.append("idConjunto", this.getAttribute('idConjunto'))
        if(this.getAttribute("modo")=="administrador"){
            let selectEstados=document.createElement('select')
            let eventoCambio=()=>{
                selectEstados.removeEventListener("change", eventoCambio)
                this.informacion.append("idEstado", selectEstados.value)
                fetch("/conjunto/cambiarEstado",
                {
                    method:"POST",
                    body: this.informacion
                })
                .then(respuesta=>respuesta.json())
                .then(texto=>{
                    selectEstados.addEventListener("change", eventoCambio)
                    alert(texto.respuesta||"Error")
                })
                .catch(er=>{
                    selectEstados.addEventListener("change", eventoCambio)
                    console.log(er)
                    alert("Error: "+er)
                })
            }
            selectEstados.addEventListener("change", eventoCambio)
            contenedorTitulo.appendChild(selectEstados)
            agregarClases(selectEstados, ['selectPSASelectEstados', 'posicionAbsoluta', 'redondear'])
            fetch("/conjunto/tiposDeConjunto")
            .then(respuesta=>respuesta.json())
            .then(jsonInformacion=>{
                let opciones={}
                opd=opciones
                jsonInformacion.forEach(datos=>{
                    let opcion=document.createElement('option')
                    let id=datos.id.valor
                    let valor=datos.estado.valor
                    opciones[id]=opcion
                    opcion.value=id
                    opcion.innerText=valor
                    selectEstados.appendChild(opcion)
                })
                fetch("/conjunto/estadoDelConjunto", {
                    method: "POST",
                    body: this.informacion
                })
            /*    .then(r=>{
                    console.log(r.text())
                })*/
                .then(r=>r.json())
                .then(jsonDatos=>{
                    if(jsonDatos.id){
                        opciones[jsonDatos.id.valor].selected=true
                    }

                })
                .catch(er=>{
                    alert("Error: "+er)
                })
            })
            .catch(error=>{
                console.log(error)
                alert("Error: "+error)
            })
            return;   
        }   
        fetch("/conjunto/estadoDelConjunto", {
                method: "POST",
                body: this.informacion
            })
          /*  .then(r=>{
                console.log(r.text())
            })*/
           .then(respuesta=>respuesta.json())
            .then(jsonData=>{
                let estadoRecivido=jsonData.estado?jsonData.estado.valor:""
                contenedorTitulo.innerHTML+=`<label class="labelPSAEstadoConjunto posicionAbsoluta">${estadoRecivido}</label>`
            })
            .catch(error=>{
                console.log(error)
                alert("Error: "+error)
            })
    }
    crearContenedorArchivosAgregados() { //elemento que contiene la interfaz de archivos agregados
        let contenedorBotonesSubirArchivo = document.createElement('div')
        let botonSubirArchivo = this.crearBotonSubirArchivos(this)
        agregarClases(contenedorBotonesSubirArchivo, ['divPSAPadreSubirArchivo', 'flexCentradoR', 'colorCuarto', 'redondearDos', 'posicionRelativa'])
        // this.padre.appendChild(contenedorBotonesSubirArchivo)
        contenedorBotonesSubirArchivo.appendChild(botonSubirArchivo)
        return contenedorBotonesSubirArchivo
    }
    crearFormularioArchivosAgregados() {//formulario oculto que subira los archivos a la api
        let formulario = document.createElement('form')
        formulario.action = this.getAttribute('urlEnviar')
        formulario.method = "POST"
        formulario.innerHTML = `<input style="display: none" name="idCurso"value="${this.getAttribute("idsql")}"></input><input style="display: none" name="idConjunto"value="${this.getAttribute("idConjunto")}"></input>`
        return formulario
    }
    crearInterfazArchivos() {
        let divPadre = document.createElement('div')
        agregarClases(divPadre, ['divPSAContenedorAgregar'])
        return divPadre
    }
    crearContenedor(clases) {
        let divPadre = document.createElement('div')
        agregarClases(divPadre, clases)
        return divPadre
    }
    //hijos de crearAgregarArchivos
    crearAccionArchivo(titulo, subtitulo, imagen, padreGlobal) {//abre una ventana para subir archivo
        let botonAccion = document.createElement('div')
        let contenedorImagen = document.createElement('div')
        let imagenIcono = this.crearImagen(imagen)
        let tituloBoton = document.createElement('abbr')

        //ediciones directas del elemento

        tituloBoton.innerText = titulo
        tituloBoton.title = subtitulo
        //clases css agregadas a los elementos
        agregarClases(botonAccion, ['divPSAPadreCrearAccionArchivo', 'redondearDos', "flexCentradoC", "colorFondo", "sombraDos", "posicionRelativa"])
        agregarClases(contenedorImagen, ["divPSAContenedorImagen", "flexCentradoR", "redondear", "colorCuarto"])


        agregarClases(tituloBoton, ["abbrPSATitulo"])

        //agregar elementos dentro de sus padres
        botonAccion.appendChild(contenedorImagen)
        contenedorImagen.appendChild(imagenIcono)
        botonAccion.appendChild(tituloBoton)
        botonAccion.addEventListener("click", function () {
            let inputArchivo = document.createElement("input")
            inputArchivo.type = "file"
            inputArchivo.id = "archivo"
            inputArchivo.style.display = "none"
            inputArchivo.id = "archivo"
            padreGlobal.formularioArchivos.appendChild(inputArchivo)
            inputArchivo.click()
            inputArchivo.addEventListener("change", function () {
                let nombre, archivoInterfaz, peso, archivo
                let datosExtra
                archivo = this.files[0]
                nombre = archivo.name
                peso = "Peso: " + archivo.size
                datosExtra = {
                    formulario: padreGlobal.formularioArchivos,
                    inputArchivo: inputArchivo
                }
                archivoInterfaz = padreGlobal.interfazReferenciaAArchivo("", nombre, peso, "public/iconos/archivo-agregado.png", padreGlobal.listaArchivos, "visible", function ({ formulario, inputArchivo }) {
                    formulario.removeChild(inputArchivo)
                }, datosExtra)
                padreGlobal.listaArchivos.appendChild(archivoInterfaz)
                padreGlobal.contadorArchivos++
                inputArchivo.name = "archivo" + padreGlobal.contadorArchivos
            }, false)
        })
        return botonAccion
    }

    interfazReferenciaAArchivo(id, titulo, peso, icono, padre, display = "none", funcionBotonEliminar = function () { }, datosExtra) {//interfaz de cada archivo agregado al formulario
        //crea la interfaz de cada archivo seleccionado, se puede quitar o poner el boton de eliminar con display
        //la function que se pasa en el metodo contiene lo que se hara en el botonEliminar
        var padreGlobal=this
        let divPrincipal = document.createElement('div')
        let atributoDiv=document.createAttribute('idsql')
        let atributoBoton=document.createAttribute('idsql')
        let contenedorImagen = document.createElement('div')
        let imagenIcono = this.crearImagen(icono)
        let tituloBoton = document.createElement('abbr')
        let botonEliminar = document.createElement("button")//elimina el archivo del formulario del formulario
        let imagenBoton = this.crearImagen("public/iconos/basura.png")
        //ediciones directas del elemento
        botonEliminar.setAttributeNode(atributoBoton)
        botonEliminar.attributes.idsql.value=id

        divPrincipal.setAttributeNode(atributoDiv)
        divPrincipal.attributes.idsql.value=id

        tituloBoton.innerText = titulo
        tituloBoton.title = peso
        botonEliminar.style.display = display
        // botonEliminar.innerText="Eliminar"
        //clases css agregadas a los elementos
        agregarClases(divPrincipal, ['divPSAPadreRerefenciaAArchivo', 'redondearDos', "flexCentradoC", "colorFondo", "sombraDos", "posicionRelativa"])
        agregarClases(contenedorImagen, ["divPSAContenedorImagen", "flexCentradoR", "redondear", "colorCuarto"])
        agregarClases(tituloBoton, ["abbrPSATitulo"])
        agregarClases(botonEliminar, ["buttonPSABotonEliminar", "flexCentradoR", "colorQuinto"])

        //agregar elementos dentro de sus padres
        divPrincipal.appendChild(contenedorImagen)
        contenedorImagen.appendChild(imagenIcono)
        divPrincipal.appendChild(tituloBoton)
        divPrincipal.appendChild(botonEliminar)
        botonEliminar.appendChild(imagenBoton)
        
        //quitar elemento visualmente, solicita a la base de datos para remover del registro y servidor
        botonEliminar.addEventListener("click", function () {
            padreGlobal.informacion.append("idArchivo", this.attributes.idsql.value)
            fetch("archivo/eliminar", {
                method: "POST",
                body: padreGlobal.informacion
            }).then(respuesta=>{
                  if(respuesta.status=="200"){
                      padreGlobal.listaArchivos.remove(padre)
                      alert("Eliminado correctamente")
                      return
                  }
                  throw "Error al eliminar"
            })
            .catch(error=>{
                console.log(error)
                alert("Error: "+error)
            })
        })
        botonEliminar.addEventListener("click", function () {
            funcionBotonEliminar(datosExtra || "")
        })

        return divPrincipal
    }
    crearListaArchivos() {
        let divPadre = document.createElement('div')
        agregarClases(divPadre, ['divPSAContenedorAgregar'])
        return divPadre
    }
    //boton con posicion absoluta
    crearBotonSubirArchivos(padreGlobal) {
        let botonSubir = document.createElement('button')
        let imagenSubir = this.crearImagen("public/iconos/file.png")
        agregarClases(botonSubir, ['buttonPSABotonSubirArchivo', 'posicionAbsoluta', 'redondear', 'BotonCircular'])
        botonSubir.appendChild(imagenSubir)
        botonSubir.addEventListener("click", function () {
            if (padreGlobal.formularioArchivos.children.length > 2) {
                padreGlobal.enviarFormularioConElemento(padreGlobal.formularioArchivos)
                    .then(respuesta =>respuesta.text())
                    .then(texto => {
                        
                        let inputNecesario1, inputNecesario2
                        inputNecesario1=padreGlobal.formularioArchivos.childNodes[0]
                        inputNecesario2=padreGlobal.formularioArchivos.childNodes[1]
                        padreGlobal.listaArchivos.innerHTML=""
                        padreGlobal.formularioArchivos.innerHTML=""
                        padreGlobal.formularioArchivos.appendChild(inputNecesario1)
                        padreGlobal.formularioArchivos.appendChild(inputNecesario2)
                        padreGlobal.solicitarArchivos(padreGlobal)
                        alert(texto)
                    })
                    .catch(error => {
                        console.log(error)
                        alert("No se pudo enviar")
                    })
                return
            }
            alert("No hay archivos para enviar")

            //  }
        })
        return botonSubir
    }
    //metodos hacia api
    async enviarFormularioConElemento(formulario) {
        let data = new FormData(formulario)
        let respuesta = await fetch(formulario.action, {
            method: formulario.method,
            body: data
        })
        return respuesta
    }
    solicitarArchivos(padreGlobal) {
        let informacion = new FormData()
        informacion.append("idCurso", this.getAttribute('idsql'))
        informacion.append("idConjunto", this.getAttribute('idconjunto'))
        informacion.append('idMaestro', this.getAttribute('idMaestro')||1)
        informacion.append('idMaestro', this.getAttribute('idMaestro')||1)
        fetch(this.getAttribute("urlInformacion"), {
            method: "POST",
            body: informacion
        })
     /*   .then(r=>{
            console.log(r.text())
        })*/
            .then(respuesta => respuesta.json())
            .then(data => {
                
                data.forEach(objeto => {
                    let id=objeto.id.valor
                    let nombre = objeto.nombre.valor
                    let permisoEliminar = objeto.permisoEliminar.valor
                    let permisoModificar = objeto.permisoModificar.valor
                    let archivoInterfaz
                    archivoInterfaz = padreGlobal.interfazReferenciaAArchivo(id, nombre, nombre, "public/iconos/archivo-agregado.png", padreGlobal.listaArchivos, (permisoEliminar) ? "visible" : "none")
                    padreGlobal.listaArchivos.appendChild(archivoInterfaz)
                })
            })
          /*  .catch(error => {
                alert("Error al consultar archivos " + error)
            })*/
    }
    //metodo que se lanza al añadir al DOM
    renderizar() {
        let botonAgregarArchivo, contenedorDivAgregar, contenedorListaArchivos
        this.style.width = "100%"
        this.formularioArchivos = this.crearFormularioArchivosAgregados()


        this.contenedorArchivosAgregados = this.crearContenedorArchivosAgregados()
        this.listaArchivos = this.crearContenedor(['divPSAListaArchivos', "flexCentradoR"])

        contenedorDivAgregar = this.crearContenedor(['divPSAContenedorAgregar', 'flexCentradoR'])
        contenedorListaArchivos = this.crearContenedor(['divPSAContenedorListaArchivos', 'barraDeDesplazamiento'])


        botonAgregarArchivo = this.crearAccionArchivo("Agregar", "Seleccionar archivo a agregar", "public/iconos/agregar-archivo.png", this)//este boton se encuentra por separado con posicion absoluta
        // this.padre.appendChild(contedorDivAgregar)
        contenedorDivAgregar.appendChild(botonAgregarArchivo)
        this.padre.appendChild(this.contenedorArchivosAgregados)
        this.contenedorArchivosAgregados.appendChild(contenedorDivAgregar)
        contenedorDivAgregar.appendChild(botonAgregarArchivo)
        this.contenedorArchivosAgregados.appendChild(contenedorListaArchivos)
        contenedorListaArchivos.appendChild(this.listaArchivos)
        this.padre.appendChild(this.formularioArchivos)
        agregarClases(this, ["divPSA", "flexCentradoC"])
        this.solicitarArchivos(this)
    }
    static get observedAttributes() {
        return ['titulo', 'urlEnviar', 'idsql', 'sinboton', 'idMaestro', 'idConjunto', 'modo']
    }
    connectedCallback() {
        if (!this.renderizado) {
            this.renderizar()
            this.renderizado = true
        }
    }
    attributeChangedCallback(identificador, valorAntiguo, valorNuevo) {
        switch (identificador) {//evita actualizar todo el elemento, solo actualiza el elemento que a sido modificado
            case 'titulo':
                this.parteTitulo = this.crearTitulo(valorNuevo)
                this.padre.appendChild(this.parteTitulo)
                break
        }
    }
    prueba() {
        alert("hoña")
    }
}
customElements.define("panel-subir-archivo", PanelSubirArchivo)