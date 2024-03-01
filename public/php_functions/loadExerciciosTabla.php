<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) ||  ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor") ) redirect("");

require "../../vendor/autoload.php";
use Clases\ExercicioDB;

//columnas donde vamos a realizar a búsqueda
$columnas = ["exercicios.id","tema","cursos.curso","asignaturas.nombre ","exercicios.activo","enunciado","usuarios.usuario","fecha_creacion"];

//recollida dos campos para filtrar a búsqueda
$datos = json_decode(file_get_contents('php://input'), true);

$filtro = isset($_POST["buscar"]) ? $_POST["buscar"] : null;            //input text de buscar...
$activo = $_POST["activo"];                                             //chekbox de exercicios activos 
$inactivo = $_POST["inactivo"];                                         //chekbox de exercicios inactivos                   
$curso = isset($_POST["curso"]) && $_POST["curso"] != "0" ? $_POST["curso"] : null;           //select de curso

//concatenamos a parte 'WHERE' da consulta SQL según os datos recibidos
$where = "";

if ( $filtro != null ) {

    $where .= " WHERE( ";
    $cont = count($columnas);

    for ($i=0; $i < $cont; $i++) {               //añadimos un filto 'LIKE' por cada columna
       
        $where .= $columnas[$i] . " LIKE '%" . $filtro . "%' OR ";
    }
    $where = substr_replace($where, "", -3);    // elminamos o último OR
    $where .= ") ";                             // cerre do where
 
    if($activo && !$inactivo) {
        $where .= "AND exercicios.activo=1";
    }else if (!$activo && $inactivo){
        $where .= "AND exercicios.activo=0";
    }
}

// si non se filtra polo cuadro de búsqueda añdimos un 'WHERE' en lugar do 'AND'
if($filtro == null && !$activo && $inactivo) $where .= " WHERE exercicios.activo=0";                                                                            
if($filtro == null && $activo && !$inactivo) $where .= " WHERE exercicios.activo=1";   

//filtro según o curso recibido 
if($curso != null) {
    // si todos os filtros están vacios añadimos un 'WHERE' si non 'AND'
    if(($filtro == null && $activo && $inactivo) || ($filtro == null && !$activo && !$inactivo)) { 
        $where .= " WHERE cursos.id='".$curso."'";
    }else {
        $where .= " AND cursos.id='".$curso."'";
    }
}
//  // si todos os filtros están vacios añadimos un 'WHERE' si non 'AND'
// if(($filtro == null && $curso == null && $activo && $inactivo) || ($filtro == null && $curso == null && !$activo && !$inactivo)) {              
//     $where .= " WHERE usuarios.id=alumno_curso.usuario_id AND alumno_curso.curso_id=cursos.id AND usuarios.rol=3"; 
// }else{
//     $where .= " AND usuarios.id=alumno_curso.usuario_id AND alumno_curso.curso_id=cursos.id AND usuarios.rol=3";
// }

 // si todos os filtros están vacios añadimos un 'WHERE' si non 'AND'
//  if(($filtro == null && $curso == null && $activo && $inactivo) || ($filtro == null && $curso == null && !$activo && !$inactivo)) {              
//     $where .= " WHERE exercicios.creador=usuarios.id AND exercicios.asignatura=asignaturas.id AND asignaturas.curso=cursos.id"; 
// }else{
//     $where .= " AND exercicios.creador=usuarios.id AND exercicios.asignatura=asignaturas.id AND asignaturas.curso=cursos.id";
// }

$sql = "SELECT " . implode(", ", $columnas) . " FROM exercicios LEFT JOIN usuarios ON exercicios.creador=usuarios.id
JOIN asignaturas ON exercicios.asignatura=asignaturas.id
JOIN cursos ON asignaturas.curso=cursos.id". $where;

 // si todos os filtros están vacios añadimos un 'WHERE' si non 'AND'
//  if(($filtro == null && $curso == null && $activo && $inactivo) || ($filtro == null && $curso == null && !$activo && !$inactivo)) {              
//     $where .= " WHERE exercicios.creador=usuarios.id AND exercicios.asignatura=asignaturas.id AND asignaturas.curso=cursos.id"; 
// }else{
//     $where .= " AND exercicios.creador=usuarios.id AND exercicios.asignatura=asignaturas.id AND asignaturas.curso=cursos.id";
// }

// $sql = "SELECT " . implode(", ", $columnas) . " FROM exercicios, usuarios, asignaturas,cursos". $where;


// var_dump($sql);
// exit;

$db = new ExercicioDB();
$stmt = $db->getExerciciosFiltered($sql);
$db->cerrarConexion();
$html = "";

if ( $stmt->rowCount() != 0 ) {

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $html .= "<tr>";
        $html .= "<td>".$row['id']."</td>";
        $html .= "<td>".$row['tema']."</td>";
        $html .= "<td>".$row['curso']."</td>";
        $html .= "<td>".$row['nombre']."</td>";
        $html .= "<td>".$row['usuario']."</td>"; 
        if ( $row['activo'] == "1" ) $html .= "<td><i class='fa-solid fa-check' style='color: #098b43;'></i></td>";
        else $html .= "<td><i class='fa-solid fa-x' style='color: #f03333;'></i></td>";
        
        $html .= "<td>".date('d-m-Y', strtotime($row['fecha_creacion']))."</td>";
        // $html .= "<td>".($row['activo'] == "1") ?  '<i class="fa-solid fa-check" style="color: #098b43;"></i>' : ''  ."</td>";
        // $html .= "<td>".$row['activo']."</td>";
        $html .= "<td><a href='./exercicio.php?id={$row['id']}' target='_blank' title='editar exercicio' id=editar-{$row['id']}><span class='fa-solid fa-pen-to-square' style='color: #e6b328;'></span></a></td>";

        $html .= "<td><a href='' data-bs-toggle='modal' title='borrar exercicio' id=borrar-{$row['id']}><span class='fa-solid fa-trash' style='color: #ff2600;'></span></a></td>";
        $html .= "</tr>";
    }
}else {
    $html .= "<tr>"; 
    $html .= "<td colspan='8' class='text-center'>Nada que mostrar</td>"; 
    $html .= "</tr>"; 
}
$stmt = null;
echo json_encode($html, JSON_UNESCAPED_UNICODE);
