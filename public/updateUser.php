<?php
session_start();
if( !isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "administrador") redirect("");

require "../vendor/autoload.php";

use Clases\UserDB;
use Clases\User;

$datos = json_decode(file_get_contents("php://input"), true);

$user = new User(
    trim($datos["usuario"]),
    trim($datos["pass"]),
    trim($datos["nombre"]),
    trim($datos["apellido1"]),
    trim($datos["apellido2"]),
    $datos["email"] != "" ? trim($datos["email"]) : null,
    $datos["tlf"] != "" ? trim($datos["tlf"]) : null,
    $datos["alta"],
    $datos["activo"] == 1 ? true : false,
    $datos["rol"]
);

$db = new UserDB();

//comprobación de si se modificou o nome de usuario, si se modificou compróbase que non exista un usuario co mesmo 
//nome de usuario e validanse os datos para gardalos na base de datos, si todo vai ben actualisa os datos na base 
//de datos e cambiase o nome de usuario na sesión

if ($_SESSION["user"] != $datos["usuario"]) { 
    if ( !$db->getUser($datos["usuario"]) && $user->validaUsuario() ) {
        $actualizado = $db->updateUser($_SESSION["user"],$user);
    
        if( $actualizado ){
            $_SESSION["user"] = $datos["usuario"];
            $output = "<div class='alert alert-success'>Usuario actualizado correctamente</div>";
        }else {
            $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario, huvo un erro o intentar actualizar, proba de novo</div>";
        }
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    }else {
        $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario, debes completar correctamente os campos obrigatorios</div>";
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    }

}else {
    if ($user->validaUsuario() ) {  //validación de datos no servidor antes de actualizalos
    
        $actualizado = $db->updateUser($_SESSION["user"],$user);
        
        if( $actualizado ){
            $_SESSION["user"] = $datos["usuario"];
            $output = "<div class='alert alert-success'>Usuario actualizado correctamente</div>";
        }else {
            $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario, huvo un erro o intentar actualizar, proba de novo</div>";
        }
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    }else {
        $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario, debes completar correctamente os campos obrigatorios</div>";
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    }
}
?>