/**
 * crea un usuario
 */
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
        // document.getElementById("novoUsuario").value = "";
        // document.getElementById("novoPassword").value = "";
        // document.getElementById("novoPassword2").value = "";
        // document.getElementById("novoNome").value = "";
        // document.getElementById("novoApellido1").value = "";
        // document.getElementById("novoApellido2").value = "";
        // document.getElementById("novoEmail").value = "";
        // document.getElementById("novoTlf").value = "";

        //execútase a funcion que carga as tablas de usuarios/estudiantes
        //solo se executa si está definida, estará definida ou non según o panel que se cargue
            if( typeof getUsersData === 'function' ) {
                getUsersData();
            } 
            if( typeof getStudentTable === 'function' ) {
                getStudentTable();
            }  
        
        }).catch(err => {
            console.error("ERROR: ", err.message)
          }); 
    } 
}

/**
 * Borra un usuario
 */
function deleteUser() {

    //recuperamos o id do usuario a borrar, está gardado nun campo oculto do modal de borrar usuario
    let userId = document.getElementById("idUsuarioBorrar").value;
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

/**
 * Actualiza os datos de un usuario, recolle os datos da pantalla modal de actualizar usuario
 */  
function updateUser() {

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

/**
 * Actualiza o contrasinal de un usuario
 */
function updatePassw() {

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
                document.getElementById("msgUpdatepassw").innerHTML = ""; //despois de tres segundos bórrase a mensaxe
                // location.href ="./closeSession.php";
            }, 3000);
        })
        .catch(err => {
            console.error("ERROR: ", err.message);            
        });
    }
}

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
     document.getElementById("alta").value = new Date(data.fecha_alta).toLocaleDateString("en-GB").replace(/\//g, '-');
     document.getElementById("rol").value = data.rol;
     
     //activamos ou desactivamos controles según rol
     if (data.rol != 3 ) {                                                   //non é estudiante
         document.getElementById("divCurso").style.display = "none";         //ocultar select de cursos
         document.getElementById("divAsignaturas").style.display = "none";   //ocultar select de asignaturas
     }else {
         document.getElementById("divCurso").style.display = "";             //mostrar select de cursos
         document.getElementById("divAsignaturas").style.display = "";       //mostrar select de asignaturas
         
         //carga de cursos no select de cursos
         getCursos("curso"); //declarada en ajaxCursos.js   

         setTimeout( () => { //seleccion do curso correspondente do alumno, retrásase para esperar que termine getCursos
             let index = "0";
             document.getElementById("curso").childNodes.forEach(element => {
                 if ( element.value == Object.keys(data.curso)[0] ) {//obtemos a key do curso para marcar seleccionado o curso correspondente do alumno, a key equivale o id do curso
                     index = element.index;
                 }
             }); 
             document.getElementById("curso").selectedIndex = index;                        
         },500);
        
         //añadimos o select de asignaturas as asignaturas correspontes co curso seleccionado
         cargarAsignaturas(Object.keys(data.curso)[0],"asignaturas"); //definida en ajaxCursos.js

         //márcanse como seleccionadas as asignaturas do usuario, poño un setTimeout para esperar pola 
         //carga de asignaturas da función anterior 
         setTimeout( () => {
             let asignaturas = document.getElementById("asignaturas");
            //  console.log([...asignaturas.options]);
             [...asignaturas.options].forEach( option => {
             
             for (const key in data.asignaturas) {
              if( option.label == data.asignaturas[key] )  option.selected = true;                
              }         
                
              // data.asignaturas.forEach( asig => {
              //   if( option.label == asig )  option.selected = true;
              // });
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

