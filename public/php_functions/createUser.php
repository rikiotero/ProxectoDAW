<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) || ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor" ) ) redirect("");

require "../../vendor/autoload.php";

use Clases\UserDB;
use Clases\User;
use Clases\Student;
use Clases\CursosDB;

$datos = json_decode(file_get_contents('php://input'), true);

if( $datos["rol"] != 3) {               // non é estudiante

    $user = new User(
        strip_tags( trim($datos["usuario"]) ),
        strip_tags( trim($datos["pass"]) ),        
        strip_tags( trim($datos["nombre"]) ),
        strip_tags( trim($datos["apellido1"]) ),
        strip_tags( trim($datos["apellido2"]) ),
        $datos["email"] != "" ? strip_tags( trim($datos["email"]) ) : null,
        $datos["tlf"] != "" ? strip_tags( trim($datos["tlf"]) ) : null,
        strip_tags( trim($datos["alta"]) ),
        $datos["activo"] == 1 ? 1 : 0,
        strip_tags( trim($datos["rol"]) ),
        $datos["curso"] != 0 ? strip_tags( trim($datos["curso"] ) ) : null,
    );
    
    $erroresValidacion = $user->validaUsuario(); //validación antes de insertar usuario
    $db = new UserDB();
    if ( $db->getUser($datos["usuario"]) ) {       //xa existe un usuario con ese nome
        $db->cerrarConexion();
        $output = "<div class='alert alert-danger'>Xa existe un usuario rexistrado con ese nome, intentao con outro nome</div>";
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    
    }elseif ( empty($erroresValidacion) ) {   //si non hai erros de validación insértase na base de datos 
        
        $rexistrado = $db->insertUser($user);
        $db->cerrarConexion();
        
        if( $rexistrado ){
            $output = "<div class='alert alert-success'>Usuario creado correctamente</div>";
        }else {
            $output = "<div class='alert alert-danger'>Non se pudo crear o usuario , proba de novo</div>";
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

}else {                     // o usuario a insertar é estudiante 

    $estudiante = new Student(
        strip_tags( trim($datos["usuario"]) ),
        strip_tags( trim($datos["pass"]) ),        
        strip_tags( trim($datos["nombre"]) ),
        strip_tags( trim($datos["apellido1"]) ),
        strip_tags( trim($datos["apellido2"]) ),
        $datos["email"] != "" ? strip_tags( trim($datos["email"]) ) : null,
        $datos["tlf"] != "" ? strip_tags( trim($datos["tlf"]) ) : null,
        strip_tags( trim($datos["alta"]) ),
        $datos["activo"] == 1 ? 1 : 0,
        strip_tags( trim($datos["rol"]) ),
        $datos["curso"] != 0 ? strip_tags( trim($datos["curso"] ) ) : null,
        $datos["asignaturas"]
    );

    $erroresValidacion = $estudiante->validaUsuario();  //validación antes de insertar usuario

    $db = new UserDB();
    if ( $db->getUser($datos["usuario"]) ) {            //xa existe un usuario con ese nome
        $db->cerrarConexion();
        $output = "<div class='alert alert-danger'>Xa existe un usuario rexistrado con ese nome, intentao con outro nome</div>";
        echo json_encode($output, JSON_UNESCAPED_UNICODE);    
    }

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
    if ( !empty($datos["asignaturas"]) ) {
        $asignaturas = array_keys($asignaturas);
        foreach ( $datos["asignaturas"] as $key => $value ) {
            if( !in_array( $value,$asignaturas ) ) {
                $erroresValidacion[] = "As asignaturas non se corresponde co curso seleccionado";
                break;
            }
        }
    }

    if ( empty($erroresValidacion) ) {      

        $rexistrado = $db->insertStudent($estudiante);
        $db->cerrarConexion();
        
        if( $rexistrado ){
            $output = "<div class='alert alert-success'>Usuario creado correctamente</div>";
        }else {
            $output = "<div class='alert alert-danger'>Non se pudo crear o usuario , proba de novo</div>";
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