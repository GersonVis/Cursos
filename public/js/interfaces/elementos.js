var pr=""
function botonAccionEnlazado(urlImagenPrimera, urlImagenPulsado="") {
    let imagenBoton = document.createElement('img')
    let boton = document.createElement('button')
  /*  boton.addEventListener("click", function(){
      
        imagenBoton.src=(imagenBoton.src.includes(urlImagenPrimera))?urlImagenPulsado:urlImagenPrimera
    })*/

    imagenBoton.src = urlImagenPrimera
    imagenBotonClases = ['imagenBoton', 'centrarAbsoluto']
    botonClases = ["botonConImagen", 'botonEnviarInstructor', 'redondear', 'colorPrimario', 'sombra']
    estilosImagen = {
        width: "70%",
        height: "auto"
    }
    estilosBoton = {
        position: "relative",
        width: "50px",
        height: "50px",
        "border-radius": "50%",
      
    }
    cssBoton = ".botonConImagen{}"

    crearEstilo(cssBoton)
    agregarEstilos(imagenBoton, estilosImagen)
    agregarEstilos(boton, estilosBoton)

    agregarClases(imagenBoton, imagenBotonClases)
    agregarClases(boton, botonClases)
    boton.appendChild(imagenBoton)
    return boton
}