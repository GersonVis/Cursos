class BotonAccion extends HTMLElement{
    constructor(){
        super()
        this.renderizado=false
        //elementos globales dentro de la clase
        this.divPrincipal=""
        this.boton
    }
    crearBoton(titulo){
        let boton=document.createElement("button")
        boton.innerText=titulo
        //clases css que iran en el elemento, los estilos css están en public/css/estilosBoton.css
        agregarClases(boton, ['buttonBABotonAccion', 'redondearDos', 'colorPrimario'])
        return boton
    }
    creacionPrincipal(){
        let elementoPadre=document.createElement('div')
        //clases css que iran en el elemento, los estilos css están en public/css/estilosBoton.css
        agregarClases(elementoPadre, ['divBAPrincipal','expandirAmbos', 'flexCentradoC'])
        return elementoPadre
    }
    agregarAPrincipal(elemento){
        this.divPrincipal.appendChild(elemento)
    }
    modificacionPadre(){
        agregarClases(this, ['BAPrincipalTR', 'flexCentradoC'])
    }
    renderizar(){
        this.modificacionPadre()
        this.divPrincipal=this.creacionPrincipal()
        this.botonPrincipal=this.crearBoton(this.getAttribute('titulo'))
        this.agregarAPrincipal(this.botonPrincipal)
        this.appendChild(this.divPrincipal)
        this.eventoInicio()
        this.eventoBoton()
    }
    connectCallBack(){
       if(!this.renderizado){
           this.renderizar()
           this.renderizado=true
       }
    }
    eventoBoton(){
        let funcionBoton
        eval("funcionBoton="+this.getAttribute("accionBoton"))
        this.botonPrincipal.addEventListener("click", function(){
            funcionBoton(this)
        })
    }
    eventoInicio(){
        //obtenemos una funcion del atributo y la guardamos
        //esta funcion se carga al inicio
        let variable;
        eval("variable="+this.getAttribute("accionInicio"))
        variable(this)
    }
    static get observedAttributes(){
        return ['titulo', 'accionInicio']
    }
    attributeChangedCallback(identificador, valorAntiguo, valorNuevo) {
        this.renderizar()
    }
    
}
customElements.define("boton-accion", BotonAccion)