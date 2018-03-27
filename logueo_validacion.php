<?php
//nombre de la sesion, inicio de la sesión y conexion con la base de datos
include ("sis/nombre_sesion.php");

//funcion de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

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
		$nombres = $fila['nombres'];
		$apellidos = $fila['apellidos'];
		$tipo = $fila['tipo'];
		$local = $fila['local'];

		//consulto el local
        $consulta_local = $conexion->query("SELECT * FROM locales WHERE id = '$local'");           

        if ($fila = $consulta_local->fetch_assoc()) 
        {
            $local = $fila['local'];
        }
        else
        {
            $local = "No se ha asignado un local";
        }		

		//si es solicitado envio el correo
		date_default_timezone_set('America/Bogota');
		$ahora = date("Y-m-d H:i:s");
		
	    $mail = new PHPMailer(true);
	    try {
	        //configuracion del servidor que envia el correo
	        $mail->SMTPDebug = 0;
	        $mail->isSMTP();
	        $mail->Host = 'mangoapp.co;mail.mangoapp.co';
	        $mail->SMTPAuth = true;
	        $mail->Username = 'notificaciones@mangoapp.co';
	        $mail->Password = 'renacimiento';
	        $mail->SMTPSecure = 'ssl';
	        $mail->Port = 465;

	        //Enviado por
	        $mail->setFrom('notificaciones@mangoapp.co', ucfirst($local));

	        //Destinatario
	        $mail->addAddress('dannyws@gmail.com');

	        //Responder a
	        $mail->addReplyTo('notificaciones@mangoapp.co', 'ManGo! App');

	        //Contenido del correo
	        $mail->isHTML(true);

	        //Asunto
	        $asunto = ucfirst($nombres) . " " . ucfirst($apellidos) . " ha iniciado sesion ";

	        //Cuerpo
	        $cuerpo = "<b>Usuario</b>: " . ucfirst($nombres) . " " . ucfirst($apellidos) . "</div><br>";
	        $cuerpo .= "<b>Tipo</b>: " . ucfirst($tipo) . "</div><br>";
	        $cuerpo .= "<b>Local</b>: " . ucfirst($local) . "</div><br>";
	        $cuerpo .= "<b>Fecha</b>: " . ucfirst($ahora) . "</div><br>";

	        //asigno asunto y cuerpo a las variables de la funcion
	        $mail->Subject = $asunto;
	        $mail->Body    = $cuerpo;

	        // Activo condificacción utf-8
			$mail->CharSet = 'UTF-8';

	        //ejecuto la funcion y envio el correo
	        $mail->send();
	    
	    }
	    catch (Exception $e)
	    {
	        echo 'Mensaje no pudo ser enviado: ', $mail->ErrorInfo;
	    }
		
		header("location:index.php");
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