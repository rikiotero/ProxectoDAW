<?php
session_start();
if( !isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "administrador") redirect("");

require "../../vendor/autoload.php";

use Clases\CursosDB;

$id = json_decode(file_get_contents("php://input"), true);

$db = new CursosDB();
$datos = $db->getAsignaturas($id);
$db->cerrarConexion();
$html = "";
if( !empty($datos) ) {
    foreach ($datos as $key => $value) {
        $html .= "<tr>";
        $html .= "<td>$key</td>";
        $html .= "<td>$value</td>";
        $html .= "<td class='text-center'><a href='' data-bs-toggle='modal'  title='editar asignarura' id=actulizarAsig-{$key}><i class='fa-solid fa-pen-to-square' style='color: #e6b328;'></i></a></td>";
        $html .= "<td class='text-center'><a href='' data-bs-toggle='modal' title='borrar asignarura' id=borrarAsig-{$key}><i class='fa-solid fa-trash' style='color: #ff2600;'></i></a></td>";
        $html .= "</tr>";
    }
}else {
    $html .= "<tr>";
    $html .= "<td colspan='3' class='text-center'>Sin Asignaturas</td>";
    $html .= "</tr>";
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
?>