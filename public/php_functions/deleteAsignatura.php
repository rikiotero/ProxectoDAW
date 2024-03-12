<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) || ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor" ) ) redirect("");

require "../../vendor/autoload.php";

use Clases\CursosDB;
use Clases\ExercicioDB;

$id = json_decode(file_get_contents("php://input"), true);


$db = new ExercicioDB();
if ( empty( $db->getExercicioByAsignatura($id)) ) {

    $db = new CursosDB();
    if ( $db->deleteAsignatura($id) ) {    
        $db->cerrarConexion();
        $output = "<div class='alert alert-success'>Materia borrada correctamente</div>";    
    }else {
        $db->cerrarConexion();
        $output = "<div class='alert alert-danger'>Non se pudo borrar a materia</div>";
    }
}else {
    $db->cerrarConexion();
    $output = "<div class='alert alert-danger'>Non se pode eliminar a materia mentras existan exercicios desta materia</div>";
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>