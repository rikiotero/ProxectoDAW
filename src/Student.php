<?php
namespace Clases;
use \JsonSerializable;

class Student extends User implements JsonSerializable {

    private $asignaturas;

    public function __construct($usuario, $password, $nombre, $apellido1, $apellido2, $email, $telefono, $fecha_alta, $activo, $rol, $curso=null, $asignaturas=null) {
        
        parent::__construct($usuario, $password, $nombre, $apellido1, $apellido2, $email, $telefono, $fecha_alta, $activo, $rol,$curso);
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

            // 'usuario' => $this->getUsuario(),
            // 'nombre' => $this->getNombre(),
            // 'apellido1' => $this->getApellido1(),
            // 'apellido2' => $this->getApellido2(),
            // 'email' => $this->getEmail(),
            // 'telefono' => $this->getTlf(),
            // 'fecha_alta' => $this->getFechaAlta(),
            // 'activo' => $this->getActivo(),
            // 'rol' => $this->getRol(),
            // 'curso' => $this->curso,
            // 'asignaturas' => $this->asignaturas
        ];
    }


    // /**
    //  * Get the value of curso
    //  */
    // public function getCurso()
    // {
    //     return $this->curso;
    // }

    // /**
    //  * Set the value of curso
    //  */
    // public function setCurso($curso)
    // {
    //     $this->curso = $curso;
    // }

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
}