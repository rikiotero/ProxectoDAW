<?php
namespace Clases;

class User {

    protected $usuario;
    protected $password;
    protected $nombre;
    protected $apellido1;
    protected $apellido2;
    protected $email;
    protected $telefono;
    protected $fecha_alta;
    protected $activo;
    protected $rol;


    public function __construct($usuario, $password, $nombre, $apellido1, $apellido2, $email, $telefono, $fecha_alta, $activo, $rol) {
        
        $this->usuario = $usuario;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->apellido2 = $apellido2;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->fecha_alta = $fecha_alta;
        $this->activo = $activo;
        $this->rol = $rol;
    }

    /**
     * Validación de datos de usuario
     * @return boolean True si valida ou false si non valida
     */
    public function validaUsuario2() {
        if ( preg_match("/[a-zA-ZçÇñÑáéíóúÁÉÍÓÚ0-9_-]{3,16}$/", $this->usuario) 
             && preg_match("/^[^\s]+.{2,}[^\s]$/", $this->password)
             && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ][a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/", $this->nombre)
             && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ][a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/", $this->apellido1)
             && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ][a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/", $this->apellido2)
             && (preg_match("/^[0-9a-zA-Z_\-\.]{2,}@[a-zA-Z_\-]+\.[a-zA-Z]{2,5}$/", $this->email) || $this->email == null)
             && (preg_match("/^[0-9]{9}$/", $this->tlf) || $this->tlf === null)
             && preg_match("/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/", $this->fecha_alta)
             && is_bool($this->activo)
             && preg_match("/^[1-3]$/", $this->rol)) 
             { 
                return true;
            }
        return false;
    }


    /**
     * Validación de datos de usuario
     * @return array Array cos erros de validación
     */
    public function validaUsuario() {
        $error = [];
        if ( !preg_match("/[a-zA-ZçÇñÑáéíóúÁÉÍÓÚ0-9_-]{3,16}$/", $this->usuario) ) $error [] = "O nome de usuario debe ter entre 3 e 16 caracteres";
        if ( !preg_match("/^[^\s]+.{2,}[^\s]$/", $this->password) ) $error [] = "O password debe ter mínimo 4 caracteres e sin espacios";
        if ( !preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ][a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/", $this->nombre) ) $error [] = "O nombre só pode ter letras";
        if ( !preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ][a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/", $this->apellido1) ) $error [] = "O primeiro apelido só pode ter letras";
        if ( !preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ][a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/", $this->apellido2) ) $error [] = "O segundo apelido só pode ter letras";
        if ( !preg_match("/^[0-9a-zA-Z_\-\.]{2,}@[a-zA-Z_\-]+\.[a-zA-Z]{2,5}$/", $this->email) && $this->email != null) $error [] = "O email é incorrecto";
        if ( !preg_match("/^[0-9]{9}$/", $this->telefono) && $this->telefono != null) $error [] = "O teléfono só poder 9 números";
        if ( !preg_match("/^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/", $this->fecha_alta) ) $error [] = "A fecha é incorrecta";
        if ( !is_bool($this->activo) ) $error [] = "O valor de usuario activo é incorrecto";
        if ( !preg_match("/^[1-3]$/", $this->rol) ) $error [] = "O rol é incorrecto";
        
        return $error;
    }


   //Getters e Setters

    public function getUsuario()
    {
        return $this->usuario;
    }

    
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

   
    public function getPassword()
    {
        return $this->password;
    }


    public function setPassword($password)
    {
        $this->password = $password;
    }

  
    public function getNombre()
    {
        return $this->nombre;
    }

 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

  
    public function getApellido1()
    {
        return $this->apellido1;
    }

  
    public function setApellido1($apellido1)
    {
        $this->apellido1 = $apellido1;
    }

  
    public function getApellido2()
    {
        return $this->apellido2;
    }


    public function setApellido2($apellido2)
    {
        $this->apellido2 = $apellido2;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getTlf()
    {
        return $this->telefono;
    }


    public function setTlf($telefono)
    {
        $this->telefono = $telefono;
    }


    public function getFechaAlta()
    {
        return $this->fecha_alta;
    }


    public function setFechaAlta($fecha_alta)
    {
        $this->fecha_alta = $fecha_alta;
    }


    public function getActivo()
    {
        return $this->activo;
    }


    public function setActivo($activo)
    {
        $this->activo = $activo;
    }


    public function getRol()
    {
        return $this->rol;
    }


    public function setRol($rol)
    {
        $this->rol = $rol;
    }
}