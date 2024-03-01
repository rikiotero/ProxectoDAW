
/**----------------------PANEL DE PROFESOR----------------------------------
 * ----------------------------------------------------------------------------------
 */

//definición de ventanas modales
const createUserModal = new bootstrap.Modal(document.getElementById("createUserModal"), {});
const deleteUserModal = new bootstrap.Modal(document.getElementById("deleteUserModal"), {});
// const updateUserModal = new bootstrap.Modal(document.getElementById("updateUserModal"), {});
const updateUsersListModal = new bootstrap.Modal(document.getElementById("updateUsersListModal"), {});
const updatePasswModal = new bootstrap.Modal(document.getElementById("updatePassModal"), {});
const updateCursoModal = new bootstrap.Modal(document.getElementById("updateCursoModal"), {});          //modal actualizar nome de curso
const updateAsignModal = new bootstrap.Modal(document.getElementById("updateAsingModal"), {});          //modal actualizar nome de asignatura
const deleteExercModal = new bootstrap.Modal(document.getElementById("deleteExercModal"), {});          //modal confirmación borrar exercicio



//Botons panel de profesor
const createUserModalButton = document.getElementById("createUserModalButton");
const updaTeacherModalButton = document.getElementById("updateTeacherModalButton");
const updatePassModalButton = document.getElementById("updatePassListModalButton");


//Listeners panel de profesor

//listener para abrir o modal de editar usuario da pantalla de datos de usuario
updaTeacherModalButton.addEventListener("click", () => {
    // updateUserModal.show();
    updateUsersListModal.show();
    loadUserDataModal(document.getElementById("idUsuario").value);  
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

getCursos("filtroCurso"); //carga a lista de cursos no select da pestaña de listar alumnos no panel de profesor
getCursos("filtroCursoEx"); //carga a lista de cursos no select da pestaña de listar exercicios
