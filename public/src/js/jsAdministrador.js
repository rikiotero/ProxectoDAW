/**----------------------PANEL DE ADMINISTRADOR----------------------------------
 * ----------------------------------------------------------------------------------
 */

/**
 * Carga a tabla de todos os usuarios
 * @param {int} paxina número de páxina desde a cal facer a búsqueda
 */
function getUsersData(paxina) {

    let filtro = document.getElementById("buscar").value;
    let numRexistros = document.getElementById("numRexistros").value;
    let rol = document.getElementById("roles").value;
    let formData = new FormData();  

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
  
    switch (rol) {
      case "1": 
          formData.append("rol", "administrador");         
        break;
  
      case "2":  
          formData.append("rol", "profesor");
          break;
      case "3":
          formData.append("rol", "estudiante");
        break;
  
      default:
        break;
    }
  
    let tablaUsuarios = document.getElementById("tablaUsuarios");
    let url = './php_functions/loadUsersTable.php';
    
    formData.append("buscar", filtro);
    formData.append("activo", activoCkecked);
    formData.append("inactivo", inactivoCkecked);
    formData.append("numRexistros", numRexistros);
    formData.append("paxina", paxinaActual);
    
    fetch( url, {
      method: "POST",
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      tablaUsuarios.innerHTML = data.html
      document.getElementById("botonsPaxinas").innerHTML = data.paxinacion;

      // añadir listener os botóns de editar usuario da tabla de usuarios, recorrense os nodos fillos da tabla
      // e engádese o listener 
      tablaUsuarios.childNodes.forEach( element => {
        element.childNodes[10].childNodes[0].addEventListener("click", () => {
          updateUsersListModal.show();                //abre o modal 'updateUsersListModal' declarado en modal.js         
          let id = element.childNodes[0].innerHTML;
          loadUserDataModal(id);            //definida en updateUser.js, carga os datos do usuario
        })
      })
  
      // añadir listener os botóns de borrar usuario da tabla de usuarios, recorrense os nodos fillos da tabla
      // e engádese o listener
      tablaUsuarios.childNodes.forEach( element => {
        element.childNodes[11].childNodes[0].addEventListener("click", () => {
          deleteUserModal.show();   //abre o modal 'deleteUserModal'
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
getUsersData(1);      //carga a tabla de usuarios

//listeners para filtrar a tabla de usuarios, filtra dinámicamente cada vez que hai algún cambio
document.getElementById("buscar").addEventListener("keyup", () => {      //filtro por búsqueda
  getUsersData(1);
});           

document.getElementById("activado").addEventListener("change", () => {  //filtro usuario activo
  getUsersData(1);
});
document.getElementById("inactivo").addEventListener("change", () => {  //filtro usuario inactivo
  getUsersData(1);
});

document.getElementById("roles").addEventListener("change", () => {     //filtro por rol de usuario 
  getUsersData(1);
});

document.getElementById("numRexistros").addEventListener("change", () => {     //listener cantidade de rexistros a mostrar
  getUsersData(1);
}); 


//carga de datos do usuario logueado na pantalla modal de editar o seu perfil
// loadUserDataModal(document.getElementById("idUsuario").value);  //definida en ajaxUser.js

getTablaCursos(); //carga a tabla de cursos
getCursos("selectCurso");

//definición de ventanas modales
const createUserModal = new bootstrap.Modal(document.getElementById("createUserModal"), {});            //modal de crear novo usuario
const deleteUserModal = new bootstrap.Modal(document.getElementById("deleteUserModal"), {});            //modal de confirmación de borrar usuario    
// const updateUserModal = new bootstrap.Modal(document.getElementById("updateUserModal"), {});
const updateUsersListModal = new bootstrap.Modal(document.getElementById("updateUsersListModal"), {});  //modal de actualizar datos de usuario
const updatePasswModal = new bootstrap.Modal(document.getElementById("updatePassModal"), {});           //modal deactualizar contrasinal
const updateCursoModal = new bootstrap.Modal(document.getElementById("updateCursoModal"), {});          //modal actualizar nome de curso
const updateAsignModal = new bootstrap.Modal(document.getElementById("updateAsingModal"), {});          //modal actualizar nome de asignatura


//Botóns panel de administrador
const createUserModalButton = document.getElementById("createUserModalButton");
const updateUserModalButton = document.getElementById("updateUserModalButton");
const updateUsersListModalButton = document.getElementById("updateUsersListModalButton");
const updatePassModalButton = document.getElementById("updatePassListModalButton");
const updatePassListModalButton = document.getElementById("updatePassListModalButton");

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
    document.getElementById("novoCurso").options[0].selected = true;
    document.getElementById("novoAsignaturas").innerHTML = "<option value='0'>Selección de materias</option>"
    document.getElementById("divCursoNovo").style.display = "";             
    document.getElementById("divNovoAsignaturas").style.display = "";
})

//listener para abrir o modal de editar usuario da pantalla de datos de usuario
updateUserModalButton.addEventListener("click", () => {
    // updateUserModal.show();
    updateUsersListModal.show();
    loadUserDataModal(document.getElementById("idUsuario").value);  
})

//listener para abrir o modal de modificar o contrasinal de usuario
updatePassModalButton.addEventListener("click", () => {
    updatePasswModal.show();
})

//listener para abrir o modal de modificar o contrasinal de usuario na pantalla de lista de usuarios
updatePassListModalButton.addEventListener("click", () => {
    updatePasswModal.show();
})





