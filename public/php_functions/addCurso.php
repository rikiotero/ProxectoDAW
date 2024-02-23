<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) || ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor" ) ) redirect("");

require "../../vendor/autoload.php";

use Clases\CursosDB;

$datos = json_decode(file_get_contents("php://input"), true);
$curso = strip_tags( trim( $datos ) );

$db = new CursosDB();

if ( !$db->getCurso($curso) ) {  // comprobación de que non existe un curso con ese nome
    $id = $db->addCurso($curso); //gárdase o id do curso insertado para retornalo no outputr 
    $db->cerrarConexion();
    
    if( $id ) {
        $output = array ($id,"<div class='alert alert-success'>Curso creado correctamente</div>");
    }else {
        $output = "<div class='alert alert-danger'>Non se pudo crear o curso, proba de novo</div>";
    }
}else {
    $db->cerrarConexion();
    $output = "<div class='alert alert-danger'>Xa existe un curso con ese nome</div>";

}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>