<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) || ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor" ) ) redirect("");

require "../../vendor/autoload.php";

use Clases\UserDB;
use Clases\ExercicioDB;

$datos = json_decode(file_get_contents("php://input"), true);
$userId = $datos["id"];


$db = new ExercicioDB();
if ( empty( $db->getExercicioByAutorId($userId) ) ) {
    $db = new UserDB();
    if( $db->deleteUser($userId) ) {

        $output = "<div class='alert alert-success'>Usuario borrado correctamente</div>";
    }else {
        $output = "<div class='alert alert-danger'>Non se pudo borrar o usuario, proba de novo</div>";
    }
}else {
    $output = "<div class='alert alert-danger'>Ese usuario non se pode borrar xa que ten exercicios asignados como creador, 
    podes desactivar o usuario ou borrar os exercicios para poder borralo</div>";
}

$db->cerrarConexion();
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>