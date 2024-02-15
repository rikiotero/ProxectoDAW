<?php

class Usuario
{
    private $nombre;
    private $apellidos;
    private $passwordHash;
    private $email;
    private $rol;

    public function __construct($nombre, $passwordHash, $email, $rol)
    {
        $this->nombre = $nombre;
        $this->passwordHash = $passwordHash;
        $this->email = $email;
    }

    // Métodos getters y setters

    public function getnombre()
    {
        return $this->nombre;
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function getapellidos()
    {
        return $this->apellidos;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = $passwordHash;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }
}
