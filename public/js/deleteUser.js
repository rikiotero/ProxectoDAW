const deleteUser = () => {
    //recuperamos o id do usuario a borrar, está en formato 'borrar-X', con slice bórranse as letras e o guión 
    //e queda solo o id de usuario
    let userId = document.getElementById("idUsuarioBorrar").value;  
    userId = userId.slice(7,);

    let datos = {
        id: userId,
    };

    fetch('./deleteUser.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(datos),
    })
    .then(response => response.json())
    .then(data => {

        deleteUserModal.hide();
        getUsersData();

        notificacion = document.getElementById('notificacion');
        notificacion.innerHTML = data;
       
        setTimeout(function(){
            notificacion.innerHTML = "";
        }, 5000);
    
    }).catch(err => {
        console.error("ERROR: ", err.message);
    });

}

