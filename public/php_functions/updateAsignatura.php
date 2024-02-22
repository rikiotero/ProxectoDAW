<?php
session_start();
if( !isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "administrador" ) redirect("");

require "../../vendor/autoload.php";

use Clases\CursosDB;

$datos = json_decode(file_get_contents("php://input"), true);
$idAsignatura = $datos["idAsignatura"];
$nomeNovo = $datos["nomeNovo"];
$idCurso = $datos["idCurso"];

$db = new CursosDB();
$arrayAsignaturas = $db->getAsignaturas($idCurso);       //array coas asignaturas dun curso

if ( !in_array($nomeNovo,$arrayAsignaturas) ) {         //comprobación de que non existe unha asignatura con ese nome

    if ( $db->updateAsignatura($idAsignatura,$nomeNovo) ) {         
            $db->cerrarConexion();
            $output = "<div class='alert alert-success'>Asignatura actualizada correctamente</div>";    
        }else {
            $db->cerrarConexion();
            $output = "<div class='alert alert-danger'>Non se pudo actualizar o asignatura</div>";
        }
}else {
    $db->cerrarConexion();
    $output = "<div class='alert alert-danger'>Xa existe unha asignatura con ese nome, proba con outro nome</div>";
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>