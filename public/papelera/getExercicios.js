getExerciciosTabla();

document.getElementById("buscarEx").addEventListener("keyup", getExerciciosTabla);
document.getElementById("ExActivado").addEventListener("change", getExerciciosTabla);
document.getElementById("ExInactivo").addEventListener("change", getExerciciosTabla);
document.getElementById("filtroCursoEx").addEventListener("change", getExerciciosTabla);

/**
 * Recupera os exercicios filtrados según elixa o usuario e mostraos nunha tabla
 */
function getExerciciosTabla() {

  let filtro = document.getElementById("buscarEx").value;
  let curso = document.getElementById("filtroCursoEx").value;
  let activoCkecked;
  let inactivoCkecked;

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

 fetch( './php_functions/loadExerciciosTabla.php', {
    method: "POST",
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    tablaExercicios.innerHTML = data

    // añadir listener os botóns de editar usuario da tabla de estudiantes, recorrense os nodos fillos da tabla
    // e engádese o listener 
    // tablaExercicios.childNodes.forEach( element => {
    //   element.childNodes[10].childNodes[0].addEventListener("click", () => {
    //     updateUsersListModal.show();                //abre o modal "updateUsersListModal" declarado en modal.js         
    //     // let id = element.childNodes[10].childNodes[0].id;
    //     let id = element.childNodes[0].innerHTML;
    //     loadUserDataModal(id);                      //definida en updateUser.js, carga os datos do usuario
    //   })
    // })

    // añadir listener os botóns de borrar usuario da tabla de estudiantes, recorrense os nodos fillos da tabla
    // e engádese o listener
    tablaExercicios.childNodes.forEach( element => {
      element.childNodes[8].childNodes[0].addEventListener("click", () => {
        deleteExercModal.show();                          //abre o modal "deleteExercModal" de copnfirmación                         
        let id = element.childNodes[0].innerHTML;         //gardo o id do exercicio nun campo oculto do modal
        document.getElementById("idExerBorrar").value = id;
      })
    })

  })
  .catch(err => console.log(err))
}
