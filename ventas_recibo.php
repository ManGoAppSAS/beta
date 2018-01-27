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
//capturo las variables que pasan por URL o formulario
if(isset($_POST['pagar'])) $pagar = $_POST['pagar']; elseif(isset($_GET['pagar'])) $pagar = $_GET['pagar']; else $pagar = null;

if(isset($_POST['venta_id'])) $venta_id = $_POST['venta_id']; elseif(isset($_GET['venta_id'])) $venta_id = $_GET['venta_id']; else $venta_id = null;
if(isset($_POST['venta_total_bruto'])) $venta_total_bruto = $_POST['venta_total_bruto']; elseif(isset($_GET['venta_total_bruto'])) $venta_total_bruto = $_GET['venta_total_bruto']; else $venta_total_bruto = null;
if(isset($_POST['descuento_valor'])) $descuento_valor = $_POST['descuento_valor']; elseif(isset($_GET['descuento_valor'])) $descuento_valor = $_GET['descuento_valor']; else $descuento_valor = null;
if(isset($_POST['venta_total_neto'])) $venta_total_neto = $_POST['venta_total_neto']; elseif(isset($_GET['venta_total_neto'])) $venta_total_neto = $_GET['venta_total_neto']; else $venta_total_neto = null;
if(isset($_POST['tipo_pago'])) $tipo_pago = $_POST['tipo_pago']; elseif(isset($_GET['tipo_pago'])) $tipo_pago = $_GET['tipo_pago']; else $tipo_pago = null;
if(isset($_POST['ubicacion_id'])) $ubicacion_id = $_POST['ubicacion_id']; elseif(isset($_GET['ubicacion_id'])) $ubicacion_id = $_GET['ubicacion_id']; else $ubicacion_id = null;
if(isset($_POST['dinero'])) $dinero = $_POST['dinero']; elseif(isset($_GET['dinero'])) $dinero = $_GET['dinero']; else $dinero = null;
if(isset($_POST['enviar_correo'])) $enviar_correo = $_POST['enviar_correo']; elseif(isset($_GET['enviar_correo'])) $enviar_correo = $_GET['enviar_correo']; else $enviar_correo = null;
if(isset($_POST['correo'])) $correo = $_POST['correo']; elseif(isset($_GET['correo'])) $correo = $_GET['correo']; else $correo = null;
if(isset($_POST['correo_cliente'])) $correo_cliente = $_POST['correo_cliente']; elseif(isset($_GET['correo_cliente'])) $correo_cliente = $_GET['correo_cliente']; else $correo_cliente = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//si la venta ya fue liquidada redirecciona a una nueva venta
$consulta_venta = $conexion->query("SELECT * FROM ventas_datos WHERE id = '$venta_id' and estado = 'ocupado'");

if ($consulta_venta->num_rows == 0)
{
    //header("location:ventas_ubicaciones.php");
    $descontar_inventario = "no";
    $liquidar_venta = "no";
}
else
{
    $descontar_inventario = "si";
    $liquidar_venta = "si";
}
?>



<?php
//liquido la venta
if (($pagar == "si") and ($liquidar_venta == "si"))
{
    $actualizar = $conexion->query("UPDATE ventas_datos SET fecha_cierre = '$ahora', estado = 'liquidado', total_bruto = '$venta_total_bruto', descuento_valor = '$descuento_valor', total_neto = '$venta_total_neto', eliminar_motivo = 'no aplica' WHERE id = '$venta_id'");
    
    $actualizar = $conexion->query("UPDATE ubicaciones SET estado = 'libre' WHERE id = '$ubicacion_id'");
    
    $actualizar = $conexion->query("UPDATE ventas_productos SET estado = 'liquidado' WHERE venta_id = '$venta_id'");

    $mensaje = "Venta No <b>$venta_id</b> liquidada y guardada";
    $body_snack = 'onLoad="Snackbar()"';
    $mensaje_tema = "aviso";
}
?>

<?php
//consulto los datos de la venta
$dinero = str_replace('.','',$dinero);

//datos de la venta
        include ("sis/ventas_datos.php");
?>

















<?php
//consulto los datos de la plantilla de la factura
$consulta_plantilla = $conexion->query("SELECT * FROM facturas_plantillas WHERE local = '$sesion_local_id'");

if ($consulta_plantilla->num_rows == 0)
{
    $consulta_generica = $conexion->query("SELECT * FROM facturas_plantillas WHERE local = 0");

    if ($consulta_generica->num_rows == 0)
    {
        $plantilla_titulo = "Factura / Recibo";
        $plantilla_texto_superior = "";
        $plantilla_texto_inferior = "";
    }
    else
    {
        while ($fila_generica = $consulta_generica->fetch_assoc())
        {
            $plantilla_titulo = $fila_generica['titulo'];
            $plantilla_texto_superior = $fila_generica['texto_superior'];
            $plantilla_texto_inferior = $fila_generica['texto_inferior'];
        }
    }

        
}
else
{
    while ($fila_plantilla = $consulta_plantilla->fetch_assoc())
    {
        $plantilla_titulo = $fila_plantilla['titulo'];
        $plantilla_texto_superior = $fila_plantilla['texto_superior'];
        $plantilla_texto_inferior = $fila_plantilla['texto_inferior'];
    }
}
?>

<?php
if ($enviar_correo == "si")
{
    if (empty($correo_cliente))
    {
        $correo_cliente = $correo;
    }
    else
    {
        $correo_cliente = $correo_cliente;
    }
    
    //envio el correo electronico al cliente y el ejecutivo
    $destinatario = $correo; 
    $asunto = "Recibo de venta No "; 
    $asunto .= $venta_id;
    $asunto .= " por $";
    $asunto .= number_format($total_neto, 0, ",", ".");
    
    $cuerpo = ' 
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <title>Correo</title>
        <meta charset="utf-8" />        
    </head>
    <body style="background: #fff; 
                color: #333;
                font-size: 13px;
                font-weight: 300;">';

    




    $cuerpo .= '<section class="rdm-factura--imprimir" style="background-color: #fff; border: 1px solid #999; box-sizing: border-box; margin: 0 auto; margin-bottom: 1em;
    width: 100%;
    max-width: 400px;
    padding: 1.25em 0em;
    font-size: 0.9em;
    font-weight: 400;
    letter-spacing: 0.04em;
    line-height: 1.75em;
    box-shadow: none;">

                    
                    <article class="rdm-factura--contenedor--imprimir" style="width: 90%; margin: 0px auto;">

                        <div class="rdm-factura--texto" style="text-align: center;width: 100%;">
                            <h3>' .  nl2br($plantilla_titulo) . '</h3>
                            <h3>' .  nl2br($plantilla_texto_superior) . '</h3>
                            <h3>' . ucfirst($sesion_local) . '<br>
                            ' . ucfirst($sesion_local_direccion) . '<br>
                            ' . ucfirst($sesion_local_telefono) . '</h3>
                        </div>

                        <div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 49%;"><b>Venta No ' . $venta_id . '</b></div>
                        <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 49%;">' . $fecha . ' ' . $hora . '</div>

                        <div class="rdm-factura--texto" style="text-align: center; width: 100%;">        
                            <p>' . ucwords($ubicacion_texto) . '<br>
                            ' . ($atendido_texto) . '</p>
                        </div>';

                        

                            //consulto y muestro los productos agregados a la venta
                            $consulta = $conexion->query("SELECT distinct producto_id FROM ventas_productos WHERE venta_id = '$venta_id' ORDER BY fecha DESC");

                            if ($consulta->num_rows == 0)
                            {
                                ?>

                                <p>No se han agregado productos a esta venta</p>

                                <?php
                            }
                            else
                            {
                                $cuerpo .= '<p class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;"><b>Descripción</b></p>
                                            <p class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;"><b>Valor</b></p>';

                                $impuesto_base_total = 0;
                                $impuesto_valor_total = 0;
                                $precio_neto_total = 0;

                                while ($fila = $consulta->fetch_assoc())
                                {   
                                    $producto_id = $fila['producto_id'];

                                    //consulto la información del producto
                                    $consulta_producto = $conexion->query("SELECT * FROM ventas_productos WHERE producto_id = '$producto_id' and venta_id = '$venta_id' ORDER BY fecha DESC");

                                    $impuesto_base_subtotal = 0;
                                    $impuesto_valor_subtotal = 0;
                                    $precio_neto_subtotal = 0;

                                    while ($fila_producto = $consulta_producto->fetch_assoc())
                                    {
                                        $producto_venta_id = $fila_producto['id'];
                                        $producto = $fila_producto['producto'];
                                        $producto_id = $fila_producto['producto_id'];
                                        $categoria = $fila_producto['categoria'];
                                        $precio_final = $fila_producto['precio_final'];
                                        $porcentaje_impuesto = $fila_producto['porcentaje_impuesto'];

                                        //consulto los datos del producto
                                        $consulta_pro_dat = $conexion->query("SELECT * FROM productos WHERE id = '$producto_id'");

                                        while ($fila_pro_dat = $consulta_pro_dat->fetch_assoc())
                                        {
                                            $precio = $fila_pro_dat['precio'];
                                            $impuesto_id = $fila_pro_dat['impuesto_id'];
                                            $impuesto_incluido = $fila_pro_dat['impuesto_incluido'];

                                            //consulto el impuesto
                                            $consulta_impuesto = $conexion->query("SELECT * FROM impuestos WHERE id = '$impuesto_id'");           

                                            if ($fila_impuesto = $consulta_impuesto->fetch_assoc()) 
                                            {
                                                $impuesto = $fila_impuesto['impuesto'];
                                                $impuesto_porcentaje = $fila_impuesto['porcentaje'];
                                            }
                                            else
                                            {
                                                $impuesto = "No se ha asignado un impuesto";
                                                $impuesto_porcentaje = 0;
                                            }

                                            //calculo el valor del precio bruto y el precio neto
                                            $impuesto_valor = $precio * ($impuesto_porcentaje / 100);

                                            if ($impuesto_incluido == "no")
                                            {
                                               $precio_bruto = $precio;
                                            }
                                            else
                                            {
                                               $precio_bruto = $precio - $impuesto_valor;
                                            }

                                            $precio_neto = $precio_bruto + $impuesto_valor;
                                            $impuesto_base = $precio_bruto;
                                        }
                                        
                                        $valor_impuesto = $precio_final * ($porcentaje_impuesto / 100);
                                        $base_impuesto = $precio_final - $valor_impuesto;

                                        $cantidad_producto = $consulta_producto->num_rows; //cantidad
                                        
                                         
                                        $impuesto_porcentaje = $porcentaje_impuesto; //porcentaje del impuesto del producto        
                                        $precio_neto = $precio_final; //precio neto del producto (con impuesto ya incluido)

                                        if ($impuesto_base == $precio_neto)
                                        {
                                            $impuesto_base = $precio_neto;
                                        }
                                        
                                        $impuesto_base_subtotal = $impuesto_base_subtotal + $impuesto_base; //subtotal de la base del impuesto del producto
                                        $impuesto_valor_subtotal = $impuesto_valor_subtotal  + $impuesto_valor; //subtotal del valor del impuesto del producto
                                        $precio_neto_subtotal = $precio_neto_subtotal  + $precio_neto; //subtotal del precio neto del producto                                        
                                    }                                    

                                    $impuesto_base_total = $impuesto_base_total + $impuesto_base_subtotal; //total de la base del impuesto de todos los productos
                                    $impuesto_valor_total = $impuesto_valor_total + $impuesto_valor_subtotal; //total del valor del impuesto de todos los productos
                                    $precio_neto_total = $precio_neto_total  + $precio_neto_subtotal; //total del precio de todos los productos

                                    //valor del descuento
                                    $descuento_valor = (($venta_descuento_porcentaje * $impuesto_base_total) / 100);

                                    //propina
                                    if (($venta_propina >= 0) and ($venta_propina <= 100))
                                    {    
                                        $propina_valor = (($venta_propina * $impuesto_base_total) / 100);
                                    }
                                    else
                                    {
                                        $propina_valor = $venta_propina;
                                    }
                                    
                                    //porcentaja de la propina
                                    $propina_porcentaje = ($propina_valor * 100) / $impuesto_base_total;
                                    
                                    //total de la venta con descuento y propina
                                    $venta_total = $precio_neto_total - $descuento_valor + $propina_valor;

                                    //cambio
                                    if ($dinero == 0)
                                    {
                                        $dinero = $venta_total;
                                    }

                                    $cambio = $dinero - $venta_total; 







                                    











                                    $cuerpo .= '<section class="rdm-factura--item" style="border-bottom: dashed 1px #555; display: block; padding: 0.2em 0em 0em 0em;">

                                                    <div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;"><b>' . ucfirst($producto) . ', ' . ucfirst($categoria) . '</b></div>
                                                    <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;"><b>$ ' . number_format($precio_final, 0, ",", ".") . '</b></div>';

                                    if ($impuesto_valor != 0)
                                    {

                                        $cuerpo .= '<div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;">Base</div>
                                                    <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;">$ ' . number_format($impuesto_base, 0, ",", ".") . '</div>

                                                    <div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;">Impuesto (' .  $porcentaje_impuesto . '%)</div>
                                                    <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;">$ ' .  number_format($impuesto_valor, 0, ",", ".") . '</div>';
                                    }
                                    if ($cantidad_producto != "1")
                                    {
                                        $cuerpo .= '<div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;">Cantidad</div>
                                                    <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;">' .   ucfirst("$cantidad_producto") . '</div>

                                                    <div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;"><b>Subtotal</b></div>
                                                    <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;"><b>$ ' .   number_format($impuesto_base_subtotal, 0, ",", ".") . '</b></div>';
                                    }

                                    $cuerpo .= '</section>';
                                }
                            }

                            $cuerpo .= '<br>
                                        <section class="rdm-factura--item" style="border-bottom: dashed 1px #555; display: block; padding: 0.2em 0em 0em 0em;">';

                            
                                $cuerpo .= '<div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;"><b>Subtotal venta</b></div>
                                            <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;"><b>$ ' . number_format($impuesto_base_total, 0, ",", ".") . '</b></div>';

                                $cuerpo .= '<div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;">Propina ('. $propina_porcentaje . '%)</div>
                                            <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;">$ ' . number_format($propina_valor, 0, ",", ".") . '</div>';                            

                                if ($descuento_valor != 0)
                                {

                                    $cuerpo .= '<div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;">Descuento (-' . number_format($venta_descuento_porcentaje, 0, ",", ".") . '%)</div>
                                                <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;">$ - ' . number_format($descuento_valor, 0, ",", ".") . '</div>';
                                
                                }

                                if ($impuesto_valor_total != 0)
                                {

                                    $cuerpo .= '<div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;">Impuestos</div>
                                                <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;">$ ' .  number_format($impuesto_valor_total, 0, ",", ".") . '</div>';

                                }
                            

                            $cuerpo .= '</section>
                                        <br>';

                            $cuerpo .= '<section class="rdm-factura--item" style="border-bottom: dashed 1px #555; display: block; padding: 0.2em 0em 0em 0em;">
                                            <div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;"><b>TOTAL A PAGAR</b></div>
                                            <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;"><b>$ ' . number_format($venta_total, 0, ",", ".") . '</b></div>
                                        </section>';

                            $cuerpo .= '<br>
                                        <section class="rdm-factura--item" style="border-bottom: dashed 1px #555; display: block; padding: 0.2em 0em 0em 0em;">';

                                $cuerpo .= '<div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;">Tipo de pago</div>
                                            <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;">' .  ucfirst($tipo_pago) . '</div>';

                                $cuerpo .= '<div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;">Dinero recibido</div>
                                            <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;">$ ' . number_format($dinero, 0, ",", ".") . '</div>';
                                            

                                $cuerpo .= '<div class="rdm-factura--izquierda" style="display: inline-block; text-align: left; width: 69%;"><b>Cambio</b></div>
                                            <div class="rdm-factura--derecha" style="display: inline-block; text-align: right; width: 29%;"><b>$ ' . number_format($cambio, 0, ",", ".") . '</b></div>';

                            $cuerpo .= '</section>';                                        

                            $cuerpo .= '<div class="rdm-factura--texto" style="text-align: center; width: 100%;">
                                            <h3>' .  nl2br($plantilla_texto_inferior) . '</h3>
                                        </div>

                                        <div style="border-top: 1px solid #BDBDBD; padding: 0; width: 100%; "></div>

                                        <p>Enviado a ti por tecnología de <b>ManGo! App</b></p>

                                        <p>En <b>ManGo! App</b> queremos un mundo mejor, gracias por usar una factura electrónica. Al no usar papel se evita no solo la tala de árboles, sino también se ahorra en la cantidad de agua necesaria para transformar esa madera en papel.</p>

                                        
                                    </article> 

                                </section>';

    $cuerpo .= '
    </body>
    </html>';

    //para el envío en formato HTML 
    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=utf-8\r\n"; 

    //dirección del remitente 
    $headers .= "From: ". ucfirst($sesion_local). "<no-reply@hostgator.com>\r\n"; 

    //dirección de respuesta, si queremos que sea distinta que la del remitente 
    $headers .= "Reply-To:  ". ucfirst($sesion_local). "<no-reply@hostgator.com>\r\n"; 

    //ruta del mensaje desde origen a destino 
    $headers .= "Return-path:  ". ucfirst($sesion_local). "<info@hostgator.com>\r\n"; 

    /*direcciones que recibián copia 
    $headers .= "Cc: dannyws69@hotmail.com\r\n"; 
    */

    //direcciones que recibirán copia oculta 
    $headers .= "Bcc: maxeventagencia@gmail.com \r\n"; 

    mail($destinatario,$asunto,$cuerpo,$headers);

    $mensaje = "Recibo de venta No <b>$venta_id</b> enviado al correo <b>$correo</b>";
    $body_snack = 'onLoad="Snackbar()"';
    $mensaje_tema = "aviso";
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
            <a href="ventas_ubicaciones.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Venta No <?php echo "$venta_id"; ?> liquidada</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <section class="rdm-tarjeta">

        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">Cambio</h1>
            <h2 class="rdm-tarjeta--dashboard-titulo-positivo">$<?php echo number_format($cambio, 2, ",", "."); ?></h2>
        </div>

        <article class="rdm-lista--item-sencillo">
            <div class="rdm-lista--izquierda-sencillo">
                <div class="rdm-lista--contenedor">
                    <div class="rdm-lista--icono"><i class="zmdi zmdi-inbox zmdi-hc-2x"></i></div>
                </div>
                <div class="rdm-lista--contenedor">
                    <h2 class="rdm-lista--titulo">Dinero recibido</h2>
                    <h2 class="rdm-lista--texto-valor">$<?php echo number_format($dinero, 2, ",", "."); ?></h2>
                </div>
            </div>
        </article>

        <article class="rdm-lista--item-sencillo">
            <div class="rdm-lista--izquierda-sencillo">
                <div class="rdm-lista--contenedor">
                    <div class="rdm-lista--icono"><i class="zmdi zmdi-money zmdi-hc-2x"></i></div>
                </div>
                <div class="rdm-lista--contenedor">
                    <h2 class="rdm-lista--titulo">Total pagado</h2>
                    <h2 class="rdm-lista--texto-valor">$<?php echo number_format($total_neto, 2, ",", "."); ?></h2>
                </div>
            </div>
        </article>



        <div class="rdm-tarjeta--acciones-izquierda">
            <a href="ventas_recibo_imprimir.php?venta_id=<?php echo "$venta_id"; ?>&dinero=<?php echo "$dinero"; ?>&tipo_pago=<?php echo "$tipo_pago"; ?>" target="_blank"><button type="button" class="rdm-boton--plano-resaltado" autofocus>Imprimir recibo</button></a>

            
        </div>

    </section>

    <section class="rdm-formulario">
    
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="venta_id" value="<?php echo "$venta_id";?>" />
            <input type="hidden" name="venta_total_bruto" value="<?php echo "$venta_total_bruto";?>" />
            <input type="hidden" name="descuento_valor" value="<?php echo "$descuento_valor";?>" />
            <input type="hidden" name="venta_total_neto" value="<?php echo "$venta_total_neto";?>" />
            <input type="hidden" name="tipo_pago" value="<?php echo "$tipo_pago";?>" />
            <input type="hidden" name="ubicacion_id" value="<?php echo "$ubicacion_id";?>" />
            <input type="hidden" name="dinero" value="<?php echo "$dinero";?>" />
            
            <p><input class="rdm-formularios--input-grande" type="email" name="correo" placeholder="Correo electrónico" required value="<?php echo "$correo_cliente"; ?>"></p>
            
            <p class="rdm-formularios--submit"><button type="submit" class="rdm-boton--plano-resaltado" name="enviar_correo" value="si">Enviar recibo</button></p>

        </form>

    </section>

    








    

    






        

        
    <h2 class="rdm-lista--titulo-largo">Recibo generado</h2>

    <section class="rdm-factura">

        <article class="rdm-factura--contenedor">

            <div class="rdm-factura--texto">
                <h3><?php echo ucfirst($plantilla_titulo)?></h3>
                <h3><?php echo nl2br($plantilla_texto_superior) ?></h3>
                <h3><?php echo ucfirst($sesion_local)?><br>
                <?php echo ucfirst($sesion_local_direccion)?><br>
                <?php echo ucfirst($sesion_local_telefono)?></h3>
            </div>

            <div class="rdm-factura--izquierda-centro"><b>Venta No <?php echo "$venta_id"; ?></b></div>
            <div class="rdm-factura--derecha-centro"><?php echo "$fecha"; ?> <?php echo "$hora"; ?></div>

            <div class="rdm-factura--texto">
                <p><?php echo ucwords($ubicacion_texto); ?><br>
                <?php echo ($atendido_texto); ?></p>
            </div>
    
    

            <?php
            //consulto y muestro los productos agregados a la venta
            $consulta_pro = $conexion->query("SELECT distinct producto_id FROM ventas_productos WHERE venta_id = '$venta_id' ORDER BY fecha DESC");

            if ($consulta_pro->num_rows == 0)
            {
                ?>

                <p>No se han agregado productos a esta venta</p>

                <?php
            }
            else
            {
                ?>

                <p class="rdm-factura--izquierda"><b>Descripción</b></p>
                <p class="rdm-factura--derecha"><b>Valor</b></p>

                <?php

                $impuesto_base_total = 0;
                $impuesto_valor_total = 0;
                $precio_neto_total = 0;

                while ($fila_pro = $consulta_pro->fetch_assoc())
                {   
                    $producto_id = $fila_pro['producto_id'];

                    //consulto la información del producto
                    $consulta_producto = $conexion->query("SELECT * FROM ventas_productos WHERE producto_id = '$producto_id' and venta_id = '$venta_id' ORDER BY fecha DESC");

                    $impuesto_base_subtotal = 0;
                    $impuesto_valor_subtotal = 0;
                    $precio_neto_subtotal = 0;

                    while ($fila_producto = $consulta_producto->fetch_assoc())
                    {
                        $producto_venta_id = $fila_producto['id'];
                        $producto = $fila_producto['producto'];
                        $producto_id = $fila_producto['producto_id'];
                        $categoria = $fila_producto['categoria'];
                        $precio_final = $fila_producto['precio_final'];
                        $porcentaje_impuesto = $fila_producto['porcentaje_impuesto'];

                        //consulto los datos del producto
                        $consulta_pro_dat = $conexion->query("SELECT * FROM productos WHERE id = '$producto_id'");

                        while ($fila_pro_dat = $consulta_pro_dat->fetch_assoc())
                        {
                            $precio = $fila_pro_dat['precio'];
                            $impuesto_id = $fila_pro_dat['impuesto_id'];
                            $impuesto_incluido = $fila_pro_dat['impuesto_incluido'];

                            //consulto el impuesto
                            $consulta_impuesto = $conexion->query("SELECT * FROM impuestos WHERE id = '$impuesto_id'");           

                            if ($fila_impuesto = $consulta_impuesto->fetch_assoc()) 
                            {
                                $impuesto = $fila_impuesto['impuesto'];
                                $impuesto_porcentaje = $fila_impuesto['porcentaje'];
                            }
                            else
                            {
                                $impuesto = "No se ha asignado un impuesto";
                                $impuesto_porcentaje = 0;
                            }

                            //calculo el valor del precio bruto y el precio neto
                            $impuesto_valor = $precio * ($impuesto_porcentaje / 100);

                            if ($impuesto_incluido == "no")
                            {
                               $precio_bruto = $precio;
                            }
                            else
                            {
                               $precio_bruto = $precio - $impuesto_valor;
                            }

                            $precio_neto = $precio_bruto + $impuesto_valor;
                            $impuesto_base = $precio_bruto;
                        }
                        
                        $valor_impuesto = $precio_final * ($porcentaje_impuesto / 100);
                        $base_impuesto = $precio_final - $valor_impuesto;

                        $cantidad_producto = $consulta_producto->num_rows; //cantidad
                        
                           
                        $impuesto_porcentaje = $porcentaje_impuesto; //porcentaje del impuesto del producto        
                        $precio_neto = $precio_final; //precio neto del producto (con impuesto ya incluido)

                        if ($impuesto_base == $precio_neto)
                        {
                            $impuesto_base = $precio_neto;
                        }
                        
                        $impuesto_base_subtotal = $impuesto_base_subtotal + $impuesto_base; //subtotal de la base del impuesto del producto
                        $impuesto_valor_subtotal = $impuesto_valor_subtotal  + $impuesto_valor; //subtotal del valor del impuesto del producto
                        $precio_neto_subtotal = $precio_neto_subtotal  + $precio_neto; //subtotal del precio neto del producto

                        //composicion de este producto                       
                        $consulta_composicion = $conexion->query("SELECT * FROM composiciones WHERE producto = '$producto_id'");

                        if ($consulta_composicion->num_rows == 0)
                        {
                            $total_componentes = "0";
                            $cantidad = "0";
                            $cantidad_inventario = "";
                        }
                        else
                        {
                            while ($fila_composicion = $consulta_composicion->fetch_assoc())
                            {
                                $componente = $fila_composicion['componente'];
                                $cantidad = $fila_composicion['cantidad'];

                                //consulto los datos del componente
                                $consulta_componente = $conexion->query("SELECT * FROM componentes WHERE id = '$componente'");           

                                if ($fila_componente = $consulta_componente->fetch_assoc()) 
                                {
                                    $componente_id = $fila_componente['id'];
                                    $componente = $fila_componente['componente'];
                                    $unidad = $fila_componente['unidad'];

                                    //consulto el iventario local de este componente                            
                                    $consulta_inventario_local = $conexion->query("SELECT * FROM inventario WHERE componente_id = '$componente_id'");           

                                    if ($fila_inventario_local = $consulta_inventario_local->fetch_assoc()) 
                                    {
                                        $id_inventario = $fila_inventario_local['id'];
                                        $cantidad_inventario = $fila_inventario_local['cantidad'];

                                        $n_cantidad = $cantidad_inventario - $cantidad;

                                        if ($descontar_inventario == "si")
                                        {

                                            $actualizar_inventario = $conexion->query("UPDATE inventario SET cantidad = '$n_cantidad' WHERE id = '$id_inventario'");

                                            //genero la novedad
                                            //$operacion = "resta";
                                            //$motivo = "venta No $venta_id";
                                            //$descripcion = "";
                                            //$insertar_novedad = $conexion->query("INSERT INTO inventario_novedades values ('', '$ahora', '$sesion_id', '$id_inventario', '$cantidad_inventario', '$operacion', '$cantidad', '$n_cantidad', '$motivo', '$descripcion')");

                                        }
                                    }
                                }
                            }
                        }                        
                    }

                    $impuesto_base_total = $impuesto_base_total + $impuesto_base_subtotal; //total de la base del impuesto de todos los productos
                    $impuesto_valor_total = $impuesto_valor_total + $impuesto_valor_subtotal; //total del valor del impuesto de todos los productos
                    $precio_neto_total = $precio_neto_total  + $precio_neto_subtotal; //total del precio de todos los productos

                    //valor del descuento
                    $descuento_valor = (($venta_descuento_porcentaje * $impuesto_base_total) / 100);

                    //propina
                    if (($venta_propina >= 0) and ($venta_propina <= 100))
                    {    
                        $propina_valor = (($venta_propina * $impuesto_base_total) / 100);
                    }
                    else
                    {
                        $propina_valor = $venta_propina;
                    }
                    
                    //porcentaja de la propina
                    $propina_porcentaje = ($propina_valor * 100) / $impuesto_base_total;
                    
                    //total de la venta con descuento y propina
                    $venta_total = $precio_neto_total - $descuento_valor + $propina_valor;

                    //cambio
                    if ($dinero == 0)
                    {
                        $dinero = $venta_total;
                    }

                    $cambio = $dinero - $venta_total; 




                    



                    














                    ?>

                    <section class="rdm-factura--item">

                        <div class="rdm-factura--izquierda"><b><?php echo ucfirst("$producto"); ?>, <?php echo ucfirst("$categoria"); ?></b></div>
                        <div class="rdm-factura--derecha"><b>$ <?php echo number_format($precio_final, 0, ",", "."); ?></b></div>
                        
                        <?php 
                        if ($impuesto_valor != 0)
                        {
                        ?>

                        <div class="rdm-factura--izquierda">Base</div>
                        <div class="rdm-factura--derecha">$ <?php echo number_format($impuesto_base, 0, ",", "."); ?></div>

                        <div class="rdm-factura--izquierda">Impuesto (<?php echo "$porcentaje_impuesto%";?>)</div>
                        <div class="rdm-factura--derecha">$ <?php echo number_format($impuesto_valor, 0, ",", "."); ?></div>

                        <?php
                        }
                        ?>

                        <?php 
                        if ($cantidad_producto != "1")
                        {
                        ?>
                        
                        <div class="rdm-factura--izquierda">Cantidad</div>
                        <div class="rdm-factura--derecha"><?php echo ucfirst("$cantidad_producto"); ?></div>

                        <div class="rdm-factura--izquierda"><b>Subtotal</b></div>
                        <div class="rdm-factura--derecha"><b>$ <?php echo number_format($impuesto_base_subtotal, 0, ",", "."); ?></b></div>

                        <?php
                        }
                        ?>

                    </section>

                    <?php
                }
            }
            ?>        

            <br>            

            <section class="rdm-factura--item">

                <div class="rdm-factura--izquierda"><b>Subtotal venta</b></div>
                <div class="rdm-factura--derecha"><b>$ <?php echo number_format($impuesto_base_total, 0, ",", "."); ?></b></div>

                <div class="rdm-factura--izquierda">Propina <?php echo "($propina_porcentaje%)"; ?></div>
                <div class="rdm-factura--derecha">$ <?php echo number_format($propina_valor, 0, ",", "."); ?></div>

                <?php 
                if ($descuento_valor != 0)
                {
                ?>

                <div class="rdm-factura--izquierda">Descuento (-<?php echo number_format($venta_descuento_porcentaje, 0, ",", "."); ?>%)</div>
                <div class="rdm-factura--derecha">$ - <?php echo number_format($descuento_valor, 0, ",", "."); ?></div>

                <?php
                }
                ?>

                <?php 
                if ($impuesto_valor_total != 0)
                {
                ?>

                <div class="rdm-factura--izquierda">Impuestos</div>
                <div class="rdm-factura--derecha">$ <?php echo number_format($impuesto_valor_total, 0, ",", "."); ?></div>

                <?php
                }
                ?>
                
            </section>

            <br>        

            <section class="rdm-factura--item">
                <div class="rdm-factura--izquierda"><b>TOTAL A PAGAR</b></div>
                <div class="rdm-factura--derecha"><b>$ <?php echo number_format($venta_total, 0, ",", "."); ?></b></div>
            </section>

            <br>

            <section class="rdm-factura--item">
                
                <div class="rdm-factura--izquierda">Tipo de pago</div>
                <div class="rdm-factura--derecha"><?php echo ucfirst($tipo_pago); ?></div>

                <div class="rdm-factura--izquierda">Dinero recibido</div>
                <div class="rdm-factura--derecha">$ <?php echo number_format($dinero, 0, ",", "."); ?></div>            

                <div class="rdm-factura--izquierda"><b>Cambio</b></div>
                <div class="rdm-factura--derecha"><b>$ <?php echo number_format($cambio, 0, ",", "."); ?></b></div>

            </section>

            <div class="rdm-factura--texto">
                <h3><?php echo nl2br($plantilla_texto_inferior) ?></h3>
            </div>

        </article>

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