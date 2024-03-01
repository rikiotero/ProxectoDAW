<?php
session_start();
require "../vendor/autoload.php";
require "./php_functions/redirect.php";

use Clases\UserDB;
use Clases\RoleDB;

if( !isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "estudiante") redirect("");

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
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">          
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">   
    <!-- <script type="text/javascript" src="./js/deleteUser.js" defer></script> -->    
</head>
<body>
<header>
        <div class="d-flex flex-row mb-3 align-items-center">
            <div class="p-2 flex-fill ">
                <h1>Panel de estudiante</h1>
            </div>
            <div class="p-2">
                <input type="text" size='10px' value="<?php echo $_SESSION["user"]?>" class="form-control bg-transparent" disabled>
            </div> 
            <div class="p-2">
                <a href="./php_functions/closeSession.php" title="cerrar sesión">
                    <span class="fa-solid fa-right-from-bracket fa-2xl" style="color: #d71919;"></span>
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
                <div class="row mt-5" id="1">           
                    <div class="col-md-3 border-end">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <!-- <img class="rounded-circle" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"> -->
                            <span class="font-weight-bold"><?php echo $datosUsuario->usuario?></span>
                            <span class="text-black-50"><?php echo $datosUsuario->email?></span>
                            <span class="text-black-50">Id de usuario: <?php echo $datosUsuario->id?></span>
                            <input type="hidden" id="idUsuario" value="<?php echo $datosUsuario->id?>"></input>
                            <span class="text-black-50">Fecha de alta: <?php echo date("d-m-Y", strtotime($datosUsuario->fecha_alta))?></span>
                        </div>
                    </div>

                    <div class="col-md-5 border-end">
                        <div class="d-flex flex-column p-3 py-5">
                            <div class="row g-3 border-bottom">
                                <div class="col-md-3">
                                    <h6 class="mb-3 mt-3">Nome</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <p class="mb-3 mt-3"><?php echo $datosUsuario->nombre." ".$datosUsuario->apellido1." ".$datosUsuario->apellido2 ?></p>
                                </div>
                            </div>
                        
                            <div class="row g-3 border-bottom">
                                <div class="col-md-3">
                                    <h6 class="mb-3 mt-3">Email</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <p class="mb-3 mt-3"><?php echo $datosUsuario->email ?></p>
                                </div>
                            </div>

                            <div class="row g-3 border-bottom">
                                <div class="col-md-3">
                                    <h6 class="mb-3 mt-3">Teléfono</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <p class="mb-3 mt-3"><?php echo $datosUsuario->telefono ?></p>
                                </div>
                            </div>

                            <div class="row g-3 border-bottom">
                                <div class="col-md-3">
                                    <h6 class="mb-3 mt-3">rol</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <p class="mb-3 mt-3"><?php echo $_SESSION["rol"] ?></p>
                                </div>
                            </div>

                            <div class="row g-3 border-bottom">
                                <div class="col-md-3">
                                    <h6 class="mb-3 mt-3">Usuario activo</h6>
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
                                    <!-- <button type="button" class="btn btn-danger" id="updatePassModalButton" data-bs-toggle="modal">
                                        Cambiar contrasinal        
                                    </button> -->
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex flex-column p-3 py-5">
                            <div class="row g-3 border-bottom">
                                <div class="col-md-3">
                                    <h6 class="mb-3 mt-3">Curso</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <p class="mb-3 mt-3"><?php echo !empty($curso) ? current($curso) : "Sin curso asignado" ?></p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-3">
                                    <h6 class="mb-3 mt-3">Asignaturas</h6>
                                </div>
                                <?php
                                if( !empty($asignaturas) ) {
                                    echo "<div class='col-md-6 mt-5'>";
                                    echo "<ul class='mt-3'>";
                                    foreach ($asignaturas as $key => $value) {
                                        echo "<li class='text-secondary'>$value</li>";
                                    }
                                    echo "</ul>";
                                    echo "</diV>";
                                }else {
                                    echo "<div class='col-md-7 text-secondary'>";
                                    echo "<p class='mb-3 mt-3'>Sin asignaturas asignadas</p>";
                                    echo "</diV>";
                                }
                                ?>
                            </div>
                        </div>    
                    </div>  
                </div>
            </div>
        </div><!-- fin contido da tab de usuario-->

        <!-- contido da tab de xestión de exercícios-->
        <div class="tab-pane fade" id="nav-exercicios" role="tabpanel" aria-labelledby="nav-exercicios">
            <div class="container mt-5">            
                <!-- fila de filtros de exercicios -->
                <div class="row d-flex align-items-end">
                    <div class="col-md-6">
                        <input type="text" name="buscarEx" id="buscarEx" placeholder="Buscar" class="form-control mt-3">
                    </div>
                </div>
                
                <table class="table table-striped table-light mt-5">
                    <thead>
                        <tr >
                            <th scope="col">Id</th>
                            <th scope="col">Tema</th>
                            <th scope="col">Asignatura</th>                                                    
                            <th scope="col">Autor</th>                           
                            <th scope="col">Fecha</th>                            
                            <th scope="col">Ver</th>
                        </tr>
                    </thead>
                    <tbody id="tablaExercicios">
                    </tbody>
                </table>    
            </div>            
            <!-- </div>   -->
        </div><!-- fin contido da tab de xestión de exercícios-->


    </div>
<?php
require "updateUsersListModal.php";
?>
<script type="text/javascript" src="./js/ajaxCursos.js" defer></script>  
<script type="text/javascript" src="./js/ajaxUser.js" defer></script>
<script type="text/javascript" src="./js/ajaxExercicios.js" defer></script>     
<script type="text/javascript" src="./js/validateForm.js" defer></script>
<script type="text/javascript" src="./js/jsStudent.js" defer></script>   
<script src="./bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>




