//en este archivo se describen las acciones del elementos listaSecciones
//que es un select que tiene como opciones los profesores divididos por carrrera

window.addEventListener("load", function(){
    fetch("maestro/carreras")
   /* .then(r=>{
        console.log(r.text())
    })*/
    .then(respuesta=>respuesta.json())
    .then(jsonInformacion=>{
                let opciones={}
                jsonInformacion.forEach(datos=>{
                    let opcion=document.createElement('option')
                    let id=datos.id.valor
                    let valor=datos.nombreCarrera.valor
                    opciones[id]=opcion
                    opcion.value=id
                    opcion.innerText=valor
                    listaSecciones.appendChild(opcion)
                })
               mostrarPorCategoria(Object.keys(opciones)[0]||0) 
    })
    .catch(e=>{
        console.error(e)
        alert("Erorr: " +e)
    })
})

listaSecciones.addEventListener("change", function(){
    mostrarPorCategoria(listaSecciones.value)
})
mostrarPorCategoria=(categoria)=>{
    /*Buscamos en la tabla el id referenciado pasamos los datos recividos por la api
    y los cargamos visualmente
    */
    let informacion=new FormData();
    informacion.append("valor", categoria)
    informacion.append("idCarrera", "1")
    contenedorOpcionesDirecto.innerHTML=""
    fetch(urlBase+'/busqueda', {
        method: "POST",
        body: informacion
    })
    .then(respuesta=>respuesta.json())
    .then(datos=>{
        actualizarPanel(datos, crearPrincipal)
    })
    .catch(e=>{
        console.error(e)
        alert("Erro: "+e)
    })
}