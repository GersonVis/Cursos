
class InterfazLink extends HTMLElement {
    constructor() {
        super()
        this.parteTitulo = ""
        this.renderizado = false
    }
    parteInformacion(strDescripcion){
        this.divInformacion=document.createElement("div")
        this.divInformacion.title=strDescripcion
        this.divInformacion.innerHTML=`<img class="InterfazLinkImagen" src="public/iconos/info.png">`
        this.divInformacion.className="InterfazLinkDivInformaccion"
        this.divPadre.appendChild(this.divInformacion)
    }
    //cre el elemento en la parte central
    parteCentral(strTitulo, strEnlace){
        let expresion=/https*:\/\//
        if(!expresion.exec(strEnlace)){
            strEnlace="http://"+strEnlace
        }
        this.divCentral=document.createElement("div")
        this.divCentral.className="divCentral"
        this.tituloLink=document.createElement("a")
        this.tituloLink.href=strEnlace
        this.tituloLink.innerText=strTitulo
        this.divCentral.appendChild(this.tituloLink)
        this.appendChild(this.divCentral)
    }
    //interfaz para eliminar el enlace
    parteEliminar(){
        this.divEliminar=document.createElement("div")
        this.divEliminar.innerHTML=`<img class="InterfazLinkImagen" src="public/iconos/basura.png">`
        this.divEliminar.className="InterfazLinkDivEliminar"
        this.divPadre.appendChild(this.divEliminar)
    }
    padre(){
        this.divPadre=document.createElement("div")
        this.divPadre.className="InterfazLinkDivPadre"
        this.appendChild(this.divPadre)
    }
    renderizar(){
        this.className="InterfazLink"
        this.padre()
        this.parteCentral(this.getAttribute("titulo")??"nulo", this.getAttribute("enlace")??"")
        this.parteEliminar()
        this.parteInformacion(this.getAttribute("descripcion")??"Sin descripcion")
    }
    static get observedAttributes() {
        return ["titulo", "descripcion", "enlace"]
    }
    connectedCallback() {
        if (!this.renderizado) {
            this.renderizar()
            this.renderizado = true
        }
    }
    attributeChangedCallback(identificador, valorAntiguo, valorNuevo) {
       /* switch(identificador){
            case "titulo":
                this.tituloLink.innerText=valorNuevo
            break
            case "descripcion":
                this.divInformacion.title=valorNuevo
            break
            case "enlace":
                this.tituloLink.innerText=valorNuevo
            break
        }*/
    }
}
customElements.define("interfaz-link", InterfazLink)