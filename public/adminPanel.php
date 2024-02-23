<?php
session_start();
require "../vendor/autoload.php";
require "./php_functions/redirect.php";

use Clases\UserDB;
use Clases\RoleDB;
use Clases\CursosDB;

if( !isset($_SESSION["rol"]) ||  $_SESSION["rol"] != "administrador") redirect("");

//recuperamos os datos do usuario
$usr = new UserDB();
$datosUsuario = $usr->getUser($_SESSION["user"]);
$activo = $datosUsuario->activo ? "checked" : "";    //guardamos o estado activo nunha variable para usalo no formulario
$usr->cerrarConexion();     

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administrador</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">          
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script type="text/javascript" src="./js/createUser.js" defer></script>
    <script type="text/javascript" src="./js/updateUser.js" defer></script>
    <script type="text/javascript" src="./js/getUsers.js" defer></script>
    <script type="text/javascript" src="./js/deleteUser.js" defer></script>
    <script type="text/javascript" src="./js/modal.js" defer></script>
</head>
<body>
    <header>
        <div class="d-flex flex-row mb-3 align-items-center">
            <div class="p-2 flex-fill ">
                <h1>Panel de administrador</h1>
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
            <button class="nav-link active" id="nav-usuario-tab" data-bs-toggle="tab" data-bs-target="#nav-usuario" type="button" role="tab" aria-controls="nav-usuario" aria-selected="true">Datos de usuario</button>
            <button class="nav-link" id="nav-listaUsuarios-tab" data-bs-toggle="tab" data-bs-target="#nav-listaUsuarios" type="button" role="tab" aria-controls="nav-listaUsuarios" aria-selected="false">Xestión de usuarios</button>
            <button class="nav-link" id="nav-asignaturas-tab" data-bs-toggle="tab" data-bs-target="#nav-asignaturas" type="button" role="tab" aria-controls="nav-asignaturas" aria-selected="false">Xestión de cursos e asignaturas</button>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <!-- contido da tab de usuario-->
        <div class="tab-pane fade show active" id="nav-usuario" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="container mt-3">
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
                                    <button type="button" class="btn btn-primary" id="updateUserModalButton"  data-bs-toggle="modal">
                                        Actualizar datos        
                                    </button>
                                    <!-- <button type="button" class="btn btn-danger" id="updatePassModalButton" data-bs-toggle="modal">
                                        Cambiar contrasinal        
                                    </button> -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div><!-- fin contido da tab de usuario-->

        <!-- contido da tab de xestión de usuarios-->
        <div class="tab-pane fade" id="nav-listaUsuarios" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="container mt-3">
                <div class="row">
                    <div class="col">
                        <!-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUserModal">
                            Crear novo usuario<span class="ms-1 fa-solid fa-plus" style="color: #ffffff;"></span>        
                        </button>                         -->
                        <button type="button" class="btn btn-success" id="createUserModalButton">
                            Crear novo usuario<span class="ms-1 fa-solid fa-plus" style="color: #ffffff;"></span>        
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
        </div><!-- fin contido da tab de xestión de usuarios-->

        <!-- contido da tab de xestión de cursos-asignaturas-->
        <div class="tab-pane fade" id="nav-asignaturas" role="tabpanel" aria-labelledby="nav-contact-tab">
            <div class="container mt-3">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-5 mt-5">
                        <div class="d-flex justify-content-end">
                            <div class="flex-grow-1">
                                <input type="text" name="addCurso" id="addCurso" class="form-control" 
                                placeholder="Escribe o nome do curso novo" title="Escribe o nome do curso e pulsa para añadilo"required>
                            </div>

                            <div class="ms-2">
                                <button type="submit" class="btn btn-success" id="addCursoButton" onclick="addCurso()" 
                                title="Escribe o nome do curso e pulsa para añadilo">
                                    Añadir curso<span class="ms-1 fa-solid fa-plus" style="color: #ffffff;"></span>        
                                </button>
                            </div>
                        </div>
                        <div class="form-text">
                                Para insertar un curso novo escribe o nome do curso e pulsa en "Añadir curso"
                        </div>

                        <div class="row">
                            <div class="col m-2" id="msgCursos">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 mt-5">
                        <div class="row">
                            <div class="col">
                                <select id="selectCurso" name="selectCurso" class="form-select">
                                    <option value="0">Selecciona curso...</option>                            
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <div class="flex-grow-1">
                                <input type="text" name="addAsign" id="addAsign" class="form-control" 
                                placeholder="Escribe o nome da asignatura nova" title="Escribe o nome da asignatura e pulsa para añadila" required>
                            </div>
                            <div class="ms-2">
                                <button type="submit" class="btn btn-success" id="addAsignButton" onclick="addAsignatura()" 
                                    title="Escribe o nome da asignatura e pulsa para añadila">
                                    Añadir asignatura o curso<span class="ms-1 fa-solid fa-plus" style="color: #ffffff;"></span>        
                                </button>
                            </div>                         
                        </div>
                        <div class="form-text">
                            Para insertar unha asignatura nova selecciona primeiro o curso donde queres insertala
                        </div>                    
                    </div>              
                </div> 

                <div class="row d-flex justify-content-between">
                    <div class="col-md-5 mt-2">
                        <table class="table table-striped table-light">
                        <caption>Cursos</caption>
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Curso</th>
                                    <th scope="col" colspan="2" class="text-center">Accións</th>
                                </tr>
                            </thead>
                            <tbody id="tablaCursos">
                            </tbody>
                        </table> 
                    </div>

                    <div class="col-md-5 mt-2">
                        <table class="table table-striped table-light">
                        <caption>Asignaturas</caption>
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Asignatura</th>
                                    <th scope="col" colspan="2" class="text-center">Accións</th>
                                </tr>
                            </thead>
                            <tbody id="tablaAsignaturas">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>  
        </div><!-- fin contido da tab de xestión de cursos-asignaturas-->
    </div>
        
   
<?php
require "createUserModal.php";
// require "updateUserModal.php";
require "updateUsersListModal.php";
require "deleteUserModal.php";
require "updateCursosModal.php";

?>
<script type="text/javascript" src="./js/ajaxCursos.js" defer></script>
<script type="text/javascript" src="./js/validateForm.js" defer></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script> -->
</body>
</html>




