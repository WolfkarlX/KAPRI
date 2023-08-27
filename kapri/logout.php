<?php       
  
  session_start(); //Inicia sesion

  session_unset(); //Elimina las variables de sesion que existan 'las limpia'

  session_destroy();//Se destruye la sesión actual

  if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_root'])){
    header("Location: mostrar");
  }
?>