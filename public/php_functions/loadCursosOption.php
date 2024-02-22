<?php
session_start();
if( !isset($_SESSION["rol"])) redirect("");

require "../../vendor/autoload.php";

use Clases\CursosDB;

$selectId = json_decode(file_get_contents("php://input"), true);
$output = "<option value='0'>Selecciona un curso...</option>";

$db = new CursosDB();
$cursos = $db->getCursos();
$db->cerrarConexion();

if( !empty($cursos) ) {
    foreach ($cursos as $key => $value) {
        $output .= "<option value='$key'>$value</option>";
    }
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>