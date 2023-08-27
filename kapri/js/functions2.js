function hades(){
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

function deletesomecoments(){
    var respuesta = confirm("Esta segur@ de eliminar todos los comentarios de esta publicacion?");

    if(respuesta == true){
        return true;
    }
    if(respuesta == false){
        return false;
    }
}