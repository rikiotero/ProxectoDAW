<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) || ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor" ) ) redirect("");

require "../../vendor/autoload.php";

use Clases\CursosDB;

$db = new CursosDB();
$datos = $db->getCursos();
$db->cerrarConexion();
$html = "";
if( !empty($datos) ) {
    foreach ($datos as $key => $value) {
        $html .= "<tr>";
        $html .= "<td>$key</td>";
        $html .= "<td>$value</td>";
        $html .= "<td><a href='' data-bs-toggle='modal'  title='editar curso' id=actulizarCurso-{$key}><i class='fa-solid fa-pen-to-square' style='color: #e6b328;'></i></a></td>";
        $html .= "<td><a href='' data-bs-toggle='modal' title='borrar curso' id=borrarCurso-{$key}><i class='fa-solid fa-trash' style='color: #ff2600;'></i></a></td>";
        $html .= "</tr>";
    }
}else {
    $html .= "<tr>";
    $html .= "<td colspan='3' class='text-center'>Sen materias</td>";
    $html .= "</tr>";
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
?>