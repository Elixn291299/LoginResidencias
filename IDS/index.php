<?php
session_start(); // Iniciar sesión al comienzo del archivo

if (!isset($_SESSION['loggedin'])) {
  header("Location: login.html");
  exit();
}

header("Content-Type: text/html;charset=utf-8");
include('Conexion.php');

if (isset($_GET['error'])) {
    if ($_GET['error'] == "invalid_file") {
        $errorMessage = "ARCHIVO NO ADMITIDO";
    }
}

$searchResult = [];

if (isset($_POST['buscar'])) {
    $search = isset($_POST['busqueda']) ? $_POST['busqueda'] : "";
    if (!empty($search)) {
        $searchQuery = "SELECT * FROM Clientes WHERE NO_CONTROL = '$search'";
        $searchResult = mysqli_query($con, $searchQuery);
    }
}

$sqlClientes = "SELECT * FROM Clientes ORDER BY id ASC";
$queryData = mysqli_query($con, $sqlClientes);
$total_client = mysqli_num_rows($queryData);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="shortcut icon" href="img/logo-mywebsite-urian-viera.svg"/>
    <title>ACTUALIZAR DATOS DE RESIDENTES</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="css/cargando.css">
    <link rel="stylesheet" type="text/css" href="css/cssGenerales.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">


</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-dark fixed-top" style="background-color: #1B396A !important;">
    <ul class="navbar-nav mr-auto collapse navbar-collapse">
        <li class="nav-item active">
            <a href="logout.php"> 
                <img src="IMG/cerrar-sesion.png" width="40">
            </a>
            <h5 class="navbar-brand">CERRAR SESIÓN</h5>
        </li>
    </ul>
    <div class="my-2 my-lg-0">
        <img src="IMG/Logos.jpg" alt="Logos" style="height: 50px; margin-right: 240px;">
        <h5 class="navbar-brand">ACTUALIZAR DATOS</h5>
    </div>
</nav>

<div class="container">
    <h3 class="text-center">ACTUALIZAR</h3>
    <hr>
    <br><br>

    <div class="row">
        <div class="col-md-7" style="margin-right: 240px;">
            <form action="recibe_excel_validando.php" method="POST" enctype="multipart/form-data">
                <div class="file-input text-center" style="margin-right: -425px;">
                    <input type="file" name="dataCliente" id="file-input" class="file-input__input" required/>
                    <label class="file-input__label" for="file-input">
                        <i class="zmdi zmdi-upload zmdi-hc-2x"></i>
                        <span>Elegir Archivo Excel</span>
                    </label>
                </div>
                <div>
                <div class="text-center mt-3" style="margin-right: 240px;">
                    <span id="file-name"></span>
                </div>
                <div class="text-center mt-5" style="margin-left: 430px;">
                    <input type="submit" name="subir" class="btn-enviar" value="Subir Excel"/>
                </div>
            </form>

            <div class="text-center mt-3" style="margin-right: -430px;">
                <form action="borrar_datos.php" method="POST">
                    <input type="submit" name="borrar" class="btn btn-danger" value="Eliminar Datos">
                </form>
            </div>

            <?php
            if (isset($errorMessage)) {
                echo '<div class="text-center mt-3">';
                echo '<span class="text-danger">' . htmlspecialchars($errorMessage) . '</span>';
                echo '</div>';
            }
            ?>

            <div class="text-center mt-5" style="margin-right: -450px;">
                <form action="" method="POST">
                    <input type="text" name="busqueda" placeholder="Buscar por N.Control">
                    <input type="submit" name="buscar" class="btn btn-danger" value="Buscar">
                </form>
            </div>

            <div class="text-center" style="margin-right: -400px">
    <?php
    if (!empty($searchResult)) {
        echo '<h6 class="mt-4">RESULTADOS DE BÚSQUEDA</h6>';
        echo '<table class="table table-bordered table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>#</th>';
        echo '<th>No_Control</th>';
        echo '<th>Contraseñas</th>';
        echo '<th>Nombre</th>';
        echo '<th>Correo</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        $i = 1;
        while ($data = mysqli_fetch_array($searchResult)) {
            echo '<tr>';
            echo '<th scope="row">' . htmlspecialchars($i++) . '</th>';
            echo '<td>' . htmlspecialchars($data['NO_CONTROL']) . '</td>';
            echo '<td>' . htmlspecialchars($data['CONTRASEÑA']) . '</td>';
            echo '<td>' . htmlspecialchars($data['NOMBRE']) . '</td>';
            echo '<td>' . htmlspecialchars($data['CORREO']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
    ?>
</div>

        </div>

        <div class="col-md-5" style="margin-left: 250px;">
            <h6 class="text-center">
                RESIDENTES (<strong><?php echo htmlspecialchars($total_client); ?></strong>)
            </h6>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No_Control</th>
                        <th>Contraseñas</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    while ($data = mysqli_fetch_array($queryData)) { ?>
                        <tr>
                            <th scope="row"><?php echo htmlspecialchars($i++); ?></th>
                            <td><?php echo htmlspecialchars($data['NO_CONTROL']); ?></td>
                            <td><?php echo htmlspecialchars($data['CONTRASEÑA']); ?></td>
                            <td><?php echo htmlspecialchars($data['NOMBRE']); ?></td>
                            <td><?php echo htmlspecialchars($data['CORREO']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="jsjquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(window).on("load", function() {
            $(".cargando").fadeOut(1000);
        });

        // Mostrar el nombre completo del archivo seleccionado
        $("#file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $("#file-name").text("Archivo seleccionado: " + fileName);
        });
    });
</script>

</body>
</html>
