<?php
session_start();
if( !isset($_SESSION["rol"])) redirect("");

require "../vendor/autoload.php";

use Clases\UserDB;

$datos = json_decode(file_get_contents("php://input"), true);

if ( $datos["pass"] != "" && preg_match("/^[^\s]{4,}$/", $datos["pass"]) ) {
    $db = new UserDB();
    $actualizado = $db->updatePassw($datos["pass"],$_SESSION["user"]);
    
    if( $actualizado ){
        $output = "<div class='alert alert-success'>Contrasinal actualizado correctamente, volve a iniciar sesión</div>";
    }else {
        $output = "<div class='alert alert-danger'>Non se pudo actualizar o contrasinal, inténtao de novo</div>";
    }
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}else {
    $output = "<div class='alert alert-danger'>Non se pudo actualizar o contrasinal, inténtao de novo</div>";
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}