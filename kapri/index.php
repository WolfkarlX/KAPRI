<?php
    include "blog.php";

    if (!isset($_SESSION['user_id'])) {
    header("Location: iniciasesion");
    }

    if(isset($_SESSION['user_id'])){
        unset($_SESSION['welcome']);
    }

?>

<!--Hoja de impresion de las publicaciones como administrador-->
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

        <?php if(!empty($user)){ ?>
			<div class="my-btn">
				<a href="cerrarsesions"><div class="btn-fun"><h2 class=dis >CERRAR SESIÓN</h2></div></a>
				<a href="/kapri/crear"><div class="btn-fun"><h2 class=dis >CREAR ALGO NUEVO</h2></div></a>
			</div>
		<?php }?>
		<?php if(!empty($user)){ ?>
        	<form action="blog.php" method="POST">
            	<button name="destroy" onclick= "return ConfirmAll()" value="<?php echo openssl_encrypt($user["Id"],AES,KEY,0,IV); ?>"><div class="btn-fun"><h2 class=dis >ELIMINAR TODAS<br>LAS PUBLICACIONES</h2></div></button>
            </form>
    	<?php }?>

        <!--Apartado de las leyendas al crear, eliminar o editar publicaciones-->
		<?php if(isset($_REQUEST["info"])){ ?>
			<?php if($_REQUEST["info"] == "ZDYXY47864PDLDJ_FFR"){ ?>
				<?php echo "<script> setTimeout(function(){ swal('¡LISTO!','¡Publicación agregada con éxito!', 'success');}, 800);</script>";?>
				<?php header("Refresh:1.5; url=inicio");?> 
			<?php  }else if($_REQUEST["info"] == "XCBDWWYURZ22Y"){?>
				<?php echo "<script> setTimeout(function(){ swal('¡LISTO!','¡Publicación editada con éxito!', 'success');}, 800);</script>";?>
				<?php header("Refresh:1.5; url=inicio");?>
			<?php }else if(($_REQUEST["info"] == "HJFR_$*42JDU385vdE")){?>
				<?php echo "<script> setTimeout(function(){ swal('¡LISTO!','¡Publicación eliminada con éxito!', 'success');}, 800);</script>";?>
				<?php header("Refresh:1.5; url=inicio");?>
			<?php }else if(($_REQUEST["info"] == "KHNmjdndkX432")){?>
            	<?php echo "<script> setTimeout(function(){ swal('¡LISTO!','¡Publicaciones eliminadas!','success');}, 800);</script>";?>
           		<?php header("Refresh:1.5; url=inicio");?>
			<?php }?>
		<?php }?>


        <!--PANEL-->
        <div>
            <?php foreach($panel as $i){ ?>
                <div class="col-sm-4 st-service-box text-uppercase">
					<h4><b><?php echo$i["Id"]; ?> <b>➤ <a href="#"<?php echo $i["Id"]; ?>><?php echo $i["titulo"]; ?></h4></a>
                    <h6><i>Creada: <?php echo $i["fecha"];?>- Ultima vez editada:  <?php echo $i["fecha_edit"];?></i></h6>
                    <form action="blog.php" method="POST">
						<button name="panel-delete" onclick= "return COnfirmDelete()" value="<?php echo openssl_encrypt($i["Id"],AES,KEY,0,IV); ?>"><img title="Eliminar publicación" width="25px" src="imgs/basura.png"></button>
                    </form>                 
                </div>
            <?php } ?>
			
			<hr style="width: 100%; height: 5px; background: blue">
			<hr style="width: 100%; height: 5px; background: blue">
		</div>
		<h1><span>PUBLICACIONES</span></h1>
        
        <!--IMPRESION DE PUBLICACIONES (TITULO, FECHA, CONTENIDO, IMAGEN)-->
        <section id="service"  class="fondo">
            <div class="container">
                <?php foreach($query as $r){ ?>
                    <div class="write largo-publications text-publications">
                        <hr style="width: 100%; height: 5px; background: blue">
                        <h3 id="<?php echo $r["Id"]; ?>"><?php echo $r["titulo"]; ?></h3>
						<h6><i> Creada: <?php echo $r["fecha"];?>- Ultima vez editada: <?php echo $r["fecha_edit"];?> </i></h6>
						<p><?php echo $r["contenido"];?></p>
						<!--FUNCIONALIDAD PARA QUE LAS IMAGENES TENGAN EXPANSION Y AUMENTO-->
						<div class="ful-img" id="fulImgBox">
							<img src="" id="fulImg" alt="">
							<span onclick="closeImg()"><img src="imgs/x.png" class="cerrar" alt="CERRAR"></span>    
						</div>
						<div class="img-gallery-cont">
							<img width="" height="" src=" img/<?php echo $r["imagen"];?>" onclick="openFulImg(this.src)" alt="">
						</div>
                        <div class="comentarios">
                        <h3><span><b>⸻⸻⸻ COMENTARIOS ⸻⸻⸻</h3></span></b>
							<?php
								$id = $r["Id"]; 
								$get_commments = "SELECT * FROM comentarios WHERE publicacion = :id ORDER BY Id DESC LIMIT 2";
								$state = $connect->prepare($get_commments);
								$state->bindParam(':id',$id);
								$state->execute();
								$comments_added = $state->fetchAll(PDO::FETCH_ASSOC);
							?>
                            <?php foreach($comments_added as $j){?>
								<div>
									<h3>Fecha de creacion: <?php echo $j["fecha"];?></h3>
									<p><?php echo $j["contenido"];?></p>
								</div>
							<?php }?>
                            <div class="my-btn write">
							    <a href="content.php?blog=<?php echo openssl_encrypt($r["Id"],AES,KEY,0,IV);?>"><div class="btn-fun"><h2 class=dis >VER MÁS</h2></div></a>
                            </div>
                            <hr style="width: 100%; height: 5px; background: blue">
                        </div>
                    </div>
                <?php } ?>
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
<script src="js/functions.js"></script>
<script src="js/script.js"></script>