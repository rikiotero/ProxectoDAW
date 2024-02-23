getStudentTable();

document.getElementById("buscar").addEventListener("keyup", getStudentTable);
document.getElementById("activado").addEventListener("change", getStudentTable);
document.getElementById("inactivo").addEventListener("change", getStudentTable);
document.getElementById("filtroCurso").addEventListener("change", getStudentTable);


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
