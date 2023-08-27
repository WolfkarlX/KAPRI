<?php       
    session_start(); //Inicia sesion
    //Hoja principal donde se configura toda la parte del administrador
    define("KEY", "Kapri123");
    define("IV", "1234567890123456");
    define("AES", "AES-128-CTR");

    date_default_timezone_set("America/Costa_Rica");

    $dsn = "mysql:host=" . "localhost" . ";dbname=" . "blog";
    $connect = new PDO($dsn, "root", "");       //establece la coneccion con la base de datos

    $adm = "SELECT * FROM ingreso WHERE Id NOT IN (SELECT MIN(Id) FROM ingreso)";
    $admins = $connect->query($adm);

    if(!$connect){
        echo "<h1>No se realizo la coneccion <h1>";

    }
   
    if(isset($_SESSION['user_id'])){
        $adm = $_SESSION['user_id'];
        $ingresar = "SELECT * FROM datos WHERE adm = :adm ORDER BY Id DESC ";
        $stmt = $connect->prepare($ingresar);
        $stmt->bindParam(':adm', $adm);
        $stmt->execute();
        $query = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $panel = $query;
        $revisar =  "SELECT * FROM ver ORDER BY Id limit 1";
        $pre = $connect ->query($revisar);
    }

    if(!isset($_SESSION['user_id'])){
        $ingresar = "SELECT * FROM datos ORDER BY Id DESC ";
        $panel = $connect->query($ingresar);
        $query = $connect->query($ingresar);
    }
    
    if(isset($_SESSION['user_root'])){
        $ingresar = "SELECT * FROM datos ORDER BY Id DESC ";
        $revisar =  "SELECT * FROM ver ORDER BY Id limit 1";
        $query = $connect->query($ingresar);
        $panel = $connect->query($ingresar);
        $pre = $connect ->query($revisar);

    }

    if(isset($_SESSION['user_id'])) { //Si la variable 'user_id' está definida
        $records = $connect->prepare('SELECT Id, email, passw FROM ingreso WHERE Id = :id'); //Consulta la informacion del usuario almacenado en 'user_id'
        $records->bindParam(':id', $_SESSION['user_id']); //Vincula el valor de 'user_id' a ':id' en la consulta de SQL
        $records->execute(); //Se hace la consulta
        $results = $records->fetch(PDO::FETCH_ASSOC); //Se obtiene la consulta

        $user = null;                                       //comenta esto ramon
        
        //Si se encontró alguna fila de la BD en los resultados asigna la info del usuario en '$user'
        if (count($results) > 0){
            $user = $results;
        }
    }

    if(isset($_SESSION['user_root'])) { //Si la variable 'user_root' está definida
        $records = $connect->prepare('SELECT Id, email, passw FROM ingreso WHERE Id = :id'); //Consulta la informacion del usuario almacenado en 'user_id'
        $records->bindParam(':id', $_SESSION['user_root']); //Vincula el valor de 'user_id' a ':id' en la consulta de SQL
        $records->execute(); //Se hace la consulta
        $results = $records->fetch(PDO::FETCH_ASSOC); //Se obtiene la consulta

        $master = null;                                       
        
        //Si se encontró alguna fila de la BD en los resultados asigna la info del usuario en '$user'
        if (count($results) > 0){
            $master = $results;
        }
    }
    
    if(isset($_POST["ready"])){
        $title = $_POST["titulo"];
        $content = $_POST["contenido"];
        $fecha = date('d-m-y g:i A');                   //condicionamiento de la obtencion de imagenes y texto del formulario o html
        $ID = "Id";
        
        if(isset($_SESSION['user_id'])){                    //se ejecuta la eliminacion de la publicacion     
            $adm_K = $_SESSION['user_id'];
        }elseif(isset($_SESSION['user_root'])){
            $adm_K = $_SESSION['user_root'];
        }

        if(isset($user)){
            $Maker = $user["email"];
        }elseif(isset($master)){
            $Maker = $master["email"];
        }

        if($_FILES['image']['error'] === 4){
            header("Location: noexiste.php");
        }else{
            $nombre_imagen = $_FILES['image']['name'];
            $imagen_tam = $_FILES['image']['size'];
            $archivo_tmp = $_FILES['image']['tmp_name'];
            $exten = ['jpg', 'jpeg', 'png'];
            $extencion = explode('.',$nombre_imagen);
            $extencion = strtolower(end($extencion));       //Asigna valores para la creacion de una publicacion
            if(!in_array($extencion, $exten)){
                header("Location: extinvalida.php");

            }elseif($imagen_tam > 256000000){
                header("Location: errorpesado.php");
            }
            else{
                $nueva = uniqid();
                $nueva .= '.' . $extencion;
                move_uploaded_file($archivo_tmp, 'img/' . $nueva);
                $ingresar = "INSERT INTO datos(titulo, contenido, fecha, imagen, adm, creador)VALUES (:titulo, :contenido, :fecha, :nueva, :adm_K, :Maker)"; //introduce los valores a la base de datos
                $stmt = $connect->prepare($ingresar);
                $stmt->bindParam(':Maker', $Maker);
                $stmt->bindParam(':adm_K', $adm_K);
                $stmt->bindParam(':nueva', $nueva);
                $stmt->bindParam(':titulo', $title,PDO::PARAM_STR);
                $stmt->bindParam(':contenido',$content,PDO::PARAM_STR);
                $stmt->bindParam(':fecha', $fecha,PDO::PARAM_STR);
                $query = $stmt->execute();
                if(isset($_SESSION['user_id'])){                    //se ejecuta la eliminacion de la publicacion     
                    header("Location:inicio?info=ZDYXY47864PDLDJ_FFR");
                }elseif(isset($_SESSION['user_root'])){
                    header("Location:admin?info=ZDYXY47864PDLDJ_FFR");
                }
                exit();
            }
        }
    }
    
    
    if(isset($_REQUEST["blog"])){
        $id = openssl_decrypt($_REQUEST["blog"],AES,KEY,0,IV);                               //funcionalidad que hace el boton "ver mas"
        $ingresar = "SELECT * FROM datos WHERE Id = ?";
        $stmt = $connect ->prepare($ingresar);
        $stmt->execute([$id]);
        $query = $stmt->fetchAll();

        $get_commments = "SELECT * FROM comentarios WHERE publicacion = :id ORDER BY Id DESC";
        $state = $connect->prepare($get_commments);
        $state->bindParam(':id',$id);
        $state->execute();
        $comments_added = $state->fetchAll(PDO::FETCH_ASSOC);  
    }

    if(isset($_REQUEST["edit"])){
        $title = $_POST["titulo"];
        $content = $_POST["contenido"];         //obtencion de la imagen y texto de el apartado de edicion
        $Id = openssl_decrypt($_POST["Id"],AES,KEY,0,IV);  
        $fecha = date('d-m-y g:i A');
        
        $nombre_imagen = $_FILES['image']['name'];
        $imagen_tam = $_FILES['image']['size'];
        $archivo_tmp = $_FILES['image']['tmp_name'];
        $exten = ['jpg', 'jpeg', 'png'];
        $extencion = explode('.',$nombre_imagen);
        $extencion = strtolower(end($extencion));
        if(!in_array($extencion, $exten) && !empty($extencion)){
            header("Location: extinvalida.php");

        }elseif($imagen_tam > 256000000){
            header("Location: errorpesado.php");
        }elseif(!in_array($extencion, $exten) && empty($extencion)){                
            $ingresar = "UPDATE datos SET titulo = :titulo, contenido = :contenido, fecha_edit = :fecha WHERE Id = :Id"; //actualizacion de datos de la tabla de la base de datos
            $stmt = $connect->prepare($ingresar);
            $stmt->bindParam(':titulo', $title,PDO::PARAM_STR);
            $stmt->bindParam(':contenido',$content,PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha,PDO::PARAM_STR); 
            $stmt->bindParam(':Id', $Id,PDO::PARAM_INT);
            $query = $stmt->execute();
            if(isset($_SESSION['user_id'])){                    //se ejecuta la eliminacion de la publicacion     
                header("Location:inicio?info=XCBDWWYURZ22Y");
            }elseif(isset($_SESSION['user_root'])){
                header("Location:admin?info=XCBDWWYURZ22Y");
            }
            exit();

        }
        else{
            $nueva = uniqid();
            $nueva .= '.' . $extencion;
            move_uploaded_file( $archivo_tmp, 'img/' . $nueva);
            $ingresar = "UPDATE datos SET titulo = :titulo, contenido = :contenido, fecha_edit = :fecha, imagen = :nueva WHERE Id = :Id"; //ingresar datos a la tabla de la base de datos en caso de que 
            $stmt = $connect->prepare($ingresar);                                                                                               //se encuentre una imagen
            $stmt->bindParam(':nueva', $nueva);
            $stmt->bindParam(':titulo', $title,PDO::PARAM_STR);
            $stmt->bindParam(':contenido',$content,PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha,PDO::PARAM_STR); 
            $stmt->bindParam(':Id', $Id,PDO::PARAM_INT);
            $query = $stmt->execute();
            if(isset($_SESSION['user_id'])){                    //se ejecuta la eliminacion de la publicacion     
                header("Location:inicio?info=XCBDWWYURZ22Y");
            }elseif(isset($_SESSION['user_root'])){
                header("Location:admin?info=XCBDWWYURZ22Y");
            }
            exit();
        }
    
    }

    if(isset($_POST["delete"])){
        $id = openssl_decrypt($_POST["Id"],AES,KEY,0,IV);
        $ingresar = "DELETE FROM datos WHERE Id = ?";           //Funcionalidad del boton
        $stmt = $connect ->prepare($ingresar);                      //Eliminar
        $stmt->execute([$id]);
        $query = $stmt->fetchAll();
        $restart = "ALTER TABLE datos AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($restart);

        $sql = "DELETE FROM comentarios WHERE publicacion = ?";
        $state = $connect ->prepare($sql);                      //Eliminar
        $state->execute([$id]);
        $reset = "ALTER TABLE comentarios AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($reset);

        if(isset($_SESSION['user_id'])){                    //se ejecuta la eliminacion de la publicacion     
            header("Location:inicio?info=HJFR_$*42JDU385vdE");
        }elseif(isset($_SESSION['user_root'])){
            header("Location:admin?info=HJFR_$*42JDU385vdE");
        }
        exit();
    }

    
    if(isset($_REQUEST["index"])){
        $ingresar = "SELECT * FROM datos ORDER BY Id Desc limit 1 ";
        $query = $connect -> query($ingresar);                                          //se obtienen los valores de las publicaciones y se 
        $tabla = "SELECT * FROM datos ORDER BY Id Desc LIMIT 1, 18446744073709551615";  //imprimen para la vista principal del blog
        $table = $connect -> query($tabla);

    }

    if(isset($_POST["see"])){
        $title = $_POST["titulo"];
        $content = $_POST["contenido"];
        $fecha = date('d-m-y g:i A');   //funcionalidad del boton "previsualizar"
        $Id = 1;

        $nombre_imagen = $_FILES['image']['name'];
        $imagen_tam = $_FILES['image']['size'];
        $archivo_tmp = $_FILES['image']['tmp_name'];
        $exten = ['jpg', 'jpeg', 'png'];
        $extencion = explode('.',$nombre_imagen);
        $extencion = strtolower(end($extencion));
        if(!in_array($extencion, $exten) && !empty($extencion)){
            header("Location: extinvalida.php");
        }elseif($imagen_tam > 256000000){
            header("Location: errorpesado.php");
        }elseif(!in_array($extencion, $exten) && empty($extencion)){
            $delete = "DELETE FROM ver";
            $connect->exec($delete);
            $restart = "ALTER TABLE ver AUTO_INCREMENT = 1"; //Se resetea el Id y se elimina
            $connect -> exec($restart);                                 //la anterior publicacion
            $ingresar = "INSERT INTO ver(titulo, contenido, fecha)VALUES (:titulo, :contenido, :fecha)";
            $stmt = $connect->prepare($ingresar);
            $stmt->bindParam(':titulo', $title,PDO::PARAM_STR);
            $stmt->bindParam(':contenido',$content,PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha,PDO::PARAM_STR);
            $query = $stmt->execute();
            header("Location:previsualizar");
            exit();
        }
        else{
            $nueva = uniqid();
            $nueva .= '.' . $extencion;
            move_uploaded_file( $archivo_tmp, 'img/' . $nueva);
            $delete = "DELETE FROM ver";
            $connect->exec($delete);
            $restart = "ALTER TABLE ver AUTO_INCREMENT = 1";
            $connect -> exec($restart);                             //ejecutar el ingreso de los datos si se encuentra una imagen
            $ingresar = "INSERT INTO ver(titulo, contenido, fecha, imagen)VALUES (:titulo, :contenido, :fecha, :nueva)";
            $stmt = $connect->prepare($ingresar);
            $stmt->bindParam(':nueva', $nueva);
            $stmt->bindParam(':titulo', $title,PDO::PARAM_STR);
            $stmt->bindParam(':contenido',$content,PDO::PARAM_STR);
            $stmt->bindParam(':fecha', $fecha,PDO::PARAM_STR); 
            $query = $stmt->execute();
            header("Location:previsualizar");
            exit();
        }
    }


    if(isset($_POST["watch"])){
        $title = $_POST["titulo"];
        $content = $_POST["contenido"];
        $fecha_edit = date('d-m-y g:i A');   //funcionalidad del boton "previsualizar de edicion"
        $Id = 1;
        $ID = $_REQUEST["blog"];
        $iD = openssl_decrypt($_REQUEST["blog"],AES,KEY,0,IV);
        $fecha = "SELECT fecha FROM datos WHERE Id = ?";
        $state = $connect->prepare($fecha);
        $state->execute([$iD]);                     //se obtiene el valor de la otra tabla y se ingresa junto con todos los demas datos para previsualizarse
        $fecha = $state->fetchColumn();
        

        $nombre_imagen = $_FILES['image']['name'];
        $imagen_tam = $_FILES['image']['size'];
        $archivo_tmp = $_FILES['image']['tmp_name'];
        $exten = ['jpg', 'jpeg', 'png'];
        $extencion = explode('.',$nombre_imagen);
        $extencion = strtolower(end($extencion));
        if(!in_array($extencion, $exten) && !empty($extencion)){
            header("Location: extinvalida.php");

        }elseif($imagen_tam > 256000000){
            header("Location: errorpesado.php");
        }elseif(!in_array($extencion, $exten) && empty($extencion)){
            $delete = "DELETE FROM ver";
            $connect->exec($delete);
            $restart = "ALTER TABLE ver AUTO_INCREMENT = 1"; //Se resetea el Id y se elimina  //la anterior publicacion
            $connect -> exec($restart);
            $input = "SELECT imagen FROM datos WHERE Id = ?";
            $state = $connect->prepare($input);
            $state->execute([$iD]);                     //se obtiene el valor de la otra tabla y se ingresa junto con todos los demas datos para previsualizarse
            $inside = $state->fetchColumn();                                
            $ingresar = "INSERT INTO ver(titulo, contenido, fecha_edit, imagen, fecha)VALUES (:titulo, :contenido, :fecha_edit, :inside, :fecha)";
            $stmt = $connect->prepare($ingresar);
            $stmt->bindParam(':titulo', $title,PDO::PARAM_STR);
            $stmt->bindParam(':contenido',$content,PDO::PARAM_STR);
            $stmt->bindParam(':fecha_edit', $fecha_edit,PDO::PARAM_STR);
            $stmt ->bindParam(':inside', $inside,PDO::PARAM_STR);
            $stmt ->bindParam(':fecha', $fecha,PDO::PARAM_STR);
            $query = $stmt->execute();
            header("Location:edit.php?blog=$ID&see=true");
            header("Refresh:0");
            exit();
        }
        else{
            $nueva = uniqid();
            $nueva .= '.' . $extencion;
            move_uploaded_file( $archivo_tmp, 'img/' . $nueva);
            $delete = "DELETE FROM ver";
            $connect->exec($delete);
            $restart = "ALTER TABLE ver AUTO_INCREMENT = 1";
            $connect -> exec($restart);                             //ejecutar el ingreso de los datos si se encuentra una imagen
            $ingresar = "INSERT INTO ver(titulo, contenido, fecha_edit, imagen, fecha)VALUES (:titulo, :contenido, :fecha_edit, :nueva, :fecha)";
            $stmt = $connect->prepare($ingresar);
            $stmt->bindParam(':nueva', $nueva);
            $stmt->bindParam(':titulo', $title,PDO::PARAM_STR);
            $stmt->bindParam(':contenido',$content,PDO::PARAM_STR);
            $stmt->bindParam(':fecha_edit', $fecha_edit,PDO::PARAM_STR);
            $stmt ->bindParam(':fecha', $fecha,PDO::PARAM_STR); 
            $query = $stmt->execute();
            header("Location:edit.php?blog=$ID&see=true");
            header("Refresh:0");
            exit();
        }
    }

    if(isset($_POST["delete-admin"])){
        $administrador = openssl_decrypt($_POST["delete-admin"],AES,KEY,0,IV);
        $sql = "DELETE FROM ingreso WHERE Id = :administrador";   // se elimina el administrador dependiendo del boton 
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':administrador', $administrador);
        $query = $stmt->execute();

        $sql = "DELETE FROM datos WHERE adm = :administrador";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':administrador', $administrador);
        $query = $stmt->execute();

        $del = "DELETE FROM comentarios WHERE adm = :administrador";
        $state = $connect->prepare($del);
        $state->bindParam(':administrador', $administrador);
        $query = $state->execute();

        $restart_ingreso = "ALTER TABLE ingreso AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($restart_ingreso);
        $restart_datos = "ALTER TABLE datos AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($restart_datos);
        $restart_comentarios = "ALTER TABLE comentarios AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($restart_comentarios);
        header("Location:registrar?added=DNJFJEEOIOMCJ");
        exit();
    }

    if(isset($_POST["panel-delete"])){
        $id = openssl_decrypt($_POST["panel-delete"],AES,KEY,0,IV);
        $ingresar = "DELETE FROM datos WHERE Id = ?";           //Funcionalidad del boton
        $stmt = $connect ->prepare($ingresar);                      //Eliminar
        $stmt->execute([$id]);
        $query = $stmt->fetchAll();
        $restart = "ALTER TABLE datos AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($restart);

        $sql = "DELETE FROM comentarios WHERE publicacion = ?";
        $state = $connect ->prepare($sql);                      //Eliminar
        $state->execute([$id]);
        $reset = "ALTER TABLE comentarios AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($reset);


        if(isset($_SESSION['user_id'])){                    //se ejecuta la eliminacion de la publicacion     
            header("Location:inicio?info=HJFR_$*42JDU385vdE");
        }elseif(isset($_SESSION['user_root'])){
            header("Location:admin?info=HJFR_$*42JDU385vdE");
        }
        exit();
    }

    if(isset($_POST["destroy"])){
        $id = openssl_decrypt($_POST["destroy"],AES,KEY,0,IV);
        $ingresar = "DELETE FROM datos WHERE adm = ?";           //Funcionalidad del boton
        $stmt = $connect ->prepare($ingresar);                      //Eliminar
        $stmt->execute([$id]);
        $query = $stmt->fetchAll();
        $restart = "ALTER TABLE datos AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($restart);

        $sql = "DELETE FROM comentarios WHERE adm = ?";
        $state = $connect ->prepare($sql);                      //Eliminar
        $state->execute([$id]);
        $reset = "ALTER TABLE comentarios AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($reset);

        if(isset($_SESSION['user_id'])){                    //se ejecuta la eliminacion de la publicacion     
            header("Location:inicio?info=KHNmjdndkX432");
        }elseif(isset($_SESSION['user_root'])){
            header("Location:admin?info=KHNmjdndkX432");
        }
        exit();
    }
    
    if(isset($_POST["Hades"])){
        $ingresar = "DELETE FROM datos";           //Funcionalidad del boton
        $stmt = $connect ->prepare($ingresar);                      //Eliminar
        $stmt->execute();
        $query = $stmt->fetchAll();
        $restart = "ALTER TABLE datos AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($restart);

        $sql = "DELETE FROM comentarios";
        $state = $connect ->prepare($sql);                      //Eliminar
        $state->execute();
        $reset = "ALTER TABLE comentarios AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($reset);
        if(isset($_SESSION['user_root'])){
            header("Location:admin?info=SSKEEJIOIEM213");
        }
        exit();
    }
    
    if(isset($_POST["comentar"])){
        $id = $_POST["comentar"];
        $_SESSION["chat"] = $id;
        $_SESSION["adm"] = $_POST["admin"]; 
		header("Location: comentarios");
		exit();
	}

    if(isset($_REQUEST["comment"]) or isset($_REQUEST["ind"])){
        $id = openssl_decrypt($_SESSION["chat"],AES,KEY,0,IV);   
        $sql = "SELECT * FROM datos WHERE Id = :id";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $coments = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        $get_commments = "SELECT * FROM comentarios WHERE publicacion = :id ORDER BY Id DESC";
        $state = $connect->prepare($get_commments);
        $state->bindParam(':id',$id);
        $state->execute();
        $comments_added = $state->fetchAll(PDO::FETCH_ASSOC);  
    }

    if(isset($_POST["comentadd"])){
        $fecha = date('d-m-y g:i A');  
        $id = openssl_decrypt($_SESSION["chat"],AES,KEY,0,IV);
        $adm = openssl_decrypt($_SESSION["adm"],AES,KEY,0,IV);
        $comentary = $_POST["comentary"];
        $ingresar = "INSERT INTO comentarios(contenido, publicacion, fecha, adm) VALUES(:comentary, :id, :fecha, :adm)";
        $stmt = $connect ->prepare($ingresar);
        $stmt ->bindParam(':adm', $adm, PDO::PARAM_INT);
        $stmt ->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt ->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt ->bindParam(':comentary', $comentary, PDO::PARAM_STR);
        $query = $stmt->execute();
        header("Location: chat.php?comment=ZDYXY47864PDLDJ_FFR");
        exit();
    }

    if(isset($_POST["delete-comments"])){
        $ID = $_POST["id"];
        $id = openssl_decrypt($_POST["delete-comments"],AES,KEY,0,IV);
        $sql = "DELETE FROM comentarios WHERE Id = :id";
        $state = $connect ->prepare($sql);                      //Eliminar
        $state->bindParam(':id', $id);
        $state->execute();
        $reset = "ALTER TABLE comentarios AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($reset);
        header("Location: content.php?blog=$ID&succes=CJDBHJKDE");
        exit();
    }

    if(isset($_POST["delete-all-comments"])){
        $ID = $_POST["delete-all-comments"];
        $id = openssl_decrypt($_POST["delete-all-comments"],AES,KEY,0,IV);
        $sql = "DELETE FROM comentarios WHERE publicacion = :id";
        $state = $connect ->prepare($sql);                      //Eliminar
        $state->bindParam(':id', $id);
        $state->execute();
        $reset = "ALTER TABLE comentarios AUTO_INCREMENT = 1";  //Se reinicia el Id de la base de datos
        $connect -> exec($reset);
        header("Location: content.php?blog=$ID&succes=CFNEKUDJSGR");
        exit();
    }
?>
