<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) || ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor" ) ) redirect("");

require "../../vendor/autoload.php";

use Clases\CursosDB;

$datos = json_decode(file_get_contents("php://input"), true);
$id = $datos["id"];
$nomeNovo = $datos["nomeNovo"];

$db = new CursosDB();

if ( !$db->getCurso($nomeNovo) ) {

    if ( $db->updateCurso($id,$nomeNovo) ) {         
            $db->cerrarConexion();
            $output = "<div class='alert alert-success'>Curso actualizado correctamente</div>";    
        }else {
            $db->cerrarConexion();
            $output = "<div class='alert alert-danger'>Non se pudo actualizar o curso</div>";
        }
}else {
    $db->cerrarConexion();
    $output = "<div class='alert alert-danger'>Xa existe un curso con ese nome, proba con outro nome</div>";
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>