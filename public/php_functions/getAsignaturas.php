<?php
session_start();
if( !isset($_SESSION["rol"])) redirect("");

require "../../vendor/autoload.php";

use Clases\CursosDB;

$idCurso = json_decode(file_get_contents("php://input"), true);
// $idCurso = $datos;
$output = "";

$db = new CursosDB();
$datos = $db->getAsignaturas($idCurso);
$db->cerrarConexion();

if( !empty($datos) ) {
    foreach ($datos as $key => $value) {
        $output .= "<option value='$key'>$value</option>";
    }

}else {
    $output .= "<option value='0'>Sen materias</option>";
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>