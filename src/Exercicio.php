<?php
namespace Clases;
use \JsonSerializable;


class Exercicio implements JsonSerializable {

    private $id;						
    private $tema;	
    private $enunciado;
    private $asignatura;
    private $activo;	
    private $creador;	
    private $fecha_creacion;	

    public function __construct($id, $tema, $enunciado, $asignatura, $activo, $creador, $fecha_creacion) {
        $this->id = $id;
        $this->tema = $tema;
        $this->enunciado = $enunciado;
        $this->asignatura = $asignatura;
        $this->activo = $activo;
        $this->creador = $creador;
        $this->fecha_creacion = $fecha_creacion;
    }


    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'tema' => $this->tema,
            'enunciado' => $this->enunciado,
            'asignatura' => $this->asignatura,
            'activo' => $this->activo,
            'creador' => $this->creador,
            'fecha_creacion' => $this->fecha_creacion

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
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of tema
     */
    public function getTema()
    {
        return $this->tema;
    }

    /**
     * Set the value of tema
     */
    public function setTema($tema)
    {
        $this->tema = $tema;
    }

    /**
     * Get the value of enunciado
     */
    public function getEnunciado()
    {
        return $this->enunciado;
    }

    /**
     * Set the value of enunciado
     */
    public function setEnunciado($enunciado)
    {
        $this->enunciado = $enunciado;
    }

    /**
     * Get the value of asignatura
     */
    public function getAsignatura()
    {
        return $this->asignatura;
    }

    /**
     * Set the value of asignatura
     */
    public function setAsignatura($asignatura)
    {
        $this->asignatura = $asignatura;
    }

    /**
     * Get the value of activo
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set the value of activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * Get the value of creador
     */
    public function getCreador()
    {
        return $this->creador;
    }

    /**
     * Set the value of creador
     */
    public function setCreador($creador)
    {
        $this->creador = $creador;
    }

    /**
     * Get the value of fecha_creacion
     */
    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }

    /**
     * Set the value of fecha_creacion
     */
    public function setFechaCreacion($fecha_creacion)
    {
        $this->fecha_creacion = $fecha_creacion;
    }
}