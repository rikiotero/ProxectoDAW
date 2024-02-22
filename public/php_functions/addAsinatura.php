<?php
session_start();
if( !isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "administrador" ) redirect("");

require "../../vendor/autoload.php";

use Clases\CursosDB;

$datos = json_decode(file_get_contents("php://input"), true);
$curso = strip_tags( trim( $datos["curso"] ) );
$asignatura = strip_tags( trim( $datos["asignNova"] ) );

$db = new CursosDB();
//comprobación de que non existe esa asignatura en ese curso
$asignaturasCurso = $db->getAsignaturas($curso);

if ( !in_array($asignatura,$asignaturasCurso) ) {  // comprobación de que non existe unha asignatura con ese nome
    $id = $db->addAsignatura($curso,$asignatura); //gárdase o id do curso insertado para retornalo no outputr 
    $db->cerrarConexion();
    
    if( $id ) {
        $output = array ($id,"<div class='alert alert-success'>Asignatura creada correctamente</div>");
    }else {
        $output = "<div class='alert alert-danger'>Non se pudo crear a asignatura, proba de novo</div>";
    }
}else {
    $db->cerrarConexion();
    $output = "<div class='alert alert-danger'>Xa existe unha asignaturas con ese nome en ese curso</div>";

}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>