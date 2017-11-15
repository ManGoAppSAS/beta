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
?>

<?php
//declaro las variables que pasan por formulario o URL
if(isset($_POST['eliminar'])) $eliminar = $_POST['eliminar']; elseif(isset($_GET['eliminar'])) $eliminar = $_GET['eliminar']; else $eliminar = null;

if(isset($_POST['venta_id'])) $venta_id = $_POST['venta_id']; elseif(isset($_GET['venta_id'])) $venta_id = $_GET['venta_id']; else $venta_id = null;
if(isset($_POST['eliminar_motivo'])) $eliminar_motivo = $_POST['eliminar_motivo']; elseif(isset($_GET['eliminar_motivo'])) $eliminar_motivo = $_GET['eliminar_motivo']; else $eliminar_motivo = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//consulto los datos de la venta
$consulta_venta = $conexion->query("SELECT * FROM ventas_datos WHERE id = '$venta_id' and estado = 'ocupado'");

if ($fila_venta = $consulta_venta->fetch_assoc())
{
    $ubicacion_id = $fila_venta['ubicacion_id'];
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
            <a href="ventas_pagar.php?venta_id=<?php echo "$venta_id";?>#eliminar"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Eliminar venta</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <form action="ventas_ubicaciones.php" method="post">
        <input type="hidden" name="venta_id" value="<?php echo $venta_id; ?>">
        <input type="hidden" name="ubicacion_id" value="<?php echo $ubicacion_id; ?>">
    
        <section class="rdm-tarjeta">

            <div class="rdm-tarjeta--primario-largo">
                <h1 class="rdm-tarjeta--titulo-largo">¿Eliminar venta No <?php echo "$venta_id"; ?>?</h1>
            </div>

            <div class="rdm-tarjeta--cuerpo">
                Se eliminará esta venta, todos los productos o servicios que se hayan agregado a ella y se liberará la ubicación. Esta acción no se puede deshacer
            </div>

            <div class="rdm-formulario" style="border: none; box-shadow: none; padding-top: 0; padding-bottom: 0; ">                
            
                <p><label for="eliminar_motivo">Motivo:</label></p>
                <p><select id="eliminar_motivo" name="eliminar_motivo" required>
                    <option value=""></option>
                    <option value="el cliente canceló el pedido">El cliente canceló el pedido</option>
                    <option value="el cliente no tiene con que pagar">El cliente no tiene con que pagar</option>
                    <option value="error del usuario que hace la atención">Error del usuario que hace la atención</option>
                    <option value="la venta es muy antigua">La venta es muy antigua</option>
                    <option value="órden de administración">Órden de administración</option>
                </select></p>

            </div>

            <div class="rdm-tarjeta--acciones-izquierda">
                <button type="submit" class="rdm-boton--plano-resaltado" name="eliminar_venta" value="si">Eliminar</button> <a href="ventas_pagar.php?venta_id=<?php echo "$venta_id";?>#eliminar"><button type="button" class="rdm-boton--plano" name="cancelar" value="si">Cancelar</button></a>
            </div>

        </section>

    </form>

</main>
    
<footer>    

</footer>

</body>
</html>