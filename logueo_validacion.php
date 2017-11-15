<?php
//nombre de la sesion, inicio de la sesión y conexion con la base de datos
include ("sis/nombre_sesion.php");

//capturo las variables que vienen desde el formulario de logueo
$correo = $_POST['correo'];
$contrasena_enviada = $_POST['contrasena'];

//consulto si el correo se encuentra en la tabla usuarios
$consulta = $conexion->query("SELECT * FROM usuarios WHERE correo = '$correo'");

if ($fila = $consulta->fetch_assoc())
{
	$contrasena = $fila['contrasena'];

	//si la contraseña enviada es igual a la guardada en la base de datos
	if ($contrasena == $contrasena_enviada)
	{
		$_SESSION['id'] = $fila['id'];
		$_SESSION['correo'] = $fila['correo'];
		$_SESSION['tipo'] = $fila['tipo'];

		if ((($_SESSION['tipo'] == "barbero") or ($_SESSION['tipo'] == "estilista") or ($_SESSION['tipo'] == "mesero")) or ($_SESSION['tipo'] == "manicurista"))
		{
			header("location:ventas_ubicaciones.php");
		}
		else
		{
			header("location:index.php");
		}		
	}
	else
	{
		header("location:logueo.php?men=2&correo=$correo");
	}
}
else
{
	header("location:logueo.php?men=1&correo=$correo");
}
?>