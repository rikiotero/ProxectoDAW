<!-- Modal borrar usuario-->
<div class="modal fade modal-sm" id="deleteUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal borrar usuario header-->      
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteUserModalLabel">Borrar usuario</h1>
      </div>
        <!-- Modal actualizar usuario body-->
      <div class="modal-body">
        <input type="hidden" name="idUsuarioBorrar" id="idUsuarioBorrar" value="">
        <div class="container">
          Vas a borrar o usuario, esta accion non se pode desfacer, realmente desexas eliminalo?
        </div>
      </div>
        <!-- Modal actualizar usuario footer-->
      <div class="modal-footer">
        <!-- onclick="window.location.reload()" -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <!-- <input type="submit" form="actualizaUsuario" class="btn btn-primary" name="enviar" id="enviar" value="Actualizar"></input> -->
        <button class="btn btn-danger" name="borrar" id="borrar"  onclick="deleteUser()">Borrar usuario</button>
      </div>      
    </div>
  </div>
</div>
<!-- Fin Modal actualizar usuario-->
