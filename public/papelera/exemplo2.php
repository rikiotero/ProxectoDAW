<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión o Registrarse</title>
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

        .register-button {
            display: block;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
            color: #333;
        }

        /* Nuevo estilo para ocultar el formulario de registro inicialmente */
        #registerForm {
            display: none;
        }
    </style>
</head>
<body>

<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Verificar las credenciales de inicio de sesión (esto es un ejemplo simple, debes mejorar la seguridad)
        $username = "usuario"; // Cambia esto con tu nombre de usuario
        $password = "contrasena"; // Cambia esto con tu contraseña

        if ($_POST["username"] == $username && $_POST["password"] == $password) {
            echo "<p>Bienvenido, $username <span class='icon'><i class='fas fa-check'></i></span></p>";
        } else {
            echo "<p>Usuario o contraseña incorrectos <span class='icon'><i class='fas fa-times'></i></span></p>";
        }
    } elseif (isset($_POST['register'])) {
        // Procesar el formulario de registro (esto es un ejemplo simple, debes mejorar la seguridad)
        $email = $_POST["email"];
        $newUsername = $_POST["newUsername"];
        $newPassword = $_POST["newPassword"];

        // Aquí deberías agregar lógica para almacenar la información del nuevo usuario en tu base de datos

        echo "<p>Registro exitoso para $newUsername <span class='icon'><i class='fas fa-check'></i></span></p>";
    }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="loginForm">
    <!-- Formulario de inicio de sesión -->
    <label for="username"><span class="icon"><i class="fas fa-user"></i></span> Usuario:</label>
    <input type="text" id="username" name="username" required>

    <label for="password"><span class="icon"><i class="fas fa-lock"></i></span> Contraseña:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit" class="icon" name="login"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</button>

    <!-- Enlace para cambiar al formulario de registro -->
    <a href="#" class="register-button" onclick="toggleForm('register')">¿No tienes cuenta? Regístrate aquí</a>
</form>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="registerForm">
    <!-- Formulario de registro -->
    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" required>

    <label for="newUsername">Nuevo Usuario:</label>
    <input type="text" id="newUsername" name="newUsername" required>

    <label for="newPassword">Nueva Contraseña:</label>
    <input type="password" id="newPassword" name="newPassword" required>

    <button type="submit" class="icon" name="register"><i class="fas fa-user-plus"></i> Registrarse</button>

    <!-- Enlace para cambiar al formulario de inicio de sesión -->
    <a href="#" class="register-button" onclick="toggleForm('login')">¿Ya tienes cuenta? Inicia sesión aquí</a>
</form>

<script>
    // Función para cambiar entre formularios
    function toggleForm(formType) {
        if (formType === 'register') {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
        } else {
            document.getElementById('loginForm').style.display = 'block';
            document.getElementById('registerForm').style.display = 'none';
        }
    }
</script>

</body>
</html>