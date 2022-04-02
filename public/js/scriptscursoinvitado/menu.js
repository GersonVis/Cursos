const opcionesMenu = document.querySelectorAll('.opcionMenu')
//var opcionSeleccionada = ""
const efectoSeleccionado = `
<div id="botonIr" class="opcionSeleccionada rotarAnimacion cuadradoChico redondear  colorPrimario flexCentradoR"><img src="/public/imagenes/right-arrow.png" alt="" class="unQuinto"></div>
         
<div class="cuadroTrasladar posicionAbsoluta expandirAmbos colorSecundario flexCentradoR"><p class="textoIr posicionAbsoluta">Ir</p></div>
`
opcionSeleccionada = document.getElementById('opcion1')
var contenidoRemplazado = ""
const elementoAbajo = document.getElementById('opcionAbajo')
const contenedorAbajo = document.getElementById("contenedorAbajo")
const elementoDescripcion = document.getElementById('descripcion')
const elementoImagen = document.getElementById('imagenDescripcion')
const elementoTitulo = document.getElementById('titulo');
const botonIr=document.getElementById('botonIr')
//opcion seleccionada por defecto
contenidoRemplazado = opcionSeleccionada.innerHTML
datosRelacionados=datosOpciones[opcionSeleccionada.id]
seleccionar(opcionSeleccionada)
//removerElemento(elementoAbajo, 1)
actualizarDescripcion(elementoDescripcion, datosRelacionados.descripcion)
actualizarImagen(elementoImagen, datosRelacionados.imagen)
actualizarTitulo(elementoTitulo, datosRelacionados.titulo)

//eventos
opcionesMenu.forEach(elemento => {
  elemento.addEventListener('mouseenter', function () {
    if (opcionSeleccionada != this) {
      datosRelacionados = datosOpciones[this.id]
      seleccionar(this)
    //  removerElemento(elementoAbajo, 1)
      actualizarDescripcion(elementoDescripcion, datosRelacionados.descripcion)
      actualizarImagen(elementoImagen, datosRelacionados.imagen)
      actualizarTitulo(elementoTitulo, datosRelacionados.titulo)
      let botonIr=document.getElementById('botonIr')
      eventoIr(botonIr, datosRelacionados.redireccion)
    }
  })
 //crearAnimaciones(elemento)
})
function eventoIr(elemento, redireccion){
     elemento.addEventListener('click', function(){
       window.location.href=redireccion
     })
}

function seleccionar(elemento) {
  remplazarContenido(opcionSeleccionada, contenidoRemplazado)
  opcionSeleccionada = elemento
  animarElemento = opcionSeleccionada.children[0]
  contenidoRemplazado = remplazarContenido(elemento, efectoSeleccionado)
  contenidoAbajo = contenidoRemplazado.replace('opcion', 'sinevento')
  contenidoAbajo=quitarParte(contenidoAbajo, '<div')
  remplazarContenido(elementoAbajo, contenidoAbajo)
}
function quitarParte(texto="", palabra, posicionInicioBusqueda=5, inicio=0){
  posicionInicioCorte=texto.indexOf(palabra, posicionInicioBusqueda)
  texto=texto.substring(inicio, posicionInicioCorte-2)
  console.log(texto)
  return texto
}
function removerElemento(elemento, posicion){
  elemento.children[posicion].remove()
}
function actualizarDescripcion(elemento, nuevoContenido) {
  elemento.innerText = nuevoContenido
}
function actualizarImagen(elemento, nuevaImagen) {
  elemento.src = nuevaImagen
}
function actualizarTitulo(elemento, textoNuevo) {
  elemento.innerText = textoNuevo
}
function agregarAnimacion({ elemento, animacion, tiempo = ".5s", iteracion = "infinite", direccion = "linear" }) {
  animacion = `animation: ${tiempo} ${iteracion} ${direccion} ${animacion}`
  elemento.style = animacion
  console.log(tiempo)
}

function remplazarContenido(elemento, nuevoContenido) {//actualiza codigo html dentro de un elemento
  contenido = elemento.innerHTML
  elemento.innerHTML = nuevoContenido
  return contenido
}
function crearAnimaciones(elemento){
     console.log('funcion crear animaciones')
     elemento.addEventListener('animationend',function(){
       alert('animacion terminada')
     })
}