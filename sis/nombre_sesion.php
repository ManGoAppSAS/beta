<?php
//con esto se pueden enviar los headers en cualquier lugar del documento
ob_start();
?>

<?php
//variable de la sesion y la bases de datos
$sesion_y_bd = "beta_bd";

//nombre de la sesion
session_name($sesion_y_bd);

//inicio de sesion
ini_set("session.cookie_lifetime","0");
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