botonSubirArchivo.addEventListener("click", function(){
    enviarFormulario("formularioSubirArchivo")
    .then(respuesta=>respuesta.text())
    .then(respuesta=>{
        metodoActualizarPanel()
        alert(respuesta)
    })
    .catch(error=>{
        console.log(error)
    })
})