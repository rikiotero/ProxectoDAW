<?php
use Clases\RoleDB;
use Clases\CursosDB;
?>

<!-- Modal actualizar usuario-->
<div class="modal fade modal-lg" id="updateUsersListModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateUsersListModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal actualizar usuario header-->      
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateUsersListModalLabel">Actualizar datos de lista usuarios</h1>
      </div>
        <!-- Modal actualizar usuario body-->
      <div class="modal-body">
        <div class="container">
            <!-- formulario -->
          <form  class="row g-3 align-items-center" id="actualizaUsuario" name="actualizaUsuario">
            <input type="hidden" name="currentUserRol" id="currentUserRol" value="<?php echo $_SESSION['rol']?>">
            <input type="hidden" name="idUsuarioActualizar" id="idUsuarioActualizar">
            <input type="hidden" name="usuarioVello" id="usuarioVello">
            <input type="hidden" name="passw" id="passw">

            <div class="row g-3">
                <div class="col-md-4">
                  <label for="usuario" class="form-label">Nome de usuario *</label>
                  <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Nome de usuario" required>
                </div>
            </div>

            <div class="row g-3">
              <div class="form-group col-md">
                <label for="nome" class="form-label">Nome *</label>
                <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome" required>
              </div>
              <div class="form-group col-md">
                <label for="apellido1" class="form-label">Primer apelido *</label>
                <input type="text" name="apellido1" id="apellido1" class="form-control" placeholder="Primer apelido" required>
              </div>
              <div class="form-group col-md">
                <label for="apellido2" class="form-label">Segundo apelido *</label>
                <input type="text" name="apellido2" id="apellido2" class="form-control" placeholder="Segundo apelido" required>
              </div> 
            </div>

            <div class="row g-3">
              <div class="col-md-4">
                <label for="email" class="form-label">Email</label>    
                <input type="mail" id="email" name="email" class="form-control" placeholder="Ex: Email@info.gal">
              </div>
              <div class="col-md-4">
                  <label for="tlf" class="form-label">Teléfono</label> 
                  <input type="tel" id="tlf" name="tlf" class="form-control" placeholder="Ex: 666999333">
              </div>
              <div class="col-md-4">
                  <label for="alta" class="form-label">Fecha de alta</label>
                  <input type="text" id="alta" name="alta" class="form-control" disabled readonly>
              </div>
            </div>
      
            <div class="row g-3">
              <div class="col-md-4">
                <label for="rol" class="form-label">Rol de usuario</label>
                <select id="rol" name="rol" class="form-select">            
                  <?php
                      $roles = new RoleDB();
                      $stmt = $roles->getRoles();
                      $roles->cerrarConexion();
                      while ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) {
                          if ( $row->rol == $_SESSION["rol"] ) echo "<option selected value='$row->id'>$row->rol</option>";
                          else echo "<option value='$row->id'>$row->rol</option>";                        
                      }
                      $stmt = null;
                  ?>            
                </select>
              </div> 
              
                <?php
                  $db = new CursosDB();  //obtemos os cursos da db
                  $cursos = $db->getCursos();
                  // $cursosAsignaturas = $db->getCursosAsignaturas();
                  // var_dump($cursosAsignaturas);
                  $db->cerrarConexion();
                ?>
                <div class="col-md-4" id="divCurso">
                  <label for="curso" class="form-label">Curso</label>
                  <select id="curso" name="curso" class="form-select">
                    <option value="0">Seleción de curso</option>
                    <?php                        
                      foreach ($cursos as $key => $value) {
                        echo "<option value='$key'>".$value."</option>";
                      }
                      // foreach ($cursos as $key => $value) { 
                      //   foreach ($value as $curso => $asignaturas) {
                      //     echo "<option value='$key'>".$curso."</option>";
                      //   }                          
                      // }
                    ?>
                  </select>
                </div>

                  <div class="col-md-4" id="divAsignaturas">
                    <label for="asignaturas" class="form-label">Asignaturas</label>
                    <select id="asignaturas" name="asignaturas" class="form-select" title="Manter pulsado 'Ctrl' para seleccionar varias" multiple>
                          <?php
                          
                            // foreach ($cursosAsignaturas as $key => $value) { 
                            //   foreach ($value as $curso => $asignaturas) {
                            //     foreach ($asignaturas as $idAsig => $nomeAsig) {

                            //       echo "<option value='$idAsig'>".$nomeAsig."</option>";
                            //     }                                
                            //   }                          
                            // }
                          ?>
                    </select>
                    <div class="form-text">
                      Manten "Ctrl" pulsado para seleccionar varias
                    </div>


                    
                    <script>


                        let rol = document.getElementById("rol");
                        rol.addEventListener("change" , () => {
                          if(rol.value != 3) {
                            document.getElementById("divCurso").style.display = "none";
                            document.getElementById("divAsignaturas").style.display = "none";
                          }else {
                            document.getElementById("divCurso").style.display = "";
                            document.getElementById("divAsignaturas").style.display = "";
                          }
                        });                        

                        selectCurso = document.getElementById("curso");
                        selectAsignaturas = document.getElementById("asignaturas");

                        selectCurso.addEventListener("change", () => {
                          cargarAsignaturas(selectCurso.value,"asignaturas");
                        });
                        
                        /**
                         * Carga as asignaturas do curso correspondente no "input select" de asignaturas
                         * @param {string} idCurso Id do curso
                         * @param {string} idSelectInput Id do input select donde se van cargar as asignaturas
                         */
                        const cargarAsignaturas = (idCurso,idSelectInput) => {
                          
                          fetch('./php_functions/getAsignaturas.php', {
                              method: 'POST',
                              headers: {
                                  'Content-Type': 'application/json',
                              },
                              body: JSON.stringify(idCurso),
                          })
                          .then(response => response.json())
                          .then(data => { 
                                                         
                            document.getElementById(idSelectInput).innerHTML = data;
                            
                          }).catch(err => {
                              console.error("ERROR: ", err.message);
                          });
                        }

                    </script>


                  </div>
              
              <div class="col-md-12">
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
        <button type="button" class="me-auto btn btn-danger" data-bs-dismiss="modal" id="updatePassListModalButton">Cambiar Contrasinal</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="getUsersData()">Cerrar</button>
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
      <!-- onclick="window.location.reload()" -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" name="actualizar" id="actualizar" onclick="updatePassw()">Actualizar contrasinal</button>
      </div>      
    </div>
  </div>
</div>
<!-- Fin Modal actualizar contrasinal-->