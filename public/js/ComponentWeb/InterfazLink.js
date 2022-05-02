
class InterfazLink extends HTMLElement {
    constructor() {
        super()
        this.parteTitulo = ""
        this.renderizado = false
    }
    renderizar(){
        const elemento=document.createElement("div")
        elemento.className="InterfazLink"
        this.appendChild(elemento)
    }
    static get observedAttributes() {
        return []
    }
    connectedCallback() {
        if (!this.renderizado) {
            this.renderizar()
            this.renderizado = true
        }
    }
    attributeChangedCallback(identificador, valorAntiguo, valorNuevo) {

    }
}
customElements.define("interfaz-link", InterfazLink)