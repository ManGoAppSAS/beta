<?php
//nombre de la sesion, inicio de la sesión y conexion con la base de datos
include ("sis/nombre_sesion.php");

//verifico si la sesión está creada y si no lo está lo envio al logueo
if (!isset($_SESSION['correo']))
{
    header("location:logueo.php");
}
?>

<?php
//variables de la conexion, sesion y subida
include ("sis/variables_sesion.php");
include('sis/subir.php');

$carpeta_destino = (isset($_GET['dir']) ? $_GET['dir'] : 'img/avatares');
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $carpeta_destino);
?>

<?php
//capturo las variables que pasan por URL o formulario
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;
if(isset($_POST['archivo'])) $archivo = $_POST['archivo']; elseif(isset($_GET['archivo'])) $archivo = $_GET['archivo']; else $archivo = null;

if(isset($_POST['id'])) $id = $_POST['id']; elseif(isset($_GET['id'])) $id = $_GET['id']; else $id = null;
if(isset($_POST['correo'])) $correo = $_POST['correo']; elseif(isset($_GET['correo'])) $correo = $_GET['correo']; else $correo = null;
if(isset($_POST['contrasena'])) $contrasena = $_POST['contrasena']; elseif(isset($_GET['contrasena'])) $contrasena = $_GET['contrasena']; else $contrasena = null;
if(isset($_POST['nombres'])) $nombres = $_POST['nombres']; elseif(isset($_GET['nombres'])) $nombres = $_GET['nombres']; else $nombres = null;
if(isset($_POST['apellidos'])) $apellidos = $_POST['apellidos']; elseif(isset($_GET['apellidos'])) $apellidos = $_GET['apellidos']; else $apellidos = null;
if(isset($_POST['tipo'])) $tipo = $_POST['tipo']; elseif(isset($_GET['tipo'])) $tipo = $_GET['tipo']; else $tipo = null;
if(isset($_POST['local'])) $local = $_POST['local']; elseif(isset($_GET['local'])) $local = $_GET['local']; else $local = null;
if(isset($_POST['imagen'])) $imagen = $_POST['imagen']; elseif(isset($_GET['imagen'])) $imagen = $_GET['imagen']; else $imagen = null;
if(isset($_POST['imagen_nombre'])) $imagen_nombre = $_POST['imagen_nombre']; elseif(isset($_GET['imagen_nombre'])) $imagen_nombre = $_GET['imagen_nombre']; else $imagen_nombre = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//actualizo la información del usuario
if ($editar == "si")
{
    if (!(isset($archivo)) && ($_FILES['archivo']['type'] == "image/jpeg") || ($_FILES['archivo']['type'] == "image/png"))
    {
        $imagen = "si";
        $imagen_nombre = $ahora_img;
        $imagen_ref = "usuarios";

        //si han cargado el archivo subimos la imagen
        include('imagenes_subir.php');
    }
    else
    {
        $imagen = $imagen;
        $imagen_nombre = $imagen_nombre;
    }

    $actualizar = $conexion->query("UPDATE usuarios SET fecha = '$ahora', usuario = '$sesion_id', correo = '$correo', contrasena = '$contrasena', nombres = '$nombres', apellidos = '$apellidos', tipo = '$tipo', local = '$local', imagen = '$imagen', imagen_nombre = '$imagen_nombre' WHERE id = '$id'");

    if ($actualizar)
    {
        $mensaje = "Cambios guardados";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";
    }     
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>ManGo!</title>    
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>
</head>
<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="ajustes.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Pagar</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    
    <form id="frm_botonePayco" name="frm_botonePayco" method="post" action="https://secure.payco.co/checkout.php"> 
        <input name="p_cust_id_cliente" type="hidden" value="20268">
        <input name="p_key" type="hidden" value="eccc90f9dac5152167a2f9ca3ed1e61d9408d7b3">
        <input name="p_id_invoice" type="hidden" value="">
        <input name="p_description" type="hidden" value="Servicio ManGo! App Mayo">
        <input name="p_currency_code" type="hidden" value="COP">
        <input name="p_amount" id="p_amount" type="hidden" value="71400.00">
        <input name="p_tax" id="p_tax" type="hidden" value="11400">
        <input name="p_amount_base" id="p_amount_base" type="hidden" value="60000">
        <input name="p_test_request" type="hidden" value="FALSE">
        <input name="p_url_response" type="hidden" value="http://www.mangoapp.co/pago_respuesta.php"> 
        <input name="p_url_confirmation" type="hidden" value="http://www.mangoapp.co/pago_confirmacion.php"> 
        <input name="p_signature" type="hidden" id="signature"  value="aefe6d74000d4f4de84d5b375827aa7b" />
        <input name="idboton"type="hidden" id="idboton"  value="4901" /> 




        

        <section class="rdm-tarjeta">

            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">Hacer mi pago</h1>
            </div>

            <div class="rdm-tarjeta--cuerpo">
                Acá puedes realizar el pago de tu servicio ManGo! App.
            </div>
            
            <div class="rdm-tarjeta--acciones-izquierda">
                <button type="submit" class="rdm-boton--plano-resaltado" name="eliminar_venta" value="si">Pagar</button>
            </div>

        </section>




    </form>
















</main>

<div id="rdm-snackbar--contenedor">
    <div class="rdm-snackbar--fila">
        <div class="rdm-snackbar--primario-<?php echo $mensaje_tema; ?>">
            <h2 class="rdm-snackbar--titulo"><?php echo "$mensaje"; ?></h2>
        </div>
    </div>
</div>

<footer>
    
    

</footer>

</body>
</html>