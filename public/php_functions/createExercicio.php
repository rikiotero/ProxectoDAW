<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) || ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor" ) ) redirect("");
require "../../vendor/autoload.php";

use Clases\UserDB;
use Clases\ExercicioDB;
use Clases\CursosDB;
use Clases\Exercicio;

$datos = json_decode(file_get_contents('php://input'), true);

$db = new UserDB();
$exercicio = new Exercicio(
            null,
            strip_tags( trim($datos["tema"] ) ),
            $datos["enunciado"],
            $datos["asignatura"],
            $datos["exercActivo"] == true ? 1 : 0,
            $db->getUserId($datos["creador"]),
            $datos["fechaCreacion"]
        );

$erroresValidacion = $exercicio->validaExercicio($datos["curso"]);

if ( empty($erroresValidacion) ) {
    $db = new ExercicioDB();
    if ( $db->insertExercicio($exercicio) ) {
        $output = "<div class='alert alert-success'>Exercicio creado correctamente</div>";
    }else {
        $output = "<div class='alert alert-danger'>Non se pudo crear o exercicio , proba de novo</div>";
    }
    $db->cerrarConexion();
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}else {
    $output = "<div class='alert alert-danger'><ul>";
    foreach ($erroresValidacion as $key => $value) {
        $output .= "<li>$value</li>";
    }
    $output .= "</ul></div>";
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
}

?>