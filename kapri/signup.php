<?php
  include "blog.php";

  if(!isset($_SESSION['user_root'])){
      header("Location:iniciasesion");
  }else{
    unset($_SESSION['welcome']);
  }

  if(isset($_REQUEST["added"])){
    if($_REQUEST["added"]== "DNJFJEEOIOMCJ"){     
        echo "<script> setTimeout(function(){ alert('Administrador Eliminado!');}, 100);</script>";
        header("Refresh:1.5; url= registrar"); //<!--Apartado de las leyendas al crear, eliminar o editar publicaciones-->
    }
  }
if(isset($_REQUEST["added"])){
  if($_REQUEST["added"]== "XFDJFEMMGFKLS"){     
      echo "<script> setTimeout(function(){ alert('Administrador Agregado!');}, 100);</script>";
      header("Refresh:1.5; url= registrar"); //<!--Apartado de las leyendas al crear, eliminar o editar publicaciones-->
    }
  }

  $message = '';
  $stmt = null;

  if (!empty($_POST['email']) && !empty($_POST['passw'])){
    if($_POST["passw"] == $_POST["confirm"]){
      
      $email = $_POST["email"];
      $sql = "SELECT COUNT(*) FROM ingreso WHERE email = :email";
      $state = $connect->prepare($sql);
      $state->bindParam(":email",$email);
      $state->execute();                     //se obtiene el valor de la otra tabla y se ingresa junto con todos los demas datos para previsualizarse
      $name = $state->fetchColumn();
      if ($name > 0) {
        $message = "Ya hay un administrador con ese usuario";
      } else {
        $sql = "INSERT INTO ingreso (email, passw) VALUES (:email, :passw)";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':email', $_POST['email']);
        $passw = password_hash($_POST['passw'], PASSWORD_BCRYPT);
        $stmt->bindParam(':passw', $passw);
        $stmt->execute();
        header("Location:registrar?added=XFDJFEMMGFKLS");
        //header("Refresh:0");
        exit();
      }
    }
    
    if (isset($stmt)){
      $message = 'Usuario creado correctamente';
      header("Refresh: 1; url=registrar");
    }elseif( isset($name) && $name > 0){
      $message = "Ya hay un administrador con ese usuario";
      header("Refresh: 1; url=registrar"); 
    }elseif(!isset($stmt)){
      $message = 'Las contraseñas no coinciden';
      header("Refresh: 1; url=registrar");   
    }
  }

  if(isset($_POST["usuarios"])){
    $base = base64_encode("NUEVO");
    header("Location: registrar?show=$base");

  } 

  if(isset($_POST["cerrar"])){
    header("Location: registrar");
  } 
  
?>

<!DOCTYPE html>
<html>
  <head>
    	<meta charset="UTF-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title>KAPRI</title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    	<link rel="stylesheet" href="css/style2.css">
    	<link rel="stylesheet" href="css/style3.css">
    	<link rel="shortcut icon" type="image/x-icon" href="imgs/favicon.ico.png">
    	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
	</head>

  <body>
    		<!-- PRECARGADOR -->
		<div id="st-preloader">
			<div id="pre-status">
				<div class="preload-placeholder"></div>
			</div>
		</div>
		<!-- /PRECARGADOR -->

		<!-- HEADER -->
		<header class="st-header st-fullHeight">
			<div class="header-overlay"></div><!-- /HEADER OVERLY -->
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center st-header-content">
						<div class="logo"><a title="KAPRI" href="show.php?index=0"><img width="180px" src="imgs/k.png" alt="logo" /></a></div>
						<div class="st-header-title">
							<h2><span>BLOG WEB</span>❤</h2>
							<p>CREA TU CONTENIDO A TU GUSTO <br /><i>"Todo lo grande empieza con algo pequeño"</i> </p>
						</div>
					</div>
				</div>
			</div>
			<a href="#service" class="mouse-icon hidden-xs">
				<div class="wheel"></div>
			</a>
		</header>
		<!-- /HEADER -->

    <?php foreach($admins->fetchAll() as $adm){ ?>
      <div>
        <p> <?php echo $adm["Id"] -1 ." " . $adm["email"]; ?></p>
        <form action="blog.php" method="POST">  
          <button onclick= "return COnfirmDeleteAdm()" name="delete-admin" value="<?php echo openssl_encrypt($adm["Id"],AES,KEY,0,IV); ?>">Eliminar Administrador</button>
        </form>
      </div>
    <?php }?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>
      <br> <br>

    <?php if(!isset($_REQUEST["show"])){ ?>
      <form action="signup.php" method="POST">
        <button name="usuarios" >Agregar nuevo administrador</button>
      </form><br><br>
    <?php }?>
    <?php if(isset($_REQUEST["show"])){ ?>
      
      <form action="signup.php" method="POST">
        <button name="cerrar" >X</button>
      </form><br>
      
     

      <form action="signup.php" method="POST">
        <input name="email" type="text" required placeholder="Ingresa tu correo">
        <input name="passw" type="password" id="passw" required placeholder="Ingresa una contraseña">
        <input name="confirm" type="password" id="confirm" required placeholder="confirme su contraseña">
        <input type="submit" value="Enviar" id="send">
        <button type="button" id="boton"> Ver contraseña </button>
      </form><br><br>
    <?php }?>

    <!-- FOOTER -->
		<footer class="footer">
			<div class="container">
				<div class="row">
					<!-- SOCIAL ICONS - SON LAS REDES SOCIALES DEL BLOG WEB-->
					<div class="col-sm-6 col-sm-push-6 social-icons">
						<a target="_black" title="Facebook" href="https://goo.su/3UVbOKq"><i class="fa fa-facebook"></i></a>
						<a target="_black" title="Twitter"  href="http://tiny.cc/1b37vz"><i class="fa fa-twitter"></i></a>
						<a target="_black" title="Instagram"href="http://tiny.cc/sa37vz"><i class="fa fa-instagram"></i></a>
					</div>
					<!-- /SOCIAL ICONS -->
					<div class="col-sm-6 col-sm-pull-6 copyright">
						<p>&copy; 2023 <a href="show.php">KAPRI</a>. Todos los derechos reservados.</p>
					</div>
				</div>
			</div>
		</footer>
		<!-- /FOOTER -->
		
		<!-- JS -->
		<script type="text/javascript" src="js/jquery.min.js"></script><!-- jQuery -->
		<script type="text/javascript" src="js/bootstrap.min.js"></script><!-- Bootstrap -->
		<script type="text/javascript" src="js/jquery.parallax.js"></script><!-- Parallax -->
		<script type="text/javascript" src="js/smoothscroll.js"></script><!-- Smooth Scroll -->
		<script type="text/javascript" src="js/scripts.js"></script><!-- Scripts -->
  </body>
</html>

<script>
  var showPasswordButton = document.getElementById("boton");
  var passwordInput = document.getElementById("passw");
  var confirmInput = document.getElementById("confirm");
  
  showPasswordButton.addEventListener("click", function() {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      confirmInput.type = "text";
    } else {
      passwordInput.type = "password";
      confirmInput.type = "password";
    }
  });
</script>

<script src="js/functions.js"></script>