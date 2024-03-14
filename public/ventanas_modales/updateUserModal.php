<?php
use Clases\RoleDB;
?>

<!-- Modal actualizar datos de usuario-->
<div class="modal fade modal-lg" id="updateUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal actualizar usuario header-->      
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateUserModalLabel">Actualizar datos de usuario </h1>
      </div>
        <!-- Modal actualizar usuario body-->
      <div class="modal-body">
        <div class="container">
            <!-- formulario -->
          <form  class="row g-3 align-items-center" id="actualizaDatosUsuario" name="actualizaDatosUsuario">
            <input type="hidden" name="userSessionRol" id="userSessionRol" value="<?php echo $_SESSION['rol']?>">
            <input type="hidden" name="userNomeVello" id="userNomeVello" value="<?php echo $datosUsuario->usuario?>">


            <div class="row g-3">
                <div class="col-md-4">
                  <label for="userUsuario" class="form-label">Nome de usuario *</label>
                  <input type="text" name="userUsuario" id="userUsuario" class="form-control" placeholder="Nome de usuario" value="<?php echo $datosUsuario->usuario?>" required>
                </div>
            </div>

            <div class="row g-3">
              <div class="form-group col-md">
                <label for="userNome" class="form-label">Nome *</label>
                <input type="text" name="userNome" id="userNome" class="form-control" placeholder="Nome" value="<?php echo $datosUsuario->nombre?>" required>
              </div>
              <div class="form-group col-md">
                <label for="userApellido1" class="form-label">Primer apelido *</label>
                <input type="text" name="userApellido1" id="userApellido1" class="form-control" placeholder="Primer apelido" value="<?php echo $datosUsuario->apellido1?>" required>
              </div>
              <div class="form-group col-md">
                <label for="userApellido2" class="form-label">Segundo apelido *</label>
                <input type="text" name="userApellido2" id="userApellido2" class="form-control" placeholder="Segundo apelido" value="<?php echo $datosUsuario->apellido2?>" required>
              </div> 
            </div>

            <div class="row g-3">
              <div class="col-md-4">
                <label for="userEmail" class="form-label">Email</label>    
                <input type="mail" id="userEmail" name="userEmail" class="form-control" value="<?php echo $datosUsuario->email?>" placeholder="Ex: Email@info.gal">
              </div>
              <div class="col-md-4">
                  <label for="userTlf" class="form-label">Teléfono</label> 
                  <input type="tel" id="userTlf" name="userTlf" class="form-control" value="<?php echo $datosUsuario->telefono?>" placeholder="Ex: 666999333">
              </div>
              <div class="col-md-4">
                  <label for="userAlta" class="form-label">Data de alta</label>
                  <input type="text" id="userAlta" name="userAlta" class="form-control" value="<?php echo date("d-m-Y", strtotime($datosUsuario->fecha_alta))?>" disabled readonly>
              </div>
            </div>
      
            <div class="row g-3 align-items-center">
              <div class="col-md-4">
                <label for="userRol" class="form-label">Rol de usuario</label>
                <select id="userRol" name="userRol" class="form-select" <?php echo $_SESSION["rol"]!="administrador" ? "disabled" : ""?>>      
            
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
                    <input class="form-check-input" type="checkbox" name="updateActivo1" id="updateActivo1" value="1" <?php echo $datosUsuario->activo ? "checked " : "";echo $_SESSION["rol"]!="administrador" ? "disabled" : ""?>>
                    <label class="form-check-label" for="updateActivo1">Usuario activo</label>
                </div>
              </div>
              <div class="col-md-12">
                * Campos obrigatorios.
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <!-- <input type="submit" form="actualizaUsuario" class="btn btn-primary" name="enviar" id="enviar" value="Actualizar"></input> -->
        <button class="btn btn-primary" name="actualizar" id="actualizar"  onclick="updateUser()">Actualizar usuario</button>
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
        <!-- Modal actualizar contrasinal body-->
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