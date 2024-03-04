<?php
namespace Clases;
use \PDO;

class Conexion {
    private $host = "localhost";
    private $db = "academia2";
    private $user = "administrador";
    private $pass= "admin";
    private $opciones = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    protected $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO("mysql:host=".$this->host.";dbname=".$this->db.";charset=utf8mb4", $this->user, $this->pass, $this->opciones);
            // echo "Conectado con éxito";
        } catch (\PDOException $ex) {
            die( "Error: " . $ex->getMessage() );
        }
    }

    public function cerrarConexion() {
        $this->conexion = null;
    }
}
?>


