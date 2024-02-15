<?php

class Alumno extends Usuario {

    private $curso;
    private $asignaturas;

    public function __construct($nombre, $passwordHash, $email, $rol = 'alumno') {

        parent::__construct($nombre, $apellidos, $passwordHash, $email, $rol);

    }

    // Métodos getters y setters
  
    public function getCurso() {
        return $this->curso;
    }

    public function setCurso($curso) {
        $this->curso = $curso;
    }
   
    public function getAsignaturas() {
        return $this->asignaturas;
    }
   
    public function setAsignaturas($asignaturas) {
        $this->asignaturas = $asignaturas;
    }
}