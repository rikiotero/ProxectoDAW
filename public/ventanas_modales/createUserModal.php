<?php
use Clases\RoleDB;
use Clases\CursosDB;
?>

<!-- Modal crear usuario-->
<div class="modal fade modal-lg" id="createUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal crear usuario header-->      
      <div class="modal-header">
        <h1 class="modal-title fs-4" id="createUserModalLabel">Rexistro de novo usuario</h1>
      </div>
      <!-- Modal crear usuario body-->
      <div class="modal-body">        
        <div class="container">
          <!-- formulario -->
          <form  class="row g-3 align-items-center" id="crearUsuario" name="crearUsuario">      
            <div class="row g-3">
                <div class="col-md">
                  <label for="novoUsuario" class="form-label">Nome de usuario *</label>
                  <input type="text" name="novoUsuario" id="novoUsuario" class="form-control" placeholder="Nome de usuario" required>
                </div>
                <div class="col-md">
                  <label for="novoPassword" class="form-label">Contrasinal *</label>
                  <input type="password" autocomplete="on" name="novoPassword" id="novoPassword" class="form-control" placeholder="Contrasinal" required>
                </div>
                <div class="col-md">
                  <label for="novoPassword2" class="form-label">Repetir contrasinal *</label>
                  <input type="password" autocomplete="on" name="novoPassword2" id="novoPassword2" class="form-control" placeholder="Repetir contrasinal" required>
                </div> 
            </div>

            <div class="row g-3">
              <div class="form-group col-md">
                <label for="novoNome" class="form-label">Nome *</label>
                <input type="text" name="novoNome" id="novoNome" class="form-control" placeholder="Nome" required>
              </div>
              <div class="form-group col-md">
                <label for="novoApellido1" class="form-label">Primer apelido *</label>
                <input type="text" name="novoApellido1" id="novoApellido1" class="form-control" placeholder="Primer apelido" required>
              </div>
              <div class="form-group col-md">
                <label for="novoApellido2" class="form-label">Segundo apelido *</label>
                <input type="text" name="novoApellido2" id="novoApellido2" class="form-control" placeholder="segundo apelido" required>
              </div> 
            </div>

            <div class="row g-3">
              <div class="col-md-4">
                <label for="novoEmail" class="form-label">Email</label>    
                <input type="mail" id="novoEmail" name="novoEmail" class="form-control" placeholder="Ex: email@info.gal">
              </div>
              <div class="col-md-4">
                  <label for="novoTlf" class="form-label">Teléfono</label> 
                  <input type="tel" id="novoTlf" name="novoTlf" class="form-control" placeholder="Ex: 666999333">
              </div>
              <div class="col-md-4">
                  <label for="novoAlta" class="form-label">Fecha de alta</label>
                  <input type="text" id="novoAlta" name="novoAlta" class="form-control" value="<?php echo date('d-m-Y');?>" readonly disabled>
              </div>
            </div>
      
            <div class="row g-3">
              <div class="col-md-4">
                <label for="novoRol" class="form-label">Rol de usuario *</label>
                <select id="novoRol" name="novoRol" class="form-select" <?php $_SESSION["rol"] == "administrador" ? "disabled" : ""?>>      
            
                  <?php
                      $roles = new RoleDB();  //obtemos os roles da db
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
              
                <?php
                  $db = new CursosDB();  //obtemos os cursos da db
                  $cursos = $db->getCursos();
                  $db->cerrarConexion();
                ?>
              <div class="col-md-4" id="divCursoNovo">
                <label for="novoCurso" class="form-label">Curso</label>
                <select id="novoCurso" name="novoCurso" class="form-select">
                  <option value="0">Seleción de curso</option>
                  <?php                        
                    foreach ($cursos as $key => $value) {
                      echo "<option value='$key'>".$value."</option>";
                    }
                  ?>
                </select>
              </div>

              <div class="col-md-4" id="divNovoAsignaturas">
                  <label for="novoAsignaturas" class="form-label">Materias</label>
                  <select id="novoAsignaturas" name="novoAsignaturas" class="form-select" title="Manter pulsado 'Ctrl' para seleccionar varias" multiple>
                    <option value="0">Selección de materias</option>
                  </select>
                  <div class="form-text">
                    Manten "Ctrl" pulsado para seleccionar varias materias
                  </div>

                  <script>
                  let novoRol = document.getElementById("novoRol");
                  novoRol.addEventListener("change" , () => {
                    if(novoRol.value != 3) {
                      document.getElementById("divCursoNovo").style.display = "none";
                      document.getElementById("divNovoAsignaturas").style.display = "none";
                    }else {
                      document.getElementById("divCursoNovo").style.display = "";
                      document.getElementById("divNovoAsignaturas").style.display = "";

                    }
                  }); 

                  selectNovoCurso = document.getElementById("novoCurso");
                  // selectAsignaturas = document.getElementById("novoAsignaturas");
                  selectNovoCurso.addEventListener("change", () => {
                    cargarAsignaturas(selectNovoCurso.value,"novoAsignaturas");
                  });
                  </script>
              </div>

              <div class="col-md-12">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="novoActivo" id="novoActivo" value="1" checked>
                    <label class="form-check-label" for="novoActivo">Usuario activo</label>
                </div>
              </div>
              <div class="col-md-12">
                * Campos obligatorios.
              </div>
              <div id="msgNovoUsuario"></div>
            </div>
          </form>
          <!-- fin formulario -->  
        </div>
      </div>
      <!-- Modal crear usuario footer-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick=<?php echo $_SESSION["rol"] == "administrador" ? "getUsersData()" : "getStudentTable()"?>>Cerrar</button>
        <!-- <input type="submit" form="crearUsuario" class="btn btn-primary" name="enviar" id="enviar" value="Rexistrar usuario" onclick="createUser()"></input> -->
        <button class="btn btn-primary" name="enviar" id="enviar"  onclick="createUser()">Rexistrar usuario</button>

      </div>
      
    </div>
  </div>
</div>

