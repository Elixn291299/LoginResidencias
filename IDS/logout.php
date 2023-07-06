<?php
session_start(); // Inicia la sesión al comienzo del archivo

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // Cerrar la sesión
    session_unset();
    session_destroy();
}

// Redireccionar al formulario de inicio de sesión
header("Location: login.html");
exit();
?>
