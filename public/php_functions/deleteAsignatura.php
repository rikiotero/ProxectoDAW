<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) || ( $_SESSION["rol"] != "administrador" ) ) redirect("");

require "../../vendor/autoload.php";

use Clases\CursosDB;
use Clases\ExercicioDB;

$id = json_decode(file_get_contents("php://input"), true);


$db = new ExercicioDB();
if ( empty( $db->getExercicioByAsignatura($id)) ) {     //non hai exercicios de esa asignatura
    $db2 = new CursosDB();
    if ( !$db2->checkAsignatura($id) ) {                //non hai estudantes con esa asignatura
        $db = new CursosDB();
        if ( $db->deleteAsignatura($id) ) {    
            $db->cerrarConexion();
            $db2->cerrarConexion();
            $output = "<div class='alert alert-success'>Materia borrada correctamente</div>";    
        }else {
            $db->cerrarConexion();
            $db2->cerrarConexion();
            $output = "<div class='alert alert-danger'>Non se pudo borrar a materia</div>";
        }
    }else {
        $db2->cerrarConexion();
        $output = "<div class='alert alert-danger'>Non se pode eliminar a materia mentras existan estudiantes con esa materia</div>";
    }

}else {
    $db->cerrarConexion();
    $output = "<div class='alert alert-danger'>Non se pode eliminar a materia mentras existan exercicios desta materia</div>";
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>