//Definición de expresiones regulares para validación
//----------------------------------------------------
const regExpUsuario = /^[a-zA-ZçÇñÑáéíóúÁÉÍÓÚ0-9_-]{3,16}$/;                //nome usuario
const regExpPass = /^[^\s]+.{2,}[^\s]$/;                                    //password
const regExpNombre = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ][a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;        //nome e apelidos
const regExpMail = /^[0-9a-zA-Z_\-\.]{2,}@[a-zA-Z_\-]+\.[a-zA-Z]{2,5}$/;    //email
const regExpTlf = /^[0-9]{9}$/;                                             //teléfono
const regExpFecha = /^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/;     //fecha de alta

/**
 * Valida un campo obligatorio dun formulario respecto a unha expresión regular
 * @param {string} id id do campo do formulario a validar
 * @param {RegExp} expresionR Expresión regular coa cal se compara campo
 * @param {string} error Mensaxe de error que se quere mostrar si non valida
 * @param {string} divErr Div de error que se quere mostrar si non valida
 * @returns {boolean} True si o campo cumple coa expresión regular, False si non
 */
function validarCampoObligatorio(id,expresionR,error,divErr) {
    const divError = document.getElementById(divErr);
    const campo = document.getElementById(id);

    if (campo.value.trim() === "") {
        divError.classList.add("alert","alert-danger");
        divError.innerHTML = "O campo "+campo.placeholder+" non pode estar vacío";
        campo.classList.add("redText");
        campo.style.borderColor = "red";
        return false;
    }
    else if (expresionR.test(campo.value) == false) {
        divError.innerHTML = error;
        divError.classList.add("alert","alert-danger");
        campo.classList.add("redText");
        campo.style.borderColor = "red";
        return false;
    }
    divError.classList.remove("alert","alert-danger");
    divError.innerHTML = "";
    campo.style.borderColor = "rgb(233,236,239)";
    campo.classList.remove("redText");
    return true;
}

/**
 * Valida un campo non obligatorio dun formulario respecto a unha expresión regular (pode estar vacío)
 * @param {string} id id do campo do formulario a validar
 * @param {RegExp} expresionR Expresión regular coa cal se compara campo
 * @param {string} error Mensaxe de error que se quere mostrar si non valida
 * @param {string} divErr Div de error que se quere mostrar si non valida
 * @returns {boolean} True si o campo cumple coa expresión regular, False si non
 */
function validarCampo(id,expresionR,error,divErr) {
    const divError = document.getElementById(divErr);
    const campo = document.getElementById(id);

    if (campo.value.trim() != "") {
        if (expresionR.test(campo.value) == false) {
            divError.innerHTML = error;
            divError.classList.add("alert","alert-danger");
            campo.focus();
            return false;
        }
    }    
    divError.classList.remove("alert","alert-danger");
    divError.innerHTML = "";
    return true;       
}

/**
 * Valida o password respeto a unha expresión regular (min 4 caracteres) e que coincida coa repetición do mesmo
 * @param {string} passw Id do campo password
 * @param {string} passw2 Id do campo repetición do password
 * @param {string} divErr Id do div de error que se quere mostrar si non valida
 * @returns {Boolean} True si valida, False si non
 */
function validarPassw(IdPassw,IdPassw2,IdDivErr) {
    let novoPassw = document.getElementById(IdPassw);
    let novoPassw2 = document.getElementById(IdPassw2);
    const divError = document.getElementById(IdDivErr);

    if ( novoPassw.value.trim() == ""  || regExpPass.test(novoPassw.value) == false ) {
        divError.innerHTML = "O contrasinal ten que ter mínimo 4 caracteres";
        divError.classList.add("alert","alert-danger");
        novoPassw.style.borderColor = "red";
        novoPassw.classList.add("redText");
        return false;
    }

    if( novoPassw.value != novoPassw2.value || novoPassw2.value.trim() == "" ) {
        divError.innerHTML = "A repetición do contrasinal non coincide";
        divError.classList.add("alert","alert-danger");
        novoPassw2.style.borderColor = "red";
        novoPassw2.classList.add("redText");
        return false;
    }

    novoPassw.style.borderColor = "rgb(233,236,239)";
    novoPassw2.style.borderColor = "rgb(233,236,239)";
    novoPassw.classList.remove("redText");
    novoPassw2.classList.remove("redText");
    divError.classList.remove("alert","alert-danger");
    divError.innerHTML = "";
    return true;    
}


/**
 * Validación do formulario para crear usuarios
 * @returns boolean True si todos os campos son válidos ou False si algún non o é
 */
function validaCreateUser() { 

    if (validarCampoObligatorio("novoUsuario",regExpUsuario,"O nome de usuario debe ter entre 3-16 letras ou números","msgNovoUsuario")
        && validarPassw("novoPassword","novoPassword2","msgNovoUsuario") 
        && validarCampoObligatorio("novoNome",regExpNombre,"O nome só pode ter letras","msgNovoUsuario")        
        && validarCampoObligatorio("novoApellido1",regExpNombre,"O apelido só pode ter letras","msgNovoUsuario") 
        && validarCampoObligatorio("novoApellido2",regExpNombre,"O apelido só pode ter letras","msgNovoUsuario") 
        && validarCampo("novoEmail",regExpMail,"Formato de email incorrecto","msgNovoUsuario") 
        && validarCampo("novoTlf",regExpTlf,"O teléfono ten que ter 9 números","msgNovoUsuario")        
        && validarCampoObligatorio("novoAlta",regExpFecha,"Data incorrecta","msgNovoUsuario")
        )
    {
        return true
    }
    return false
} 

/** Validación do formulario do modal de actualizar usuario ------------------------------------------
 * --------------------------------------------------------------------------------------------------------
 --------------------------------------------------------------------------------------------------------*/

// /**
//  * Validación do formulario para actualizar os datos de usuario
//  * @returns boolean True si todos os campos son válidos ou False si algún non o é
//  */
function validaUpdateUser() {    
    usuarioVello = document.getElementById("usuarioVello").value;
    usuarioNovo = document.getElementById("usuario");

    if( usuarioVello != usuarioNovo.value ) {

        if (validarCampoObligatorio("usuario",regExpUsuario,"O nome de usuario debe ter entre 3-16 letras ou números","msgUpdate")
            && validarCampoObligatorio("nome",regExpNombre,"O nome só pode ter letras","msgUpdate")
            && validarCampoObligatorio("apellido1",regExpNombre,"O apelido só pode ter letras","msgUpdate") 
            && validarCampoObligatorio("apellido2",regExpNombre,"O apelido só pode ter letras","msgUpdate") 
            && validarCampo("email",regExpMail,"Formato de email incorrecto","msgUpdate") 
            && validarCampo("tlf",regExpTlf,"O teléfono ten que ter 9 números","msgUpdate")) {
            return true
        }
    }else if(validarCampoObligatorio("usuario",regExpUsuario,"O nome de usuario debe ter entre 3-16 letras ou números","msgUpdate")
            && validarCampoObligatorio("nome",regExpNombre,"O nome só pode ter letras","msgUpdate")
            && validarCampoObligatorio("apellido1",regExpNombre,"O apelido só pode ter letras","msgUpdate") 
            && validarCampoObligatorio("apellido2",regExpNombre,"O apelido só pode ter letras","msgUpdate") 
            && validarCampo("email",regExpMail,"Formato de email incorrecto","msgUpdate") 
            && validarCampo("tlf",regExpTlf,"O teléfono ten que ter 9 números","msgUpdate")) {
            return true
        } 
    return false   
}
