function deleteUser() {
    //recuperamos o id do usuario a borrar, está gardado nun campo oculto do modal de borrar usuario
    let userId = document.getElementById("idUsuarioBorrar").value;  
    // userId = userId.slice(7,);

    let datos = {
        id: userId,
    };

    fetch('./php_functions/deleteUser.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(datos),
    })
    .then(response => response.json())
    .then(data => {

        //execútase a funcion que carga as tablas de usuarios/estudiantes
        //solo se executa si está definida, estará definida ou non según o panel que se cargue
        if(typeof getUsersData === 'function') {
            getUsersData();
        } 
        if(typeof getStudentTable === 'function') {
            getStudentTable();
        }

        deleteUserModal.hide();
        notificacion = document.getElementById('notificacion');
        notificacion.innerHTML = data;
       
        setTimeout(function(){
            notificacion.innerHTML = "";
        }, 5000);
    
    }).catch(err => {
        console.error("ERROR: ", err.message);
    });

}

