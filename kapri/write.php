<?php
include "blog.php";
//Impresion de el apartado de escribir para crear nueva publicacion
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_root'])) {
        header("Location: iniciasesion");
    }

    if(isset($_SESSION['user_id'])){
        $kapri = "inicio";
        unset($_SESSION['welcome']);
    }elseif(isset($_SESSION['user_root'])){
        $kapri = "admin";
        unset($_SESSION['welcome']);
    }
?>

<!DOCTYPE html>
<html lang="es">
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
        
		<!-- HEADER -->
		<header class="st-header st-fullHeight">
			<div class="header-overlay"></div><!-- /HEADER OVERLY -->
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center st-header-content">
                    <div class="logo"><a title="KAPRI" href="inicio"><img width="180px" src="imgs/k.png" alt="logo" /></a></div>
						<div class="st-header-title">
							<h2><span>BLOG WEB</span>❤</h2>
							<p><br /><i>"Todo lo grande empieza con algo pequeño"</i> </p>
						</div>
					</div>
				</div>
			</div>
			<a href="#service" class="mouse-icon hidden-xs">
				<div class="wheel"></div>
			</a>
		</header>
		<!-- /HEADER -->
    <body>
        <section id="service"  class="fondo"><br><br>
            <div class="container">
                <div class="write largo-publications text-publications">
                    <hr style="width: 100%; height: 5px; background: blue">
                        <?php if (isset($_REQUEST["in"])){ ?>
                            <?php if($_REQUEST["in"] == "publicacion"){  //condicional por si se encuentra en la pagina que quiero y no ha presionado el boton?>
                                <div>
                                    <h3>¡SIEMPRE HAY ALGO QUE COMPARTIR!</h3><img width="80px" title="crear" alt="ícono de lápiz plano" src="imgs/write.png"><br>   
                                    <form action="blog.php" method="POST" enctype="multipart/form-data">
                                        <input class="estilotextarea" type="text" placeholder="Titulo" name="titulo" required><br><br>
                                        <textarea class="estilotextarea" name="contenido" placeholder="Contenido" required></textarea> <br> <br>
                                        <p>Ingrese una imagen porfavor</p>
                                        <input class="center" type="file" accept=".jpeg, .png, .jpg " name="image"  required>
                                        <hr style="width: 100%; height: 5px; background: blue">
                                        <div class="my-btn">
                                            <button name="ready"><div class="btn-fun"><h2 class=dis >LISTO</h2></div></button></button>
                                            <button name="see"><div class="btn-fun"><h2 class=dis >PREVISUALIZAR</h2></div></button>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                        <?php }?>
                    </div>
                    <div class="write">
                        <hr style="width: 100%; height: 5px; background: blue">
                        <?php if(isset($_REQUEST["look"])){?>
                            <?php if($_REQUEST["look"] == "Previsualizar"){//Condicional de si se ha presionado el boton?>
                                <?php foreach($pre->fetchAll() as $r){ ?>
                                        <h2>¡SIEMPRE HAY ALGO QUE COMPARTIR!</h2><img width="80px" title="crear" alt="ícono de lápiz plano" src="imgs/write.png"><br>
                                        <form action="blog" method="POST" enctype="multipart/form-data">
                                            <input class="estilotextarea"  id="texto-inputt" type="text" placeholder="Titulo" name="titulo" value="<?php echo $r["titulo"]; ?>" required><br><br>
                                            <textarea class="estilotextarea" id="texto-inputp" name="contenido" placeholder="Contenido" required><?php echo $r["contenido"]; ?></textarea> <br> <br>
                                            <p>Ingrese una imagen porfavor</p>
                                            <input class="center" type="file" accept=".jpeg, .png, .jpg " name="image" id="imagen-input" required>
                                            <div class="my-btn">
                                                <button name="ready"><div class="btn-fun"><h2 class=dis >LISTO</h2></div></button>
                                            </div>
                                        </form>

                                    <div class="largo-publications text-publications">
                                        <h4 id="<?php echo $r["Id"]; ?>"><?php echo $r["titulo"]; ?></h4>
                                        <p> Creada: <?php echo $r["fecha"];?>- Ultima vez editada: <?php echo $r["fecha_edit"];?></p>
                                        <p id="Cont"><?php echo $r["contenido"];?></p>
                                        <img id="imagen-mostrada" src="img/<?php echo $r["imagen"];?>" width="400px" height="">
                                    </div>

                                    <script>
                                        var textoInputt = document.getElementById("texto-inputt");
                                        var textoInputp = document.getElementById("texto-inputp");

                                        var textoMostradot = document.getElementById("<?php echo $r["Id"]; ?>");
                                        var textoMostradop = document.getElementById("Cont");

                                        textoInputt.addEventListener("input", function() {
                                            textoMostradot.textContent = textoInputt.value;
                                        });

                                        textoInputp.addEventListener("input", function() {
                                            textoMostradop.textContent = textoInputp.value;
                                        });
                                    </script>

                                <?php }?>
                            <?php } ?>
                        <?php }?>
                        <hr style="width: 100%; height: 5px; background: blue">
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
		<footer class="footer">
			<div class="container">
				<div class="row">
					<!-- SOCIAL ICONS -->
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

    var inputImagen = document.getElementById("imagen-input");
    var imagenMostrada = document.getElementById("imagen-mostrada");

    // Restaurar la imagen seleccionada si se encuentra almacenada en localStorage
    if (localStorage.getItem("imagenSeleccionada")) {
    imagenMostrada.src = localStorage.getItem("imagenSeleccionada");
    }

    inputImagen.addEventListener("change", function() {
    var imagenSeleccionada = inputImagen.files[0];
    var imagenURL = URL.createObjectURL(imagenSeleccionada);
    imagenMostrada.src = imagenURL;

    // Guardar la imagen seleccionada en localStorage
    localStorage.setItem("imagenSeleccionada", imagenURL);
    });

    // Limpiar localStorage después de enviar el formulario
    document.querySelector("form").addEventListener("submit", function() {
    localStorage.removeItem("imagenSeleccionada");
    });
</script>

