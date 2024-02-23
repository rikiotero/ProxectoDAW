<?php
session_start();
if( !isset($_SESSION["rol"]) ) redirect("");

require "../../vendor/autoload.php";

use Clases\UserDB;
use Clases\User;
use Clases\Student;
use Clases\CursosDB;

$datos = json_decode(file_get_contents("php://input"), true);

$db = new UserDB();

//comprobación de si se modificou o nome de usuario, 
//si se modificou compróbase que non exista un usuario co mesmo nome

if ( $datos["usuarioVello"] != $datos["usuario"] ) { 
    
    if ( $db->getUser($datos["usuario"]) ) {       //xa existe un usuario con ese nome
        $db->cerrarConexion();
        $output = "<div class='alert alert-danger'>Xa existe un usuario rexistrado con ese nome, intentao con outro nome</div>";
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    }else {
        if ( $_SESSION["user"] == $datos["usuarioVello"] ) //si é o usuario logueado o que modifica o seu nome de usuario actualizase a sesion
            $_SESSION["user"] = $datos["usuario"];
    }
}

// $sesion = $_SESSION["user"];

if ( $datos["rol"] != 3) {   // non é estudiante
    
    $passw = $db->getPassword($datos["usuarioVello"]);

    $user = new User(
        strip_tags( trim($datos["usuario"]) ),
        $passw,
        strip_tags( trim($datos["nombre"]) ),
        strip_tags( trim($datos["apellido1"]) ),
        strip_tags( trim($datos["apellido2"]) ),
        $datos["email"] != "" ? strip_tags( trim($datos["email"]) ) : null,
        $datos["tlf"] != "" ? strip_tags( trim($datos["tlf"]) ) : null,
        strip_tags( trim($datos["alta"]) ),
        $datos["activo"] == 1 ? 1 : 0,
        strip_tags( trim($datos["rol"]) )
    );

    $erroresValidacion = $user->validaUsuario(); //validación antes de insertar usuario

    if ( empty($erroresValidacion) ) { 

        $actualizado = $db->updateUser($datos["usuarioVello"],$user);
        $db->cerrarConexion();

        if( $actualizado ) {
            $output = "<div class='alert alert-success'>Usuario actualizado correctamente</div>";

        }else {
            $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario , proba de novo</div>";
        }
        echo json_encode($output, JSON_UNESCAPED_UNICODE);

    }else {

        $db->cerrarConexion();
        $output = "<div class='alert alert-danger'><ul>";  //si hai erros píntanse en pantalla

        foreach ($erroresValidacion as $key => $value) {
            $output .= "<li>$value</li>";
        }
        $output .= "</ul></div>";
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    }

}else { // é estudiante    
        
    $passw = $db->getPassword($datos["usuario"]);

    $estudiante = new Student(
        strip_tags( trim($datos["usuario"]) ),
        $passw,        
        strip_tags( trim($datos["nombre"]) ),
        strip_tags( trim($datos["apellido1"]) ),
        strip_tags( trim($datos["apellido2"]) ),
        $datos["email"] != "" ? strip_tags( trim($datos["email"]) ) : null,
        $datos["tlf"] != "" ? strip_tags( trim($datos["tlf"]) ) : null,
        strip_tags( trim($datos["alta"]) ),
        $datos["activo"] == 1 ? 1 : 0,
        strip_tags( trim($datos["rol"]) ),
        strip_tags( trim($datos["curso"] ) ),
        $datos["asignaturas"]
    );

    $erroresValidacion = $estudiante->validaUsuario();  //validación antes de insertar usuario

    //validación do curso
    if ( $datos["curso"] != "0" ) {
        $cursosDB = new CursosDB();     
        $cursos =  $cursosDB->getCursos();
        $asignaturas = $cursosDB->getAsignaturas($datos["curso"]);
        $cursosDB->cerrarConexion();
    
        if ( !array_key_exists( $datos["curso"],$cursos ) ) {
            $erroresValidacion[] = "O curso insertado é incorrecto";
        }
    }

    //Validación das asignaturas
    if ( !empty($datos["asignaturas"]) && $datos["asignaturas"][0] != "0" ) {
        $asignaturas = array_keys($asignaturas);
        foreach ( $datos["asignaturas"] as $key => $value ) {
            if( !in_array( $value,$asignaturas ) ) {
                $erroresValidacion[] = "As asignaturas non se corresponde co curso seleccionado";
                break;
            }
        }
    }

    if ( empty($erroresValidacion) ) {

        $actualizado = $db->updateStudent($datos["usuarioVello"],$estudiante);
        $db->cerrarConexion();
        
        if( $actualizado ){
            $output = "<div class='alert alert-success'>Usuario actualizado correctamente</div>";
        }else {
            $output = "<div class='alert alert-danger'>Non se pudo crear o actualizar o usuario, proba de novo</div>";
        }
        echo json_encode($output, JSON_UNESCAPED_UNICODE);

    }else {

        $db->cerrarConexion();
        $output = "<div class='alert alert-danger'><ul>";  //si hai erros píntanse en pantalla

        foreach ($erroresValidacion as $key => $value) {
            $output .= "<li>$value</li>";
        }
        $output .= "</ul></div>";
        echo json_encode($output, JSON_UNESCAPED_UNICODE);

    }
}





//comprobación de si se modificou o nome de usuario, si se modificou compróbase que non exista un usuario co mesmo 
//nome de usuario e validanse os datos para gardalos na base de datos, si todo vai ben actualizanse os datos na base 
//de datos e cambiase o nome de usuario na sesión



// if ( $datos["usuarioVello"] != $datos["usuario"] ) { 
//     if ( !$db->getUser($datos["usuario"]) && $user->validaUsuario() ) {
//         $actualizado = $db->updateUser($_SESSION["user"],$user);
    
//         if( $actualizado ){
//             $_SESSION["user"] = $datos["usuario"];
//             $output = "<div class='alert alert-success'>Usuario actualizado correctamente</div>";
//         }else {
//             $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario, huvo un erro o intentar actualizar, proba de novo</div>";
//         }
//         echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     }else {
//         $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario, debes completar correctamente os campos obrigatorios</div>";
//         echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     }

// }else {
//     if ( $user->validaUsuario() ) {  //validación de datos no servidor antes de actualizalos
    
//         $actualizado = $db->updateUser($_SESSION["user"],$user);
        
//         if( $actualizado ){
//             $_SESSION["user"] = $datos["usuario"];
//             $output = "<div class='alert alert-success'>Usuario actualizado correctamente</div>";
//         }else {
//             $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario, huvo un erro o intentar actualizar, proba de novo</div>";
//         }
//         echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     }else {
//         $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario, debes completar correctamente os campos obrigatorios</div>";
//         echo json_encode($output, JSON_UNESCAPED_UNICODE);
//     }
// }
?>