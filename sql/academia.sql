SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



-- Creamos a base de datos
CREATE DATABASE IF NOT EXISTS academia DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- Seleccionamos a base de datos "academia"
use academia;

-- Creamos un usuario
create user administrador@'localhost' identified by 'admin';

-- damoslle permisos na base de datos "academia"
grant all on academia.* to administrador@'localhost';

-- Creamos tabla de "roles"
CREATE TABLE `roles`.`usuarios` (
    `id` INT PRIMARY KEY AUTO_INCREMENT , 
    `rol` VARCHAR(30) NOT NULL) ENGINE = InnoDB;

-- Creamos tabla de "usuarios"
CREATE TABLE `academia`.`usuarios` (
    `id` INT NOT NULL AUTO_INCREMENT , 
    `usuario` VARCHAR(30) NOT NULL UNIQUE , 
    `password` VARCHAR(120) NOT NULL , 
    `nombre` VARCHAR(50) NOT NULL , 
    `apellido1` VARCHAR(50) NOT NULL , 
    `apellido2` VARCHAR(50) NOT NULL , 
    `email` VARCHAR(50) NULL , 
    `telefono` VARCHAR(20) NULL , 
    `fecha_alta` DATETIME NOT NULL , 
    `activo` BOOLEAN NOT NULL DEFAULT TRUE , 
    `rol` INT NOT NULL , 
    PRIMARY KEY (`id`)) ENGINE = InnoDB;

-- Añadimos clave foránea "usuario_rol"
ALTER TABLE `usuarios` 
ADD CONSTRAINT `usuario_rol` 
FOREIGN KEY (`rol`) REFERENCES `roles`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Insertamos roles
INSERT INTO roles (rol) VALUES ('administrador'),('profesor'),('estudiante');


-- Creamos tabla de "cursos"
CREATE TABLE `academia`.`cursos` (
    `id` INT NOT NULL AUTO_INCREMENT , 
    `nombre` VARCHAR(50) NOT NULL UNIQUE, 
    PRIMARY KEY (`id`)) ENGINE = InnoDB;

-- Creamos tabla asignaturas
CREATE TABLE `academia`.`asignaturas` 
(`id` INT NOT NULL AUTO_INCREMENT , 
`nombre` VARCHAR(50) NOT NULL , 
`curso` INT NOT NULL , 
PRIMARY KEY (`id`)) ENGINE = InnoDB;

-- Añadimos clave foránea "asignatura_curso"
ALTER TABLE `asignaturas` 
ADD CONSTRAINT `asignatura_curso` 
FOREIGN KEY (`curso`) REFERENCES `cursos`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- Creamos tabla "exercicios"
CREATE TABLE `academia`.`exercicios` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `tema` VARCHAR(100) NOT NULL ,
    `enunciado` TEXT NOT NULL , 
    `asignatura` INT NOT NULL ,
    `activo` BOOLEAN NOT NULL DEFAULT TRUE , 
    PRIMARY KEY (`id`)) ENGINE = InnoDB;

-- Añadimos clave foránea "exercicio_asignatura"
ALTER TABLE `exercicios` 
ADD CONSTRAINT `exercicio_asignatura` 
FOREIGN KEY (`asignatura`) REFERENCES `asignaturas`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


-- Creamos tabla "alumno_curso"
CREATE TABLE `academia`.`alumno_curso` (
    `usuario_id` INT NOT NULL , 
    `curso_id` INT NOT NULL , 
    PRIMARY KEY (`usuario_id`, `curso_id`)) ENGINE = InnoDB;

-- Añadimos claves foráneas
ALTER TABLE `alumno_curso` 
ADD FOREIGN KEY (`curso_id`) 
REFERENCES `cursos`(`id`) 
ON DELETE CASCADE ON UPDATE CASCADE; 

ALTER TABLE `alumno_curso` 
ADD FOREIGN KEY (`usuario_id`) 
REFERENCES `usuarios`(`id`) 
ON DELETE CASCADE ON UPDATE CASCADE;

-- Creamos tabla "usuario_asignatura"
CREATE TABLE `academia`.`usuario_asignatura` (
    `usuario_id` INT NOT NULL , 
    `asignatura_id` INT NOT NULL , 
    PRIMARY KEY (`usuario_id`, `asignatura_id`)) ENGINE = InnoDB;

-- Añadimos claves foráneas
ALTER TABLE `usuario_asignatura` 
ADD FOREIGN KEY (`asignatura_id`) 
REFERENCES `asignaturas`(`id`) 
ON DELETE CASCADE ON UPDATE CASCADE; 

ALTER TABLE `usuario_asignatura` 
ADD FOREIGN KEY (`usuario_id`) 
REFERENCES `usuarios`(`id`) 
ON DELETE CASCADE ON UPDATE CASCADE;

-- Insertamos usuarios
INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fecha_alta`, `activo`, `rol`) VALUES (NULL, 'administrador', '$2y$10$hDl6apU1qTmsdQF3c87u0.zD3gmZusyhuG/qAK4bDgZhQpI2IcHFK', 'Ricardo', 'Otero', 'González', 'riki.otero@gmail.com', '678441054', '2024-01-25 13:42:23.000000', '1', '1');
INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fecha_alta`, `activo`, `rol`) VALUES (NULL, 'profesor1', '$2y$10$jlL0xTiFmdGllVBcPLKgbOykzVrVtBkzlGfjMcZh7eB6vBU2HVo1e', 'David', 'López', 'García', 'davidlopez@hotmail.com', '678999000', '2024-01-30 18:39:06.000000', '1', '2');
INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fecha_alta`, `activo`, `rol`) VALUES (NULL, 'profesor2', '$2y$10$ipRVlSXB88q5Xkw35u5QJePbtuxaQMXyU2QoIeD5p8rEbXqRGlvqi', 'Jose Luis', 'Gallardo', 'Pérez', 'gallardoperez@gmail.es', '786564342', '2024-01-30 18:42:58.000000', '1', '2');
INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fecha_alta`, `activo`, `rol`) VALUES (NULL, 'estudiante1', '$2y$10$ONeYYcf.6DAbiZDfna/9UeoF1DUio5FXBN0VaXaBFwm5rYFTm/sy.', 'Juan', 'Caamaño', 'del toro', 'caamañodeltoro@terra.es', '654349875', '2024-01-30 18:50:55.000000', '1', '3');
INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fecha_alta`, `activo`, `rol`) VALUES (NULL, 'estudiante2', '$2y$10$9GVTENGTt2LK4eK0UuvP4edu4ndvjcOcYfPCZb3P/kKiGvbh7lkFm', 'Ángela', 'Prol', 'Vidal', 'angelaprol@gmail.com', NULL, '2024-01-30 18:56:53.000000', '1', '3');

-- Insertamos cursos
INSERT INTO `cursos` (`id`, `nombre`) VALUES 
(NULL, '1º Educación Primaria'), 
(NULL, '2º Educación Primaria'), 
(NULL, '3º Educación Primaria'), 
(NULL, '4º Educación Primaria'), 
(NULL, '5º Educación Primaria'), 
(NULL, '6º Educación Primaria'), 
(NULL, '1º Educación Secundaria Obligatoria (ESO)'), 
(NULL, '2º Educación Secundaria Obligatoria (ESO)'), 
(NULL, '3º Educación Secundaria Obligatoria (ESO)'), 
(NULL, '4º Educación Secundaria Obligatoria (ESO)'), 
(NULL, '1º Bachillerato'), 
(NULL, '2º Bachillerato')

-- Insertamos asignaturas de exemplo
INSERT INTO `asignaturas` (`id`, `nombre`, `curso`) 
VALUES (NULL, 'Matemáticas', '11'), 
(NULL, 'Física', '11')

INSERT INTO `asignaturas` (`id`, `nombre`, `curso`) 
VALUES (NULL, 'Matemáticas', '12'), 
(NULL, 'Física', '12'), 
(NULL, 'Química', '12')

COMMIT;

