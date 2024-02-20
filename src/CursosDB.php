<?php
namespace Clases;
use \PDO;

class CursosDB extends Conexion {
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * Consulta os cursos dispoñibles
     * @return array array cos cursos, as keys son os id dos cursos e os valores o seu nome
     */
    public function getCursos() {
        $cursos = [];
        $sql = "SELECT * FROM cursos";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            if ( $stmt->rowCount() != 0 ) {
                while ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) {
                    $cursos[$row->id] = $row->nombre;
                    // array_push($cursos,$row->nombre);                
                }        
                $stmt = null;
                return $cursos;
            }
        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        $stmt = null;
        return $cursos;
    }

     /**
     * Consulta os cursos dispoñibles e as asignaturas de cada curso
     * @return array array multidimensional de cursos e asignaturas
     */
    public function getCursosAsignaturas() {
        $cursos = [];        
        $sql = "SELECT cursos.id 
        as idCurso,cursos.nombre 
        as nomeCurso,asignaturas.id 
        as idAsignatura ,asignaturas.nombre 
        as nomeAsignatura 
        FROM cursos, asignaturas 
        WHERE cursos.id=asignaturas.curso";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            if ( $stmt->rowCount() != 0 ) {
                while ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) {

                    $cursos[$row->idCurso][$row->nomeCurso][$row->idAsignatura] = $row->nomeAsignatura;               
                }        
                $stmt = null;
                return $cursos;
            }
        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        $stmt = null;
        return $cursos;
    }

   /**
     * Consulta as asignaturas dispoñibles para un curso
     * @return array array coas asignaturas as keys son o id da asignatura e o valor o nome da asignatura
     */
    public function getAsignaturas($idCurso) {
        $sql = "SELECT id,nombre FROM asignaturas WHERE curso=:id";
        $asignaturas = [];
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':id' => $idCurso
                ]);

            if ( $stmt->rowCount() != 0 ) {
                while ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) {
                    $asignaturas[$row->id] = $row->nombre;              
                }        
                $stmt = null;
                return $asignaturas;
            }
        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        $stmt = null;
        return $asignaturas;
    }

}