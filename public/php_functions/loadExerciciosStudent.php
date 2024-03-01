<?php
// require "./redirect.php";
// if( !isset($_SESSION["rol"]) ||  ( $_SESSION["rol"] != "administrador" || $_SESSION["rol"] != "profesor") ) redirect("");
session_start();
require "../../vendor/autoload.php";
use Clases\ExercicioDB;

//columnas donde vamos a realizar a búsqueda
$columnas = ["exercicios.id","tema","asignaturas.nombre ","usuarios.usuario","fecha_creacion"];

//recollida dos campos para filtrar a búsqueda
$datos = json_decode(file_get_contents('php://input'), true);

// $curso = isset($_POST["curso"]) && $_POST["curso"] != "0" ? $_POST["curso"] : null;          //select de curso
// $asignaturas = isset($_POST["asignaturas"]) ? $_POST["asignaturas"] : null;

$filtro = $datos["filtro"] != "" ? $datos["filtro"] : null;  //input text de buscar...
// $curso = array_keys($_SESSION["curso"])[0];                   //curso
$asignaturas = $_SESSION["asignaturas"];                      //array de asignaturas

//concatenamos a parte 'AND' da consulta SQL según as asignaturas do usuario
$andAsignaturas = "";
if ( !empty($asignaturas) ) {

    $andAsignaturas .= " AND( ";
    
    foreach ($asignaturas as $key => $value) {
        $andAsignaturas .= "asignatura=". $key ." OR ";   //añadimos un filto 'OR' por cada asignatura     
    }

    $andAsignaturas = substr_replace($andAsignaturas, "", -3);    // elminamos o último OR
    $andAsignaturas .= ") "; 
}else {
    $andAsignaturas .= " AND asignatura=0";
}

//concatenamos a parte 'AND' da consulta SQL para filtrar según os datos recibidos
$andFiltro = "";

if ( $filtro != null ) {

    $andFiltro .= " AND( ";
    $cont = count($columnas);

    for ($i=0; $i < $cont; $i++) {               //añadimos un filto 'LIKE' por cada columna
       
        $andFiltro .= $columnas[$i] . " LIKE '%" . $filtro . "%' OR ";
    }
    $andFiltro = substr_replace($andFiltro, "", -3);    // elminamos o último OR
    $andFiltro .= ") ";                                 // cerre do where
}

$sql = "SELECT " . implode(", ", $columnas) . " FROM exercicios, asignaturas, usuarios 
                                                WHERE exercicios.asignatura=asignaturas.id 
                                                AND exercicios.creador=usuarios.id ".$andAsignaturas."".$andFiltro.
                                                " AND exercicios.activo=1";

$db = new ExercicioDB();
$stmt = $db->getExerciciosFiltered($sql);
$db->cerrarConexion();
$html = "";

if ( $stmt->rowCount() != 0 ) {

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $html .= "<tr>";
        $html .= "<td>".$row['id']."</td>";
        $html .= "<td>".$row['tema']."</td>";
        $html .= "<td>".$row['nombre']."</td>";
        $html .= "<td>".$row['usuario']."</td>";
        $html .= "<td>".date('d-m-Y', strtotime($row['fecha_creacion']))."</td>";
        $html .= "<td><a href='./exercicio.php?id={$row['id']}' target='_blank' title='ver exercicio' id=ver-{$row['id']}>
                    <span class='fa-regular fa-eye' style='color: #e6b328;'></span></a></td>";
        $html .= "</tr>";
    }
}else {
    $html .= "<tr>"; 
    $html .= "<td colspan='6' class='text-center'>Nada que mostrar</td>"; 
    $html .= "</tr>"; 
}
$stmt = null;
echo json_encode($html, JSON_UNESCAPED_UNICODE);