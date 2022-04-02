
dat=""
botonEnviar.addEventListener('click', function(){
    contenedorOpcionesDirecto.innerHTML=""
    enviarFormulario('formularioBusqueda')
    .then(respuesta=>respuesta.json())
    .then(datos=>{
       // seleccionarOpcion(this, subMenu)
        console.log(datos)
        actualizarPanel(datos, crearPrincipal)
        console.log(datos)
    })
    
})