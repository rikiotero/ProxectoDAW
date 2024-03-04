<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) ) redirect("");

require "../../vendor/autoload.php";

use Clases\UserDB;
use Clases\Student;

$datos = json_decode(file_get_contents("php://input"), true);
$userId = $datos["id"];

$db = new UserDB();
$datos = $db->getUserById($userId);

if( $datos ) {

    switch ($datos->rol) {
        case 1:                         //administrador
            $db->cerrarConexion();
            $output = $datos;
            break;
        case 2:                         //profesor
            $db->cerrarConexion();
            $output = $datos;
            break;
        case 3:                         //estudiante
            $curso = $db->getCurso($userId);
            $asignaturas = $db->getAsignaturas($userId);
            // $estudiante = new Student($datos,$curso,$asignaturas);

            $estudiante = new Student(
                            $datos->usuario,
                            $datos->password,
                            $datos->nombre,
                            $datos->apellido1,
                            $datos->apellido2,
                            $datos->email,
                            $datos->telefono,
                            $datos->fecha_alta,                
                            $datos->activo,
                            $datos->rol,
                            $curso,
                            $asignaturas);

            $db->cerrarConexion();
            // $output = $estudiante->jsonSerialize();
            $output = $estudiante;
            break;
        default:            
            break;
    }

}else {
    $output = "<div class='alert alert-danger'>Non se pudo borrar o usuario, proba de novo</div>";
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>