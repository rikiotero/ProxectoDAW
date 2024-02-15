<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
        }

        .icon {
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
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
    <label for="username"><span class="icon fas fa-user"></span> Usuario:</label>
    <input type="text" id="username" name="username" required>

    <label for="password"><span class="icon fas fa-lock"></span> Contraseña:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit" class="icon"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</button>
</form>

</body>
</html>