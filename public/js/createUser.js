
function  createUser() {

    //recollida dos datos
    let usuario = document.getElementById("novoUsuario").value;
    let pass = document.getElementById("novoPassword").value;
    let pass2 = document.getElementById("novoPassword2").value;
    let nombre = document.getElementById("novoNome").value;
    let apellido1 = document.getElementById("novoApellido1").value;
    let apellido2 = document.getElementById("novoApellido2").value;
    let email = document.getElementById("novoEmail").value;
    let tlf = document.getElementById("novoTlf").value;
    let alta = document.getElementById("novoAlta").value;
    let rol = document.getElementById("novoRol").value;
    let curso = document.getElementById("novoCurso").value;
    let activo = document.getElementById("novoActivo").checked;

    //recollemos asignaturas seleccionadas e gardamolas en un array
    let seleccionadas = document.querySelectorAll("#novoAsignaturas option:checked");
    let asignaturas = Array.from(seleccionadas).map(element => element.value);

    let datos = {
        usuario: usuario,
        pass: pass,
        nombre: nombre,
        apellido1: apellido1,
        apellido2: apellido2,
        email: email,
        tlf: tlf,
        alta: alta,        
        rol: rol,
        curso: curso,
        asignaturas: asignaturas,
        activo: activo
    };


    //validación dos datos, función definida en validateForm.js 
    if ( validaCreateUser () ) {

        fetch("./php_functions/createUser.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(datos),
        })
        .then(response => response.json())
        .then(data => {

        document.getElementById("msgNovoUsuario").innerHTML = data; //móstrase a mensaxe de todo ben ou non
            
        //reseteo dos campos do formulario
        document.getElementById("novoUsuario").value = "";
        document.getElementById("novoPassword").value = "";
        document.getElementById("novoPassword2").value = "";
        document.getElementById("novoNome").value = "";
        document.getElementById("novoApellido1").value = "";
        document.getElementById("novoApellido2").value = "";
        document.getElementById("novoEmail").value = "";
        document.getElementById("novoTlf").value = "";

        //execútase a funcion que carga as tablas de usuarios/estudiantes
        //solo se executa si está definida
        if( typeof getUsersData === 'function' ) {
            getUsersData();
        } 
        if( typeof getStudentTable === 'function' ) {
            getStudentTable();
        }

            // setTimeout(function() {
            //     document.getElementById("msgNovoUsuario").innerHTML = ""; //despois de cinco segundos bórrase a mensaxe
            // }, 5000);
        
        }).catch(err => {
            console.error("ERROR: ", err.message)
          }); 
    }
      
}