<?php
namespace Clases;
use \PDO;

class CursosDB extends Conexion {
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * Engade un curso novo
     * @param string Curso novo
     * @return string|false Id do curso insertado ou false si non o insertou
     */
    public function addCurso($curso) {
        $sql = "INSERT INTO cursos VALUES (null,:curso)";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ":curso" => $curso
            ]);
            return $this->conexion->lastInsertId();;
        } catch (\PDOException $ex) {
            die("Error insertando curso: ".$ex->getMessage());
        }
        return false;
    }

    /**
     * Engade unha asignatura nova
     * @param string Curso novo
     * @return string|false Id do curso insertado ou false si non o insertou
     */
    public function addAsignatura($curso,$asignatura) {
        $sql = "INSERT INTO asignaturas VALUES (null,:asigantura,:curso)";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ":asigantura" => $asignatura,
                ":curso" => $curso
            ]);
            return $this->conexion->lastInsertId();
        } catch (\PDOException $ex) {
            die("Error insertando curso: ".$ex->getMessage());
        }
        return false;
    }


    /**
     * Elimina un curso
     * @param string Id do curso a elminar
     */
    public function deleteCurso($id) {
        $sql = "DELETE FROM cursos WHERE id=:id";
        try {
            $stmt = $this->conexion->prepare($sql);
            $isOk = $stmt->execute([                
                    ":id" => $id              
                    ]);
            $stmt = null;
            if( $isOk ) return true;

        } catch (\PDOException $ex) {
            die("Error borrando o curso: ".$ex->getMessage());
        }
        return false;
    }

    /**
     * Elimina unha asignatura
     * @param string Id da asignatura a elminar
     */
    public function deleteAsignatura($id) {
        $sql = "DELETE FROM asignaturas WHERE id=:id";
        try {
            $stmt = $this->conexion->prepare($sql);
            $isOk = $stmt->execute([                
                    ":id" => $id              
                    ]);
            $stmt = null;
            if( $isOk ) return true;

        } catch (\PDOException $ex) {
            die("Error borrando o curso: ".$ex->getMessage());
        }
        return false;
    }

    /**
     * Actualiza o nome dun curso
     * @param string $id Id do curso
     * @param string $nomeNovo Nome novo do curso
     */
    public function updateCurso($id,$nomeNovo) {
        $sql = "UPDATE cursos SET nombre=:nome WHERE id=:id";
        try {
            $stmt = $this->conexion->prepare($sql);
            $isOk = $stmt->execute([                
                ':nome' => $nomeNovo,
                ':id' => $id               
            ]);
            $stmt = null;
            if( $isOk ) return true;

            } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        $stmt = null;
        return false;
    }
    /**
     * Actualiza o nome duha asignatura
     * @param string $id Id da asignatura
     * @param string $nomeNovo Nome novo da asignatura
     */
    public function updateAsignatura($id,$nomeNovo) {
        $sql = "UPDATE asignaturas SET nombre=:nome WHERE id=:id";
        try {
            $stmt = $this->conexion->prepare($sql);
            $isOk = $stmt->execute([                
                ':nome' => $nomeNovo,
                ':id' => $id               
            ]);
            $stmt = null;
            if( $isOk ) return true;

            } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        $stmt = null;
        return false;
    }

    /**
     * Recupera un curso buscanbdo polo seu nome
     * @return object|boolean Un obxeto co curso si existe ou false si non hai resultados
     */
    public function getCurso($curso) {
        
        $sql = "SELECT * FROM cursos WHERE nombre=:curso";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ":curso" => $curso
            ]);
            if ( $stmt->rowCount() != 0 ) {
                $row = $stmt->fetch(PDO::FETCH_OBJ);        
                $stmt = null;
                return $row;
            }
        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        $stmt = null;
        return false;
    }


        /**
     * Recupera un curso buscanbdo polo seu nome
     * @return object|boolean Un obxeto co curso si existe ou false si non hai resultados
     */
    public function getCursoById($id) {
        
        $sql = "SELECT * FROM cursos WHERE id=:id";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ":id" => $id
            ]);
            if ( $stmt->rowCount() != 0 ) {
                $row = $stmt->fetch(PDO::FETCH_OBJ);        
                $stmt = null;
                return $row;
            }
        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        $stmt = null;
        return false;
    }


    /**
     * Consulta os cursos dispoñibles
     * @return array array cos cursos, as keys son os id dos cursos e os valores o seu nome
     */
    public function getCursos() {
        $cursos = [];
        $sql = "SELECT * FROM cursos ORDER BY id";
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
    // public function getCursosAsignaturas() {
    //     $cursos = [];        
    //     $sql = "SELECT cursos.id 
    //     as idCurso,cursos.nombre 
    //     as nomeCurso,asignaturas.id 
    //     as idAsignatura ,asignaturas.nombre 
    //     as nomeAsignatura 
    //     FROM cursos, asignaturas 
    //     WHERE cursos.id=asignaturas.curso";

    //     try {
    //         $stmt = $this->conexion->prepare($sql);
    //         $stmt->execute();
    //         if ( $stmt->rowCount() != 0 ) {
    //             while ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) {

    //                 $cursos[$row->idCurso][$row->nomeCurso][$row->idAsignatura] = $row->nomeAsignatura;               
    //             }        
    //             $stmt = null;
    //             return $cursos;
    //         }
    //     } catch (\PDOException $ex) {
    //         die("Error consultando a base de datos: ".$ex->getMessage());
    //     }
    //     $stmt = null;
    //     return $cursos;
    // }

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