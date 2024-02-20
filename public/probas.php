<?php
session_start();
require "../vendor/autoload.php";
use Clases\Student;
use Clases\UserDB;
use Clases\User;
// require "load.php";



// $hash = password_hash('estudiante2', PASSWORD_DEFAULT, [15]);
// echo "HASH: ".$hash."<br>";

// $user = new UserDB();
// $activo = $user->isActive("profesor1");
// echo "Activo: ".$activo;

$usuario = new User("riki", "pass", "rikiNick", "otero","Gonzalez", "lellamaban@gmail.com", "222333444", "02-04-2018", "1", "estudiante");
$estudiante = new Student($usuario);
var_dump($estudiante);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">          

    <title>Document</title>

    <style>
      table, th, td {
        border: 1px solid black;
        padding: 3px;
      }
      table {
        width: 80%;
      }

    </style>
</head>
<body>
  <!-- <h2>Empleados</h2>

  <form action="" method="post">
    <label for="campo">Buscar:</label>
    <input type="text" name="campo" id="campo">
    
    <label for="activo">activos</label>
    <input type="checkbox" name="activo" id="activo" checked>
    <label for="inactivo">inactivos</label>
    <input type="checkbox" name="inactivo" id="inactivo" checked>

    <label for="roles">Roles: </label>
    <select name="roles" id="roles">
      <option value="0" selected>Todos</option>
      <option value="1">Administrador</option>
      <option value="2">Profesor</option>
      <option value="3">Estudiante</option>
    </select>
  </form>

  <p></p>
  
  <table>
    <thead>
      <th>ID</th>
      <th>USUARIO</th>
      <th>NOMBRE</th>
      <th>PRIMER APELIDO</th>
      <th>SEGUNDO APELIDO</th>
      <th>EMAIL</th>
      <th>TELEFONO</th>
      <th>ALTA</th>
      <th>ACTIVO</th>
      <th>ROL</th>
      <th></th>
      <th></th>
    </thead>
    <tbody id="content">

    </tbody>
  </table>
  
  <script>

    getData();

    document.getElementById("campo").addEventListener("keyup", getData);
    document.getElementById("activo").addEventListener("change", getData);
    document.getElementById("inactivo").addEventListener("change", getData);
    document.getElementById("roles").addEventListener("change", getData);
 
    
    function getData() {

      let filtro = document.getElementById("campo").value;
      let rol = document.getElementById("roles").value;
      let formData = new FormData();

      if( document.getElementById("activo").checked )
      {
        activoCkecked = "1";
      }else {
        activoCkecked = "0";
      }

      if( document.getElementById("inactivo").checked )
      {
        inactivoCkecked = "1";
      }else {
        inactivoCkecked = "0";
      }

      switch (rol) {
        case "1": 
            formData.append("rol", "administrador");         
          break;

        case "2":  
            formData.append("rol", "profesor");
            break;
        case "3":
            formData.append("rol", "estudiante");
          break;

        default:
          break;
      }

      let content = document.getElementById("content");
      let url = './loadUsersTable.php';
      
      formData.append("campo", filtro);
      formData.append("activo", activoCkecked);
      formData.append("inactivo", inactivoCkecked);


      fetch( url, {
        method: "POST",
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        content.innerHTML = data
      })
      .catch(err => console.log(err))
    }
  </script> -->

</body>
</html>
