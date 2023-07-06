<?php
include('Conexion.php');

if (isset($_POST['borrar'])) {
    $sqlBorrar = "DELETE FROM Clientes WHERE id > 1";
    mysqli_query($con, $sqlBorrar);
    mysqli_close($con);
    header("Location: index.php");
    exit();
}
?>
