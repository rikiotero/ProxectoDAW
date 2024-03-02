<?php
session_start();
require "./redirect.php";
if( !isset($_SESSION["rol"]) || $_SESSION["rol"] != "administrador"  ) redirect("");

require "../../vendor/autoload.php";
use Clases\UserDB;

//columnas nas que vamos a realizar a búsqueda
$columnas = ["usuarios.id","usuario","nombre","apellido1","apellido2","email","telefono","fecha_alta","activo","roles.rol"];

//recollida dos campos para filtrar a búsqueda
$filtro = isset($_POST["buscar"]) ? $_POST["buscar"] : null;                    //input text de buscar...
$activo = $_POST["activo"];                                                     //chekbox de usuarios activos 
$inactivo = $_POST["inactivo"];                                                 //chekbox de usuarios inactivos                   
$rol = isset($_POST["rol"]) ? $_POST["rol"] : null;                             //select de roles
$numRexistros = isset($_POST["numRexistros"]) ? $_POST["numRexistros"] : 10;    //select de número de rexistros a mostrar
$paxina = isset($_POST["paxina"]) ? $_POST["paxina"] : 0;                       //paxina de resultados

//cálculo do rexistro de inicio desde donde se fai a consulta en caso de que a páxina non sexa a primeira
if ( $paxina == 0 ) {
    $inicio = 0;
    $paxina = 1;
}else {
    $inicio = ($paxina - 1) * $numRexistros;  
}

//concatenamos a parte 'WHERE' da consulta SQL según os datos recibidos
$where = "";

if( $filtro != null ) {

    $where .= " WHERE( ";
    $cont = count($columnas);

    for ($i=0; $i < $cont; $i++) {               //añadimos un filto 'LIKE' por cada columna
        $where .= $columnas[$i] . " LIKE '%" . $filtro . "%' OR ";
    }
    $where = substr_replace($where, "", -3);    // elminamos o último OR
    $where .= ") ";                            // cerre do where
 
    if($activo && !$inactivo) {
        $where .= "AND activo=1";
    }else if (!$activo && $inactivo){
        $where .= "AND activo=0";
    }
}  

// si non se filtra polo cuadro de búsqueda añdimos un 'WHERE' en lugar do 'AND'
if( $filtro == null && !$activo && $inactivo ) $where .= " WHERE activo=0";                                                                            
if( $filtro == null && $activo && !$inactivo ) $where .= " WHERE activo=1";   

//filtro según o rol recibido 
if( $rol != null ) {
    // si todos os filtros están vacios añadimos un 'WHERE' si non 'AND'
    if(($filtro == null && $activo && $inactivo) || ($filtro == null && !$activo && !$inactivo)) { 
        $where .= " WHERE roles.rol='".$rol."'";
    }else {
        $where .= " AND roles.rol='".$rol."'";
    }
}
 // si todos os filtros están vacios añadimos un 'WHERE' si nn 'AND'
if( ($filtro == null && $rol == null && $activo && $inactivo) || ($filtro == null && $rol == null && !$activo && !$inactivo) ) {              
    $where .= " WHERE usuarios.rol=roles.id"; 
}else{
    $where .= " AND usuarios.rol=roles.id";
}

//limite de rexistros
$limit = "LIMIT $inicio , $numRexistros";

//con "implode" creamos un string coas columnas que desexamos buscar, separando os elementos do array con ", "
$sql = "SELECT " . implode(", ", $columnas) . " FROM usuarios, roles". "$where $limit";
// var_dump($sql);
// exit;

$db = new UserDB();
$stmt = $db->getUsersFiltered($sql);

//obtemos o número total de rexistros da consulta para facer a paxinación
$sql = "SELECT " . implode(", ", $columnas) . " FROM usuarios, roles". $where;
$rexistros = $db->getUsersFiltered($sql);
$numRows = $rexistros->rowCount();


//consulta para obter o número de rexistros que devolve a consulta filtrada
// $sqlFiltro = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $columnas) . " FROM usuarios, roles ". "$where $limit";
// $resultadoFiltrado = $db->getUsersFiltered($sqlFiltro);


// $sqlNumRows = "SELECT FOUND_ROWS()";                     //número de rexistros que devolveu a consulta con "SQL_CALC_FOUND_ROWS"
// $resultado = $db->getUsersFiltered($sqlNumRows);
// $numRows = $resultado->fetch(PDO::FETCH_NUM);
// if ( $numRows ) $totalFiltro =  $numRows[0];
// else $totalFiltro = 0;

$db->cerrarConexion();

$output = [];                                       //array que se vai retornar
$output["numRexistrosFiltrados"] = $numRows;        //número de rexistros devoltos pola consulta
$output["html"] = "";                               //html para pintar  a tabla de usuarios
$output["paxinacion"] = "";                         //html para pintar os botóns de paxinación

if ( $stmt->rowCount() != 0 ) {

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {   
        $output["html"] .= "<tr>";
        $output["html"] .= "<td>".$row['id']."</td>";
        $output["html"] .= "<td>".$row['usuario']."</td>";
        $output["html"] .= "<td>".$row['nombre']."</td>";
        $output["html"] .= "<td>".$row['apellido1']."</td>";
        $output["html"] .= "<td>".$row['apellido2']."</td>";
        $output["html"] .= "<td>".$row['email']."</td>";
        $output["html"] .= "<td>".$row['telefono']."</td>";       
        $output["html"] .= "<td>".date('d-m-Y', strtotime($row['fecha_alta']))."</td>";

        if ( $row['activo'] == "1" ) $output["html"] .= "<td><i class='fa-solid fa-check' style='color: #098b43;'></i></td>";
        else $output["html"] .= "<td><i class='fa-solid fa-x' style='color: #f03333;'></i></td>";
        //botón editar usuario
        $output["html"] .= "<td>".$row['rol']."</td>";
        $output["html"] .= "<td><a href='' data-bs-toggle='modal'  title='editar usuario' id={$row['id']}><i class='fa-solid fa-pen-to-square' style='color: #e6b328;'></i></a></td>";
        //botón borrar usuario
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

    $output["paxinacion"] .= "<nav class='d-flex justify-content-end'>";
    $output["paxinacion"] .= "<ul class='pagination'>";

    for ($i=1; $i<=$numPaxinas ; $i++) {  //marcar seleccionada a páxina activa
        if( $paxina == $i ) {
            $output["paxinacion"] .= "<li class='page-item active'><a class='page-link' href='#'>$i</a></li>";
        } else {
            $output["paxinacion"] .= "<li class='page-item'><a class='page-link' href='#' onclick='getUsersData($i)'>$i</a></li>";
        }        
    }
    $output["paxinacion"] .= "</ul>";
    $output["paxinacion"] .= "</nav>";
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
