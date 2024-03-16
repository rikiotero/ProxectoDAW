<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) ) redirect("");

require "../../vendor/autoload.php";

use Clases\UserDB;
use Clases\User;
use Clases\Student;
use Clases\CursosDB;

$datos = json_decode(file_get_contents("php://input"), true);

$db = new UserDB();
$userAntes = $db->getUser($datos["usuarioVello"]); //datos de usuario antes ser modificado

//Prevención de que un estudiante modifique datos que non ten permitido
if ( $_SESSION["rol"] == "estudiante" ) {
    $datos["nombre"] = $userAntes->nombre;
    $datos["apellido1"] = $userAntes->apellido1;
    $datos["apellido2"] = $userAntes->apellido2;
    $datos["curso"] = array_keys( $db->getCurso($userAntes->id) )[0];
    $datos["asignaturas"] = array_keys( $db->getAsignaturas($userAntes->id) );
}

//comprobación de si se modificou o nome de usuario, 
//si se modificou compróbase que non exista un usuario co mesmo nome
if ( $datos["usuarioVello"] != $datos["usuario"] ) { 
    
    if ( $db->getUser($datos["usuario"]) ) {       //xa existe un usuario con ese nome
        $db->cerrarConexion();
        $output = "<div class='alert alert-danger'>Xa existe un usuario rexistrado con ese nome, intentao con outro nome</div>";
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
        exit;
    } 
}


if ( $datos["rol"] != 3) {   // non é estudiante
    
    // $passw = $db->getPassword($datos["usuarioVello"]);
    if ( $userAntes->id == 1 ) {
        $datos["activo"] = 1;
    }

    $user = new User(
        strip_tags( trim($datos["usuario"]) ),
        $userAntes->password,
        strip_tags( trim($datos["nombre"]) ),
        strip_tags( trim($datos["apellido1"]) ),
        strip_tags( trim($datos["apellido2"]) ),
        $datos["email"] != "" ? strip_tags( trim($datos["email"]) ) : null,
        $datos["tlf"] != "" ? strip_tags( trim($datos["tlf"]) ) : null,
        strip_tags( trim($datos["alta"]) ),
        $datos["activo"] == 1 ? 1 : 0,
        strip_tags( trim($datos["rol"]) ),
    );

    $erroresValidacion = $user->validaUsuario(); //validación antes de insertar usuario

    //Validación por si o usuario modificou o rol sin poder facelo
    if ( $_SESSION["rol"] != "administrador" && $datos["rol"] != $userAntes->rol ) {     
        $erroresValidacion[] = "O rol introducido é incorrecto";
    }

    if ( empty($erroresValidacion) ) { 

        $actualizado = $db->updateUser($datos["usuarioVello"],$user);
        $db->cerrarConexion();

        if( $actualizado ) {
            if ( $_SESSION["user"] == $datos["usuarioVello"] ) //si é o usuario logueado o que modifica o seu nome de usuario actualizase a sesion
                $_SESSION["user"] = $datos["usuario"];
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

    $estudiante = new Student(
        strip_tags( trim($datos["usuario"]) ),
        $userAntes->password,        
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
    
    //Validación por si o usuario modificou o rol sin poder facelo
    if ( $_SESSION["rol"] != "administrador" && $datos["rol"] != $userAntes->rol ) {     
        $erroresValidacion[] = "O rol introducido é incorrecto";
    }
    //validación do curso
    if ( $datos["curso"] == "0" ) {
        $erroresValidacion[] = "Seleccionar un curso é obrigatorio";
    }else {
        $cursosDB = new CursosDB();     
        $cursos =  $cursosDB->getCursos();
        $asignaturas = $cursosDB->getAsignaturas($datos["curso"]);
        $cursosDB->cerrarConexion();
    
        if ( !array_key_exists( $datos["curso"],$cursos ) ) {
            $erroresValidacion[] = "O curso insertado é incorrecto";
        }
    }

    //Validación das asignaturas
    if ( empty($datos["asignaturas"]) ) {
        $erroresValidacion[] = "Debes seleccionar algunha materia";
    }else {
        $asignaturas = array_keys($asignaturas);
        foreach ( $datos["asignaturas"] as $key => $value ) {
            if( !in_array( $value,$asignaturas ) ) {
                $erroresValidacion[] = "As materias non se corresponde co curso seleccionado";
                break;
            }
        }
    }


    if ( empty($erroresValidacion) ) {

        // $actualizado = $db->updateStudent($datos["usuarioVello"],$estudiante);
        $actualizado = $db->updateUser($datos["usuarioVello"],$estudiante);
        $db->cerrarConexion();
        
        if( $actualizado ){

            if ( $_SESSION["user"] == $datos["usuarioVello"] ) //si é o usuario logueado o que modifica o seu nome de usuario actualizase a sesion
                $_SESSION["user"] = $datos["usuario"];
    
            $output = "<div class='alert alert-success'>Usuario actualizado correctamente</div>";
        }else {
            $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario, proba de novo</div>";
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

?>