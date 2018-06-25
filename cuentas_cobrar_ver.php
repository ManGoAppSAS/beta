<?php
//inicio y nombre de la sesion
include ("sis/nombre_sesion.php");

//verifico si la sesión está creada y si no lo está lo envio al logueo
if (!isset($_SESSION['correo']))
{
    header("location:logueo.php");
}
?>

<?php
//variables de la sesion
include ("sis/variables_sesion.php");
?>

<?php
//capturo las variables que pasan por URL o formulario
if(isset($_POST['eliminar'])) $eliminar = $_POST['eliminar']; elseif(isset($_GET['eliminar'])) $eliminar = $_GET['eliminar']; else $eliminar = null;
if(isset($_POST['consultaBusqueda'])) $consultaBusqueda = $_POST['consultaBusqueda']; elseif(isset($_GET['consultaBusqueda'])) $consultaBusqueda = $_GET['consultaBusqueda']; else $consultaBusqueda = null;

if(isset($_POST['id'])) $id = $_POST['id']; elseif(isset($_GET['id'])) $id = $_GET['id']; else $id = null;
if(isset($_POST['concepto'])) $concepto = $_POST['concepto']; elseif(isset($_GET['concepto'])) $concepto = $_GET['concepto']; else $concepto = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//elimino el gasto
if ($eliminar == "si")
{
    $borrar = $conexion->query("DELETE FROM gastos WHERE id = '$id'");

    if ($borrar)
    {
        $mensaje = "Gasto eliminado";
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

    <script>
    $(document).ready(function() {
        $("#resultadoBusqueda").html('');
    });

    function buscar() {
        var textoBusqueda = $("input#busqueda").val();
     
         if (textoBusqueda != "") {
            $.post("cuentas_cobrar_buscar.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
                $("#resultadoBusqueda").html(mensaje);
             }); 
         } else { 
            $("#resultadoBusqueda").html('');
            };
    };
    </script>
</head>

<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="index.php#cuentas_cobrar"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Cuentas por cobrar</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto y muestro ventas con saldo pendiente
    $consulta = $conexion->query("SELECT * FROM ventas_datos WHERE estado = 'pendiente' ORDER BY fecha ASC");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">No hay ventas con saldo pendiente</p>
            <p class="rdm-tipografia--cuerpo1--margen-ajustada">Las cuentas por cobrar es el proceso donde se registran los aumentos y las disminuciones derivados de la venta de los productos o servicios.</p>
        </div>

        <?php
    }
    else                 

    {
        ?>

        <input type="search" name="busqueda" id="busqueda" value="<?php echo "$consultaBusqueda"; ?>" placeholder="Buscar" maxlength="30" autofocus autocomplete="off" onKeyUp="buscar();" onFocus="buscar();" />

        <div id="resultadoBusqueda"></div>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc())
        {
            $venta_id = $fila['id'];
            $fecha = date('d/m/Y', strtotime($fila['fecha']));
            $hora = date('h:i a', strtotime($fila['fecha']));
            $venta_consecutivo = $fila['consecutivo'];
            $estado = $fila['estado'];
            $total_neto = $fila['total_neto'];
            $saldo_pendiente = $fila['saldo_pendiente'];
            
            ?>

            <a href="cuentas_cobrar_detalle.php?venta_id=<?php echo "$venta_id"; ?>&venta_consecutivo=<?php echo "$venta_consecutivo"; ?>">

                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <div class="rdm-lista--icono"><i class="zmdi zmdi-case zmdi-hc-2x"></i></div>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo">Venta No <?php echo ucfirst("$venta_consecutivo"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario">A pagar: $ <?php echo number_format($total_neto, 2, ",", "."); ?></h2>
                            <h2 class="rdm-lista--texto-valor">Pendiente: $ <?php echo number_format($saldo_pendiente, 2, ",", "."); ?></h2>
                        </div>
                    </div>
                </article>

            </a>
            
            <?php
        }

        ?>

        </section>

        <?php
    }
    ?>

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