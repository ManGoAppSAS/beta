<?php
//con esto se pueden enviar los headers en cualquier lugar del documento
ob_start();
?>

<?php
//variable de la sesion y la bases de datos
$sesion_y_bd = "sab";

//nombre de la sesion
session_name($sesion_y_bd);

//inicio de sesion
include ("tiempo_sesion.php");
session_start();
//conexión con la base de datos
//$conexion_host = "localhost";
//$conexion_user = "mangoapp_root";
//$conexion_pass = "8359856";
//$conexion_bd = $sesion_y_bd;
//fin de la conexión con la base de datos

//conexion local
$conexion_host = "localhost";
$conexion_user = "root";
$conexion_pass = "";
$conexion_bd = $sesion_y_bd;
//fin de la conexión local

$conexion = new mysqli($conexion_host, $conexion_user, $conexion_pass, $conexion_bd);
?>

<?php
//conexión con la base de datos administrativa
//$conexion2_host = "localhost";
//$conexion2_user = "mangoapp_root";
//$conexion_pass = "8359856";
//$conexion2_bd = "administrativo";
//fin de la conexión con la base de datos

//conexion local
$conexion2_host = "localhost";
$conexion2_user = "root";
$conexion2_pass = "";
$conexion2_bd = "administrativo";
//fin de la conexión local

$conexion2 = new mysqli($conexion2_host, $conexion2_user, $conexion2_pass, $conexion2_bd);
?>