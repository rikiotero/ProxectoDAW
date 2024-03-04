<?php
session_start();
unset($_SESSION["rol"]);
unset($_SESSION["user"]);
unset($_SESSION["error"]);
unset($_SESSION["curso"]);
unset($_SESSION["asignaturas"]);
unset($_SESSION["id"]);

header("Location:../index.php");
