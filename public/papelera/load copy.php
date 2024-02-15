<?php
class Conexion {
    private $host = "localhost";
    private $db = "academia";
    private $user = "administrador";
    private $pass= "admin";
    private $opciones = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    public $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO("mysql:host=".$this->host.";dbname=".$this->db.";charset=utf8mb4", $this->user, $this->pass, $this->opciones);
            // echo "Conectado  éxit";
        } catch (\PDOException $ex) {
            die("Error: " . $ex->getMessage());
        }
    }
    
    public function cerrarConexion() {
        $this->conexion = null;
    }
}



$columnas = ["usuarios.id","usuario","nombre","apellido1","apellido2","email","telefono","fecha_alta","activo","roles.rol"];
// $table = "usuarios";

$conexion = new Conexion();

$campo = isset($_POST["campo"]) ? $_POST["campo"] : null;
$activo = $_POST["activo"];
$inactivo = $_POST["inactivo"];
$rol = isset($_POST["rol"]) ? $_POST["rol"] : null;




$where = "";

if($campo != null) {

    $where .= " WHERE( ";
    $cont = count($columnas);

    for ($i=0; $i < $cont; $i++) {               //añadimos un filto por cada columna
        $where .= $columnas[$i] . " LIKE '%" . $campo . "%' OR ";
    }
    $where = substr_replace($where, "", -3);    // elminamos o último OR
    $where .= ") ";                            // cerre do where
 
    if($activo && !$inactivo) {
        $where .= "AND activo=1";
    }else if (!$activo && $inactivo){
        $where .= "AND activo=0";
    }
}  

// if($campo == null && $activo) $where .= "WHERE activo=1";
// if($campo == null && !$activo) $where .= "WHERE activo=0";
// if($campo == null && $activo && $inactivo) $where .= ")";
if($campo == null && !$activo && $inactivo) $where .= " WHERE activo=0";  // si non se filtra polo cuadro de búsqueda                                                                           
if($campo == null && $activo && !$inactivo) $where .= " WHERE activo=1";   //añdimos un 'WHERE' en lugar do 'AND'

if($rol != null) {
    if(($campo == null && $activo && $inactivo) || ($campo == null && !$activo && !$inactivo)) { // si todos os filtros están vacios añadimos un 'WHERE' si nn 'AND'
        $where .= " WHERE roles.rol='".$rol."'";
    }else {
        $where .= " AND roles.rol='".$rol."'";
    }
}

if(($campo == null && $rol == null && $activo && $inactivo) || ($campo == null && $rol == null && !$activo && !$inactivo)) {               // si todos os filtros están vacios añadimos un 'WHERE' si nn 'AND'
    $where .= " WHERE usuarios.rol=roles.id"; 
}else{
    $where .= " AND usuarios.rol=roles.id";
}

$sql = "SELECT " . implode(", ", $columnas) . " FROM usuarios, roles". $where;
// var_dump($sql);
// exit;

//execución da consulta
try {
    $stmt = $conexion->conexion->prepare($sql);
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
        $html .= "<td>".$row['fecha_alta']."</td>";
        $html .= "<td>".$row['activo']."</td>";
        $html .= "<td>".$row['rol']."</td>";
        $html .= "<td><a href=''>Editar</a></td>";
        $html .= "<td><a href=''>Eliminar<a></a></td>";
        $html .= "</tr>";
    }
}else {
    $html .= "<tr>"; 
    $html .= "<td colspan='7'>Sin resultados</td>"; 
    $html .= "</tr>"; 
}

echo json_encode($html, JSON_UNESCAPED_UNICODE);
