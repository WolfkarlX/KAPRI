<?php               //zona del funcionamiento del login
  include "blog.php";
  //Si ya hay una sesión iniciada se redirige a la página principal
  if (isset($_SESSION['user_id'])) {
      header("Location: inicio");
  }
  if (isset($_SESSION['user_root'])) {
    header("Location: admin");
}
if(isset($_SESSION["chat"]) or isset($_SESSION["adm"])){
  session_unset();
  session_destroy();
}
  //Si se envió un formulario con correo y contraseña
  if (!empty($_POST['email']) && !empty($_POST['passw'])){
      //Consulta del id, correo y contraseña de la tabla 'ingreso' que coincidan
      $records = $connect->prepare('SELECT Id, email, passw FROM ingreso WHERE email=:email');
      $records->bindParam(':email', $_POST['email']);
      //Hace la consulta y los resultados
      $records->execute();
      $results = $records->fetch(PDO::FETCH_ASSOC);
      //Guarda un mensaje de error si la contra o usuario es incorrecto
      $message = '';

      //Si se encontro un registro y si la contraseña es real
      if (!empty($results) > 0 && password_verify($_POST['passw'], $results['passw'])){
        if($results['Id']!=1){  
          $_SESSION['user_id'] = $results['Id'];
          //Redireccion a la pagina principal
          $_SESSION['welcome'] = "Bienvenido";
          header("Location: bienvid@");
        }
        if($results['Id'] == 1){
            $_SESSION['user_root'] = $results['Id'];
            header("Location: bienvid@");
            $_SESSION['welcome'] = "Bienvenido";
        }
      }else{ $message = 'Los datos son incorrectos';}
  }
    
?>

<!--Hoja de impresion del menu del login-->
<!DOCTYPE html>
<html lang="es">

	<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="css/style5.css">
    <link rel="shortcut icon" type="image/x-icon" href="imgs/k.png">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
		<script src="https://kit.fontawesome.com/a81368914c.js"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	</head>

	<body>
		<img class="wave" src="imgs/nube.png">
            <a href="mostrar"><img class="flecha" src="imgs/flecha1.png" title="Regresar" height="60px"><a>
			<div class="container">
				<div class="img">
					<img src="imgs/selfie.png">
				</div>

				<?php echo "<script> setTimeout(function(){ swal('LOGIN', 'INICIA SESIÓN', 'info');}, 200);</script>";  ?>

				<?php if (!empty($message)) : ?>
					<p> <?= $message ?> </p>
				<?php endif;?>

				<div class="login-content">
					<form action="login.php" method="post">
						<img  src="imgs/lock.gif">
						<h2 class="title">LOGIN</h2>
						<div class="input-div one">
						<div class="i">
								<i class="fas fa-user"></i>
						</div>

						<div class="div">
								<h5>Usuario</h5>
								<input autocomplete="on" type="text" name="email" id="form2Example11" class="input">
						</div>
						</div>
						<div class="input-div pass">
						<div class="i"> 
								<i class="fas fa-lock"></i>
						</div>
						<div class="div">
								<h5>Contraseña</h5>
								<input type="password" name="passw" id="form2Example22" class="input">
						</div>
						</div>
						<input type="submit" class="btn-log" value="ACCEDER"> <span>
					</form>
				</div>
			</div>
		<script type="text/javascript" src="js/main.js"></script>
		<head>
            <title></title>
                <style>
                    *{
                    margin: 0;
                    padding: 0;
                    }
                    body{
                    width: 100%;
                    height: 100vh;
                    color: #fff;
                    background: linear-gradient(100deg, #fff, #fff, #00AEFF, #fff, #fff);
                    background-size: 400% 400%;
                    position: right;
                    animation: cambiar 25s ease-in-out infinite;
                    }

                    @keyframes cambiar{
                    0%{background-position: 0 50%;}
                    50%{background-position: 100% 50%;}
                    100%{background-position: 0 50%;}
                    }
                </style>
    	</head>
	</body>
</html>