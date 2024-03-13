//iniciar o editor
tinymce.init({
    selector: '#enunciado',
    language: 'es',
    width: '100%',
    height:600,
    plugins: ['fullscreen','table','code','searchreplace','eqneditor'],
    toolbar: 'fullscreen | undo redo | searchreplace | eqneditor | styles | fontfamily |' + 
    '| fontsizeinput | forecolor | backcolor | bold italic | alignleft aligncenter alignright alignjustify | outdent indent',
  });

//listener para cargar as asignaturas correspondentes co curso seleccionado
let cursoExercicio = document.getElementById("curso");
cursoExercicio.addEventListener("change", () => {
    cargarAsignaturas(cursoExercicio.value,"asignatura");
});