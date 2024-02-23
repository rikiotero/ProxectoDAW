<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) || ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor" ) ) redirect("");

require "../../vendor/autoload.php";

use Clases\CursosDB;

$id = json_decode(file_get_contents("php://input"), true);

$db = new CursosDB();

if ( empty( $db->getAsignaturas($id) ) ) {
    if ( $db->deleteCurso($id) ) {  
        $db->cerrarConexion();
        $output = "<div class='alert alert-success'>Curso borrado correctamente</div>";    
    }else {
        $db->cerrarConexion();
        $output = "<div class='alert alert-danger'>Non se pudo borrar o curso</div>";
    }
}else {
    $db->cerrarConexion();
    $output = "<div class='alert alert-danger'>Non se pode eliminar o curso mentras teña asignaturas asociadas</div>";
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>