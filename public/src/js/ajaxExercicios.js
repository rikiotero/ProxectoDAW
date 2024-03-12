
/**
 * Recupera os exercicios filtrados según elixa o usuario e mostraos nunha tabla, carga os exercicios para os profesores
 */
function getExerciciosTabla(paxina) {

  let filtro = document.getElementById("buscarEx").value;
  let curso = document.getElementById("filtroCursoEx").value;
  let numRexistros = document.getElementById("numRexistrosEX").value;
  let activoCkecked;
  let inactivoCkecked;

  if(paxina != null) {      //si non recibe páxina manten a actual
    paxinaActual = paxina;
  }

  if( document.getElementById("ExActivado").checked )
  {
    activoCkecked = "1";
  }else {
    activoCkecked = "0";
  }

  if( document.getElementById("ExInactivo").checked )
  {
    inactivoCkecked = "1";
  }else {
    inactivoCkecked = "0";
  }

  let tablaExercicios = document.getElementById("tablaExercicios");

  let formData = new FormData();
  formData.append("activo", activoCkecked);
  formData.append("inactivo", inactivoCkecked);
  formData.append("curso", curso);
  formData.append("buscar", filtro);  
  formData.append("numRexistros", numRexistros);
  formData.append("paxina", paxinaActual);

 fetch( './php_functions/loadExerciciosTabla.php', {
    method: "POST",
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    tablaExercicios.innerHTML = data.html;
    document.getElementById("botonsPaxinasEx").innerHTML = data.paxinacion;

    // añadir listener os botóns de borrar exercicio da tabla de exercicios, recorrense os nodos fillos da tabla
    // e engádese o listener
    tablaExercicios.childNodes.forEach( element => {
      element.childNodes[8].childNodes[0].addEventListener("click", () => {
        deleteExercModal.show();                          //abre o modal "deleteExercModal" de confirmación de borrado                         
        let id = element.childNodes[0].innerHTML;         //gardo o id do exercicio nun campo oculto do modal
        document.getElementById("idExercBorrar").value = id;
      })
    })

  })
  .catch(err => console.log(err))
}

/**
* Recupera os exercicios activos de un estudiante filtrados por curso e polo cuadro de búsqueda, 
* pinta a tabla de exercicios dos estudiantes
*/
function getExerciciosStudent(paxina) {

  let filtro = document.getElementById("buscarEx").value;     //campo de búsqueda 
  let numRexistros = document.getElementById("numRexistrosEX").value;
  // let curso = document.getElementById("curso").value;         //curso

  // let asignaturaSelect = document.getElementById("asignaturas").selectedOptions;
  // let asignaturas = [];                                       //asignaturas
  // [...asignaturaSelect].forEach( element => { 
  //   asignaturas.push(element.value);
  // });

  if(paxina != null) {      //si non recibe páxina manten a actual
    paxinaActual = paxina;
  }

  let tablaExercicios = document.getElementById("tablaExercicios");

  let data = {
    filtro: filtro,
    numRexistros: numRexistros,
    paxina: paxinaActual,
  }

 fetch( './php_functions/loadExerciciosStudent.php', {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
  .then(response => response.json())
  .then(data => {
    tablaExercicios.innerHTML = data.html;
    document.getElementById("botonsPaxinasEx").innerHTML = data.paxinacion;
  })
  .catch(err => console.log(err))
}

/**
 * Borra un exercicio 
 */
function deleteExercicio() {

    let id = document.getElementById("idExercBorrar").value;
    fetch( "./php_functions/deleteExercicio.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(id)
    })
    .then(response => response.json())
    .then(data => {
  
      getExerciciosTabla();           //recargar tabla de exercicios
      deleteExercModal.hide();     
      notificacion = document.getElementById("notificacionExercicio"); //notificación
      notificacion.innerHTML = data;

      setTimeout(function() {        //borrado da notificación
        notificacion.innerHTML = "";
      }, 5000);    
  
    })
    .catch(err => console.log(err))
  }

  /**
   * Garda un exercicio
   */
  function saveExercicio() {

    //recollida de datos
    let creador = document.getElementById("creador").value;
    let fechaCreacion = document.getElementById("fechaCreacion").value;
    let tema = document.getElementById("tema").value;
    let curso = document.getElementById("curso").value;
    let asignatura = document.getElementById("asignatura").value;
    let exercActivo = document.getElementById("exercActivo").checked;
    let enunciado = tinymce.activeEditor.getContent();
    
    let datos = {
      creador: creador,
      fechaCreacion: fechaCreacion,
      tema: tema,
      curso: curso,
      asignatura: asignatura,
      exercActivo: exercActivo,
      enunciado: enunciado
    };

    fetch("./php_functions/createExercicio.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(datos),
      })
    .then(response => response.json())
    .then(data => {
      document.getElementById("msgExercicio").innerHTML = data;
     
      setTimeout(function() {        //borrado da notificación
        document.getElementById("msgExercicio").innerHTML = "";
      }, 10000);

    }).catch(err => {
        console.error("ERROR: ", err.message)
      }); 
  }

  /**
   * Actualiza os datos de un exercicio
   */
  function updateExercicio() {

    //recollida de datos
    
    let idExerc = document.getElementById("idExerc").value;
    let creador = document.getElementById("creador").value;
    let fechaCreacion = document.getElementById("fechaCreacion").value;
    let tema = document.getElementById("tema").value;
    let curso = document.getElementById("curso").value;
    let asignatura = document.getElementById("asignatura").value;
    let exercActivo = document.getElementById("exercActivo").checked;
    let enunciado = tinymce.activeEditor.getContent();
    
    let datos = {
      idExerc: idExerc,
      creador: creador,
      fechaCreacion: fechaCreacion,
      curso: curso,
      tema: tema,
      asignatura: asignatura,
      exercActivo: exercActivo,
      enunciado: enunciado
    };

    fetch("./php_functions/updateExercicio.php", {
      method: "POST",
      headers: {
          "Content-Type": "application/json",
      },
      body: JSON.stringify(datos),
      })
    .then(response => response.json())
    .then(data => {
      document.getElementById("msgExercicio").innerHTML = data;

      setTimeout(function() {          
        document.getElementById("msgExercicio").innerHTML = "";
      }, 5000);
      
    }).catch(err => {
        console.error("ERROR: ", err.message)
      });
  }


