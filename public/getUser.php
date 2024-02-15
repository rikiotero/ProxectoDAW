<?php
session_start();
if( !isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "administrador") redirect("");

require "../vendor/autoload.php";

use Clases\UserDB;

$datos = json_decode(file_get_contents("php://input"), true);
$userId = $datos["id"];

$db = new UserDB();
$datos = $db->getUserById($userId);
 
if( $datos ) {
    $output = $datos;
}else {
    $output = "<div class='alert alert-danger'>Non se pudo borrar o usuario, proba de novo</div>";
}
$db->cerrarConexion();
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>