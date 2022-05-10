//en este archivo se describen las acciones del elementos listaSecciones
//que es un select que tiene como opciones los profesores divididos por carrrera

window.addEventListener("load", function(){
    /*fetch("maestro/carreras")
   /* .then(r=>{
        console.log(r.text())
    })*/
   /* .then(respuesta=>respuesta.json())
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
    })*/

    recorrerSolicitud(0,"/maestro/carreras", function(jsonInformacion){
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
    }, datos=[]) 
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
var c=0
function recorrerSolicitud(posicion, ruta, funcionHacer, guardarDatos){
    let data=new FormData()
    data.append("posicion", posicion)
    console.log("Estamos ejecustando la peticion: "+c)
    fetch( ruta, {
        method: "POST",
        body: data
    })
    .then(respuesta=>respuesta.text())
    .then(texto=>{
      /*  c=c+1
        console.log("Estamos ejecustando la peticion: "+c)
        console.log(texto)*/
        if(texto!=""){
            guardarDatos.push(JSON.parse(texto.substring(1, texto.length-1)))
            recorrerSolicitud(posicion+1, funcionHacer, guardarDatos)
        }else{
            console.log(guardarDatos)
            funcionHacer(guardarDatos)
        }
    })
    .catch(error=>{
        console.log("error", error)
        posicion=posicion-1
    })
}