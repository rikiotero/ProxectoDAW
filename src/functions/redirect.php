<?php
/**
 * Fai unha redirección a outra páxina dependendo do rol de usuario
 * @param string rol de usuario
 */
function redirect($rol) {

    switch ($rol) {
        case 'administrador':
            header('Location:adminPanel.php');
            break;
        case 'profesor':
            header('Location:teacherPanel.php');
            break;
        case 'estudiante':
            header('Location:studentPanel.php');
            break;
        default:
        header('Location:login.php');
            break;
    }
}

// function closeSession() {
//     session_start();
//     unset($_SESSION['rol']);
//     unset($_SESSION['user']);
//     unset($_SESSION['error']);
//     redirect("");
// }