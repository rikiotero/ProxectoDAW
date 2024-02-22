<?php
session_start();
if( !isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "administrador" ) redirect("");

require "../../vendor/autoload.php";

use Clases\CursosDB;

$id = json_decode(file_get_contents("php://input"), true);

$db = new CursosDB();

if ( $db->deleteAsignatura($id) ) {
    
    $db->cerrarConexion();
    $output = "<div class='alert alert-success'>Asignatura borrada correctamente</div>";    
}else {
    $db->cerrarConexion();
    $output = "<div class='alert alert-danger'>Non se pudo borrar a asignatura</div>";
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>