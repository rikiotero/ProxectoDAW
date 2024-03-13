<?php
namespace Clases;
use \JsonSerializable;
use Clases\CursosDB;
use Clases\UserDB;

class Exercicio implements JsonSerializable {

    private $id;						
    private $tema;	
    private $enunciado;
    private $asignatura;
    private $activo;	
    private $creador;	
    private $fecha_creacion;	

    public function __construct($id=null, $tema, $enunciado, $asignatura, $activo, $creador, $fecha_creacion) {
        $this->id = $id;
        $this->tema = $tema;
        $this->enunciado = $enunciado;
        $this->asignatura = $asignatura;
        $this->activo = $activo;
        $this->creador = $creador;
        $this->fecha_creacion = $fecha_creacion;
    }
    /**
     * Validación de datos de un exercicio
     * @return array Array cos erros de validación
     */
    public function validaExercicio($curso) {
        
        $erroresValidacion = [];
        if ( $this->tema == "" ) $erroresValidacion[] = "O tema non pode estar vacío";
        if ( $this->enunciado == "" ) $erroresValidacion[] = "O enunciado non pode estar vacío";
 
       
        //validación do curso e asignatura        
        $cursosDB = new CursosDB();
        // $cursoId = $cursosDB->getCursoByAsignatura($this->asignatura);
        $asignaturas = $cursosDB->getAsignaturas($curso);

        if ( $curso != "0" ) {
            $cursos =  $cursosDB->getCursos();
            $cursosDB->cerrarConexion();

            if ( !array_key_exists( $curso,$cursos ) ) {
                $erroresValidacion[] = "O curso insertado é incorrecto";
            }

            if ( !empty($asignaturas) ) {                
                if ( !array_key_exists( $this->asignatura,$asignaturas ) ) {
                    $erroresValidacion[] = "A materia é incorrecta";
                }
            }else {
                $erroresValidacion[] = "O curso seleccionado non ten materias";
            }
            

        }else {
            $cursosDB->cerrarConexion();
            $erroresValidacion[] = "O curso non pode estar vacío";
        }
        
        $db = new UserDB();
        if ( !$db->getUserById($this->creador) ) $erroresValidacion [] = "O usuario autor é incorrecto";
        $db->cerrarConexion();
        if ( !preg_match("/^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4}$/", $this->fecha_creacion) ) $erroresValidacion [] = "A Data é incorrecta";
        if ( !preg_match("/^[01]$/", $this->activo) ) $erroresValidacion [] = "O valor de exercicio activo é incorrecto";
        return $erroresValidacion;
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