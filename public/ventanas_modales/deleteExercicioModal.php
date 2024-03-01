<!-- Modal borrar exercicio-->
<div class="modal fade modal-sm" id="deleteExercModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteExercModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal borrar exercicio header-->      
      <div class="modal-header">
        <h1 class="modal-title fs-5">Borrar exercicio</h1>
      </div>
        <!-- Modal actualizar exercicio body-->
      <div class="modal-body">
        <input type="hidden" name="idExercBorrar" id="idExercBorrar" value="">
        <div class="container">
          Vas a borrar o exercicio, esta accion non se pode desfacer, realmente desexas eliminalo?
        </div>
      </div>
        <!-- Modal actualizar exercicio footer-->
      <div class="modal-footer">
        <!-- onclick="window.location.reload()" -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="getExerciciosTabla()">Cerrar</button>
        <!-- <input type="submit" form="actualizaexercicio" class="btn btn-primary" name="enviar" id="enviar" value="Actualizar"></input> -->
        <button class="btn btn-danger" name="borrar" id="borrarExerc" onclick="deleteExercicio();">Borrar exercicio</button>
      </div>      
    </div>
  </div>
</div>
<!-- Fin Modal actualizar exercicio-->
