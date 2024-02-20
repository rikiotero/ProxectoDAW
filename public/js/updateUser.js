//carga de datos do usuario logueado na pantalla modal de editar o seu perfil
loadUserDataModal(document.getElementById("idUsuario").value);

/**
 * Caga os datos do usuario correspondente na pantalla modal de edición de usuario
 */
function loadUserDataModal(userId) {

       //borrar mensaxes de error
       const divError = document.getElementById("msgUpdate");
       divError.innerHTML = "";
       divError.classList.remove("alert","alert-danger");
   
       //reseteo dos estilos dos campos
       document.getElementById("usuario").style.borderColor = "rgb(233,236,239)";
       document.getElementById("usuario").classList.remove("redText");
       document.getElementById("nome").style.borderColor = "rgb(233,236,239)";
       document.getElementById("nome").classList.remove("redText");
    
       document.getElementById("apellido1").style.borderColor = "rgb(233,236,239)";
       document.getElementById("apellido1").classList.remove("redText");
       
       document.getElementById("apellido2").style.borderColor = "rgb(233,236,239)";
       document.getElementById("apellido2").classList.remove("redText");


    const userRol = document.getElementById("currentUserRol").value;

    let id = {
        id: userId,
    };

    fetch("./php_functions/getUser.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(id),
    })
    .then(response => response.json())
    .then(data => {
        //carga de datos no formulario 
        document.getElementById("idUsuarioActualizar").value = userId;
        document.getElementById("usuarioVello").value = data.usuario;
        document.getElementById("usuario").value = data.usuario;
        document.getElementById("nome").value = data.nombre;
        document.getElementById("apellido1").value = data.apellido1;
        document.getElementById("apellido2").value = data.apellido2;
        document.getElementById("email").value = data.email;
        document.getElementById("tlf").value = data.telefono;
        // document.getElementById("alta").value = new Date(data.fecha_alta).toLocaleDateString();
        document.getElementById("alta").value = new Date(data.fecha_alta).toLocaleDateString("en-GB").replace(/\//g, '-');
        document.getElementById("rol").value = data.rol;
        
        //activamos ou desactivamos controles según rol
        if (data.rol != 3 ) {   //non é estudiante
            document.getElementById("divCurso").style.display = "none";         //ocultar select de cursos
            document.getElementById("divAsignaturas").style.display = "none";   //ocultar select de asignaturas
        }else {
            document.getElementById("divCurso").style.display = "";             //mostrar select de cursos
            document.getElementById("divAsignaturas").style.display = "";       //mostrar select de asignaturas
            //carga de cursos e asignaturas
            //obtemos a key do curso para marcar seleccionado o curso correspondente do alumno, a key equivale o id do curso
            document.getElementById("curso").selectedIndex = Object.keys(data.curso)[0]; 

            //añadimos ao select de asignaturas as asignaturas correspontes co curso seleccionado
            cargarAsignaturas(Object.keys(data.curso)[0],"asignaturas");

  
            //márcanse como seleccionadas as asignaturas do usuario, poño un setTimeout para esperar pola 
            //carga de asignaturas da función anterior 
            setTimeout( () => {
                let asignaturas = document.getElementById("asignaturas");
                // console.log([...asignaturas.options]);
                [...asignaturas.options].forEach(option => {
                    data.asignaturas.forEach(asig => {
                        if(option.label == asig)  option.selected = true;
                    });
                });
            },500);
         
        } 
        //marcar usuario activo ou non
        if (data.activo == 1) document.getElementById("updateActivo").checked = true;
        else document.getElementById("updateActivo").checked = false;

    }).catch(err => {
        console.error("ERROR: ", err.message);
    });
}


    
const updateUser = () => {

    // event.preventDefault();
    const divError = document.getElementById("msgUpdate");
    divError.innerHTML = "";

    //recollida dos datos de usuario
    let usuarioVello = document.getElementById("usuarioVello").value;
    let usuario = document.getElementById("usuario").value;
    let nombre = document.getElementById("nome").value;
    let apellido1 = document.getElementById("apellido1").value;
    let apellido2 = document.getElementById("apellido2").value;
    let email = document.getElementById("email").value;
    let tlf = document.getElementById("tlf").value;
    let alta = document.getElementById("alta").value;
    let rol = document.getElementById("rol").value;
    let curso = document.getElementById("curso").value;
    let activo = document.getElementById("updateActivo").checked;

    //recollemos asignaturas seleccionadas e gardamolas en un array
    let seleccionadas = document.querySelectorAll("#asignaturas option:checked");
    let asignaturas = Array.from(seleccionadas).map(element => element.value);

    let datos = {
        usuarioVello: usuarioVello,
        usuario: usuario,
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

    if ( validaUpdateUser() ) {  

        fetch("./php_functions/updateUser.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(datos),
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("msgUpdate").innerHTML = "";
            document.getElementById("msgUpdate").classList.remove("alert","alert-danger");
            document.getElementById("msgUpdate").innerHTML = data; //móstrase a mensaxe de todo ben ou non

            setTimeout(function(){
                document.getElementById("msgUpdate").classList.remove("alert","alert-danger");
                document.getElementById("msgUpdate").innerHTML = ""; //despois de cinco segundos bórrase a mensaxe
            }, 5000);
        
        }).catch(err => {
            console.error("ERROR: ", err.message);
        });
    }   
}




const updatePassw = () => {

    if (validarPassw("passwUpdate","passwUpdate2","msgUpdatepassw")) {
    
        let pass = document.getElementById("passwUpdate").value;
        let usuario = document.getElementById("usuario").value;
        let datos = {
            usuario: usuario,
            pass: pass
        }
        fetch("./php_functions/updatePassw.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById("msgUpdate").innerHTML = "";
            document.getElementById("msgUpdatepassw").innerHTML = data; //móstrase a mensaxe de todo ben ou non
            
            setTimeout(function(){
                document.getElementById("msgUpdatepassw").innerHTML = ""; //despois de tres segundos bórrase a mensaxe e cérrase a sesión
                // location.href ="./closeSession.php";
            }, 3000);
        })
        .catch(err => {
            console.error("ERROR: ", err.message);            
        });
    }
}
