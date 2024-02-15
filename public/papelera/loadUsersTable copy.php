<?php
require "../vendor/autoload.php";
use Clases\Conexion;


$columnas = ["usuarios.id","usuario","nombre","apellido1","apellido2","email","telefono","fecha_alta","activo","roles.rol"];

$db = new Conexion();
$conexion = $db->getConexion();

//recollida dos campos para filtrar a búsqueda
$filtro = isset($_POST["buscar"]) ? $_POST["buscar"] : null;
$activo = $_POST["activo"];
$inactivo = $_POST["inactivo"];
$rol = isset($_POST["rol"]) ? $_POST["rol"] : null;

//concatenamos a parte 'WHERE' da consulta SQL según os datos recibidos
$where = "";

if($filtro != null) {

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
if($filtro == null && !$activo && $inactivo) $where .= " WHERE activo=0";                                                                            
if($filtro == null && $activo && !$inactivo) $where .= " WHERE activo=1";   

//filtro según o rol recibido 
if($rol != null) {
    // si todos os filtros están vacios añadimos un 'WHERE' si non 'AND'
    if(($filtro == null && $activo && $inactivo) || ($filtro == null && !$activo && !$inactivo)) { 
        $where .= " WHERE roles.rol='".$rol."'";
    }else {
        $where .= " AND roles.rol='".$rol."'";
    }
}
 // si todos os filtros están vacios añadimos un 'WHERE' si nn 'AND'
if(($filtro == null && $rol == null && $activo && $inactivo) || ($filtro == null && $rol == null && !$activo && !$inactivo)) {              
    $where .= " WHERE usuarios.rol=roles.id"; 
}else{
    $where .= " AND usuarios.rol=roles.id";
}

$sql = "SELECT " . implode(", ", $columnas) . " FROM usuarios, roles". $where;
// var_dump($sql);
// exit;

//execución da consulta
try {
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
} catch (\PDOException $ex) {
    die("Error consultando base de datos: ".$ex->getMessage());
}


$html = "";
if ( $stmt->rowCount() != 0 ) {
    // echo "Temos resultados!";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $html .= "<tr>";
        $html .= "<td>".$row['id']."</td>";
        $html .= "<td>".$row['usuario']."</td>";
        $html .= "<td>".$row['nombre']."</td>";
        $html .= "<td>".$row['apellido1']."</td>";
        $html .= "<td>".$row['apellido2']."</td>";
        $html .= "<td>".$row['email']."</td>";
        $html .= "<td>".$row['telefono']."</td>";       
        $html .= "<td>".date('d-m-Y', strtotime($row['fecha_alta']))."</td>";

        if ( $row['activo'] == "1" ) $html .= "<td><i class='fa-solid fa-check' style='color: #098b43;'></i></td>";
        else $html .= "<td><i class='fa-solid fa-x' style='color: #f03333;'></i></td>";
         
        // $html .= "<td>".($row['activo'] == "1") ?  '<i class="fa-solid fa-check" style="color: #098b43;"></i>' : ''  ."</td>";
        // $html .= "<td>".$row['activo']."</td>";
        $html .= "<td>".$row['rol']."</td>";
        $html .= "<td><a href='' data-bs-toggle='modal' data-bs-target='#updateUserModal' ><i class='fa-solid fa-pen-to-square' style='color: #e6b328;'></i></a></td>";

        $html .= "<td><a href=''><i class='fa-solid fa-trash' style='color: #ff2600;'></i></a></td>";
        $html .= "</tr>";
    }
}else {
    $html .= "<tr>"; 
    $html .= "<td colspan='11' class='text-center'>Nada que mostrar</td>"; 
    $html .= "</tr>"; 
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
