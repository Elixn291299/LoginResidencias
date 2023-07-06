<?php
session_start(); // Inicia la sesión al comienzo del archivo
require_once("Conexion.php"); // Incluir el archivo de conexión

try {
    $no_control = isset($_POST['no_control']) ? $_POST['no_control'] : "";
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : "";

    // Verificar si se presionó el botón de inicio de sesión
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Comprobar las credenciales "VINC" y "VERO"
        if ($no_control === "VINC" && $contrasena === "VERO") {
            $_SESSION['loggedin'] = true;
            header("Location: index.php");
            exit();
        } else {
            // Establecer la conexión a la base de datos
            $conn = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT * FROM Clientes WHERE NO_CONTROL = :no_control AND CONTRASEÑA = :contrasena");
            $stmt->bindParam(':no_control', $no_control);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $_SESSION['loggedin'] = true;
                header("Location: https://bit.ly/3FZ8frH");
                exit();
            } else {
                header("Location: login.html");
                exit();
            }
        }
    } else {
        header("Location: login.html");
        exit();
    }
} catch(PDOException $e) {
    //echo "Error de conexión: " . $e->getMessage();
    echo "Error de conexión";
}
?>
