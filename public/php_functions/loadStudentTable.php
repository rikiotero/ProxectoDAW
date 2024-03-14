<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) ||  ( $_SESSION["rol"] != "administrador" && $_SESSION["rol"] != "profesor") ) redirect("");

require "../../vendor/autoload.php";
use Clases\UserDB;

//columnas donde vamos a realizar a búsqueda
// $columnas = ["usuarios.id","usuario","cursos.nombre as curso","usuarios.nombre","apellido1","apellido2","email","telefono","fecha_alta","activo"];
$columnas = ["usuarios.id","usuario","cursos.curso","usuarios.nombre","apellido1","apellido2","email","telefono","fecha_alta","activo"];

//recollida dos campos para filtrar a búsqueda
$datos = json_decode(file_get_contents('php://input'), true);

$filtro = isset($_POST["buscar"]) ? $_POST["buscar"] : null;                            //input text de buscar...
$activo = $_POST["activo"];                                                             //chekbox de estudiantes activos 
$inactivo = $_POST["inactivo"];                                                         //chekbox de estudiantes inactivos                   
$curso = isset($_POST["curso"]) && $_POST["curso"] != "0" ? $_POST["curso"] : null;     //select de cursos
$numRexistros = isset($_POST["numRexistros"]) ? $_POST["numRexistros"] : 10;            //select de número de rexistros a mostrar
$paxina = isset($_POST["paxina"]) ? $_POST["paxina"] : 0;                               //paxina de resultados


//cálculo do rexistro de inicio desde donde se fai a consulta en caso de que a páxina non sexa a primeira
if ( $paxina == 0 ) {
    $inicio = 0;
    $paxina = 1;
}else {
    $inicio = ($paxina - 1) * $numRexistros;  
}

//concatenamos a parte 'WHERE' da consulta SQL según os datos recibidos
$where = "";

if($filtro != null) {

    $where .= " WHERE( ";
    $cont = count($columnas);

    for ($i=0; $i < $cont; $i++) {                          //añadimos un filto 'LIKE' por cada columna
       
        $where .= $columnas[$i] . " LIKE '%" . $filtro . "%' OR ";
    }
    $where = substr_replace($where, "", -3);                // elminamos o último OR
    $where .= ") ";                                         // cerre do where
 
    if($activo && !$inactivo) {
        $where .= "AND activo=1";
    }else if (!$activo && $inactivo){
        $where .= "AND activo=0";
    }
}  
// si non se filtra polo cuadro de búsqueda añdimos un 'WHERE' en lugar do 'AND'
if($filtro == null && !$activo && $inactivo) $where .= " WHERE activo=0";                                                                            
if($filtro == null && $activo && !$inactivo) $where .= " WHERE activo=1";   

//filtro según o curso recibido 
if($curso != null) {
    // si todos os filtros están vacios añadimos un 'WHERE' si non 'AND'
    if(($filtro == null && $activo && $inactivo) || ($filtro == null && !$activo && !$inactivo)) { 
        $where .= " WHERE cursos.id='".$curso."'";
    }else {
        $where .= " AND cursos.id='".$curso."'";
    }
}

 // si todos os filtros están vacios añadimos un 'WHERE' si non 'AND'
//  if(($filtro == null && $curso == null && $activo && $inactivo) || ($filtro == null && $curso == null && !$activo && !$inactivo)) {              
//     $where .= " WHERE usuarios.rol=3"; 
// }else{
//     $where .= " AND usuarios.rol=3";
// }

//limite de rexistros
$limit = "LIMIT $inicio , $numRexistros";

// $sql = "SELECT " . implode(", ", $columnas) . " FROM usuarios 
// LEFT JOIN cursos ON usuarios.curso = cursos.id".$where." ORDER BY fecha_alta DESC ".$limit;
$sql = "SELECT DISTINCT " . implode(", ", $columnas) . " FROM usuarios     
    JOIN usuario_asignatura ON usuario_asignatura.usuario_id=usuarios.id    
    JOIN asignaturas ON asignaturas.id=usuario_asignatura.asignatura_id    
    JOIN cursos ON cursos.id=asignaturas.curso ".$where." ORDER BY fecha_alta DESC ".$limit;
// var_dump($sql);
// exit;

$db = new UserDB();
$stmt = $db->getUsersFiltered($sql);

//obtemos o número total de rexistros da consulta para facer a paxinación
$sql = "SELECT DISTINCT " . implode(", ", $columnas) . " FROM usuarios     
    JOIN usuario_asignatura ON usuario_asignatura.usuario_id=usuarios.id    
    JOIN asignaturas ON asignaturas.id=usuario_asignatura.asignatura_id    
    JOIN cursos ON cursos.id=asignaturas.curso ".$where;
$rexistros = $db->getUsersFiltered($sql);
$numRows = $rexistros->rowCount();

$rexistros = $db->getUsersFiltered($sql);
$db->cerrarConexion();

$output = [];                                           //array que se vai retornar
// $output["numRexistrosFiltrados"] = $totalFiltro;     //número de rexistros devoltos pola consulta
$output["numRexistrosFiltrados"] = $numRows;            //número de rexistros devoltos pola consulta
$output["html"] = "";                                   //html para pintar  a tabla de usuarios
$output["paxinacion"] = "";                             //html para pintar os botóns de paxinación

if ( $stmt->rowCount() != 0 ) {

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $output["html"] .= "<tr>";
        $output["html"] .= "<td>".$row['id']."</td>";
        $output["html"] .= "<td>".$row['usuario']."</td>";
        $output["html"] .= "<td>".$row['curso']."</td>";
        $output["html"] .= "<td>".$row['nombre']."</td>";
        $output["html"] .= "<td>".$row['apellido1']."</td>";
        $output["html"] .= "<td>".$row['apellido2']."</td>";
        $output["html"] .= "<td>".$row['email']."</td>";
        $output["html"] .= "<td>".$row['telefono']."</td>";       
        $output["html"] .= "<td>".date('d-m-Y', strtotime($row['fecha_alta']))."</td>";

        if ( $row['activo'] == "1" ) $output["html"] .= "<td><i class='fa-solid fa-check' style='color: #098b43;'></i></td>";
        else $output["html"] .= "<td><i class='fa-solid fa-x' style='color: #f03333;'></i></td>";
         
        $output["html"] .= "<td><a href='' data-bs-toggle='modal'  title='editar usuario' id={$row['id']}><i class='fa-solid fa-pen-to-square' style='color: #e6b328;'></i></a></td>";

        $output["html"] .= "<td><a href='' data-bs-toggle='modal' title='borrar usuario' id=borrar-{$row['id']}><i class='fa-solid fa-trash' style='color: #ff2600;'></i></a></td>";
        $output["html"] .= "</tr>";
    }
}else {
    $output["html"] .= "<tr>"; 
    $output["html"] .= "<td colspan='11' class='text-center'>Nada que mostrar</td>"; 
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
            $output["paxinacion"] .= "<li class='page-item'><a class='page-link' href='#' onclick='getStudentTable($i)'>$i</a></li>";
        }        
    }
    $output["paxinacion"] .= "</ul>";
    $output["paxinacion"] .= "</nav>";
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
