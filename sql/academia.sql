-- Creamos a base de datos
CREATE DATABASE IF NOT EXISTS academia DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- Seleccionamos a base de datos "academia"
use academia;

-- Creamos un usuario
create user administrador@'localhost' identified by 'admin';

-- damoslle permisos na base de datos "academia"
grant all on academia.* to administrador@'localhost';

-- Creamos tabla de "roles"
CREATE TABLE roles (
id INT PRIMARY KEY AUTO_INCREMENT , 
rol VARCHAR(30) NOT NULL) ENGINE = InnoDB;

-- Creamos tabla de "usuarios"
CREATE TABLE `academia`.`usuarios` (
    `id` INT NOT NULL AUTO_INCREMENT , 
    `usuario` VARCHAR(30) NOT NULL , 
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
    `nombre` VARCHAR(50) NOT NULL , 
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

-- -- Creamos tabla "usuario_asignatura"
-- CREATE TABLE `academia`.`usuario_asignatura` (
--     `usuario_id` INT NOT NULL , 
--     `asignatura_id` INT NOT NULL , 
--     PRIMARY KEY (`usuario_id`, `asignatura_id`)) ENGINE = InnoDB;

-- -- Añadimos claves foráneas
-- ALTER TABLE `usuario_asignatura` 
-- ADD FOREIGN KEY (`asignatura_id`) 
-- REFERENCES `asignaturas`(`id`) 
-- ON DELETE CASCADE ON UPDATE CASCADE; 

-- ALTER TABLE `usuario_asignatura` 
-- ADD FOREIGN KEY (`usuario_id`) 
-- REFERENCES `usuarios`(`id`) 
-- ON DELETE CASCADE ON UPDATE CASCADE;

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

-- Insertamos exercicios exemplo

INSERT INTO `exercicios` (`id`, `tema`, `enunciado`, `asignatura`) VALUES (NULL, 'Espacios Vectoriales', '1. ¿Cuál es el elemento opuesto del (1, -2,6,3) en el espacio R4? ¿Y el elemento cero?. 2. ¿Qué‚ condiciones tiene que cumplir un subconjunto no vacío de un espacio vectorial para que sea un subespacio vectorial de ‚este? Pon un ejemplo. 3. ¿Existe algún vector que sea combinación lineal de cualquier conjunto de vectores? Razona la contestación. 4. ¿Es cierto que un vector es combinación lineal de sí mismo? Pon un ejemplo. 5. ¿Cuál será el espacio engendrado por los vectores (2,3,4) y (6,9,12)? ¿Qué dimensión tiene dicho subespacio? 6. Razona, con ejemplos, cuando dos vectores de R² son linealmente dependientes o independientes ¿Qué relación tienen que verificar las componentes en cada caso?. 7. En R², dos vectores cualesquiera son siempre linealmente independientes, ¿es cierto?. En R², el número máximo de vectores linealmente independientes es dos, ¿es cierto?. Razona las respuestas. 8. Razona, mediante ejemplos, cuando dos vectores de R3 son linealmente dependientes o independientes. ¿Qué relación tienen que verificar las componentes en cada caso? 9. En R3, tres vectores cualesquiera son siempre linealmente independientes, ¿es cierto?, en R3, el número máximo de vectores linealmente independientes es tres, ¿es cierto? Razona las respuestas. 10. ¿Qué significa que un conjunto de vectores sea linealmente dependiente? Razona si son linealmente dependientes los vectores, v! y 2u!−v\"11. Dos fracciones a/b y c/d son equivalentes. Si consideramos los vectores numéricos (a,c) y (b,d), ¿son dependientes o independientes? Razona la respuesta. 12. Si un conjunto de vectores contiene al vector nulo, ¿es dependiente o independiente? Razona tu contestación con un ejemplo. 13. ¿Es siempre cierto que un vector es linealmente independiente? ¿Y si se trata del vector nulo?. 14. ¿Qué 3 condiciones debe cumplir un conjunto de vectores para que sea una base del espacio vectorial? 15. ¿Puede tener un vector distintas coordenadas respecto de la misma base? ¿Y respecto de bases distintas? Pon un ejemplo. 16. Si un espacio vectorial tiene dos bases distintas, ¿es posible que dichas bases tengan distinto número de elementos?. 17. ¿Qué condiciones debe cumplir una aplicación entre espacios vectoriales para que sea una aplicación lineal?. 18. ¿Para que valores de \"a\" el conjunto de vectores [(1,1,1), (1,a,1), (1,1,a)] es una base de R3? 19. En R4 determinar a y b para que los vectores u!1=(0,1,a,2b), u!2=(1,0,1,1) y u!3=(1,1,−1,b) sean dependientes. Escribir la relación de dependencia. 20. Determinar x para que los vectores de (R4,+,·) sean linealmente dependientes: v!1=(1,1,x,2) v!2=(x,3,2,1) v!3=(0,0,x,1) \r\n', '3'), (NULL, 'Matrices', '1. Supóngase que un constructor de edificios ha aceptado ordenes para 5 casas estilo rústico, 7 casas estilo imperial y 12 casas estilo colonial. El constructor está familiarizado, por supuesto, con la clase de materiales que entran en cada tipo de casa. Supongamos que los materiales son acero, madera, vidrio pintura y trabajo. Los números de la matriz que sigue dan las cantidades de cada material que entra en cada tipo de casa, expresadas en unidades convenientes. (Los números están expuestos arbitrariamente, y no es el propósito que sean realistas) Acero Madera Vidrio Pintura TrabajoRústico: 5 20 16 7 17 Imperial: 7 18 12 9 21 Colonial: 6 25 8 5 13 Calcular cuánto debe obtener, el contratista, de cada material para cumplir con sus contratos. Qué precios tiene que pagar por estos materiales, suponiendo que el acero cuesta 15$ por unidad, la madera 8$ por unidad, el vidrio 5$ por unidad, la pintura 1$ por unidad, y el trabajo 10$ por unidad. ¿Cuál es el costo de los materiales para todas las casas? 2. Juan necesita comprar una docena de huevos y otra de naranjas, media docena de manzanas y otra de peras y tres limones. En una tienda A las manzanas valen 4 pts cada una, los huevos 6 pts, los limones 9 pts, las naranjas 5 pts y las peras 7 pts. En la tienda B, los precios son ligeramente diferentes, 5 pts por la manzana, 5 pts por huevo, 10 pts por limón, 10 pts por naranja y 6 pts por pera. ¿Cómo le resultará a Juan la compra más económica? 3. Una urna contiene 5 bolas rojas, 3 verdes y 1 blanca. Se sacará al azar una bola, Y luego se pagará a los portadores de tres clases de billetes de la lotería, A, B y C, de acuerdo con la siguiente manera: Si se escoge una bola roja, los portadores del billete A obtendrán 1$, los portadores del billete B 3$, y los portadores del billete C no obtendrán nada. Si se escoge la verde, los pagos son de 4, 1 y 0 respectivamente. Si se escoge la blanca, los portadores del billete C obtendrán 16$, y los otros nada. ¿Qué billete preferiríamos tener? 4.En un hospital oncológico se aplica a un grupo de 4 pacientes un tratamiento de quimioterapia mediante un protocolo CMF. Las cantidades diarias que necesita cada paciente de cada uno de los compuestos varían según la superficie total corporal, del siguiente modo: Paciente 1: 1.200 mg de C, 80 mg de M y 1.200 mg de F Paciente 2: 900 mg de C, 60 mg de M y 950 mg de F Paciente 3: 1.100 mg de C, 75 mg de M y 1.000 mg de F Paciente 4: 1.150 mg de C, 80 mg de M y 1.100 mg de F Teniendo en cuente que el tratamiento se va a aplicar 3 semanas a los pacientes 1, 3 y 4, y 2 semanas al paciente 2; hallar la matriz de necesidades diarias y las cantidades de cada compuesto necesarias para poder atender correctamente los tratamientos de los 4 pacientes. 5. Dos dietas para la alimentación semanal de “perros de tamaño medio” combinan latas de las marcas DOG,CHOW y CAN. La dieta primera, combina una lata de DOG, 3 de CHOW y 2 de CAN . La dieta segunda 2 de DOG, 1 de CHOW, y 4 de CAN. El contenido vitamínico en vitaminas A, B y C, en miligramos de cada lata, DOG, CHOW y CAN viene dado por la matriz =×303112215230V43, los precios por lata son DOG 120 pts, CHOW 140 pts y CAN 110 pts. Obtener la matriz del contenido vitamínico y del coste total de la dieta. 6. En una urbanización hay dos tipos de viviendas N, normales y L, lujosas. Cada vivienda-N tiene 2 ventanas grandes, 9 medianas y 2 pequeñas. Cada vivienda-L tiene 4 ventanas grandes, 10 medianas y 3 pequeñas. Cada ventana grande tiene 4 cristales y 8 bisagras. Cada ventana mediana 2 cristales y 4 bisagras. Cada ventana pequeña 1 cristal y 2 bisagras. Escribir una matriz que describa n° y tamaño de las ventanas en \r\n', '3')
INSERT INTO `exercicios` (`id`, `tema`, `enunciado`, `asignatura`) VALUES (NULL, 'vibraciones y ondas', 'Ejercicio 1Una partícula vibra con una frecuencia de 30Hzy una amplitud de 5,0 cm. Calcula la velocidad máxima y la aceleración máxima con que se mueve.Ejercicio 2¿Cómo se modifica la energía mecánica de un oscilador en los siguiente casos?a)Si se duplica la frecuencia.b)Si se duplica la masa.c)Si se duplica el periodo.d)Si se duplica la amplitud.Ejercicio 3Una partícula vibra con una frecuencia de 5Hz. ¿Cuánto tiempo tardará en desplazarse desde un extremo hasta la posición de equilibrio?Ejercicio 4Una masa de 0,50 kg cuelga de un resorte con constante de elasticidad k=50N/m. Si la desplazamos 5,0 cm y la soltamos, calcula:a)La frecuencia.b)La velocidad que tiene cuando pasa por la posición de equilibrio.Ejercicio 5Una partícula vibra de modo que tarda 0,50 s en ir desde un extremo a la posición de equilibrio, distantes entre sí 8,0 cm. Si para t = 0 la elongación de la partícula es de 4,0 cm, halla la ecuación que define este movimiento.Ejercicio 6Un muelle se alarga 25 cm cuando se cuelga de él una masa de 2,0 kg. Calcula la frecuencia y la velocidad máxima de oscilación de la masa, sabiendo que la amplitud del movimiento es 5,0 cm. Ejercicio 7Una masa m oscila en el extremo de un resorte vertical con una frecuencia de 1 Hz y una amplitud de 5cm. Cuando se añade otra masa de 300 g, la frecuencia de oscilación pasa a ser de 0,5 Hz. Determinar:a)El valor de la masa m y de la constante recuperadora del resorte.\r\n', '4'), (NULL, 'Óptica física', '1.Se hace incidir sobre un prisma de 60º e índice de refracción 2un rayo luminoso que forma un ángulo de 45º con la normal. Determinar:a)El ángulo de refracción en el interior del prisma.b)El ángulo de incidencia sobre la otra cara del prisma.c)El ángulo del rayo emergente. d)El ángulo formado por el rayo incidente y el emergente.2.La figura muestra un rayo de luz que avanza por el aire y se encuentra con un bloque de vidrio. La luz en parte se refleja y en parte se refracta. Calcula la velocidad en la luz en este vidrio y su índice de refracción.3.Un prisma de 60º tiene un índice de refracción de 1,52. Calcula el ángulo de incidencia del rayo, que penetrando por el prisma, sufra justamente la reflexión total en la cara opuesta.4.El índice de refracción del prisma de la figura es 2. Dibuja la trayectoria que seguirá el rayo de luz en él, sabiendo que el exterior es el aire.5.Los índices de refracción absolutos del agua y el vidrio para la luz amarilla del sodio son 1,33 y 1,52 respectivamente. Calcula:a)La velocidad de propagación de esta luz en el agua y en el vidrio.b)El índice de refracción relativo del vidrio respecto al agua.6.Calcula la longitud de onda en el agua y en el cuarzo de un rayo de luz amarilla cuya longitud de onda en el vació es de 589 nm, sabiendo que los índices de refracción absolutos del agua y el cuarzo son 1,33 y 1,54 respectivamente.', '4')
INSERT INTO `exercicios` (`id`, `tema`, `enunciado`, `asignatura`) VALUES (NULL, 'Leyes Ponderales', '1. Definir: mol, átomo-gramo, u.m.a., peso atómico, peso molecular, número de Avogadro. 2. Al analizar dos muestras se han obtenido los siguientes resultados: 1ª muestra 1,004 g. de Ca y 0,400 g de oxigeno. 2ª muestra 2,209 g. de Ca y 0,880 g de oxigeno. Indicar si se cumple la ley de Proust. Solución. Se cumple la Ley de Proust.3. Los elementos A y B pueden formar dos compuestos diferentes. En el 1º hay 8 g. de A por cada 26 g de compuesto. En el 2º tiene una composición centesimal de 25 % de A y 75 % de B. Se cumple la ley de las proporciones múltiples. Solución. Se cumple la Ley de Dalton4. Sabiendo que 2 g. de Na se combinan con 3,0842 g de Cl; 1 g de Cl con 0,2256 g. de O, para formar oxido y que 1 g de O reacciona con 2,8738 g. de Na para dar él oxido de sodio. Comprobar si se cumple la ley de las proporciones recíprocas. Solución. Se cumple la Ley de Richter.5. En análisis de dos óxidos de Cr, muestran que 2,51 g del 1º contienen 1,305 g de Cr, y que 3,028 g del 2º contiene 2,072 g. de Cr. Demostrar que se cumple la ley de las proporciones múltiples. Solución. Se cumple la Ley de Dalton6. El H y él O reaccionan dando agua, pero sometido a una fuerte descarga eléctrica pueden producir peróxido de hidrogeno. La 1ª contiene el 11,2% de H, mientras que la 2ª posee un 5,93%. Demostrar que se cumple la ley de las proporciones múltiples. H = 1 gr.; O = 16 gr. Solución. Se cumple la Ley de DaltonLey de las proporciones múltiples ó Ley de Dalton. 7. Una muestra de óxido de vanadio que pesaba 3,53 g. se redujo con H obteniendo agua y otro óxido de vanadio que peso 2,909 g. Este 2º óxido se trato de nuevo con H hasta que se obtuvieron 1,979 g. de metal. a.cuales son las formulas empíricas de ambos óxidos. b.Cual es la cantidad de agua formada en ambas reacciones. V = 50’9 gr.; O = 16 gr.; H = 1 gr. Solución. a) V2O5, V2O3. b) 0’699 gr., 1’046 gr 8. Calcular él % en peso de cada átomo que forma el ácido sulfúrico. H = 1 gr.; S = 32 gr.; O = 16 gr. Solución. H(2’04%), S(32’65%), O(65’31%) 9. La progesterona es un componente común de la píldora anticonceptiva, si su fórmula es C21H30O2 ¿cuál es su composición porcentual? Datos: C = 12 gr.; H = 1 gr.; O = 16 gr. Solución. C(80’25%), S(9’55%), O(10’20%)10. Calcular el porcentaje de cobre en cada uno de los minerales siguientes cuprita Cu2O, piritas cupríferas CuFeS2, malaquita Cu2CO3(OH)2, ¿Cuántas toneladas de cuprita se necesitan para extraer 500 toneladas de cobre? Datos: Cu = 63’5 gr.; O = 16 gr.; Fe = 55’8 gr.; S = 32 gr.; C = 12 gr.; H = 1gr. Solución. 88’81% en cuprita, 34’64% en piritas cupríferas; 57’47% en malaquita; 563 toneladas de cuprita.11. Hallar la fórmula de un compuesto cuya composición centesimal es: N 10,7%, O 36,8% y Ba 52,5%. Pesos atómicos: N = 14, O = 16 y Ba = 137’3. Solución.Ba(NO3)2\r\n', '5'), (NULL, 'Termodinámica', '1. Explicar cómo variar con la temperatura la espontaneidad de una reacción en la que AHº < 0 y ASº < 0, suponiendo que ambas magnitudes constantes con la temperatura. 2. Se suele decir que la ley de Hess es una consecuencia directa del primer principio de la Termodinámica en su aplicación a una reacción química. Justificar esta afirmación. 3. La Entalpía de formación del agua a 298 K es −286 kJ/mol. Sin embargo, cuando se mezclan a 298 K el hidrógeno y el oxígeno, no se observa reacción apreciable. Comente estos hechos. 4.a-Utilizando diagramas Energía / coordenada de reacción, represente los perfiles de una reacción endotérmica y de otra exotérmica, partiendo de reactivos (R) para dar productos (P) y establezca, al mismo tiempo, el signo de la variación de entalpía (∆H) para ambas reacciones. b-En uno de los diagramas, represente el perfil de la reacción al añadir un catalizador al medio de reacción y comente qué efecto tiene sobre: b.l.- la entalpía de reacción, y b.2.-la constante cinética de la reacción directa. 5. Dadas tres reacciones espontáneas cualquiera. Razone: a)Cual es el signo de ∆G para cada una. b)Qué datos serían precisos conocer para saber si al producirse las reacciones, aumenta el grado de desorden y cuál de ellas transcurriría a mayor velocidad. 6. De las siguientes reacciones, cada una de ellas a 1 atm de presión. ∆H (kJ) ∆S (kJ/K) ½ H 2 (g) + ½ I 2 (g) → HI (g) +25’94 +34’63·10−22NO2 (g) → N2O4 (g) −58’16 −73’77·10−2S (s) + H2 (g) → H2S (g) −16’73 +18’19·10−2Razonar: a)Las que son espontáneas a todas temperaturas. b)Las que son espontáneas a bajas temperaturas y no espontáneas a altas temperaturas. c)Las que son espontáneas a altas temperaturas y no espontáneas a bajas temperaturas. 7. Teniendo en cuenta la gráfica adjunta que deberá copiar en su hoja de contestaciones: a)Indique si la reacción es exotérmica o endotérmica. b)Represente el valor de ∆H de reacción. c)Represente la curva de reacción al añadir un catalizador positivo. d)¿Qué efectos produce el hecho de añadir un catalizador positivo? \r\n', '5')
INSERT INTO `exercicios` (`id`, `tema`, `enunciado`, `asignatura`) VALUES (NULL, 'Números Reales', '1.Averiguar los valores reales que verifican las siguientes condiciones: a.22x≤−b.521x=+c.63x2≥+2.Expresar en forma de valor absoluto los siguientes intervalos: a.(−3, 5) b.(−∞, 2] ∪ [5, +∞) 3.Calcular: a.33385423216−+b.ab21ab2ba2+−c.()233x2x8x42x+−+−+d.()()63644222nm·cb·nmnama−+−+−e.125,0c·ac92ca2c2ab18baba18,03,0b432222−++4.Calcular: a.334:32b.333133c.32bb25.Racionalizar: 23223−+6.Racionalizar: 2232263++7.Racionalizar: 32233223−+8.Racionalizar: 18232−9.Racionalizar: 12232+10.Racionalizar: 2332263++\r\n', '1'), (NULL, 'Números Complejos', '1. Hallar \"a\" para que el complejo i6ai23++: a)sea real puro b)sea imaginario puro 2. Hallar el valor de k para que el complejo ()ki1i·k12−+− sea un nº real. Hallar su cociente. 3. Hallar a y b para que el complejo bi3i2a++ sea igual 31524. Hallar dos números complejos cuya diferencia es imaginaria, su suma tiene como parte imaginaria 5 y su producto vale i55+−. 5. Hallar dos nº complejos tales que su suma sea 1 + 2i, el cociente de ambos real puro y la parte real del 1º sea igual a 2. 6. Determine un número complejo cuyo cuadrado sea igual a su conjugado. 7. Expresar en forma polar los siguientes nº complejos: a)2 b)−5 c)i d)i 322+−e)i3−8. Expresar en forma binómica los siguientes complejos: a)3180ºb)630ºc)2270ºd)√245º9. El complejo de argumento 75º y módulo 12 es el producto de dos complejos, uno de ellos tiene de argumento 45º y el otro de módulo 3. Escribir ambos en forma binómica. 10. Sean los complejos: Z = 330º ; W = 260º ; P = 2 + 2i ; i322Q−=realizar las siguientes operaciones: a)Z· W b)2WZ⋅c)P² d)Q5e)12QPZ−⋅f)3333PWZQ−+\r\n', '1')

-- Insertamos usuarios
INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fecha_alta`, `activo`, `rol`) VALUES (NULL, 'administrador', '$2y$10$hDl6apU1qTmsdQF3c87u0.zD3gmZusyhuG/qAK4bDgZhQpI2IcHFK', 'Ricardo', 'Otero', 'González', 'riki.otero@gmail.com', '678441054', '2024-01-25 13:42:23.000000', '1', '1');
INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fecha_alta`, `activo`, `rol`) VALUES (NULL, 'profesor1', '$2y$10$jlL0xTiFmdGllVBcPLKgbOykzVrVtBkzlGfjMcZh7eB6vBU2HVo1e', 'David', 'López', 'García', 'davidlopez@hotmail.com', '678999000', '2024-01-30 18:39:06.000000', '1', '2');
INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fecha_alta`, `activo`, `rol`) VALUES (NULL, 'profesor2', '$2y$10$ipRVlSXB88q5Xkw35u5QJePbtuxaQMXyU2QoIeD5p8rEbXqRGlvqi', 'Jose Luis', 'Gallardo', 'Pérez', 'gallardoperez@gmail.es', '786564342', '2024-01-30 18:42:58.000000', '1', '2');
INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fecha_alta`, `activo`, `rol`) VALUES (NULL, 'estudiante1', '$2y$10$ONeYYcf.6DAbiZDfna/9UeoF1DUio5FXBN0VaXaBFwm5rYFTm/sy.', 'Juan', 'Caamaño', 'del toro', 'caamañodeltoro@terra.es', '654349875', '2024-01-30 18:50:55.000000', '1', '3');
INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido1`, `apellido2`, `email`, `telefono`, `fecha_alta`, `activo`, `rol`) VALUES (NULL, 'estudiante2', '$2y$10$9GVTENGTt2LK4eK0UuvP4edu4ndvjcOcYfPCZb3P/kKiGvbh7lkFm', 'Ángela', 'Prol', 'Vidal', 'angelaprol@gmail.com', NULL, '2024-01-30 18:56:53.000000', '1', '3');