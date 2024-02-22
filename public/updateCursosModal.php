<!-- Modal actualizar cursos e asignaturas ------------------------------------------------->
<!-------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------->

<!-- Modal actualizar cursos-->
<div class="modal fade" id="updateCursoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateCursoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal actualizar cursos header-->      
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateCursoModalLabel">Editar nome do curso</h1>
      </div>
        <!-- Modal actualizar cursos body-->
      <div class="modal-body">
            <div id="msgUpdateCursos"></div>
            <div class="container">
                <form  class="row g-3 align-items-center" id="actualizaCurso" name="actualizaCurso"> 
                    <div class="row g-3">
                        <div class="col-md-12">
                            <input type="hidden"  name="IdcursoUpdate" id="IdcursoUpdate" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label for="cursoUpdate" class="form-label">Novo nome</label>
                            <input type="text"  name="cursoUpdate" id="cursoUpdate" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
      </div>
        <!-- Modal actualizar cursos footer-->
      <div class="modal-footer mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" name="sairActCurso" id="sairActCurso">Cerrar</button>
        <button class="btn btn-primary" name="actualizarCurso" id="actualizarCurso">Actualizar curso</button>
      </div>      
    </div>
  </div>
</div>
<!-- Fin Modal cursos-->


<!-- Modal actualizar asignatura-->
<div class="modal fade" id="updateAsingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateAsingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal actualizar asignatura header-->      
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateAsingModalLabel">Editar nome da asignatura</h1>
      </div>
        <!-- Modal actualizar asignatura body-->
      <div class="modal-body">
            <div id="msgUpdateAsign"></div>
            <div class="container">
                <form  class="row g-3 align-items-center" id="actualizaAsign" name="actualizaAsign"> 
                    <div class="row g-3">
                        <div class="col-md-12">
                            <input type="hidden"  name="IdAsignUpdate" id="IdAsignUpdate" class="form-control">
                            <input type="hidden"  name="IdCursoAsign" id="IdCursoAsign" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label for="asignUpdate" class="form-label">Novo nome</label>
                            <input type="text"  name="asignUpdate" id="asignUpdate" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
      </div>
        <!-- Modal actualizar asignatura footer-->
      <div class="modal-footer mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" name="sairActAsign" id="sairActAsign">Cerrar</button>
        <button class="btn btn-primary" name="actualizarAsign" id="actualizarAsign">Actualizar asignatura</button>
      </div>      
    </div>
  </div>
</div>
<!-- Fin Modal asignatura-->