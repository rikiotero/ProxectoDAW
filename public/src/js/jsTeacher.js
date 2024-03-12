/**----------------------PANEL DE PROFESOR----------------------------------
 * ----------------------------------------------------------------------------------
 */

/**
 * Carga a tabla de estudiantes según os filtros que se apliquen
 * @param {int} paxina número de páxina desde a cal facer a búsqueda
 */
function getStudentTable(paxina) {
  
  let filtro = document.getElementById("buscar").value;
  let curso = document.getElementById("filtroCurso").value;
  let numRexistros = document.getElementById("numRexistros").value;
  let activoCkecked;
  let inactivoCkecked;

  if(paxina != null) {
    paxinaActual = paxina;
  }

  if( document.getElementById("activado").checked )
  {
    activoCkecked = "1";
  }else {
    activoCkecked = "0";
  }

  if( document.getElementById("inactivo").checked )
  {
    inactivoCkecked = "1";
  }else {
    inactivoCkecked = "0";
  }

  let tablaAlumnos = document.getElementById("tablaAlumnos");

  let formData = new FormData();
  formData.append("activo", activoCkecked);
  formData.append("inactivo", inactivoCkecked);
  formData.append("curso", curso);
  formData.append("buscar", filtro);  
  formData.append("numRexistros", numRexistros);
  formData.append("paxina", paxinaActual);  
 
  fetch( "./php_functions/loadStudentTable.php", {
    method: "POST",
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    tablaAlumnos.innerHTML = data.html;
    document.getElementById("botonsPaxinas").innerHTML = data.paxinacion;

    // añadir listener os botóns de editar usuario da tabla de estudiantes, recorrense os nodos fillos da tabla
    // e engádese o listener 
    tablaAlumnos.childNodes.forEach( element => {
      element.childNodes[10].childNodes[0].addEventListener("click", () => {
        updateUsersListModal.show();                //abre o modal "updateUsersListModal" declarado en modal.js         
        // let id = element.childNodes[10].childNodes[0].id;
        let id = element.childNodes[0].innerHTML;
        loadUserDataModal(id);                      //definida en updateUser.js, carga os datos do usuario
      })
    })

    // añadir listener os botóns de borrar usuario da tabla de estudiantes, recorrense os nodos fillos da tabla
    // e engádese o listener
    tablaAlumnos.childNodes.forEach( element => {
      element.childNodes[11].childNodes[0].addEventListener("click", () => {
        deleteUserModal.show();               //abre o modal "deleteUserModal"
        // alert("pulsado id:"+element.childNodes[11].childNodes[0].id+" evenTarget:"+event.target)
        //gardo o id do usuario nun campo oculto do modal
        let id = element.childNodes[0].innerHTML;
        document.getElementById("idUsuarioBorrar").value = id;
        document.getElementById("usuarioBorrar").innerHTML = element.childNodes[1].innerHTML;
      })
    })

  })
  .catch(err => console.log(err))
}
let paxinaActual = 1;         
getStudentTable(1);          //carga a tabla de estudiantes

//listeners para filtrar a tabla de estudiantes
document.getElementById("buscar").addEventListener("keyup", () => {  //filtro por búsqueda
  getStudentTable(1);
});  
document.getElementById("activado").addEventListener("change", () => {   //filtro usuario activo
  getStudentTable(1);
});  
document.getElementById("inactivo").addEventListener("change", () => {  //filtro usuario inactivo
  getStudentTable(1);
});  
document.getElementById("filtroCurso").addEventListener("change", () => {  //filtro por curso 
  getStudentTable(1);
});

document.getElementById("numRexistros").addEventListener("change", () => {     //listener cantidade de rexistros a mostrar
  getStudentTable(1);
});   

//carga de datos do usuario logueado na pantalla modal de editar o seu perfil
// loadUserDataModal(document.getElementById("idUsuario").value);   //definida en ajaxUser.js

getTablaCursos();           //carga a tabla de cursos
getCursos("selectCurso");   //carga os cursos no select da pestaña de "xestión de cursos e asignaturas"
getCursos("filtroCurso");   //carga a lista de cursos no select da pestaña de listar alumnos no panel de profesor
getCursos("filtroCursoEx");  //carga a lista de cursos no select da pestaña de listar exercicios




//listeners para filtrar a búsqueda de exercicios
document.getElementById("buscarEx").addEventListener("keyup", () => {  //filtro por búsqueda
  getExerciciosTabla(1);
});  
document.getElementById("ExActivado").addEventListener("change", () => {   //filtro usuario activo
  getExerciciosTabla(1);
});  
document.getElementById("ExInactivo").addEventListener("change", () => {  //filtro usuario inactivo
  getExerciciosTabla(1);
});  
document.getElementById("filtroCursoEx").addEventListener("change", () => {  //filtro por curso 
  getExerciciosTabla(1);
});
document.getElementById("numRexistrosEX").addEventListener("change", () => {     //listener cantidade de rexistros a mostrar
  getExerciciosTabla(1);
});

let paxinaActualEx = 1;   //páxina actual da tabla de exercicios
getExerciciosTabla(1);    //carga a tabla de exercicios. definida en ajaxExercicios.js

//definición de ventanas modales
const createUserModal = new bootstrap.Modal(document.getElementById("createUserModal"), {});
const deleteUserModal = new bootstrap.Modal(document.getElementById("deleteUserModal"), {});
// const updateUserModal = new bootstrap.Modal(document.getElementById("updateUserModal"), {});
const updateUsersListModal = new bootstrap.Modal(document.getElementById("updateUsersListModal"), {});
const updatePasswModal = new bootstrap.Modal(document.getElementById("updatePassModal"), {});
const updateCursoModal = new bootstrap.Modal(document.getElementById("updateCursoModal"), {});          //modal actualizar nome de curso
const updateAsignModal = new bootstrap.Modal(document.getElementById("updateAsingModal"), {});          //modal actualizar nome de asignatura
const deleteExercModal = new bootstrap.Modal(document.getElementById("deleteExercModal"), {});          //modal confirmación borrar exercicio

//Botons 
const createUserModalButton = document.getElementById("createUserModalButton");
const updaTeacherModalButton = document.getElementById("updateTeacherModalButton");
const updatePassModalButton = document.getElementById("updatePassListModalButton");

//listener para abrir o modal de editar usuario da pantalla de datos de usuario
updaTeacherModalButton.addEventListener("click", () => {
    // updateUserModal.show();
    updateUsersListModal.show();
    //carga de datos do usuario logueado na pantalla modal de editar o seu perfil
    loadUserDataModal(document.getElementById("idUsuario").value);   //definida en ajaxUser.js 
})

//listener para abrir o modal de modificar o contrasinal de usuario
updatePassModalButton.addEventListener("click", () => {
    updatePasswModal.show();
})

//listener para abrir o modal de crear novo usuario
createUserModalButton.addEventListener("click", () => {          
    createUserModal.show();
    const divError = document.getElementById("msgNovoUsuario");
    divError.innerHTML = "";
    divError.classList.remove("alert","alert-danger");

    //reseteo dos campos do formulario e dos estilos dos campos
    document.getElementById("novoUsuario").value = "";
    document.getElementById("novoUsuario").style.borderColor = "rgb(233,236,239)";
    document.getElementById("novoUsuario").classList.remove("redText");
    document.getElementById("novoPassword").value = "";
    document.getElementById("novoPassword").style.borderColor = "rgb(233,236,239)";
    document.getElementById("novoPassword").classList.remove("redText");
    document.getElementById("novoPassword2").value = "";
    document.getElementById("novoPassword2").style.borderColor = "rgb(233,236,239)";
    document.getElementById("novoPassword2").classList.remove("redText");
    document.getElementById("novoNome").value = "";
    document.getElementById("novoNome").style.borderColor = "rgb(233,236,239)";
    document.getElementById("novoNome").classList.remove("redText");
    document.getElementById("novoApellido1").value = "";
    document.getElementById("novoApellido1").style.borderColor = "rgb(233,236,239)";
    document.getElementById("novoApellido1").classList.remove("redText");
    document.getElementById("novoApellido2").value = "";
    document.getElementById("novoApellido2").style.borderColor = "rgb(233,236,239)";
    document.getElementById("novoApellido2").classList.remove("redText");
    document.getElementById("novoEmail").value = "";
    document.getElementById("novoTlf").value = "";
    document.getElementById("novoRol").options[2].selected = true;
    document.getElementById("novoRol").disabled = true;
    document.getElementById("novoCurso").options[0].selected = true;
    document.getElementById("novoAsignaturas").innerHTML = "<option value='0'>Selección de materias</option>"
    document.getElementById("divCursoNovo").style.display = "";             
    document.getElementById("divNovoAsignaturas").style.display = "";
})

