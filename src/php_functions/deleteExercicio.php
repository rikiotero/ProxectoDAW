<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) || ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor" ) ) redirect("");

require "../../vendor/autoload.php";

use Clases\ExercicioDB;

$id = json_decode(file_get_contents("php://input"), true);

$db = new ExercicioDB();

if ( $db->deleteExercicio($id) ) {    
    $db->cerrarConexion();
    $output = "<div class='alert alert-success'>Exercicio borrado correctamente</div>";    
}else {
    $db->cerrarConexion();
    $output = "<div class='alert alert-danger'>Non se pudo borrar o exercicio</div>";
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>