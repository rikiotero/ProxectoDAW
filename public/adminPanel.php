<?php
session_start();
require "../vendor/autoload.php";
require "../src/functions/redirect.php";

use Clases\UserDB;


if( !isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "administrador") redirect("");

//recuperamos os datos do usuario
$usr = new UserDB();
$datosUsuario = $usr->getUser($_SESSION["user"]);
// $_SESSION["userId"] = $datosUsuario->id;
$activo = $datosUsuario->activo ? "checked" : "";    //guardamos o estado activo nunha variable para usalo no formulario
$usr->cerrarConexion();     

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administrador</title>
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">          
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script type="text/javascript" src="./js/createUser.js" defer></script>
    <script type="text/javascript" src="./js/updateUser.js" defer></script>
    <script type="text/javascript" src="./js/getUsers.js" defer></script>
    <script type="text/javascript" src="./js/deleteUser.js" defer></script>
    <script type="text/javascript" src="./js/modal.js" defer></script>
</head>
<body>
    <div class="float float-right d-inline-flex mt-2">
        <input type="text" size='10px' value="<?php echo $_SESSION["user"]; ?>" class="form-control mr-2 bg-transparent"
           disabled>
        <a href="../src/functions/closeSession.php" class='btn btn-danger'>Cerrar sesión</a>
    </div>    
    <h1 class="text-center">Panel de administrador</h1>

    <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Datos de usuario</button>
        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Xestión de usuarios</button>
        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Xestión de asignaturas</button>
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
                                    Actualizar usuario        
                                </button>
                                <button type="button" class="btn btn-danger" id="updatePassModalButton" data-bs-toggle="modal">
                                    Cambiar contrasinal        
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- fin contido da tab de usuario-->

        <!-- contido da tab de xestión de usuarios-->
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="container mt-3">
                <div class="row">
                    <div class="col">
                        <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            Crear novo usuario<i class="ms-1 fa-solid fa-plus" style="color: #ffffff;"></i>        
                        </button>                         -->
                        <button type="button" class="btn btn-success" id="createUserModalButton">
                            Crear novo usuario<i class="ms-1 fa-solid fa-plus" style="color: #ffffff;"></i>        
                        </button> 
                    </div>

                    <div class="col" id="notificacion">
                    </div>

                </div>
                <!-- fila de filtros de usuarios -->
                <div class="row align-items-center">                    
                    <div class="col-md-2 mt-3">
                        <input type="checkbox" name="activado" id="activado" class="form-check-input" checked>
                        <label for="activado" class="form-check-label">Usuarios activos</label>
                    </div>  
                    <div class="col-md-2 mt-3">
                        <input type="checkbox" name="inactivo" id="inactivo" class="form-check-input" checked>
                        <label for="inactivo" class="form-check-label">Usuarios inactivos</label>
                    </div>
                    
                    <div class="col-md-2 mt-3">
                        <select name="roles" id="roles" class="form-select">
                            <option value="0" selected>Roles...</option>
                            <option value="1">Administrador</option>
                            <option value="2">Profesor</option>
                            <option value="3">Estudiante</option>
                        </select>
                    </div>

                    <div class="col-md-4 offset-md-2">
                        <input type="text" name="buscar" id="buscar" placeholder="Buscar" class="form-control mt-3">
                    </div>
                </div>
                
                <table class="table table-striped table-light mt-3">
                    <thead>
                        <tr >
                            <th scope="col">Id</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Primer apelido</th>
                            <th scope="col">Segundo apelido</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Data de alta</th></th>
                            <th scope="col">Activo</th>
                            <th scope="col">Rol</th>
                            <th scope="col" colspan="2" class="text-center">Accións</th>
                        </tr>
                    </thead>
                    <tbody id="tablaUsuarios">
                    </tbody>
                </table>    
            </div>
        </div>
        <!-- contido da tab de xestión de asignaturas-->
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
            <h1>Xestión de asignaturas</h1>
        </div>
    </div>
<?php
require "createUserModal.php";
require "updateUserModal.php";
require "deleteUserModal.php";

?>
<script type="text/javascript" src="./js/validateForm.js" defer></script>
<script src="../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script> -->

</body>
</html>




