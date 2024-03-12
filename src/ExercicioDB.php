<?php
namespace Clases;
use Clases\ExercicioDB;
use \PDO;

class ExercicioDB extends Conexion {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Garda un exercicio
     * @param Exercicio Exercicio que vai gardar
     * @return boolean True si se garda correctamente, False si non
     */
    public function insertExercicio($exercicio) {
        $sql = "INSERT INTO exercicios VALUES (:id,:tema,:enunciado,:asignatura,:activo,:creador,:fecha)";
        try {
            $stmt = $this->conexion->prepare($sql);
            $isOk = $stmt->execute([
                ':id' => null,
                ':tema' => $exercicio->getTema(),
                ':enunciado' => addslashes($exercicio->getEnunciado()),//escápase o enunciado con "addslashes" para que funcione ben o plugin de fórmulas
                ':asignatura' => $exercicio->getAsignatura(),
                ':activo' => $exercicio->getActivo(),
                ':creador' => $exercicio->getCreador(),
                ':fecha' => date( 'Y-m-d',strtotime($exercicio->getFechaCreacion()) )//formateo da fecha en formato compatible con MySQL
                ]);
            $stmt = null;
            if( $isOk ) return true;
        } catch (\PDOException $ex) {
            die("Error insertando exercicio na base de datos: ".$ex->getMessage());
        }
        return false;
    }

    /**
    * Elimina un exercicio
    * @param string Id da asignatura a elminar
    * @return boolean true si borra con éxito ou false si non
    */
    public function deleteExercicio($id) {
        $sql = "DELETE FROM exercicios WHERE id=:id";
        try {
            $stmt = $this->conexion->prepare($sql);
            $isOk = $stmt->execute([                
                    ":id" => $id              
                    ]);
            $stmt = null;
            if( $isOk ) return true;

        } catch (\PDOException $ex) {
            die("Error borrando o exercicio: ".$ex->getMessage());
        }
        return false;
    }

    /**
    * Elimina un exercicio
    * @param string Id do exercico a actualizar
    * @param string datos novos do exercicio
    * @return boolean true si actualiza con éxito ou false si non
    */
    public function updateExercicio($exercicio) {

        $sql = "UPDATE exercicios SET 	
        tema=:tema,	
        enunciado=:enunciado,	
        asignatura=:asignatura,	
        activo=:activo,	
        creador=:creador,	
        fecha_creacion=:fecha
        WHERE id=:id";

        try {
            $stmt = $this->conexion->prepare($sql);
            $isOk = $stmt->execute([                
                    ":tema" => $exercicio->getTema(),              
                    ":enunciado" => addslashes($exercicio->getEnunciado()), //escápase o enunciado con "addslashes" para que funcione ben o plugin de fórmulas          
                    ":asignatura" => $exercicio->getAsignatura(),              
                    ":activo" => $exercicio->getActivo(),              
                    ":creador" => $exercicio->getCreador(),              
                    ":fecha" => date( 'Y-m-d',strtotime($exercicio->getFechaCreacion()) ),//formateo da fecha en formato compatible con MySQL              
                    ":id" => $exercicio->getId()              
                    ]);
            $stmt = null;
            if( $isOk ) return true;

        } catch (\PDOException $ex) {
            die("Error actualizando o exercicio: ".$ex->getMessage());
        }
        return false;
    }

    /**
    * obtén todos os exercicios filtrados por unha query SQL
    * @param string $sql query
    * @return stament stament cos resultados da consulta 
    */
    public function getExerciciosFiltered($sql) {

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
        } catch (\PDOException $ex) {
            die("Error consultando os exercicios: ".$ex->getMessage());
        }
        return $stmt;
    }

    /**
    * recupera un exercicio polo seu id
    * @param string id do exercicio 
    * @return object|boolean objeto cos resultados da consulta ou false si non existe
    */
    public function getExercicioById($id) {

        $sql = "SELECT * FROM exercicios WHERE id=:id";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ":id" => $id
            ]);
            if ( $stmt->rowCount() != 0 ) {
                $row = $stmt->fetch(PDO::FETCH_OBJ);
                $exercicio = new Exercicio($row->id,$row->tema,$row->enunciado,$row->asignatura,$row->activo,$row->creador,$row->fecha_creacion);                  
                $stmt = null;
                return $exercicio;
            }
        } catch (\PDOException $ex) {
            die("Error consultando os exercicios: ".$ex->getMessage());
        }
        $stmt = null;
        return false;
    }

    /**
    * recupera uns exercicios polo id do creador
    * @param string id do autor dos exercicios
    * @return array array cos resultados da consulta ou false si non existe
    */
    public function getExercicioByAutorId($id) {

        $sql = "SELECT * FROM exercicios WHERE creador=:id";
        $exercicio = [];
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ":id" => $id
            ]);
            if ( $stmt->rowCount() != 0 ) {
                while ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) {
                    array_push($exercicio,$row);                
                }        
                $stmt = null;
            }
        } catch (\PDOException $ex) {
            die("Error consultando os exercicios: ".$ex->getMessage());
        }
        $stmt = null;
        return $exercicio;
    }

    /**
    * Consulta os exercicios de unha asignatura
    * @param string asignatura
    * @return stament PDOStatement cos resultados da consulta
    */
    public function getExercicioByAsignatura($asignatura) {
        $resultado = [];
        $sql = "SELECT * FROM exercicios WHERE asignatura=:a";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ":a" => $asignatura
            ]);
            if ( $stmt->rowCount() != 0 ) {
                while ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) {
                    array_push($resultado,$row);                
                }        
                $stmt = null;
                return $resultado;
            }
        } catch (\PDOException $ex) {
            die("Error consultando os exercicios: ".$ex->getMessage());
        }
        return $resultado;
    }
}