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
//variables de la conexion, sesion y subida
include ("sis/variables_sesion.php");
?>

<?php
//capturo las variables que pasan por URL o formulario
if(isset($_POST['agregar'])) $agregar = $_POST['agregar']; elseif(isset($_GET['agregar'])) $agregar = $_GET['agregar']; else $agregar = null;

if(isset($_POST['venta_id'])) $venta_id = $_POST['venta_id']; elseif(isset($_GET['venta_id'])) $venta_id = $_GET['venta_id']; else $venta_id = null;
if(isset($_POST['venta_consecutivo'])) $venta_consecutivo = $_POST['venta_consecutivo']; elseif(isset($_GET['venta_consecutivo'])) $venta_consecutivo = $_GET['venta_consecutivo']; else $venta_consecutivo = null;

if(isset($_POST['valor'])) $valor = $_POST['valor']; elseif(isset($_GET['valor'])) $valor = $_GET['valor']; else $valor = null;
if(isset($_POST['concepto'])) $concepto = $_POST['concepto']; elseif(isset($_GET['concepto'])) $concepto = $_GET['concepto']; else $concepto = null;
if(isset($_POST['tipo_pago'])) $tipo_pago = $_POST['tipo_pago']; elseif(isset($_GET['tipo_pago'])) $tipo_pago = $_GET['tipo_pago']; else $tipo_pago = null;


if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//agrego el comprobante de ingreso
if ($agregar == "si")
{   
    $insercion_comprobante = $conexion->query("INSERT INTO comprobantes_ingreso values ('', '$ahora', '$sesion_id', '$venta_id', '$valor', '')");

    if ($insercion_comprobante)
    {
        $mensaje = "Comprobante agregado";
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
            <a href="cuentas_cobrar_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Venta No <?php echo ucfirst("$venta_consecutivo"); ?></h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">
            
    <?php
    //consulto y muestro la venta
    $consulta = $conexion->query("SELECT * FROM ventas_datos WHERE id = '$venta_id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Esta venta no tiene cuentas por cobrar</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $venta_id = $fila['id'];
            $fecha = date('d/m/Y', strtotime($fila['fecha']));
            $hora = date('h:i a', strtotime($fila['fecha']));
            $usuario = $fila['usuario_id'];
            $venta_consecutivo = $fila['consecutivo'];
            $estado = $fila['estado'];
            $total_neto = $fila['total_neto'];
            $saldo_pendiente = $fila['saldo_pendiente'];

            //consulto el usuario que realizo la ultima modificacion
            $consulta_usuario = $conexion->query("SELECT * FROM usuarios WHERE id = '$usuario'");           

            if ($fila = $consulta_usuario->fetch_assoc()) 
            {
                $usuario = $fila['correo'];
            }
            ?>

            <section class="rdm-tarjeta">

                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo">Pendiente: $ <?php echo number_format($saldo_pendiente, 2, ",", "."); ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo">A pagar: $ <?php echo number_format($total_neto, 2, ",", "."); ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">
                    <p><b>Fecha de venta</b> <br><?php echo ucfirst("$fecha"); ?> - <?php echo ucfirst("$hora"); ?></p>
                    <p><b>Vendido por</b> <br><?php echo ("$usuario"); ?></p>
                </div>

            </section>
            
            <?php
        }
    }
    ?>    

    <h2 class="rdm-lista--titulo-largo">Comprobantes de ingreso</h2>

    <section class="rdm-lista">

        <?php
        //consulto y muestro los productos
        $consulta = $conexion->query("SELECT * FROM comprobantes_ingreso WHERE venta_id = '$venta_id' ORDER BY fecha");

        if ($consulta->num_rows == 0)
        {
            ?>

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-long-arrow-down zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Vacio</h2>

                    </div>
                </div>
            </article>

            <?php
        }
        else
        {
            while ($fila = $consulta->fetch_assoc())
            {
                $comprobante_id = $fila['id'];
                $fecha = date('Y/m/d', strtotime($fila['fecha']));
                $hora = date('h:i a', strtotime($fila['fecha']));
                $valor = $fila['valor'];
                $consecutivo = $fila['consecutivo'];
              
                ?>

                <article class="rdm-lista--item-sencillo">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <div class="rdm-lista--icono"><i class="zmdi zmdi-long-arrow-down zmdi-hc-2x"></i></div>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst("$fecha"); ?></h2>
                            <h2 class="rdm-lista--texto-valor">$ <?php echo number_format($valor, 2, ",", "."); ?></h2>
                        </div>
                    </div>
                </article>
                
                <?php
            }
        }
        ?>

    </section>

    

</main>

<div id="rdm-snackbar--contenedor">
    <div class="rdm-snackbar--fila">
        <div class="rdm-snackbar--primario-<?php echo $mensaje_tema; ?>">
            <h2 class="rdm-snackbar--titulo"><?php echo "$mensaje"; ?></h2>
        </div>
    </div>
</div>

<footer>
    
    <a href="cuentas_cobrar_comprobante_agregar.php?venta_id=<?php echo "$venta_id"; ?>&venta_consecutivo=<?php echo "$venta_consecutivo"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-plus zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>