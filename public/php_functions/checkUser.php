<?php
session_start();
require "../redirect.php";
if( !isset($_SESSION["rol"]) || ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor" ) ) redirect("");

require "../../vendor/autoload.php";
use Clases\UserDB;

$datos = json_decode(file_get_contents('php://input'), true);
$db = new UserDB();

if ( $db->getUser($datos["usuario"]) ) {
    $db->cerrarConexion();
    $output = true;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}else {
    $db->cerrarConexion();
    $output = false;
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}
?>