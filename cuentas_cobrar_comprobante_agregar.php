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
include('sis/subir.php');

$carpeta_destino = (isset($_GET['dir']) ? $_GET['dir'] : 'img/avatares');
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $carpeta_destino);
?>

<?php
//capturo las variables que pasan por URL o formulario
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;
if(isset($_POST['archivo'])) $archivo = $_POST['archivo']; elseif(isset($_GET['archivo'])) $archivo = $_GET['archivo']; else $archivo = null;

if(isset($_POST['venta_id'])) $venta_id = $_POST['venta_id']; elseif(isset($_GET['venta_id'])) $venta_id = $_GET['venta_id']; else $venta_id = null;
if(isset($_POST['venta_consecutivo'])) $venta_consecutivo = $_POST['venta_consecutivo']; elseif(isset($_GET['venta_consecutivo'])) $venta_consecutivo = $_GET['venta_consecutivo']; else $venta_consecutivo = null;

if(isset($_POST['concepto'])) $concepto = $_POST['concepto']; elseif(isset($_GET['concepto'])) $concepto = $_GET['concepto']; else $concepto = null;
if(isset($_POST['valor'])) $valor = $_POST['valor']; elseif(isset($_GET['valor'])) $valor = $_GET['valor']; else $valor = null;
if(isset($_POST['local'])) $local = $_POST['local']; elseif(isset($_GET['local'])) $local = $_GET['local']; else $local = 0;
if(isset($_POST['periodicidad'])) $periodicidad = $_POST['periodicidad']; elseif(isset($_GET['periodicidad'])) $periodicidad = $_GET['periodicidad']; else $periodicidad = 0;
if(isset($_POST['observaciones'])) $observaciones = $_POST['observaciones']; elseif(isset($_GET['observaciones'])) $observaciones = $_GET['observaciones']; else $observaciones = null;

if(isset($_POST['fecha'])) $fecha = $_POST['fecha']; elseif(isset($_GET['fecha'])) $fecha = $_GET['fecha']; else $fecha = date('Y-m-d');
if(isset($_POST['hora'])) $hora = $_POST['hora']; elseif(isset($_GET['hora'])) $hora = $_GET['hora']; else $hora = date('H:i');

if(isset($_POST['fecha_pago'])) $fecha_pago = $_POST['fecha_pago']; elseif(isset($_GET['fecha_pago'])) $fecha_pago = $_GET['fecha_pago']; else $fecha_pago = date('Y-m-d');
if(isset($_POST['hora_pago'])) $hora_pago = $_POST['hora_pago']; elseif(isset($_GET['hora_pago'])) $hora_pago = $_GET['hora_pago']; else $hora_pago = date('H:i');

if(isset($_POST['estado'])) $estado = $_POST['estado']; elseif(isset($_GET['estado'])) $estado = $_GET['estado']; else $estado = null;

if(isset($_POST['imagen'])) $imagen = $_POST['imagen']; elseif(isset($_GET['imagen'])) $imagen = $_GET['imagen']; else $imagen = null;
if(isset($_POST['imagen_nombre'])) $imagen_nombre = $_POST['imagen_nombre']; elseif(isset($_GET['imagen_nombre'])) $imagen_nombre = $_GET['imagen_nombre']; else $imagen_nombre = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//actualizo la información del gasto
if ($editar == "si")
{   
    if (!(isset($archivo)) && ($_FILES['archivo']['type'] == "image/jpeg") || ($_FILES['archivo']['type'] == "image/png"))
    {
        $imagen = "si";
        $imagen_nombre = $ahora_img;
        $imagen_ref = "gastos";

        //si han cargado el archivo subimos la imagen
        include('imagenes_subir.php');
    }
    else
    {
        $imagen = $imagen;
        $imagen_nombre = $imagen_nombre;
    }

    $fecha_gasto = date("$fecha $hora:s");
    $valor = str_replace('.','',$valor);

    $actualizar = $conexion->query("UPDATE gastos SET fecha = '$fecha_gasto', usuario = '$sesion_id', tipo = '$tipo', concepto = '$concepto', valor = '$valor', local = '$local', estado = '$estado', fecha_pago = '$fecha_pago', periodicidad = '$periodicidad', imagen = '$imagen', imagen_nombre = '$imagen_nombre' WHERE id = '$id'");

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
            <a href="cuentas_cobrar_detalle.php?venta_id=<?php echo "$venta_id"; ?>&venta_consecutivo=<?php echo "$venta_consecutivo"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Agregar comprobante</h2>
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

    <h2 class="rdm-lista--titulo-largo">Comprobante de ingreso</h2>

    <section class="rdm-formulario">

        <form action="cuentas_cobrar_detalle.php" method="post">
            <input type="hidden" name="venta_id" value="<?php echo "$venta_id"; ?>" />
            <input type="hidden" name="venta_consecutivo" value="<?php echo "$venta_consecutivo"; ?>" />
            <input type="hidden" name="total_neto" value="<?php echo "$total_neto"; ?>" />
            <input type="hidden" name="saldo_pendiente" value="<?php echo "$saldo_pendiente"; ?>" />

            <p class="rdm-formularios--label"><label for="valor">Valor*</label></p>
            <p><input type="tel" id="valor" name="valor" value="<?php echo "$valor"; ?>" spellcheck="false" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Valor a pagar</p>

            <p class="rdm-formularios--label"><label for="tipo_pago">Tipo de pago*</label></p>
            <p><select id="tipo_pago" name="tipo_pago" required>
                <?php
                //consulto y muestro los tipos de pago
                $consulta = $conexion->query("SELECT * FROM tipos_pagos ORDER BY tipo_pago");

                //si solo hay un registro lo muestro por defecto
                 if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $id_tipo = $fila['id'];
                        $tipo_pago = $fila['tipo_pago'];
                        $tipo = $fila['tipo'];
                        ?>

                        <option value="<?php echo "$id_tipo"; ?>"><?php echo ucfirst($tipo_pago) ?> (<?php echo ucfirst($tipo) ?>)</option>

                        <?php
                    }
                }
                else
                {   
                    //si hay mas de un registro los muestro todos menos el local que acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM tipos_pagos ORDER BY tipo_pago");

                    if (!($consulta->num_rows == 0))
                    {
                        ?>
                            
                        <?php echo "$local_g"; ?>

                        <?php
                        while ($fila = $consulta->fetch_assoc()) 
                        {
                            $id_tipo = $fila['id'];
                            $tipo_pago = $fila['tipo_pago'];
                            $tipo = $fila['tipo'];
                            ?>

                            <option value="<?php echo "$id_tipo"; ?>"><?php echo ucfirst($tipo_pago) ?> (<?php echo ucfirst($tipo) ?>)</option>

                            <?php
                        }
                    }
                    else
                    {
                        ?>

                        <option value="">No se han agregado tipos de pago</option>

                        <?php
                    }
                }
                ?>
            </select></p>
            <p class="rdm-formularios--ayuda">Selecciona un tipo de pago</p>  

            <p class="rdm-formularios--label"><label for="concepto">Concepto*</label></p>
            <p><input type="text" id="concepto" name="concepto" value="<?php echo "$concepto"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Concepto del comprobante</p>

            <p class="rdm-formularios--label"><label for="observaciones">Observaciones</label></p>
            <p><textarea id="observaciones" name="observaciones"><?php echo "$observaciones"; ?></textarea></p>
            <p class="rdm-formularios--ayuda">Escribe observaciones para el comprobante</p>

                      
            
            <button type="submit" class="rdm-boton--fab" name="agregar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>
        </form>

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
    
    

</footer>

</body>
</html>