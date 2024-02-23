<?php
namespace Clases;
use \PDO;

class ExercicioDB extends Conexion {
    
    public function __construct() {
        parent::__construct();
    }

    /**
    * Consulta todos os exercicios
    * @return array Array de exercicios cos resultados da consulta
    */
    // public function getExercicios() {
    //     $resultado = [];
    //     $sql = "SELECT * FROM exercicios";
    //     try {
    //         $stmt = $this->conexion->prepare($sql);
    //         $stmt->execute();
    //         if ( $stmt->rowCount() != 0 ) {
    //             while ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) {
    //                 $exercicio = new Exercicio(
    //                     $row->id,
    //                     $row->tema,
    //                     $row->enunciado,
    //                     $row->asignatura,
    //                     $row->activo,
    //                     $row->creador,
    //                     $row->fecha_creacion
    //                 );
    //                 array_push($resultado,$exercicio);
    //                 $exercicio = null;                
    //             }        
    //             $stmt = null;
    //             return $resultado;
    //         }
    //     } catch (\PDOException $ex) {
    //         die("Error consultando os exercicios: ".$ex->getMessage());
    //     }
    //     return $resultado;
    // }

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
    * Consulta os exercicios de unha asignatura
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

    /**
    * Elimina un exercicio
    * @param string Id da asignatura a elminar
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

  

    

}