<?php
session_start();
require "../vendor/autoload.php";
require "../src/functions/redirect.php";

if( isset($_SESSION["rol"]) ) redirect($_SESSION["rol"]);
use Clases\UserDB;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <!-- css para usar Bootstrap -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">           -->
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">          
</head>
<body style="background:silver;">
<?php

if (isset($_POST['login'])) {
    $user = trim($_POST['usuario']);
    $pass = trim($_POST['pass']);
 // if (strlen($nombre) == 0 || strlen($pass) == 0) {
    //     error("Error, El nombre o la contraseña no pueden contener solo espacios en blancos.");
    // }

    $usr = new UserDB();

    if ( $usr->validateUserCredentials($user,$pass) ) {        
        if( $usr->isActive($user) ) {
            $_SESSION["user"] = $user;
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

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">                
                <div class="card my-5">
                    <div class="card-header">
                        <h2 class="text-center text-dark mt-5">INICIO DE SESIÓN</h2>
                    </div>
                    <form name="login" method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>" class="card-body cardbody-color p-lg-5">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario" autofocus required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="pass" id="pass" placeholder="Contrasinal" required>
                        </div>
                        <div class="text-center"><button type="submit" name="login" class="btn btn-dark px-5 mb-5 w-100">Iniciar sesión</button></div>
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
    </div>


    <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    -->
  <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!-- el bundle ya incluye el popper -->

 <?php } ?> 
</body>
</html>




