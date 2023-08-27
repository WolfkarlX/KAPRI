/*function ConfirmAll(){
    var respuesta = confirm("Esta segur@ de eliminar todas sus publicaciones?");

    if(respuesta == true){
        return true;
    }
    if(respuesta == false){
        return false;
    }
} */


/*function ConfirmAll(){
  var respuesta = 
 swal({
    title: "¿Estás seguro de hacer genocidio?",
    text: "¡Una vez realizado el genocidio, no se podrán recuperar las publicaciones!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((r) => {
    if (respuesta == true) {
      swal("¡LISTO!, ¡ACABAS DE REALIZAR UN GENOCIDIO!", {
        icon: "success",
      });
      return true;
  } 
    if(respuesta == false){
      swal("¡VALE!", "no se ha eliminado ninguna publicación");
      return false;
  }
  })
  
} */

/* function ConfirmAll() {
swal({
    title: "¿Estás seguro de hacer genocidio?",
    text: "¡Una vez realizado el genocidio, no se podrán recuperar las publicaciones!",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
      swal("¡LISTO!, ¡ACABAS DE REALIZAR UN GENOCIDIO!", {
        icon: "success",
      });
    } else {
      swal("¡VALE!", "no se ha eliminado ninguna publicación");
    }
  }); 
} */
  
/*function ConfirmAll() {
  swal({
    title: "¿Estás seguro?",
    text: "Esta acción no se puede deshacer",
    icon: "warning",
    buttons: ["Cancelar", "Eliminar"],
    dangerMode: true,
  }).then((eliminar) => {
    if (eliminar) {
      // Aquí puedes realizar la eliminación de la publicación
      swal("¡Las publicaciones han sido eliminadas!", {
        icon: "success",
      });
    } else {
      swal("Ninguna publicación ha sido eliminada");
    }
  });
} */

