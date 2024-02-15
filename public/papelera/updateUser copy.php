<?php
session_start();
if( !isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "administrador") redirect("");

require "../vendor/autoload.php";

use Clases\UserDB;
use Clases\User;


$datos = json_decode(file_get_contents("php://input"), true);

$userName = $datos["usuarioVello"];  //nome de usuario anterior (si se cambia) para usar na query
$user = new User(
    $datos["usuario"],
    $datos["pass"],
    $datos["nombre"],
    $datos["apellido1"],
    $datos["apellido2"],
    $datos["email"] != "" ? $datos["email"] : null,
    $datos["tlf"] != "" ? $datos["tlf"] : null,
    $datos["alta"],
    $datos["activo"] == 1 ? true : false,
    $datos["rol"]
);

if ( $user->validaUsuario() ) {
    
    $db = new UserDB();    
    if( $userName == $datos["usuario"] ) {      // non se modifica o nome de usuario    
        
        $actualizado = $db->updateUser($userName,$user);
    
        if( $actualizado ){
            $output = "<div class='alert alert-success'>Usuario actualizado correctamente</div>";
        }else {
            $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario, inténtao de novo</div>";
        }
        echo json_encode($output, JSON_UNESCAPED_UNICODE);

    }else if ( $db->getUser( $datos["usuario"] ) == false ) {  // comprobamos que non existe ese nome de usuario
        
        $actualizado = $db->updateUser($userName,$user);
    
        if( $actualizado ){
            header("Location:closeSession.php");
            $output = "<div class='alert alert-success'>Usuario actualizado correctamente</div>";
            echo json_encode($output, JSON_UNESCAPED_UNICODE);
        }else {
            $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario, inténtao de novo</div>";
        }
        
        echo json_encode($output, JSON_UNESCAPED_UNICODE);

    }else {
        $output = "<div class='alert alert-danger'>O nome de usuario xa existe, inténtao de novo</div>";
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    }
    
}else {
    $output = "<div class='alert alert-danger'>Non se pudo actualizar o usuario, inténtao de novo</div>";
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}

?>