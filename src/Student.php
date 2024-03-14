<?php
namespace Clases;
use \JsonSerializable;

class Student extends User implements JsonSerializable {

    private $curso;
    private $asignaturas;    

    public function __construct($usuario, $password, $nombre, $apellido1, $apellido2, $email, $telefono, $fecha_alta, $activo, $rol, $curso, $asignaturas) {
        
        parent::__construct($usuario, $password, $nombre, $apellido1, $apellido2, $email, $telefono, $fecha_alta, $activo, $rol);
        $this->curso = $curso;
        $this->asignaturas = $asignaturas;
    }

    public function jsonSerialize() {
        return [
            'usuario' => $this->usuario,
            'nombre' => $this->nombre,
            'apellido1' => $this->apellido1,
            'apellido2' => $this->apellido2,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'fecha_alta' => $this->fecha_alta,
            'activo' => $this->activo,
            'rol' => $this->rol,
            'curso' => $this->curso,
            'asignaturas' => $this->asignaturas
        ];
    }

    /**
     * Get the value of asignaturas
     */
    public function getAsignaturas()
    {
        return $this->asignaturas;
    }

    /**
     * Set the value of asignaturas
     */
    public function setAsignaturas($asignaturas)
    {
        $this->asignaturas = $asignaturas;
    }
     /**
     * Get the value of asignaturas
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Set the value of asignaturas
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;
    }
}