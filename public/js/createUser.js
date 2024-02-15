
function createUser(event) {
    event.preventDefault();

    const divError = document.getElementById("msgNovoUsuario");
    divError.innerHTML = "";
    divError.classList.remove("alert","alert-danger");

    let usuario = document.getElementById('novoUsuario').value;
    let pass = document.getElementById('novoPassword').value;
    let nombre = document.getElementById('novoNome').value;
    let apellido1 = document.getElementById('novoApellido1').value;
    let apellido2 = document.getElementById('novoApellido2').value;
    let email = document.getElementById('novoEmail').value;
    let tlf = document.getElementById('novoTlf').value;
    let alta = document.getElementById('novoAlta').value;
    let rol = document.getElementById('novoRol').value;
    let activo = document.getElementById('novoActivo').checked;

    let datos = {
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
    // if ( validaCreateUser () ) {

        fetch('./createUser.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(datos),
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('msgNovoUsuario').innerHTML = data; //móstrase a mensaxe de todo ben ou non

            
    //reseteo dos campos do formulario
    document.getElementById('novoUsuario').value = "";
    document.getElementById('novoPassword').value = "";
    document.getElementById('novoPassword2').value = "";
    document.getElementById('novoNome').value = "";
    document.getElementById('novoApellido1').value = "";
    document.getElementById('novoApellido2').value = "";
    document.getElementById('novoEmail').value = "";
    document.getElementById('novoTlf').value = "";

            setTimeout(function(){
                document.getElementById('mensaxe').innerHTML = ""; //despois de cinco segundos bórrase a mensaxe
            }, 5000);
        
        }).catch(err => {
            console.error("ERROR: ", err.message)
          }); 
    }
      
// }