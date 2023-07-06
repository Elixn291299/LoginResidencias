<?php
require('Conexion.php');
$tipo = $_FILES['dataCliente']['type'];
$tamanio = $_FILES['dataCliente']['size'];
$archivotmp = $_FILES['dataCliente']['tmp_name'];

// Verificar el tipo de archivo
if ($tipo !== 'text/csv' && $tipo !== 'application/vnd.ms-excel') {
    header("Location: index.php?error=invalid_file");
    exit();
}

$lineas = file($archivotmp);

$i = 0;
$cant_duplicidad = 0; // Inicializa la variable $cant_duplicidad

foreach ($lineas as $linea) {
    $cantidad_registros = count($lineas);
    $cantidad_regist_agregados = ($cantidad_registros - 1);

    if ($i != 0) {
        $datos = explode(",", $linea);

        $control = !empty($datos[0]) ? ($datos[0]) : '';
        $contraseña = !empty($datos[1]) ? ($datos[1]) : '';
        $nombre = !empty($datos[2]) ? ($datos[2]) : '';
        $correo = !empty($datos[3]) ? ($datos[3]) : '';

        if (!empty($correo)) {
            $checkemail_duplicidad = ("SELECT CORREO FROM clientes WHERE CORREO='" . ($correo) . "' ");
            $ca_dupli = mysqli_query($con, $checkemail_duplicidad);

            if ($ca_dupli !== false) { // Verifica si la consulta se ejecutó correctamente
                $cant_duplicidad = mysqli_num_rows($ca_dupli);
            } else {
                // Manejar el error de consulta aquí
                // Por ejemplo, mostrar un mensaje de error o registrar el error en un archivo de registro
            }
        }

        // No existe Registros Duplicados
        if ($cant_duplicidad == 0) {
            $insertarData = "INSERT INTO clientes( 
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
            mysqli_query($con, $insertarData);
        } else {
            /** Caso Contrario actualizo el o los Registros ya existentes */
            $updateData =  ("UPDATE clientes SET 
                NO_CONTROL='" . $control . "',
                CONTRASEÑA='" . $contraseña . "',
                NOMBRE='" . $nombre . "',
                CORREO='" . $correo . "'  
                WHERE CORREO='" . $correo . "'
            ");
            $result_update = mysqli_query($con, $updateData);
        }
    }

    $i++;
}

mysqli_close($con); // Cerrar la conexión a la base de datos

// Redirigir a index.php después de cargar el archivo
header("Location: index.php");
exit;
?>
