<?php 
    include "blog.php"; 

    //Hoja de impresion dentro del "ver mas"
    if (!isset($_SESSION['user_id']) and !isset($_SESSION['user_root'])){
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

        <section id="service" class="fondo">
            <div class="container">
                <div class="write largo-publications">
                    <hr style="width: 100%; height: 5px; background: blue">
                    <?php foreach($query as $r){?>    
                        <div class="text-publications">
                            <div class="my-btn">
                                <a href="edit.php?blog=<?php echo openssl_encrypt($r["Id"],AES,KEY,0,IV);?>"><div class="btn-fun"><h2 class=dis >EDITAR</h2></div></a> 
                                <button name="delete" onclick= "return COnfirmDelete()"><div class="btn-fun"><h2 class=dis >ELIMINAR</h2></div></button>
                            </div>
                            <h3><?php echo $r["titulo"];?></h3>
                            <form method="POST" name="eliminate" enctype="multipart/form-data">
                                <div>
                                    <h6><i>Creada: <?php echo $r["fecha"];?>-  Ultima vez editada: <?php echo $r["fecha_edit"];?> </i></h6>
                                    <input type="text" hidden name="Id" value="<?php echo openssl_encrypt($r["Id"],AES,KEY,0,IV); ?>">   
                                </div>
                            </form>
                            <?php $ID = openssl_encrypt($r["Id"],AES,KEY,0,IV);?>
                            <p><?php echo $r["contenido"];?></p>
                            <!--FUNCIONALIDAD PARA QUE LAS IMAGENES TENGAN EXPANSION Y AUMENTO-->
                            <div class="ful-img" id="fulImgBox">
                                <img src="" id="fulImg" alt="">
                                <span onclick="closeImg()"><img src="imgs/x.png" class="cerrar" alt="CERRAR"></span>    
                            </div>
                            <div class="img-gallery-cont">
                                <img width="" height="" src=" img/<?php echo $r["imagen"];?>" onclick="openFulImg(this.src)" alt="">
                            </div>
                            <script src="js/script.js"></script><!--Link del java script donde anda la funcion-->

                            <div class="comentarios"> 
                                
                                <form action="blog.php" method="POST">
                                    <div class="my-btn write">
                                        <button name="delete-all-comments" onclick="return deletesomecoments()" value="<?php echo openssl_encrypt($r["Id"],AES,KEY,0,IV);?>"><div class="btn-fun"><h2 class=dis >ELIMINAR TODOS<br>LOS COMENTARIOS</h2></div></button>
                                    </div>
                                </form>
                                <p>⸻⸻⸻ COMENTARIOS ⸻⸻⸻</p>
                                <?php foreach($comments_added as $i){?>
                                    <h3><b>Creado:<?php echo $i["fecha"];?></h3></b>
                                    <p><span><?php echo $i["contenido"];?></span></p>
                                    <form action="blog.php" method="POST">
                                        <input name="id" value="<?php echo openssl_encrypt($r["Id"],AES,KEY,0,IV); ?>" hidden type="text">
                                        <button name="delete-comments" onclick="return deletecoments()" value="<?php echo openssl_encrypt($i["Id"],AES,KEY,0,IV); ?>"><img title="Eliminar comentario" width="25px" src="imgs/basura.png"></button>
                                    </form>
                                    <hr style="width: 100%; height: 5px; background: blue">
                                <?php }?>
                            </div>
                            <hr style="width: 100%; height: 5px; background: blue">
                        </div>
                    <?php }?>
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
<?php 
    if(isset($_REQUEST["succes"])){
        if($_REQUEST["succes"] == "CJDBHJKDE"){
            echo "<script> setTimeout(function(){ swal('¡LISTO!','¡Comentario Eliminado!','success';}, 800);</script>";
            header("Refresh:1.5; url= content.php?blog=$ID"); //<!--Apartado de las leyendas al crear, eliminar o editar publicaciones-->
        }
    }
    if(isset($_REQUEST["succes"])){
        if($_REQUEST["succes"] == "CFNEKUDJSGR"){
            echo "<script> setTimeout(function(){ swal('¡LISTO!','¡Publicaciones eliminadas!','success');}, 800);</script>";
            header("Refresh:1.5; url= content.php?blog=$ID"); //<!--Apartado de las leyendas al crear, eliminar o editar publicaciones-->
        }
    }
    
?>
<script src="js/functions.js"></script>
<script src="js/functions2.js"></script>