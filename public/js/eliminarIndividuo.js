const botonesEliminar=document.querySelectorAll('.opcionesDentro.opcionEliminar')
res=""
botonesEliminar.forEach(elemento=>{
    elemento.addEventListener('click', function(e){
        e.stopPropagation()
        res=this
        let resultado=confirm("eliminar")
        if(resultado){
           procesoDeEliminacion(this)
        }
    }
    )
})

async function procesoDeEliminacion(elemento){
      resultado=await eliminarInstructor(elemento.attributes.idsql.value)
      if(resultado.status==200){
        actualizarInterfazEliminacion(elemento)
      }
}
function actualizarInterfazEliminacion(elemento){
    let opcion=document.getElementById('opcion'+elemento.attributes.idsql.value)
    let elementoPadre=opcion.parentElement
    elementoPadre.removeChild(opcion)
}
async function eliminarInstructor(id){
     let datos= new FormData()
     datos.append('id', id)
     resultado= await fetch('/instructor/eliminar', {
         method: "POST",
         body: datos
     })
     return resultado
}