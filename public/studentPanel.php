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
$asignaturas = $usr->getAsignaturas($datosUsuario->id);
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
    <script type="text/javascript" src="./js/updateUser.js" defer></script>
    <script type="text/javascript" src="./js/modalStudentPanel.js" defer></script>
    <!-- <script type="text/javascript" src="./js/validateForm.js" defer></script> -->
</head>
<body>
    <div class="float float-right d-inline-flex mt-2">
        <input type="text" size='10px' value="<?php echo $_SESSION["user"]; ?>" class="form-control mr-2 bg-transparent"
           disabled>
        <a href="./php_functions/closeSession.php" class='btn btn-danger'>Cerrar sesión</a>
    </div>    
    <h1 class="text-center">Panel de estudiante</h1>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Datos de usuario</button>
            <button class="nav-link" id="nav-tasks-tab" data-bs-toggle="tab" data-bs-target="#nav-tasks" type="button" role="tab" aria-controls="nav-tasks" aria-selected="false">Exercicios</button>
            <!-- <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Pestaña 3</button> -->
        </div>
    </nav>

    
    <div class="tab-content" id="nav-tabContent">
        <!-- contido da tab de usuario-->
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            <div class="container row" id="1">
                <div class="mt-5"></div>                
                    <div class="col-md-3 border-end">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                            <!-- <img class="rounded-circle" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"> -->
                            <span class="font-weight-bold"><?php echo $datosUsuario->usuario?></span>
                            <span class="text-black-50"><?php echo $datosUsuario->email?></span>
                            <span class="text-black-50">Id de usuario: <?php echo $datosUsuario->id?></span>
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
                                    <button type="button" class="btn btn-primary" id="updateUserModalButton" data-bs-toggle="modal">
                                        Actualizar datos        
                                    </button>
                                    <button type="button" class="btn btn-danger" id="updatePassModalButton" data-bs-toggle="modal">
                                        Cambiar contrasinal        
                                    </button>
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
        </div>
        <!-- fin contido da tab de usuario-->
    </div>
<?php

require "updateUserModal.php";

?>

<script src="./bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>




