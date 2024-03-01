/**----------------------PANEL DE PROFESOR----------------------------------
 * ----------------------------------------------------------------------------------
 */

/**
 * Carga a tabla de estudiantes según os filtros que se apliquen
 */
function getStudentTable() {

    let filtro = document.getElementById("buscar").value;
    let curso = document.getElementById("filtroCurso").value;
    let activoCkecked;
    let inactivoCkecked;
  
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
  
    // switch (rol) {
    //   case "1": 
    //       formData.append("rol", "administrador");         
    //     break;
  
    //   case "2":  
    //       formData.append("rol", "profesor");
    //       break;
    //   case "3":
    //       formData.append("rol", "estudiante");
    //     break;
  
    //   default:
    //     break;
    // }
    let url = "./php_functions/loadStudentTable.php";
    let tablaAlumnos = document.getElementById("tablaAlumnos");
    // let data =  {
    //   activoCkecked: activoCkecked,
    //   inactivoCkecked: inactivoCkecked,
    //   curso: curso,
    //   filtro: filtro,
    // }
    let formData = new FormData();
    formData.append("activo", activoCkecked);
    formData.append("inactivo", inactivoCkecked);
    formData.append("curso", curso);
    formData.append("buscar", filtro);
  
  
   fetch( './php_functions/loadStudentTable.php', {
      method: "POST",
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      tablaAlumnos.innerHTML = data
  
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

  
//carga de datos do usuario logueado na pantalla modal de editar o seu perfil
loadUserDataModal(document.getElementById("idUsuario").value);   //definida en ajaxUser.js

getStudentTable(); //carga a tabla de estudiantes, definida en ajaxUser.js
getTablaCursos();  //carga a tabla de cursos
getCursos("selectCurso");

//listeners para filtrar a tabla de estudiantes
document.getElementById("buscar").addEventListener("keyup", getStudentTable);
document.getElementById("activado").addEventListener("change", getStudentTable);
document.getElementById("inactivo").addEventListener("change", getStudentTable);
document.getElementById("filtroCurso").addEventListener("change", getStudentTable);

getCursos("filtroCurso"); //carga a lista de cursos no select da pestaña de listar alumnos no panel de profesor
getCursos("filtroCursoEx"); //carga a lista de cursos no select da pestaña de listar exercicios

getExerciciosTabla(); //carga a tabla de exercicios. definida en ajaxExercicios.js

//listeners para filtrar a búsqueda de exercicios
document.getElementById("buscarEx").addEventListener("keyup", getExerciciosTabla);
document.getElementById("ExActivado").addEventListener("change", getExerciciosTabla);
document.getElementById("ExInactivo").addEventListener("change", getExerciciosTabla);
document.getElementById("filtroCursoEx").addEventListener("change", getExerciciosTabla);


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
    // loadUserDataModal(document.getElementById("idUsuario").value);   //definida en ajaxUser.js 
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
    document.getElementById("novoAsignaturas").innerHTML = "<option value='0'>Selección de asignaturas</option>"
    document.getElementById("divCursoNovo").style.display = "";             
    document.getElementById("divNovoAsignaturas").style.display = "";
})

