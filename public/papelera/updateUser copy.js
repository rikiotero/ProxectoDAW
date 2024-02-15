
function updateUser(event) {

    event.preventDefault();
    const divError = document.getElementById("msgUpdate");
    divError.innerHTML = "";
    let usuarioVello = document.getElementById('usuarioVello').value;
    let usuario = document.getElementById('usuario').value;
    let pass = document.getElementById('passw').value;
    let nombre = document.getElementById('nome').value;
    let apellido1 = document.getElementById('apellido1').value;
    let apellido2 = document.getElementById('apellido2').value;
    let email = document.getElementById('email').value;
    let tlf = document.getElementById('tlf').value;
    let alta = document.getElementById('alta').value;
    let rol = document.getElementById('rol').value;
    let activo = document.getElementById('activo').checked;

    let datos = {
        usuarioVello: usuarioVello,
        usuario: usuario,
        pass: pass,
        nombre: nombre,
        apellido1: apellido1,
        apellido2: apellido2,
        email: email,
        tlf: tlf,
        alta: alta,
        activo: activo,
        rol: rol
    };


    //validación dos datos, función definida en validateForm.js 

    // if ( validaUpdateUser() ) {  

        fetch('./updateUser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(datos),
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('msgUpdate').innerHTML = "";
            document.getElementById('msgUpdate').classList.remove("alert","alert-danger");
            document.getElementById('msgUpdate').innerHTML = data; //móstrase a mensaxe de todo ben ou non

            setTimeout(function(){
                document.getElementById('msgUpdate').classList.remove("alert","alert-danger");
                document.getElementById('msgUpdate').innerHTML = ""; //despois de cinco segundos bórrase a mensaxe
            }, 5000);
        
        }).catch(err => {
            console.error("ERROR: ", err.message);
        });
    }   
// }


function updatePassw(event) {

    event.preventDefault();
    if (validarPassw("passwUpdate","passwUpdate2","msgUpdatepassw")) {
    
        let pass = document.getElementById('passwUpdate').value;
        let datos = {
            pass: pass,
        }
        fetch("./updatePassw.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('msgUpdate').innerHTML = "";
            document.getElementById("msgUpdatepassw").innerHTML = data; //móstrase a mensaxe de todo ben ou non
            
            setTimeout(function(){
                document.getElementById('msgUpdatepassw').innerHTML = ""; //despois de tres segundos bórrase a mensaxe e cérrase a sesión
                location.href ="./closeSession.php";
            }, 3000);
        })
        .catch(err => {
            console.error("ERROR: ", err.message);            
        });
    }
}
