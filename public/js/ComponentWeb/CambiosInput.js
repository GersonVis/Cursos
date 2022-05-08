class CambiosInput extends HTMLElement {
    constructor() {
        super()
        this.seleccionado = "noSeleccionado"
        this.accion = ""
    }
    agregarClases(clases) {//recive un array
        agregarClases(this, clases)//esta funcion esta en el archivo funcioens utilies

    }
    acccionBoton(padre) {//boton para actualizar regsitro en la base de  datos
        let botonActualizar = document.createElement("button")
        botonActualizar.innerHTML = "Actualizar"
        agregarClases(botonActualizar, ["buttonCIA", "redondear"])
        botonActualizar.value = "Actualizar"
        botonActualizar.addEventListener("click", function () {
            if (padre.elementoCambio.value == padre.valor) {
                alert("Los datos son los mismos")
                return false
            }
            padre.accion({
                id: padre.id,
                nombreColumna: padre.getAttribute("etiqueta"),
                valorNuevo: padre.elementoCambio.value
            })

        })
        return botonActualizar
    }
    textoRegistro(padre, valor, tipo) {//inputtext para modificar los datos en mysql
        let textoRegistro = document.createElement("input")
        textoRegistro.type = tipo
        textoRegistro.placeholder = "No tiene valor asignado"
        textoRegistro.value = valor
        agregarClases(textoRegistro, ["ciInputCambiar", "redondearDos"])
        textoRegistro.addEventListener("mousedown", function () {
            if (textoEditarAnterior != "") {
                quitarClase(textoEditarAnterior, "seleccionado")
                agregarClase(textoEditarAnterior, "noSeleccionado")
            }
            quitarClase(padre, "noSeleccionado")
            agregarClase(padre, "seleccionado")
            textoEditarAnterior = padre
        })
        return textoRegistro
    }
    listaOpciones(padre, valor, opciones, formaDeAcceso){
        let accesoUno=formaDeAcceso[0]
       
        let accesoDos=formaDeAcceso[1]
        let elemento = document.createElement("select")
        agregarClases(elemento, ["ciInputCambiar", "redondearDos"])
        let opcionesContenedor={}
        opciones.forEach(dato=>{
           let id=dato[accesoUno[0]][accesoUno[1]]
           let contenido=dato[accesoDos[0]][accesoDos[1]]
           let opcion=document.createElement("option")
           opcion.value=id
           opcion.innerText=contenido
           elemento.appendChild(opcion)
           opcionesContenedor[id]=opcion
           console.log(id+" "+contenido)
        })
        
        opcionesContenedor[valor].selected="true"
        elemento.addEventListener("mousedown", function () {
            if (textoEditarAnterior != "") {
                quitarClase(textoEditarAnterior, "seleccionado")
                agregarClase(textoEditarAnterior, "noSeleccionado")
            }
            quitarClase(padre, "noSeleccionado")
            agregarClase(padre, "seleccionado")
            textoEditarAnterior = padre
        })
        return elemento
    }
    renderizar() {
        let etiqueta = this.getAttribute("etiqueta")
        this.valor = this.getAttribute("valor") == "null" ? "" : this.getAttribute("valor")
        let tipo = this.getAttribute("tipo")
        
        this.innerHTML = '<label>' + etiqueta + '</label>'
        this.agregarClases(["divOF", "redondearDos", "posicionRelativa", "colorCuarto", "noSeleccionado"])
        //elementos creados aparte
        if (tipo == "select" && this.getAttribute("opciones")!=null) {
            //si el dato es un llave foranea crea las opciones disponibles de la llave foranea
            let opciones=JSON.parse(this.getAttribute("opciones"))
            let formaDeAcceso=JSON.parse(this.getAttribute("accederAJSON"))
            this.elementoCambio = this.listaOpciones(this, this.valor, opciones, formaDeAcceso)
            this.appendChild(this.elementoCambio)
        } else {
            this.elementoCambio = this.textoRegistro(this, this.valor, tipo)
            this.appendChild(this.elementoCambio)
        }
        this.interfazAccionBoton = this.acccionBoton(this)
        this.appendChild(this.interfazAccionBoton)
    }
    static get observedAttributes() {
        return ['etiqueta', 'tipo', 'valor', 'opciones', 'accederAJSON']
    }
    connectedCallback() {
      //  this.renderizar()

    }
    attributeChangedCallback(identificador, valorAntiguo, valorNuevo) {
        this.renderizar()
    }
}
customElements.define("cambios-input", CambiosInput)