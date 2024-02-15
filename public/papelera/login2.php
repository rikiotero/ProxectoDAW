<?php
require "../vendor/autoload.php";

// use Clases\Conexion;
use Clases\RoleDB;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>

<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar las credenciales (esto es un ejemplo simple, debes mejorar la seguridad)
    $username = "usuario"; // Cambia esto con tu nombre de usuario
    $password = "contrasena"; // Cambia esto con tu contraseña

    if ($_POST["username"] == $username && $_POST["password"] == $password) {
        echo "<p>Bienvenido, $username <i class='fas fa-check'></i></p>";
    } else {
        echo "<p>Usuario o contraseña incorrectos <i class='fas fa-times'></i></p>";
    }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username"> Usuario:</label>
    <input type="text" id="username" name="username" required>

    <label for="password"> Contraseña:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit" class="icon"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</button>
</form>

</body>
</html>