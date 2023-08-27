
function COnfirmDelete(){
    var respuesta = confirm("Esta segur@ de eliminar la publicacion?");

    if(respuesta == true){
        return true;
    }
    if(respuesta == false){
        return false;
    }
}

function COnfirmDeleteAdm(){
    var respuesta = confirm("Esta segur@ de eliminar este administrador y todas sus publicaciones?");

    if(respuesta == true){
        return true;
    }
    if(respuesta == false){
        return false;
    }
}

function ConfirmAll(){
    var respuesta = confirm("Esta segur@ de eliminar todas sus publicaciones?");

    if(respuesta == true){
        return true;
    }
    if(respuesta == false){
        return false;
    }
}

function ConfirmAll() {
    swal({
      title: "¿Estás seguro?",
      text: "Esta acción no se puede deshacer",
      icon: "warning",
      buttons: ["Cancelar", "Eliminar"],
      dangerMode: true,
    }).then((respuesta) => {
      if (respuesta == true) {
        swal("¡La publicación ha sido eliminada!", {
          icon: "success",
        });
      } else {
        swal("La publicación no ha sido eliminada");
      }
    });
}

function Hades(){
    var respuesta = confirm("Esta segur@ de eliminar todas las publicaciones de todos los administradores?");

    if(respuesta == true){
        return true;
    }
    if(respuesta == false){
        return false;
    }
}

function deletecoments(){
    var respuesta = confirm("Esta segur@ de eliminar este comentario?");

    if(respuesta == true){
        return true;
    }
    if(respuesta == false){
        return false;
    }
}

