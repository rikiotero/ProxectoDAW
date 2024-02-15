<?php
session_start();
require "../src/functions/redirect.php";
require "../vendor/autoload.php";


if( !isset($_SESSION["rol"]) || ($_SESSION["rol"] != "profesor" &&  $_SESSION["rol"] != "administrador") ) redirect("");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del teacher</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">          
</head>
<body>
    <div class="float float-right d-inline-flex mt-2">
        <input type="text" size='10px' value="<?php echo $_SESSION["user"]; ?>" class="form-control mr-2 bg-transparent"
           disabled>
        <a href="closeSession.php" class='btn btn-danger mr-2'>Salir</a>
    </div>    
    <h1>Panel del teacher</h1>
</body>
</html>