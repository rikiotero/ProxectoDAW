<?php
session_start();
require "./php_functions/redirect.php";
if( isset($_SESSION["rol"]) ) redirect($_SESSION["rol"]);

require "../vendor/autoload.php";

use Clases\UserDB;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskVault</title>
    <link rel="icon" href="./src/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./src/css/style.css">          
</head>
<body>
<?php

if ( isset($_POST['login']) ) {
    $user = trim($_POST['usuario']);
    $pass = trim($_POST['pass']);

    $usr = new UserDB();

    if ( $usr->validateUserCredentials($user,$pass) ) {        //Validación de credenciales e comprobación de que é usuario activo
        if( $usr->isActive($user) ) {
            $_SESSION["user"] = $user;                         //gárdanse os datos do usuario na sesión
            $_SESSION["rol"] = $usr->getRole($user) ? $usr->getRole($user) : ""; 
            $_SESSION["id"] = $usr->getUserId($user) ? $usr->getUserId($user) : "";
            $usr->cerrarConexion();           
            redirect($_SESSION["rol"]);
        }else {
            $_SESSION["error"] = "O usuario está desactivado.";
            $usr->cerrarConexion();
            redirect("");
        }        
        
    }else {
        $_SESSION["error"] = "Credenciais incorrectas.";
        $usr->cerrarConexion();
        redirect("");
    }

}else {
?>
    <div class="container login">
        <div class="wrapper d-flex align-items-center justify-content-center vh-100">
                           
                <div class="card login-form my-5 col-md-4">
                    <div class="card-header">
                        <h2 class="text-center p-3">INICIO DE SESIÓN</h2>
                    </div>
                    <form name="login" method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>" class="card-body cardbody-color p-lg-5">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" autofocus required>
                        </div>
                        <div class="mb-5">
                            <input type="password" class="form-control" name="pass" id="pass" placeholder="Contrasinal" required>
                        </div>
                        <div class="text-center"><button type="submit" name="login" class="btn btn-dark px-5 mb-3 w-100">Iniciar sesión</button></div>
                        <?php
                        if( isset($_SESSION["error"]) ) {
                            echo "<div class='alert alert-danger'>{$_SESSION["error"]}</div>";
                            unset($_SESSION["error"]);
                         }
                        ?>
                    </form>                    
                </div>
                  
        </div>
    </div>

  <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>

 <?php } ?> 
</body>
</html>




