<?php

session_start();
unset($_SESSION['rol']);
unset($_SESSION['user']);
unset($_SESSION['error']);
header('Location:login.php');
