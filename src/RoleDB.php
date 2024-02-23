<?php
namespace Clases;

class RoleDB extends Conexion {
   
    public function __construct() {
        parent::__construct();
    }

    /**
     * Consulta os roles dispoñibles
     * @return stmt PDOStatement cos resultados da consulta
     */
    public function getRoles() {
        $sql = "SELECT * FROM roles";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        return $stmt;
    }

}