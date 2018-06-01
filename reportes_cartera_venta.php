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
//declaro las variables que pasan por formulario o URL
date_default_timezone_set('America/Bogota');

if(isset($_POST['fecha_inicio'])) $fecha_inicio = $_POST['fecha_inicio']; elseif(isset($_GET['fecha_inicio'])) $fecha_inicio = $_GET['fecha_inicio']; else $fecha_inicio = date('Y-m-d');
if(isset($_POST['hora_inicio'])) $hora_inicio = $_POST['hora_inicio']; elseif(isset($_GET['hora_inicio'])) $hora_inicio = $_GET['hora_inicio']; else $hora_inicio = "00:00";

if(isset($_POST['fecha_fin'])) $fecha_fin = $_POST['fecha_fin']; elseif(isset($_GET['fecha_fin'])) $fecha_fin = $_GET['fecha_fin']; else $fecha_fin = date('Y-m-d');
if(isset($_POST['hora_fin'])) $hora_fin = $_POST['hora_fin']; elseif(isset($_GET['hora_fin'])) $hora_fin = $_GET['hora_fin']; else $hora_fin = "23:59";

if(isset($_POST['rango'])) $rango = $_POST['rango']; elseif(isset($_GET['rango'])) $rango = $_GET['rango']; else $rango = "jornada";

if(isset($_POST['venta_id'])) $venta_id = $_POST['venta_id']; elseif(isset($_GET['venta_id'])) $venta_id = $_GET['venta_id']; else $venta_id = null;
?>

<?php
//rangos
include ("sis/reportes_rangos.php");
?>

<?php
//variables de la conexion, sesion y subida
include ("sis/variables_sesion.php");
?>

<?php
//consulto los datos de la venta
$consulta_venta = $conexion->query("SELECT * FROM ventas_datos WHERE id = '$venta_id'");

if ($consulta_venta->num_rows == 0)
{
    
}
else
{
    while ($fila_venta = $consulta_venta->fetch_assoc())
    {
        $venta_id = $fila_venta['id'];
        $fecha = date('Y/m/d', strtotime($fila_venta['fecha']));
        $hora = date('H:i', strtotime($fila_venta['fecha']));
        $usuario_id = $fila_venta['usuario_id'];
        $ubicacion = $fila_venta['ubicacion'];
        $total_bruto = $fila_venta['total_bruto'];
        $descuento_porcentaje = $fila_venta['descuento_porcentaje'];
        $descuento_valor = $fila_venta['descuento_valor'];
        $venta_propina = $fila_venta['propina'];
        $total_neto = $fila_venta['total_neto'];
        $saldo_pendiente = $fila_venta['saldo_pendiente'];

        $total_pagado = $total_neto - $saldo_pendiente;
        
        //consulto el usuario que realizo la ultima modificacion
        $consulta_usuario = $conexion->query("SELECT * FROM usuarios WHERE id = '$usuario_id'");           

        if ($fila = $consulta_usuario->fetch_assoc()) 
        {
            $nombres = $fila['nombres'];
            $apellidos = $fila['apellidos'];
        }
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
    //fin información del head <meta http-equiv="refresh" content="20" >
    ?>

    <style type="text/css">
    #grafico1 {        
        height: 10em;
        margin: 0 auto
    }

    #grafico2 {
        height: 12em;
        margin: 0 auto
    }
    </style>

    <script src="graficos/code/highcharts.js"></script>
    <script src="graficos/code/modules/exporting.js"></script>
</head>
<body>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="reportes_cartera.php#ingresos"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Venta No <?php echo ($venta_id); ?></h2>
        </div>        
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    

    <section class="rdm-lista--porcentaje">

        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">Venta No <?php echo ($venta_id); ?></h1>        
            <h2 class="rdm-tarjeta--dashboard-titulo-positivo">$ <?php echo number_format($total_neto, 2, ",", ".");?></h2>
            <h2 class="rdm-tarjeta--titulo-largo">Total pagado: $ <?php echo number_format($total_pagado, 2, ",", ".");?></h2>
            <h2 class="rdm-tarjeta--titulo-largo">Saldo pendiente: $ <?php echo number_format($saldo_pendiente, 2, ",", ".");?></h2>
        </div>      

    </section>

    <h2 class="rdm-lista--titulo-largo">Abonar</h2>

    <section class="rdm-tarjeta">

       

        

        <article class="rdm-formulario">
    
            <form action="ventas_recibo.php" method="post">
                <input type="hidden" name="venta_id" value="<?php echo "$venta_id";?>" />
                <input type="hidden" name="venta_total_bruto" value="<?php echo "$impuesto_base_total";?>" />
                <input type="hidden" name="descuento_valor" value="<?php echo "$descuento_valor";?>" />
                <input type="hidden" name="venta_total_neto" value="<?php echo "$venta_total";?>" />
                <input type="hidden" name="tipo_pago" value="<?php echo "$tipo_pago";?>" />
                <input type="hidden" name="ubicacion_id" value="<?php echo "$ubicacion_id";?>" />



                
                
                <p><input class="rdm-formularios--input-grande" type="<?php echo "$caja_tipo";?>" id="dinero" name="dinero" value="" placeholder="Dinero entregado" ></p>   
                
                <p class="rdm-formularios--submit"><button type="submit" class="rdm-boton--plano-resaltado" name="pagar" value="liquidar">Abonar</button></p>

            </form>

        </article>

    </section>





    

        











       


        

    


</main> 
   
<footer></footer>

</body>
</html>