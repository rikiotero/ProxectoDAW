<?php
use Clases\RoleDB;
?>

<!-- Modal actualizar usuario-->
<div class="modal fade modal-lg" id="updateUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal actualizar usuario header-->      
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateUserModalLabel">Actualizar datos de usuario</h1>
      </div>
        <!-- Modal actualizar usuario body-->
      <div class="modal-body">
        <div class="container">
            <!-- formulario -->
          <form  class="row g-3 align-items-center" id="actualizaUsuario" name="actualizaUsuario">
            <input type="hidden" name="userRol" id="userRol" value="<?php echo $_SESSION['rol']?>">
            <input type="hidden" name="idUsuarioActualizar" id="idUsuarioActualizar" value="<?php echo $datosUsuario->id?>">
            <input type="hidden" name="usuarioVello" id="usuarioVello" value="<?php echo $datosUsuario->usuario?>">
            <input type="hidden" name="passw" id="passw" value="<?php echo $datosUsuario->password?>">

            <div class="row g-3">
                <div class="col-md-4">
                  <label for="usuario" class="form-label">Nome de usuario *</label>
                  <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Nome de usuario" value="" required>
                </div>
            </div>

            <div class="row g-3">
              <div class="form-group col-md">
                <label for="nome" class="form-label">Nome *</label>
                <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome" value="" required>
              </div>
              <div class="form-group col-md">
                <label for="apellido1" class="form-label">Primer apelido *</label>
                <input type="text" name="apellido1" id="apellido1" class="form-control" placeholder="Primer apelido" value="" required>
              </div>
              <div class="form-group col-md">
                <label for="apellido2" class="form-label">Segundo apelido *</label>
                <input type="text" name="apellido2" id="apellido2" class="form-control" placeholder="Segundo apelido" value="" required>
              </div> 
            </div>

            <div class="row g-3">
              <div class="col-md-4">
                <label for="email" class="form-label">Email</label>    
                <input type="mail" id="email" name="email" class="form-control" value="" placeholder="Ex: Email@info.gal">
              </div>
              <div class="col-md-4">
                  <label for="tlf" class="form-label">Teléfono</label> 
                  <input type="tel" id="tlf" name="tlf" class="form-control" value="" placeholder="Ex: 666999333">
              </div>
              <div class="col-md-4">
                  <label for="alta" class="form-label">Fecha de alta</label>
                  <input type="text" id="alta" name="alta" class="form-control" value="" disabled readonly>
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
                      while ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) {
                          if ( $row->rol == $_SESSION["rol"] ) echo "<option selected value='$row->id' >$row->rol</option>";
                          else echo "<option value='$row->id'>$row->rol</option>";                        
                      }
                      $stmt = null;
                  ?>
            
                </select>
              </div>    
              <div class="col-md-4">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="updateActivo" id="updateActivo" value="1" >
                    <label class="form-check-label" for="updateActivo">Usuario activo</label>
                </div>
              </div>
              <div class="col-md-12">
                * Campos obligatorios.
              </div>
              <div id="msgUpdate"></div>
            </div>
          </form>  
          <!-- fin formulario -->  
        </div>
      </div>
        <!-- Modal actualizar usuario footer-->
      <div class="modal-footer">
        <!-- onclick="window.location.reload()" -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="getUsersData()">Cerrar</button>
        <!-- <input type="submit" form="actualizaUsuario" class="btn btn-primary" name="enviar" id="enviar" value="Actualizar"></input> -->
        <button class="btn btn-primary" name="actualizar" id="actualizar"  onclick="updateUser(event)">Actualizar usuario</button>
      </div>      
    </div>
  </div>
</div>
<!-- Fin Modal actualizar usuario-->

<!-- Modal actualizar contrasinal------------------------------------------------->
<!-------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------->

<!-- Modal actualizar contrasinal-->
<div class="modal fade" id="updatePassModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal actualizar contrasinal header-->      
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updatePassModalLabel">Actualizar contrasinal</h1>
      </div>
        <!-- MModal actualizar contrasinal body-->
      <div class="modal-body">
        <div id="msgUpdatepassw"></div>
        <div class="container">
          <form  class="row g-3 align-items-center" id="actualizaPassw" name="actualizaPassw"> 
            <div class="row g-3">
                <div class="col-md-6">
                  <label for="passwUpdate" class="form-label">Novo contrasinal</label>
                  <input type="password" autocomplete="on" name="passwUpdate" id="passwUpdate" class="form-control">
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label for="passwUpdate2" class="form-label">Repite o contrasinal</label>
                  <input type="password" autocomplete="on" name="passwUpdate2" id="passwUpdate2" class="form-control">
                </div>
            </div>
          </form>
        </div>
      </div>
        <!-- Modal actualizar contrasinal footer-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.location.reload()">Cerrar</button>
        <button class="btn btn-primary" name="actualizar" id="actualizar" onclick="updatePassw(event)">Actualizar contrasinal</button>
      </div>      
    </div>
  </div>
</div>
<!-- Fin Modal actualizar contrasinal-->