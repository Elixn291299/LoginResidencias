<?php
//header("Content-Type: text/html;charset=utf-8");
$usuario  = "9sd0ezf2no8g3jd9obl2";
$password = "pscale_pw_aVD9l51sFaVJCnAatFEa20btzJctNIpNxqwkMxMrp6m";
$servidor = "aws.connect.psdb.cloud";
$basededatos = "practicas";
$con = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor");
mysqli_query($con,"SET SESSION collation_connection ='utf8_unicode_ci'");
$db = mysqli_select_db($con, $basededatos) or die("Upps! Error en conectar a la Base de Datos");

?>
