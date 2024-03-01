<?php
session_start();
require "../../vendor/autoload.php";
require "./redirect.php";
use Clases\UserDB;
use Clases\ExercicioDB;
use Clases\CursosDB;
use Clases\Exercicio;

$datos = json_decode(file_get_contents('php://input'), true);

// //validación de datos
// $erroresValidacion = [];
// if ( $datos["tema"] == "" ) $erroresValidacion[] = "O tema non pode estar vacío";
// if ( $datos["enunciado"] == "" ) $erroresValidacion[] = "O enunciado non pode estar vacío";

// //validación do curso
// if ( $datos["curso"] != "0" ) {
//     $cursosDB = new CursosDB();     
//     $cursos =  $cursosDB->getCursos();
//     $asignaturas = $cursosDB->getAsignaturas($datos["curso"]);
//     $cursosDB->cerrarConexion();

//     if ( !array_key_exists( $datos["curso"],$cursos ) ) {
//         $erroresValidacion[] = "O curso insertado é incorrecto";
//     }
// }else {
//     $erroresValidacion[] = "O curso non pode estar vacío";
// }

// //Validación das asignaturas
// if ( $datos["asignatura"] != "0" ) {
//     if ( !array_key_exists( $datos["asignatura"],$asignaturas ) ) {
//         $erroresValidacion[] = "A asignatura é incorrecta";
//     }
// }else {
//     $erroresValidacion[] = "A asignatura non pode estar vacía";
// }

// $db = new UserDB();
// if ( !$db->getUser($datos["creador"]) ) $erroresValidacion [] = "O usuario autor é incorrecto";
// if ( !preg_match("/^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/", $datos["fechaCreacion"]) ) $erroresValidacion [] = "A fecha é incorrecta";
// if ( !preg_match("/^[01]$/", $datos["exercActivo"]) ) $erroresValidacion [] = "O valor de exercicio activo é incorrecto";
// //fin validación
$db = new UserDB();
$exercicio = new Exercicio(null,$datos["tema"],$datos["enunciado"],$datos["asignatura"],$datos["exercActivo"],$db->getUserId($datos["creador"]),$datos["fechaCreacion"]);

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