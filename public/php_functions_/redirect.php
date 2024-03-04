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
            header('Location:index.php');
            break;
    }
}
