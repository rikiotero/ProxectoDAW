<?php
session_start();
require "../vendor/autoload.php";
require "./php_functions/redirect.php";

use Clases\UserDB;
use Clases\RoleDB;

if( !isset($_SESSION["rol"]) ) redirect("");

//recuperamos os datos do usuario
$usr = new UserDB();
$datosUsuario = $usr->getUser($_SESSION["user"]);
$activo = $datosUsuario->activo ? "checked" : "";    //guardamos o estado activo nunha variable para usalo no formulario
$curso = $usr->getCurso($datosUsuario->id);
$_SESSION["curso"] = $curso;
$asignaturas = $usr->getAsignaturas($datosUsuario->id);
$_SESSION["asignaturas"] = $asignaturas;

$usr->cerrarConexion();     

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de estudiante</title>
    <link rel="icon" href="./src/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">          
    <link rel="stylesheet" href="./src/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">   
</head>
<body>
    <header>
        <div class="d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex flex-row align-items-center p-3 headerLogo">
                <a class="navbar-brand" href="index.php">
                    <img src="src/img/logo.png" alt="Logo" loading="lazy" />
                </a>
                <h1 class="ms-2">Task Vault</h1>
            </div>
        
            <div class="headerTitle p-2">
                <h1>Panel de Estudiante</h1>
            </div>
            <div class="p-2 d-flex flex-row align-items-center align-self-start headerUsuario">
                <input type="text" size='10px' value="<?php echo $_SESSION["user"]?>" class="form-control bg-transparent" disabled>
                <a href="./php_functions/closeSession.php" title="cerrar sesión">
                    <span class="fa-solid fa-right-from-bracket fa-xl" style="color: #d71919;"></span>
                </a>
            </div>       
        </div> 
    </header>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-usuario-tab" data-bs-toggle="tab" data-bs-target="#nav-usuario" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Datos de usuario</button>
            <button class="nav-link" id="nav-exercicios-tab" data-bs-toggle="tab" data-bs-target="#nav-exercicios" type="button" role="tab" aria-controls="nav-exercicios" aria-selected="false">Exercícios</button>
        </div>
    </nav>

    
    <div class="tab-content" id="nav-tabContent">
       <!-- contido da tab de usuario-->
        <div class="tab-pane fade show active" id="nav-usuario" role="tabpanel" aria-labelledby="nav-usuario">
            <div class="container mt-5">
                <div class="row d-flex justify-content-center mt-5">           
                    <div class="col-md-3 border-end">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <span class="fw-bold fs-4 mb-3"><?php echo $datosUsuario->usuario?></span>
                            <span class="text-secondary">Id de usuario: <?php echo $datosUsuario->id?></span>
                            <input type="hidden" id="idUsuario" value="<?php echo $datosUsuario->id?>"></input>
                            <span class="text-secondary">Data de alta: <?php echo date("d-m-Y", strtotime($datosUsuario->fecha_alta))?></span>
                        </div>
                    </div>

                    <div class="col-md-5 border-end">
                        <div class="d-flex flex-column p-3 py-5">
                            <div class="row g-3 border-bottom">
                                <div class="col-md-4">
                                    <p class="fw-bold mb-3 mt-3">Nome</p>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <p class="mb-3 mt-3"><?php echo $datosUsuario->nombre." ".$datosUsuario->apellido1." ".$datosUsuario->apellido2 ?></p>
                                </div>
                            </div>
                        
                            <div class="row g-3 border-bottom">
                                <div class="col-md-4">
                                    <p class="fw-bold mb-3 mt-3">Email</p>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <p class="mb-3 mt-3"><?php echo $datosUsuario->email ?></p>
                                </div>
                            </div>

                            <div class="row g-3 border-bottom">
                                <div class="col-md-4">
                                    <p class="fw-bold mb-3 mt-3">Teléfono</p>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <p class="mb-3 mt-3"><?php echo $datosUsuario->telefono ?></p>
                                </div>
                            </div>

                            <div class="row g-3 border-bottom">
                                <div class="col-md-4">
                                    <p class="fw-bold mb-3 mt-3">rol</p>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <p class="mb-3 mt-3"><?php echo $_SESSION["rol"] ?></p>
                                </div>
                            </div>

                            <div class="row g-3 border-bottom">
                                <div class="col-md-4">
                                    <p class="fw-bold mb-3 mt-3">Usuario activo</p>
                                </div>
                                <div class="col-md-6 text-secondary">
                                

                                    <input class="form-check-input mb-3 mt-3" type="checkbox" id="activo" disabled <?php echo $activo?>>
                                </div>
                            </div>

                            <div class="row g-3 mt-3">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary" id="updateStudentModalButton"  data-bs-toggle="modal">
                                        Actualizar datos        
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex flex-column p-3 py-5">
                            <div class="row g-3 border-bottom">
                                <div class="col-md-3">
                                    <p class="fw-bold mb-3 mt-3">Curso</p>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <p class="mb-3 mt-3"><?php echo !empty($curso) ? current($curso) : "Sin curso asignado" ?></p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-3">
                                    <p class="fw-bold mb-3 mt-3">Materias</p>
                                </div>
                                <?php
                                if( !empty($asignaturas) ) {
                                    echo "<div class='col-md-8 mt-5'>";
                                    echo "<ul class='mt-3'>";
                                    foreach ($asignaturas as $key => $value) {
                                        echo "<li class='text-secondary'>$value</li>";
                                    }
                                    echo "</ul>";
                                    echo "</diV>";
                                }else {
                                    echo "<div class='col-md-8 text-secondary'>";
                                    echo "<p class='mb-3 mt-3'>Sin materias asignadas</p>";
                                    echo "</diV>";
                                }
                                ?>
                            </div>
                        </div>    
                    </div>  
                </div>
            </div>
        </div><!-- fin contido da tab de usuario-->

        <!-- contido da tab de lista de exercícios-->
        <div class="tab-pane fade" id="nav-exercicios" role="tabpanel" aria-labelledby="nav-exercicios">
            <div class="container mt-5">            
                <!-- fila de filtros de exercicios -->
                <div class="row">

                    <div class="col-md-auto mt-3"><!--numero de rexistros-->
                        <label for="numRexistrosEX" class="col-form-label">Mostrar:</label>
                    </div>
                    <div class="col-md-auto mt-3">    
                        <select name="numRexistrosEX" id="numRexistrosEX" class="form-select">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <div class="col-md-4 ms-auto"><!--cuadro de búsqueda-->
                        <input type="text" name="buscarEx" id="buscarEx" placeholder="Buscar" class="form-control mt-3">
                    </div>
                </div>
                
                <div class="row"><!--fila da tabla de exercicios-->
                    <div class="col-md-12 mt-3">
                        <table class="table table-striped table-light mt-5">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Tema</th>
                                    <th scope="col">Materia</th>                                                    
                                    <th scope="col">Autor</th>                           
                                    <th scope="col">Data</th>                            
                                    <th scope="col">Ver</th>
                                </tr>
                            </thead>
                            <tbody id="tablaExercicios">
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="row"><!--fila botóns de paxinación-->
                    <div class="col-md-12" id="botonsPaxinasEx">
                    </div>
                </div>

            </div>            
            <!-- </div>   -->
        </div><!-- fin contido da tab de xestión de exercícios-->


    </div>
<?php
require "./ventanas_modales/updateUsersListModal.php";
?>
<script type="text/javascript" src="./src/js/ajaxCursos.js" defer></script>  
<script type="text/javascript" src="./src/js/ajaxUser.js" defer></script>
<script type="text/javascript" src="./src/js/ajaxExercicios.js" defer></script>     
<script type="text/javascript" src="./src/js/validateForm.js" defer></script>
<script type="text/javascript" src="./src/js/jsStudent.js" defer></script>   
<script src="./bootstrap/js/bootstrap.bundle.min.js"></script>

<footer class="text-center py-1 fixed-bottom">
    <div class="container">
        <div class="row">
            <div class="col">2024 TaskVault
            </div>
        </div>
    </div>
</footer>
</body>
</html>




