<?php
session_start();
if( !isset($_SESSION["rol"])) redirect("");

require "../../vendor/autoload.php";

use Clases\UserDB;

$datos = json_decode(file_get_contents("php://input"), true);

if ( $datos["pass"] != "" && preg_match("/^[^\s]+.{2,}[^\s]$/", $datos["pass"]) ) { //validación, mínimo 4 caracteres sin espacio en blanco
    $db = new UserDB();
    $actualizado = $db->updatePassw($datos["pass"],$datos["usuario"]);
    
    if( $actualizado ){
        $output = "<div class='alert alert-success'>Contrasinal actualizado correctamente</div>";
    }else {
        $output = "<div class='alert alert-danger'>Non se pudo actualizar o contrasinal, inténtao de novo</div>";
    }
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}else {
    $output = "<div class='alert alert-danger'>O contrasinal ten que ter mínimo 4 caracteres sin espacio en branco</div>";
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}