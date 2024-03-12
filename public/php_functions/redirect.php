<?php
/**
 * Fai unha redirección a outra páxina dependendo do rol de usuario
 * @param string rol de usuario
 */
function redirect($rol) {

    switch ($rol) {
        case "administrador":
            header("Location:".$_SERVER['DOCUMENT_ROOT']."/adminPanel.php");
            break;
        case "profesor":
            header("Location:".$_SERVER['DOCUMENT_ROOT']."/teacherPanel.php");
            break;
        case "estudiante":
            header("Location:".$_SERVER['DOCUMENT_ROOT']."/studentPanel.php");
            break;
        default:
            header("Location:".$_SERVER['DOCUMENT_ROOT']."/index.php");
            break;
    }
}
