<?php
require "../vendor/autoload.php";

use Clases\RoleDB;
use Clases\UserDB;

$roles = new RoleDB();
$stmt = $roles->getRoles();
$roles->cerrarConexion();

$usr = new UserDB();
$stmt = $usr->getUsers();
$usr->cerrarConexion();

// $hash = password_hash('admin', PASSWORD_DEFAULT, [15]);
// echo "passW: ". $hash;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tabla roles</title>
    <!-- css para usar Bootstrap -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">          
</head>
<body>
    <div class="container mt-3">
    <table class="table table-striped table-dark">
        <thead>
            <tr class="text-center">
                <th scope="col">id</th>
                <th scope="col">rol</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr>";
                    echo "<td>{$row->id}</td>";
                    echo "<td>{$row->rol}</td>";
                    echo "</tr>";
                }
                $stmt = null;
            ?>
        </tbody>
    </div>



    <div class="container mt-3">
    <table class="table table-striped table-dark">
        <thead>
            <tr class="text-center">
                <th scope="col">id</th>
                <th scope="col">usuario</th>
                <th scope="col">nombre</th>
                <th scope="col">apelido1</th>
                <th scope="col">apelido2</th>
                <th scope="col">email</th>
                <th scope="col">telefono</th>
                <th scope="col">fecha_alta</th>
                <th scope="col">activo</th>
                <th scope="col">rol</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr>";
                    echo "<td>{$row->id}</td>";
                    echo "<td>{$row->usuario}</td>";
                    echo "<td>{$row->nombre}</td>";
                    echo "<td>{$row->apellido1}</td>";
                    echo "<td>{$row->apellido2}</td>";
                    echo "<td>{$row->email}</td>";
                    echo "<td>{$row->telefono}</td>";
                    echo "<td>{$row->fecha_alta}</td>";
                    echo "<td>{$row->activo}</td>";
                    echo "<td>{$row->rol}</td>";
                    echo "</tr>";
                }
                $stmt = null;
            ?>
        </tbody>
    </div>



    <div class="col-md-4">
        <label for="novoRol" class="form-label">Rol de usuario *</label>
        <select id="novoRol" name="novoRol" class="form-select">      

        <?php
        $roles = new RoleDB();
        $stmt = $roles->getRoles();
        $roles->cerrarConexion();
        while ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) {
        if ( $row->rol == "estudiante" ) echo "<option selected value='$row->id'>$row->rol</option>";
        else echo "<option value='$row->id'>$row->rol</option>";                        
        }
        $stmt = null;
        ?>

        </select>

    </div>    
        <div class="col-md-4">
            <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" name="novoActivo" id="novoActivo" value="1" checked>
            <label class="form-check-label" for="novoActivo">Usuario activo</label>
        </div>
    </div>


    <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    -->
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- el bundle ya incluye el popper -->

  
</body>
</html>