<?php
require "../vendor/autoload.php";
use Clases\UserDB;
use Clases\User;

$datos = json_decode(file_get_contents('php://input'), true);

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

if ( $user->validaUsuario() ) {  //validación de datos no servidor antes de insertalos
    $db = new UserDB();
    $rexistrado = $db->insertUser($user);
    
    if( $rexistrado ){
        $output = "<div class='alert alert-success'>Usuario {$datos['usuario']} creado correctamente</div>";
    }else {
        $output = "<div class='alert alert-danger'>Non se pudo crear o usuario {$datos['usuario']}, proba de novo</div>";
    }
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}else {
    $output = "<div class='alert alert-danger'>Non se pudo crear o usuario {$datos['usuario']}, debes completar os campos obrigatorios correctamente</div>";
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}

?>