/**
 * Engade un curso novo
 */
function addCurso() { 

  let cursoNovo = document.getElementById("addCurso").value;
  if ( cursoNovo != "" ) {

    fetch( "./php_functions/addCurso.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(cursoNovo)
    })
    .then(response => response.json())
    .then(data => {

      document.getElementById("addCurso").value = "";
      getTablaCursos();   //reacargar tabla      
      notificacion = document.getElementById("msgCursos");

      if ( Array.isArray(data) ) { //curso insertado correctamente
        notificacion.innerHTML = data[1];  
        //engádese o curso novo ao select de curso no modal de actualizar usuario
        // document.getElementById("curso").add(new Option(cursoNovo,data[0]));
        getCursos("selectCurso");  //actualiza o select de curso da pestaña de editaradignaturas
        getCursos("curso");        //actualiza o select de curso do nodal de editas usuario
      }else {
        notificacion.innerHTML = data; 
      }
      
      setTimeout(function() {
          notificacion.innerHTML = "";
      }, 5000);

    })
    .catch(err => console.log(err))
  }
}

/**
 * Engade unha asignatura
 */
function addAsignatura() { 

  let curso = document.getElementById("selectCurso").value;
  let asignNova = document.getElementById("addAsign").value;

  let datos = {
    curso: curso,
    asignNova: asignNova
  }

  if ( asignNova != "" && curso != "0" ) {

    fetch( "./php_functions/addAsinatura.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(data => {

      document.getElementById("addAsign").value = "";
      loadAsignaturasTable( document.getElementById("selectCurso").value );   //recargar tabla   
      notificacion = document.getElementById("msgCursos");      

      if ( Array.isArray(data) ) { //curso insertado correctamente
        notificacion.innerHTML = data[1];   
      }else {
        notificacion.innerHTML = data; 
      }
      
      setTimeout(function() {
          notificacion.innerHTML = "";
      }, 5000);

    })
    .catch(err => console.log(err))
  }
}

/**
 * Borra un curso 
 * @param {string} id Id do curso a borrar
 */
function deleteCurso(id) {

  fetch( "./php_functions/deleteCurso.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(id)
  })
  .then(response => response.json())
  .then(data => {

    getTablaCursos();   //recargar tabla      
    notificacion = document.getElementById("msgCursos");
    notificacion.innerHTML = data;
    getCursos("selectCurso");  //actualiza o select de curso da pestaña de editar asignaturas
    getCursos("curso");        //actualiza o select de curso do nodal de editar usuario
    //bórrase o curso do select de curso no modal de actualizar usuario
    // let select = document.getElementById("curso");
    // let options = Array.from( select.options );
    // let index = options.findIndex( (opt) => opt.value == id );
    // select.remove(index);

    setTimeout(function() {
      notificacion.innerHTML = "";
    }, 5000);    

  })
  .catch(err => console.log(err))
}


/**
 * Borra unha asignatura 
 * @param {string} id Id da asignatura a borrar
 */
function deleteAsignatura(id) {

  // if ( confirm("Desexas borrar a asignatura?") ){
    fetch( "./php_functions/deleteAsignatura.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(id)
    })
    .then(response => response.json())
    .then(data => {      
      notificacion = document.getElementById("msgCursos");
      notificacion.innerHTML = data;
      loadAsignaturasTable(document.getElementById("selectCurso").value);
  
      setTimeout(function() {
        notificacion.innerHTML = "";
      }, 5000);    
  
    })
    .catch(err => console.log(err))
  // }
  
}

/**
 * Actualiza o nome dun curso
 * @param {string} id Id do curso a actualizar 
 * @param {string} nomeNovo Nome novo do curso 
 */
function updateCurso(id,nomeNovo) {

  let datos = {
    id: id,
    nomeNovo: nomeNovo
  }
  fetch( "./php_functions/updateCurso.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(datos)
  })
  .then(response => response.json())
  .then(data => {      
    notificacion = document.getElementById("msgUpdateCursos");
    notificacion.innerHTML = data;
    getTablaCursos();

    setTimeout(function() {
      notificacion.innerHTML = "";
    }, 5000);    

  })
  .catch(err => console.log(err))
}

//listener botón actualizar curso
document.getElementById("actualizarCurso").addEventListener("click", () => { 
  let nomeNovo = document.getElementById("cursoUpdate").value;
  let id = document.getElementById("IdcursoUpdate").value;
  updateCurso(id,nomeNovo);
});

/**
 * Actualiza o nome duha asignatura
 * @param {string} id Id do asignatura a actualizar 
 * @param {string} nomeNovo Nome novo da asignatura 
 */
function updateAsignatura(idAsignatura,idCurso,nomeNovo) {

  let datos = {
    idAsignatura: idAsignatura,
    idCurso: idCurso,
    nomeNovo: nomeNovo
  }

  fetch( "./php_functions/updateAsignatura.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(datos)
  })
  .then(response => response.json())
  .then(data => {

    notificacion = document.getElementById("msgUpdateAsign");
    notificacion.innerHTML = data;
    loadAsignaturasTable(idCurso);

    setTimeout(function() {
      notificacion.innerHTML = "";
    }, 5000);    

  })
  .catch(err => console.log(err))
}

//listener botón actualizar a asignatura
document.getElementById("actualizarAsign").addEventListener("click", () => { 
  let nomeNovo = document.getElementById("asignUpdate").value;
  let idAsignatura = document.getElementById("IdAsignUpdate").value;
  let idCurso = document.getElementById("IdCursoAsign").value;
  updateAsignatura(idAsignatura,idCurso,nomeNovo);
});


/**
 * Obten os cursos da base de datos e mostraos en forma de tabla
 */
function getTablaCursos() {

  fetch( "./php_functions/loadCursosTable.php", {
    method: "POST"
  })
  .then(response => response.json())
  .then(data => {

    let tablaCursos = document.getElementById("tablaCursos"); 
    tablaCursos.innerHTML = data   

    // añadir listener os botóns de editar curso da tabla de cursos, recorrense os nodos fillos da tabla
    // e engádese o listener 
    tablaCursos.childNodes.forEach( element => {
      element.childNodes[2].childNodes[0].addEventListener("click", (e) => {    //listener para os botón de editar curso da lista de cusos 
        let id = element.childNodes[0].innerHTML;                               //id do curso a actualizar
        updateCursoModal.show();                                                //abrir modal de editar nome de curso
        document.getElementById("IdcursoUpdate").value = id;                    //gárdase o Id do curso nun campo oculto do modal
        document.getElementById("msgUpdateCursos").innerHTML = "";              //borrar mensaxes de exito/error
        document.getElementById("cursoUpdate").value = element.childNodes[1].innerHTML; //engadir o input text o nome do curso
      });
    })

    // añadir listener os botóns de eliminar curso da tabla de cursos, recorrense os nodos fillos da tabla
    // e engádese o listener 
    tablaCursos.childNodes.forEach( element => {
      element.childNodes[3].childNodes[0].addEventListener("click", (e) => {
        // id = element.childNodes[3].childNodes[0].id;
        // cursoId = id.slice(12,);
        let id = element.childNodes[0].innerHTML;
        deleteCurso(id);
      });
    });

  })
  .catch(err => console.log(err))
}

getTablaCursos();

/**
 * Obten os cursos da base de datos e cargaos en un input de tipo select
 * @param {string} id Id do select donde se cargan os cursos 
 */
function getCursos(selectId) {
  fetch( "./php_functions/loadCursosOption.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(selectId)
  })
  .then(response => response.json())
  .then(data => {
      let selectInput = document.getElementById(selectId);
      selectInput.innerHTML = data;
  })
  .catch(err => console.log(err))
}
getCursos("selectCurso");

/**
 * Carga as asignaturas do curso correspondente no "input select" de asignaturas
 * @param {string} idCurso Id do curso
 * @param {string} idSelectInput Id do input select donde se van cargar as asignaturas
 */
function cargarAsignaturas(idCurso,idSelectInput) {
                          
  fetch("./php_functions/getAsignaturas.php", {
      method: "POST",
      headers: {
          "Content-Type": "application/json",
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

/**
 * Carga a tabla de asignaturas
 * @param {string} idCurso Id do curso
 */
function loadAsignaturasTable(idCurso) {
  let tablaAsignaturas = document.getElementById("tablaAsignaturas");
  let idCursoAsig = document.getElementById("selectCurso").value;

  fetch("./php_functions/loadAsignaturasTable.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
    },
    body: JSON.stringify(idCurso),
  })
  .then(response => response.json())
  .then(data => { 
                                
    tablaAsignaturas.innerHTML = data;

    // añadir listener os botóns de editar asignatura da tabla de asignaturas, recorrense os nodos fillos da tabla
    // e engádese o listener 
    tablaAsignaturas.childNodes.forEach( element => {
      element.childNodes[2].childNodes[0].addEventListener("click", (e) => {
        // alert("pulsado id:"+element.childNodes[2].childNodes[0].id+" evenTarget:"+e.target)    
        let idAsign = element.childNodes[0].innerHTML;
        updateAsignModal.show();                                                         //abrir modal de editar nome de asignatura
        document.getElementById("asignUpdate").value = element.childNodes[1].innerHTML;  //engadir o input text o nome da asignatura
        document.getElementById("IdAsignUpdate").value = idAsign;                        //gárdase o Id da asignatura nun campo oculto do modal
        document.getElementById("IdCursoAsign").value = idCursoAsig;                     //gárdase o Id do curso nun campo oculto do modal
        document.getElementById("msgUpdateAsign").innerHTML = "";                        //borrar mensaxes de exito/error
      });
    });

    // añadir listener os botóns de eliminar asignatura da tabla de asignaturas, recorrense os nodos fillos da tabla
    // e engádese o listener 
    tablaAsignaturas.childNodes.forEach( element => {
      element.childNodes[3].childNodes[0].addEventListener("click", (e) => {
        // id = element.childNodes[3].childNodes[0].id;
        // cursoId = id.slice(12,);
        let id = element.childNodes[0].innerHTML;
        deleteAsignatura(id);
      });
    });
    
  }).catch(err => {
      console.error("ERROR: ", err.message);
  });
}

let selectCurso = document.getElementById("selectCurso");

selectCurso.addEventListener("change", () => {
  idCurso = selectCurso.value;
  loadAsignaturasTable(idCurso);
})

