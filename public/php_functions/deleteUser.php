<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) || ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor" ) ) redirect("");

require "../../vendor/autoload.php";

use Clases\UserDB;

$datos = json_decode(file_get_contents("php://input"), true);
$userId = $datos["id"];

$db = new UserDB();

if( $db->deleteUser($userId) ){

    $output = "<div class='alert alert-success'>Usuario borrado correctamente</div>";
}else {
    $output = "<div class='alert alert-danger'>Non se pudo borrar o usuario, proba de novo</div>";
}
$db->cerrarConexion();
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>