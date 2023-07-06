<?php
require('Conexion.php');
$tipo = $_FILES['dataCliente']['type'];
$tamanio = $_FILES['dataCliente']['size'];
$archivotmp = $_FILES['dataCliente']['tmp_name'];
$lineas = file($archivotmp);

$i = 0;

foreach ($lineas as $linea) {
    $cantidad_registros = count($lineas);
    $cantidad_regist_agregados = ($cantidad_registros - 1);

    if ($i != 0) {
        $datos = explode(",", $linea);

        $control = !empty($datos[0]) ? ($datos[0]) : '';
        $contraseña = !empty($datos[1]) ? ($datos[1]) : '';
        $nombre = !empty($datos[2]) ? ($datos[2]) : '';
        $correo = !empty($datos[3]) ? ($datos[3]) : '';

        $insertar = "INSERT INTO clientes( 
            NO_CONTROL,
            CONTRASEÑA,
            NOMBRE,
            CORREO
        ) VALUES(
            '$control',
            '$contraseña',
            '$nombre',
            '$correo'
        )";
        mysqli_query($con, $insertar);
    }

    echo '<div>' . $i . "). " . $linea . '</div>';
    $i++;
}

echo '<p style="text-align: center; color: #333;">Total de Registros: ' . $cantidad_regist_agregados . '</p>';

mysqli_close($con); // Cerrar la conexión a la base de datos

// Redirigir a index.php después de que se haya subido el archivo
header("Location: index.php");
exit();
?>
