getUsersData();

document.getElementById("buscar").addEventListener("keyup", getUsersData);
document.getElementById("activado").addEventListener("change", getUsersData);
document.getElementById("inactivo").addEventListener("change", getUsersData);
document.getElementById("roles").addEventListener("change", getUsersData);


function getUsersData() {

  let filtro = document.getElementById("buscar").value;
  let rol = document.getElementById("roles").value;
  let formData = new FormData();

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


  fetch( url, {
    method: "POST",
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    tablaUsuarios.innerHTML = data

    // añadir listener os botóns de editar usuario da tabla de usuarios, recorrense os nodos fillos da tabla
    // e engádese o listener 
    tablaUsuarios.childNodes.forEach( element => {
      element.childNodes[10].childNodes[0].addEventListener("click", () => {
        updateUsersListModal.show();                //abre o modal 'updateUsersListModal' declarado en modal.js         
        // let id = element.childNodes[10].childNodes[0].id;
        let id = element.childNodes[0].innerHTML;
        loadUserDataModal(id);            //definida en updateUser.js, carga os datos do usuario
      })
    })

    // añadir listener os botóns de borrar usuario da tabla de usuarios, recorrense os nodos fillos da tabla
    // e engádese o listener
    tablaUsuarios.childNodes.forEach( element => {
      element.childNodes[11].childNodes[0].addEventListener("click", () => {
        deleteUserModal.show(); //abre o modal 'deleteUserModal'
        // alert("pulsado id:"+element.childNodes[11].childNodes[0].id+" evenTarget:"+event.target)
        //gardo o id do usuario nun campo oculto do modal
        let id = element.childNodes[0].innerHTML;
        document.getElementById("idUsuarioBorrar").value = id;
      })
    })

  })
  .catch(err => console.log(err))
}
