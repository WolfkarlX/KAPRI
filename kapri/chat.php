<?php 
    include "blog.php";
    
    if(!isset($_SESSION["chat"]) and !isset($_SESSION["adm"])){
        header("Location: publicaciones");
    }
    if(isset($_SESSION["user_root"])){
        header("Location: admin");
    }
    if(isset($_SESSION["user_id"])){
        header("Location: inicio");
    }
    if(isset($_POST["addCom"])){
        header("Location: comentar");
    }
?>

<?php 
    if(isset($_REQUEST["comment"])){
        if($_REQUEST["comment"]== "ZDYXY47864PDLDJ_FFR"){    
            echo "<script> setTimeout(function(){ swal('¡LISTO!','¡Comentario Agregado!','success');}, 800);</script>";
            header("Refresh:8; url= comentarios"); //<!--Apartado de las leyendas al crear, eliminar o editar publicaciones-->
        } 
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

		<link rel="stylesheet" href="css/style2.css">
		<link rel="stylesheet" href="css/style3.css">
		<link rel="shortcut icon" type="image/x-icon" href="imgs/favicon.ico.png">
		<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
	</head>

    <body>
        <!-- HEADER -->
        <header class="st-header st-fullHeight">
            <div class="header-overlay"></div><!-- /HEADER OVERLY -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center st-header-content">
                        <div class="logo"><a title="KAPRI" href="mostrar"><img width="180px" src="imgs/k.png" alt="logo" /></a></div>
                        <div class="st-header-title">
                            <h2><span>BLOG WEB</span>❤</h2>
                            <p><i>"Todo lo grande empieza con algo pequeño"</i> </p>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#service" class="mouse-icon hidden-xs">
            <div class="wheel"></div>
            </a>
            </header>
            <!-- /HEADER -->
        <section id="service" class="fondo">
            <div class="container">
                <div class="write largo-publications">
                    <?php foreach($coments as $i){ ?>
                        <div class="text-publications">
                            <hr style="width: 100%; height: 5px; background: blue">
                            <h5><i>Creada por: <?php echo $i["creador"]; ?></i></h5>
                            <h3 id="<?php echo $i["Id"]?>"><?php echo $i["titulo"]; ?></h3>
                            <h6><i>Creada: <?php echo $i["fecha"];?>- Ultima vez editada: <?php echo $i["fecha_edit"];?> </i></h6>
                            <p><?php echo $i["contenido"]; ?></p>
                            <div class="ful-img" id="fulImgBox">
                                <img src="" id="fulImg" alt="">
                                <span onclick="closeImg()"><img src="imgs/x.png" class="cerrar" alt="CERRAR"></span>
                            </div>
                            <div class="img-gallery-cont">
                                <img width="" height="" src=" img/<?php echo $i["imagen"];?>" onclick="openFulImg(this.src)" alt="">
                            </div><br>
                            <script src="js/script.js"></script><!--Link del java script donde anda la funcion-->
                        </div>
                    <?php } ?>
                    <div class="comentarios">    
                        <?php if(isset($succes)){ ?>
                            <p> <?php echo $succes; ?></p>
                        <?php }?>
                        
                        <?php if(!isset($_REQUEST["ind"])){?>
                            <div class="my-btn">
                                <form action="chat.php" method="POST">
                                    <button name="addCom"><div class="btn-fun"><h2 class=dis >AGREGAR COMENTARIO</h2></div></button>
                                </form>
                            </div>
                            
                        <?php }?>
                        
                        <?php if(isset($_REQUEST["ind"])){?>
                            <p>INGRESE AQUÍ SU COMENTARIO</p>
                            <form action="blog.php" method="POST">
                                <textarea class="estilotextarea" name="comentary" cols="30" rows="10" placeholder="Comentario" required></textarea> <br>
                                <div class="my-btn">
                                    <button name="comentadd"><div class="btn-fun"><h2 class=dis >¡COMENTAR!</h2></div></button>
                                </div>
                            </form>
                        <?php }?>
                        <h3><span><b>⸻⸻⸻ COMENTARIOS DE LA PUBLICACIÓN ⸻⸻⸻</b></span></h3>
                        <?php foreach($comments_added as $r){?>
                            <div class="largo">
                                <h3><b>Fecha de creacion: <?php echo $r["fecha"];?></b></h3>
                                <p><span><?php echo $r["contenido"];?></span></p>
                            </div>
                        <?php }?>
                    </div>
                    <hr style="width: 100%; height: 5px; background: blue">
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