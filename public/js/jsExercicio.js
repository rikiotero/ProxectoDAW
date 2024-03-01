
//listener para cargar as asignaturas correspondentes co curso seleccionado
let cursoExercicio = document.getElementById("curso");
cursoExercicio.addEventListener("change", () => {
    cargarAsignaturas(cursoExercicio.value,"asignatura");
});

  // getCursos("curso");

  //carga o contido do textarea TinyMCE
  window.addEventListener('load', function() {
    let cadena = <?php echo '`'.$exercicio->getEnunciado().'`'?>;
    setTimeout(function() {
      tinymce.activeEditor.setContent(cadena);
    }, 1000);

    // fetch("./php_functions/loadEnunciado.php", {
    //   method: "POST",
    //   headers: {
    //       "Content-Type": "application/json",
    //   },
    //   body: JSON.stringify(datos),
    //   })
    // .then(response => response.json())
    // .then(data => {
    //   tinymce.activeEditor.setContent(response);
    // }).catch(err => {
    //     console.error("ERROR: ", err.message)
    //   }); 

     
  });
  
