<?php
namespace Clases;

class User {

    private $usuario;
    private $passw;
    private $nombre;
    private $apelido1;
    private $apelido2;
    private $email;
    private $tlf;
    private $fechaAlta;
    private $activo;
    private $rol;

    public function __construct($usuario, $passw, $nombre, $apelido1, $apelido2, $email, $tlf, $fechaAlta, $activo, $rol) {
        
        $this->usuario = $usuario;
        $this->passw = $passw;
        $this->nombre = $nombre;
        $this->apelido1 = $apelido1;
        $this->apelido2 = $apelido2;
        $this->email = $email;
        $this->tlf = $tlf;
        $this->fechaAlta = $fechaAlta;
        $this->activo = $activo;
        $this->rol = $rol;
    }

    /**
     * Validación de datos de usuario
     * @return boolean True si valida ou false si non valida
     */
    public function validaUsuario() {
        if ( preg_match("/[a-zA-ZçÇñÑáéíóúÁÉÍÓÚ0-9_-]{3,16}$/", $this->usuario) 
             && preg_match("/^[^\s]{4,}$/", $this->passw)
             && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ][a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/", $this->nombre)
             && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ][a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/", $this->apelido1)
             && preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ][a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/", $this->apelido2)
             && (preg_match("/^[0-9a-zA-Z_\-\.]{2,}@[a-zA-Z_\-]+\.[a-zA-Z]{2,5}$/", $this->email) || $this->email == null)
             && (preg_match("/^[0-9]{9}$/", $this->tlf) || $this->tlf === null)
             && preg_match("/^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/", $this->fechaAlta)
             && is_bool($this->activo)
             && preg_match("/^[1-3]$/", $this->rol)) 
             { 
                return true;
            }
        return false;
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

   
    public function getPassw()
    {
        return $this->passw;
    }


    public function setPassw($passw)
    {
        $this->passw = $passw;
    }

  
    public function getNombre()
    {
        return $this->nombre;
    }

 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

  
    public function getApelido1()
    {
        return $this->apelido1;
    }

  
    public function setApelido1($apelido1)
    {
        $this->apelido1 = $apelido1;
    }

  
    public function getApelido2()
    {
        return $this->apelido2;
    }


    public function setApelido2($apelido2)
    {
        $this->apelido2 = $apelido2;
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
        return $this->tlf;
    }


    public function setTlf($tlf)
    {
        $this->tlf = $tlf;
    }


    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }


    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;
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