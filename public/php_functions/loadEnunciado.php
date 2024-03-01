<?php
session_start();
require "../../vendor/autoload.php";
require "./redirect.php";
use Clases\UserDB;
use Clases\ExercicioDB;
use Clases\CursosDB;
use Clases\Exercicio;

$datos = json_decode(file_get_contents('php://input'), true);

$db = new ExercicioDB();
$exercicio = $db->getExercicioById($datos);
$db->cerrarConexion();
$enunciado = $exercicio->getEnunciado();

echo json_encode($enunciado, JSON_UNESCAPED_UNICODE);