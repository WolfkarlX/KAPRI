<?php
include "blog.php";
 //aqui reenvia al login si no te has iniciado y te reenvia a donde estabas si la sesion welcome no esta definida 
if (!isset($_SESSION['user_id']) and !isset($_SESSION['user_root'])){
	header("Location: iniciasesion");
}

if (!isset($_SESSION['welcome']) and isset($_SESSION['user_id'])){
	header("Location: inicio");
}

if (!isset($_SESSION['welcome']) and isset($_SESSION['user_root'])){
	header("Location: admin");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    	<meta charset="UTF-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title>KAPRI</title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    	<link rel="stylesheet" href="css/style4.css">
    	<link rel="shortcut icon" type="image/x-icon" href="imgs/k.png">
    	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
	</head>

    <body>
		<?php if(isset($_SESSION["user_id"])){?>
			<?php if(!empty($user)){ ?>
				<h1><br>Bienvenido(a) <?= $user['email']; ?></h1><br><br>
				<!--<br><br><br><br><a href="#" class="venida">SEGUIR</a>-->
			<?php }?>
		<?php }?>
		
		<?php if(isset($_SESSION["user_root"])){?>
			<?php if(!empty($master)){ ?>
				<h1><br>Bienvenido(a) <?= $master['email']; ?></h1><br><br>
				<!--<br><br><br><br><a href="#" class="venida">SEGUIR</a>-->
			<?php }?>
		<?php }?>
		
    </body>
</html>

<?php 
	if(isset($_SESSION['user_id'])){ //aqui te reenvia al inicio dependiendo de si es admin root o no
		header("Refresh:3; url=inicio");
	}                                       //se le puede cambiar el tiempo en el que te reenvia la pagina 
	if(isset($_SESSION['user_root'])){
		header("Refresh:3; url=admin");
	}
?>