<?php
namespace Clases;
use \JsonSerializable;

class Student extends User implements JsonSerializable {

    private $curso;
    private $asignaturas;

    public function __construct($usuario, $password, $nombre, $apellido1, $apellido2, $email, $telefono, $fecha_alta, $activo, $rol, $curso=null, $asignaturas=null) {
        
        parent::__construct($usuario, $password, $nombre, $apellido1, $apellido2, $email, $telefono, $fecha_alta, $activo, $rol);
        $this->curso = $curso;
        $this->asignaturas = $asignaturas;
    }

    // public function __construct($usuario, $curso=null, $asignaturas=null) {
        
    //     parent::__construct($usuario->usuario, $usuario->password, $usuario->nombre, $usuario->apellido1, $usuario->apellido2, $usuario->email, $usuario->telefono, $usuario->fecha_alta, $usuario->activo, $usuario->rol);
    //     $this->curso = $curso;
    //     $this->asignaturas = $asignaturas;
    // }


    // /**
    //  * Validación de datos de estudiante
    //  * @return array Array cos erros de validación
    //  */
    // public function validaStudent() {
       
    //     $error = parent::validaUsuario();
        
    //     return $error;
    // }

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


    /**
     * Get the value of curso
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Set the value of curso
     */
    public function setCurso($curso)
    {
        $this->curso = $curso;
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
}