<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) ) redirect("");

require "../../vendor/autoload.php";
use Clases\ExercicioDB;

//columnas donde vamos a realizar a búsqueda
$columnas = ["exercicios.id","tema","asignaturas.nombre","usuarios.usuario","fecha_creacion","enunciado"];

//recollida dos campos para filtrar a búsqueda
$datos = json_decode(file_get_contents('php://input'), true);

// $curso = isset($_POST["curso"]) && $_POST["curso"] != "0" ? $_POST["curso"] : null;          //select de curso
// $asignaturas = isset($_POST["asignaturas"]) ? $_POST["asignaturas"] : null;

$filtro = $datos["filtro"] != "" ? $datos["filtro"] : null;         //input text de buscar...
// $curso = array_keys($_SESSION["curso"])[0];                      //curso
$asignaturas = $_SESSION["asignaturas"];                            //array de asignaturas
$numRexistros = $datos["numRexistros"] != 10 ? $datos["numRexistros"] : 10;            //select de número de rexistros a mostrar
$paxina = $datos["paxina"] ? $datos["paxina"] : 0;

//cálculo do rexistro de inicio desde donde se fai a consulta en caso de que a páxina non sexa a primeira
if ( $paxina == 0 ) {
    $inicio = 0;
    $paxina = 1;
}else {
    $inicio = ($paxina - 1) * $numRexistros;  
}

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

$limit = "LIMIT $inicio , $numRexistros";

$sql = "SELECT " . implode(", ", $columnas) . " FROM exercicios, asignaturas, usuarios 
                                                WHERE exercicios.asignatura=asignaturas.id 
                                                AND exercicios.creador=usuarios.id ".$andAsignaturas."".$andFiltro.
                                                " AND exercicios.activo=1 ORDER BY asignaturas.nombre,fecha_creacion DESC ".$limit;

$db = new ExercicioDB();
$stmt = $db->getExerciciosFiltered($sql);

//obtemos o número total de rexistros da consulta para facer a paxinación
$sql = $sql = "SELECT " . implode(", ", $columnas) . " FROM exercicios, asignaturas, usuarios 
WHERE exercicios.asignatura=asignaturas.id 
AND exercicios.creador=usuarios.id ".$andAsignaturas."".$andFiltro.
" AND exercicios.activo=1";

$rexistros = $db->getExerciciosFiltered($sql);
$numRows = $rexistros->rowCount();

$db->cerrarConexion();

$output = [];                                           //array que se vai retornar
$output["numRexistrosFiltrados"] = $numRows;            //número de rexistros devoltos pola consulta
$output["html"] = "";                                   //html para pintar  a tabla de usuarios
$output["paxinacion"] = "";                             //html para pintar os botóns de paxinación


if ( $stmt->rowCount() != 0 ) {

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $output["html"] .= "<tr>";
        $output["html"] .= "<td>".$row['id']."</td>";
        $output["html"] .= "<td>".$row['tema']."</td>";
        $output["html"] .= "<td>".$row['nombre']."</td>";
        $output["html"] .= "<td>".$row['usuario']."</td>";
        $output["html"] .= "<td>".date('d-m-Y', strtotime($row['fecha_creacion']))."</td>";
        $output["html"] .= "<td><a href='./exercicio.php?id={$row['id']}' target='_blank' title='ver exercicio' id=ver-{$row['id']}>
                    <span class='fa-regular fa-eye' style='color: #e6b328;'></span></a></td>";
        $output["html"] .= "</tr>";
    }
}else {
    $output["html"] .= "<tr>"; 
    $output["html"] .= "<td colspan='6' class='text-center'>Nada que mostrar</td>"; 
    $output["html"] .= "</tr>"; 
}
$stmt = null;

//creación do "nav" para a paxinación
if ( $output["numRexistrosFiltrados"] > 0 ) {

    //cálculo do número de páxinas según o número de usuarios que se mostran
    $numPaxinas =  ceil( $output["numRexistrosFiltrados"] / $numRexistros ) ;   

    $output["paxinacion"] .= "<nav class='d-flex justify-content-center'>";
    $output["paxinacion"] .= "<ul class='pagination'>";

    for ($i=1; $i<=$numPaxinas ; $i++) {  //marcar seleccionada a páxina activa
        if( $paxina == $i ) {
            $output["paxinacion"] .= "<li class='page-item active'><a class='page-link' href='#'>$i</a></li>";
        } else {
            $output["paxinacion"] .= "<li class='page-item'><a class='page-link' href='#' onclick='getExerciciosStudent($i)'>$i</a></li>";
        }        
    }
    $output["paxinacion"] .= "</ul>";
    $output["paxinacion"] .= "</nav>";
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);