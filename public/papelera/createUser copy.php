<?php
session_start();
require "../vendor/autoload.php";

use Clases\UserDB;
use Clases\RoleDB;
use Clases\User;


if( isset($_POST["guardarUsuario"]) ) {
  //si se envia o formulario crease unha instancia de usuario cos datos
  $usuario = new User(
    $_POST["usuario"],
    $_POST["pass"],
    $_POST["nombre"],
    $_POST["apellido1"],
    $_POST["apellido2"],
    $_POST["email"] != "" ? $_POST["email"] : null,
    $_POST["tlf"] != "" ? $_POST["tlf"] : null,
    $_POST["alta"],
    $_POST["activo"] == 1 ? true : false,
    $_POST["rol"]
  );
  $userDB = new UserDB();
  $userDB->insertUser($usuario);
  $userDB->cerrarConexion();
}else {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo usuario</title>
    <!-- css para usar Bootstrap -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">          
</head>
<body>
  <div class="container mt-5">
    <form  class="row g-3 align-items-center" name="crearUsuario" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      
      <div class="row g-3">
          <div class="col-md">
            <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Nome de usuario" required>
          </div>
          <div class="col-md">
            <input type="password" name="pass" id="pass" class="form-control" placeholder="Contrasinal" required>
          </div>
          <div class="col-md">
            <input type="password" name="pass2" id="pass2" class="form-control" placeholder="Repite contrasinal" required>
          </div> 
      </div>

      <div class="row g-3">
          <div class="form-group col-md">
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nome" required>
          </div>
          <div class="form-group col-md">
            <input type="text" name="apellido1" id="apellido1" class="form-control" placeholder="Primer apelido" required>
          </div>
          <div class="form-group col-md">
            <input type="text" name="apellido2" id="apellido2" class="form-control" placeholder="segundo apelido" required>
          </div> 
      </div>

    

      <div class="row g-3">
        <div class="col-md-4">
          <label for="email" class="form-label">Email</label>    
          <input type="mail" id="email" name="email" class="form-control" placeholder="Email@info.gal">
        </div>
        <div class="col-md-4">
            <label for="tlf" class="form-label">Teléfono</label> 
            <input type="tel" id="tlf" name="tlf" class="form-control" placeholder="666999333">
        </div>
        <div class="col-md-4">
            <label for="alta" class="form-label">Fecha de alta</label>
            <input type="text" id="alta" name="alta" class="form-control" value="<?php echo date('d-m-Y');?>" readonly>
        </div>
      </div>    


      <div class="row g-3 align-items-center">
        <div class="col-md-4">
            <label for="rol" class="form-label">Rol de usuario</label>
            <select id="rol" name="rol" class="form-select">      
        
              <?php
                  $roles = new RoleDB();
                  $stmt = $roles->getRoles();
                  $roles->cerrarConexion();
                  while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                      if ( $_SESSION["rol"] == $row->rol) echo "<option selected value='$row->id'>$row->rol</option>";
                      else echo "<option value='$row->id'>$row->rol</option>";                        
                  }
                  $stmt = null;
              ?>
        
            </select>
        </div>    
        <div class="col-md-4">
            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" checked>
                <label class="form-check-label" for="activo">Usuario activo</label>
            </div>
        </div>
      </div>

      <div class="col-12">
        <button type="submit" name="guardarUsuario" class="btn btn-primary">Gardar usuario</button>
      </div>

    </form>


    
  </div>


    <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    -->
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- el bundle ya incluye el popper -->
<?php
}
?>
  
</body>
</html>




