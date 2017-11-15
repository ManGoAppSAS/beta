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
if(isset($_POST['venta_id'])) $venta_id = $_POST['venta_id']; elseif(isset($_GET['venta_id'])) $venta_id = $_GET['venta_id']; else $venta_id = null;
if(isset($_POST['dinero'])) $dinero = $_POST['dinero']; elseif(isset($_GET['dinero'])) $dinero = $_GET['dinero']; else $dinero = null;
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

<!DOCTYPE html>
<html lang="es">
<head>
    <title>ManGo! - Venta No <?php echo "$venta_id"; ?></title>
    <?php
    //información del head
    include ("partes/head.php");
    //fin información del head
    ?>

    <script>
    function loaded()
    {
        
        window.setTimeout(CloseMe, 500);
    }

    function CloseMe() 
    {
        window.close();
    }
    </script>    
</head>

<body style="background: none; margin-top: -10px; margin-bottom: -10px" onload="javascript:window.print(); loaded()">

<section class="rdm-factura--imprimir" style="font-size: 8px;">

    <article class="rdm-factura--contenedor--imprimir" style="max-width: none;">

        <div class="rdm-factura--texto">
            <h3><?php echo ucfirst($plantilla_titulo)?><br>
            PENDIENTE DE PAGO</h3>
            <h3><?php echo nl2br($plantilla_texto_superior) ?></h3>
            <h3><?php echo ucfirst($sesion_local)?><br>
            <?php echo ucfirst($sesion_local_direccion)?><br>
            <?php echo ucfirst($sesion_local_telefono)?></h3>
        </div>

        <?php
        //datos de la venta
        include ("sis/ventas_datos.php");
        ?>

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














                //cambio de idea

    $total_con_descuento = $impuesto_base_total - $descuento_valor;//total antes de impuestos con el descuento

    $total_con_descuento_mas_impuesto = ($total_con_descuento * $impuesto_porcentaje) / 100 ;

    
    $nuevo_total = $total_con_descuento + $total_con_descuento_mas_impuesto;

    $venta_total = $nuevo_total;
    $impuesto_valor_total = $total_con_descuento_mas_impuesto;



    

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

        <div class="rdm-factura--texto">
            <h3><?php echo nl2br($plantilla_texto_inferior) ?></h3>
        </div>

    </article>

</section>


</body>
</html>