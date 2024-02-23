<?php
namespace Clases;
use \PDO;

class UserDB extends Conexion {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Inserta un usuario na base de datos
     * @param object usuario
     * @return boolean True si inserta os datos con éxito ou False si non
     */
    public function insertUser($user) {

        $sql = "INSERT INTO usuarios VALUES (:id,:usuario,:pass,:nombre,:apellido1,:apellido2,:email,:telefono,:fecha_alta,:activo,:rol)";
        try {
            $stmt = $this->conexion->prepare($sql);
            $isOk = $stmt->execute([
                    ':id' => null,
                    ':usuario' => $user->getUsuario(),
                    ':pass' => password_hash( $user->getPassword(), PASSWORD_DEFAULT, [15] ), //gárdase un hash do password
                    ':nombre' => $user->getNombre(),
                    ':apellido1' => $user->getApellido1(),
                    ':apellido2' => $user->getApellido2(),
                    ':email' => $user->getEmail(),
                    ':telefono' => $user->getTlf(),
                    ':fecha_alta' => date('Y-m-d',strtotime($user->getFechaAlta())),//formateo da fecha en formato compatible con MySQL
                    ':activo' => $user->getActivo(),
                    ':rol' => $user->getRol()
                ]);
            $stmt = null;
            if( $isOk ) return true;
        } catch (\PDOException $ex) {

            die("Error insertando usuario na base de datos: ".$ex->getMessage());
        }
        return false;
    }

    /**
     * Inserta un estudiante na base de datos
     * @param object estudiante
     * @return boolean True si inserta os datos con éxito ou False si non
     */
    public function insertStudent($student) {
        
        $sql = "INSERT INTO usuarios VALUES (:id,:usuario,:pass,:nombre,:apellido1,:apellido2,:email,:telefono,:fecha_alta,:activo,:rol)";
        try {
            if ( !$this->conexion->inTransaction() ) $this->conexion->beginTransaction();
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':id' => null,
                ':usuario' => $student->getUsuario(),
                ':pass' => password_hash( $student->getPassword(), PASSWORD_DEFAULT, [15] ), //gárdase un hash do password
                ':nombre' => $student->getNombre(),
                ':apellido1' => $student->getApellido1(),
                ':apellido2' => $student->getApellido2(),
                ':email' => $student->getEmail(),
                ':telefono' => $student->getTlf(),
                ':fecha_alta' => date('Y-m-d',strtotime($student->getFechaAlta())),//formateo da fecha en formato compatible con MySQL
                ':activo' => $student->getActivo(),
                ':rol' => $student->getRol()
                ]);
            
            $id = $this->conexion->lastInsertId();
            $curso = $student->getCurso();
            if( $curso != "0" ) {                
                $sql = "INSERT INTO alumno_curso VALUES (:idUsr, :idCurso)";
                $stmt = $this->conexion->prepare($sql);
                $stmt->execute([
                    ':idUsr' => $id,
                    ':idCurso' => $curso       
                    ]);
            }

            $asignaturas = $student->getAsignaturas();
            if( !empty($asignaturas) && $asignaturas[0] != "0" ) {
                $sql = "INSERT INTO usuario_asignatura VALUES (:idUsr, :idAsign)";
                foreach ($asignaturas as $key => $value) {
                    $stmt = $this->conexion->prepare($sql);
                    $stmt->execute([
                        ':idUsr' => $id,
                        ':idAsign' => $value       
                        ]);
                }
            }

            $stmt = null;
            $this->conexion->commit();
            return true;
            
        } catch (\PDOException $ex) {
            $this->conexion->rollback();
            die("Error insertando usuario na base de datos: ".$ex->getMessage());
        }        
        return false;
    }
    

    /**
     * Consulta os datos de un usuario
     * @return object obxeto co resultado da consulta 
     */
    public function getUser($user) {
        $sql = "SELECT * FROM usuarios WHERE usuario=:u";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':u' => $user
            ]);
            
        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        if ( $stmt->rowCount() != 0 ) {        
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row;
        } 
        $stmt = null;                
        return  false;
    }

    /**
     * Consulta os datos de un usuario
     * @return object obxeto co resultado da consulta 
     */
    public function getUserById($id) {
        $sql = "SELECT * FROM usuarios WHERE id=:i";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':i' => $id
            ]);
            
        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        if ( $stmt->rowCount() != 0 ) {        
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row;
        } 
        $stmt = null;                
        return  false;
    }

    /**
     * obtén todos os usuarios rexistrados e o seu rol
     * @return PDOStatement PDOStatement cos resultados da consulta 
     */
    public function getUsers() {
        $sql ="SELECT usuarios.id, usuario, nombre, apellido1, apellido2, email, telefono, fecha_alta, activo, roles.rol 
                FROM usuarios, roles 
                WHERE usuarios.rol=roles.id
                ORDER BY usuarios.id ";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        return $stmt;
    }

    /**
     * obtén todos os usuarios filtrados por unha query SQL
     * @param string $sql query
     * @return object stament cos resultados da consulta 
     */
    public function getUsersFiltered($sql) {

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        return $stmt;
    }

      /**
     * Obtén o hash do contrasinal dun usuario
     * @param string nome do usuario
     * @return string O hash do password
     */
    public function getPassword($usuario) {
        $sql = "SELECT password FROM usuarios WHERE usuario=:u";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':u' => $usuario
            ]);
            
        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }

        if ( $stmt->rowCount() != 0 ) {        
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            return $row->password;
        } 
        $stmt = null;                
        return  false;
    }



    /**
     * Obtén o curso asignado a un usuario
     * @param string Id do usuario
     * @return string O curso si é que ten algún asignado, false si non
     */
    public function getCurso($id) {
        $sql = "SELECT cursos.id,cursos.curso from cursos, alumno_curso where cursos.id=alumno_curso.curso_id and alumno_curso.usuario_id=:id";
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                    ':id' => $id
                    ]);
            
            if ( $stmt->rowCount() != 0 ) {        
                $row = $stmt->fetch(PDO::FETCH_OBJ);
                $stmt = null;
                $curso [$row->id] = $row->curso;
                return $curso;
            }

        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        $stmt = null;
        return false;
    }
    
    /**
     * Obtén as asignaturas asignadas a un usuario
     * @param string Id do usuario
     * @return array array coas asignaturas asignadas o usuario
     */
    public function getAsignaturas($id) {
        $sql = "SELECT asignaturas.nombre FROM asignaturas, usuario_asignatura WHERE asignaturas.id=usuario_asignatura.asignatura_id AND usuario_asignatura.usuario_id=:id";
        $resultado = [];
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                    ':id' => $id
                    ]);
            
            if ( $stmt->rowCount() != 0 ) {
                while ( $row = $stmt->fetch(PDO::FETCH_OBJ) ) {
                    array_push($resultado,$row->nombre);                
                }        
                $stmt = null;
                return $resultado;
            }

        } catch (\PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        $stmt = null;
        return $resultado;
    }

    /**
     * Actualiza os datos de un usuario
     * @param string $userName Nome do usuario que se vai actualizar
     * @param object $user datos novos que se van gardar
     * @return boolean True si actualiza os datos con éxito ou False si non
     */
    public function updateUser($userName,$user) {        
        
        if ( !$this->conexion->inTransaction() ) $this->conexion->beginTransaction();
            $sql = "DELETE FROM alumno_curso WHERE usuario_id=:id";
        try {
            //inténtase borrar datos de curso e asignaturas por si antes o usuario era estudiante e tiña algo asignado
            //sería o caso no que se fixera un cambio de rol de estudiante a outro rol
            $userId = self::getUserId( $user->getUsuario() );
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([                
                ':id' => $userId
            ]);
            $sql = "DELETE FROM usuario_asignatura WHERE usuario_id=:id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([                
                ':id' => $userId
            ]);

            $sql="UPDATE usuarios SET usuario=:usuario, nombre=:nome, apellido1=:apellido1, apellido2=:apellido2 ,email=:email,telefono=:telefono, activo=:activo, rol=:rol WHERE usuario=:u";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([                
                ':usuario' => $user->getUsuario(),
                ':nome' => $user->getNombre(),
                ':apellido1' => $user->getApellido1(),
                ':apellido2' => $user->getApellido2(),
                ':email' => $user->getEmail(),
                ':telefono' => $user->getTlf(),
                ':activo' => $user->getActivo(),
                ':rol' => $user->getRol(),
                ':u' => $userName               
                ]);
            $stmt = null;
            $this->conexion->commit();
            return true;
            
        } catch (\PDOException $ex) {
            $this->conexion->rollback();
            die("Error actualizando a base de datos: ".$ex->getMessage());
        }
        return false;
    }


    /**
     * Actualiza os datos de un usuario
     * @param string $userName Nome do usuario que se vai actualizar
     * @param object $user datos novos que se van gardar
     * @return boolean True si actualiza os datos con éxito ou False si non
     */
    public function updateStudent($userName,$student) {
        
        try {
            if ( !$this->conexion->inTransaction() ) $this->conexion->beginTransaction();
            //primeiro borro o usuario por si tiña outro curso ou asignaturas asignadas
            $sql = "DELETE FROM usuarios WHERE usuario=:u";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([                
                ':u' => $userName
            ]);

            $stmt = null;
            if ( self::insertStudent($student) ) return true;                                
          
        } catch (\PDOException $ex) {
            if ( !$this->conexion->inTransaction() ) $this->conexion->rollback();
            die("Error actualizando a base de datos: ".$ex->getMessage());
        }
        return false;
}
    /**
     * Borra un usuario
     * @param string Id do usuario a borrar
     * @return boolean True si borra os datos con éxito ou False si non
     */
    public function deleteUser($id) {
        $sql = "DELETE FROM usuarios WHERE id=:i ";

        try {
            $stmt = $this->conexion->prepare($sql);
            $isOk = $stmt->execute([                
                ':i' => $id              
            ]);
        $stmt = null;
        if( $isOk ) return true;
            
        } catch (\PDOException $ex) {
            die("Error borrando usuario: ".$ex->getMessage());
        }
        return false;
    }
    

    /**
     * Actualiza o password de un usuario
     * @param string $passw Password novo
     * @param string $user Usuario o cal se lle cambia o password
     * @return boolean True si actualiza os datos con éxito ou False si non
     */
    public function updatePassw($passw,$user) {
        $sql="UPDATE usuarios SET password=:p WHERE usuario=:u";
        $hash = password_hash($passw, PASSWORD_DEFAULT, [15]);
        try {
            $stmt = $this->conexion->prepare($sql);
            $isOk = $stmt->execute([                
                ':p' => $hash,
                ':u' => $user               
            ]);
        $stmt = null;
        if( $isOk ) return true;
            
        } catch (\PDOException $ex) {
            die("Error actualizando a base de datos: ".$ex->getMessage());
        }
        return false;
    }

    /**
     * Comproba as credenciais de un usario
     * @param string credeciales de usuario
     * @param string credeciales de usuario
     * @return boolean true si son credenciale válida false en caso contrario
     */
    public function validateUserCredentials($user,$pass) {
        
        $sql = "SELECT usuario, password FROM usuarios WHERE usuario=:u";
                
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':u' => $user
            ]);
        } catch (PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }

        if ( $stmt->rowCount() != 0 ) {        
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            if( password_verify($pass, $row->password) ) {
                $stmt = null;
                return  true;
            }
        } 
        $stmt = null;                
        return  false;                        
    }
    
    /**
     * Devolve o Id de un usuario
     * @param string usuario
     * @return string Id do usuario
     */
    public function getUserId($user) {
        $sql = "SELECT id FROM usuarios WHERE usuario=:u";
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':u' => $user
            ]);
        } catch (PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        if ( $stmt->rowCount() != 0 ) {        
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            $stmt = null;
            return  $row->id;               
        } 
        $stmt = null;                
        return  false;
    }


    /**
     * Devolve o rol de un usuario
     * @param string usuario
     * @return string rol do usuario
     */
    public function getRole($user) {

        $sql = "SELECT roles.rol FROM roles,usuarios WHERE roles.id=usuarios.rol AND usuario = :u";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':u' => $user
            ]);
        } catch (PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
        
        if ( $stmt->rowCount() != 0 ) {        
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            $stmt = null;
            return  $row->rol;               
        } 
        $stmt = null;                
        return  false;
    }

    /**
     * Comproba si un usuario está activo
     * @param string usuario
     * @return bool usuario activado ou non
     */
    public function isActive($user) {

        $sql = "SELECT activo FROM usuarios WHERE usuario = :u";

        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':u' => $user
            ]);
        } catch (PDOException $ex) {
            die("Error consultando a base de datos: ".$ex->getMessage());
        }
          
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        $stmt = null;
        if ( $row->activo == 1 ) return true;                        
        return  false;
    }
}