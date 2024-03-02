/**----------------------PANEL DE ESTUDIANTE----------------------------------
 * ----------------------------------------------------------------------------------
 */

// carga de datos do usuario logueado na pantalla modal de editar o seu perfil
loadUserDataModal(document.getElementById("idUsuario").value);  //definida en ajaxUser.js

//listeners para filtrar a tabla de estudiantes
document.getElementById("buscarEx").addEventListener("keyup", getExerciciosStudent);
getExerciciosStudent(); //carga a tabla de exercicios. definida en ajaxExercicios.js

//definición de ventanas modales
const updateUsersListModal = new bootstrap.Modal(document.getElementById("updateUsersListModal"), {});
const updatePasswModal = new bootstrap.Modal(document.getElementById("updatePassModal"), {});

//Botons 
const updaStudentModalButton = document.getElementById("updateStudentModalButton");
const updatePassModalButton = document.getElementById("updatePassListModalButton");



//listener para abrir o modal de editar usuario da pantalla de datos de usuario
updaStudentModalButton.addEventListener("click", () => {
    // updateUserModal.show();
    updateUsersListModal.show();
    //carga de datos do usuario logueado na pantalla modal de editar o seu perfil
    // loadUserDataModal(document.getElementById("idUsuario").value);  //definida en ajaxUser.js
 
})

//listener para abrir o modal de modificar o contrasinal de usuario
updatePassModalButton.addEventListener("click", () => {
    updatePasswModal.show();
})





