<?php

class Profesor extends Usuario {

    private $cursos;
    private $asignaturas;

    public function __construct($nombre, $passwordHash, $email, $rol = 'profesor') {

        parent::__construct($nombre, $apellidos, $passwordHash, $email, $rol);

    }

    // Métodos getters y setters
    
    public function getCursos() {
        return $this->cursos;
    }

    public function setCursos($cursos) {
        $this->curso = $cursos;
    }

    public function getAsignaturas() {
        return $this->asignaturas;
    }

    public function setAsignaturas($asignaturas) {
        $this->asignaturas = $asignaturas;
    }
}