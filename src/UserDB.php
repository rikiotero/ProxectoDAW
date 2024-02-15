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
                    ':pass' => password_hash( $user->getPassw(), PASSWORD_DEFAULT, [15] ), //gárdase un hash do password
                    ':nombre' => $user->getNombre(),
                    ':apellido1' => $user->getApelido1(),
                    ':apellido2' => $user->getApelido2(),
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
     * @return stmt PDOStatement cos resultados da consulta 
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
     * @return statement PDOStatement cos resultados da consulta 
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
     * Actualiza os datos de un usuario
     * @param string $userName Nome do usuario que se vai actualizar
     * @param object $user datos novos que se van gardar
     * @return boolean True si actualiza os datos con éxito ou False si non
     */
    public function updateUser($userName,$user) {
        
        $sql="UPDATE usuarios SET usuario=:usuario, nombre=:nome, apellido1=:apellido1, apellido2=:apellido2 ,email=:email,telefono=:telefono WHERE usuario=:u";
        
        try {
            $stmt = $this->conexion->prepare($sql);
            $isOk = $stmt->execute([                
                ':usuario' => $user->getUsuario(),
                ':nome' => $user->getNombre(),
                ':apellido1' => $user->getApelido1(),
                ':apellido2' => $user->getApelido2(),
                ':email' => $user->getEmail(),
                ':telefono' => $user->getTlf(),
                ':u' => $userName               
            ]);
        $stmt = null;
        if( $isOk ) return true;
            
        } catch (\PDOException $ex) {
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
     * @param string $user Usuarioo que se lle cambia o password
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