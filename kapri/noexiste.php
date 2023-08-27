<?php
    
    if(isset($_SESSION['user_id'])){
        unset($_SESSION['welcome']);
    }elseif(isset($_SESSION['user_root'])){
        unset($_SESSION['welcome']);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error</title>
    </head>
    <body>
        <h1>ERROR</h1>
        <p>La imagen no existe</p>
    </body>
</html>
<?php
    header("Refresh:2; url=inicio");
?>