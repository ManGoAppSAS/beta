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
?>

<?php
//rangos
include ("sis/reportes_rangos.php");
?>

<?php
//variables de la conexion, sesion y subida
include ("sis/variables_sesion.php");
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
            <a href="reportes.php#ingresos"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Resultados</h2>
        </div>        
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    

    <section class="rdm-lista--porcentaje">

        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">Ingresos <?php echo ($rango); ?></h1>
            <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo "$rango_texto"; ?></h2>

            <?php
            //ingresos de hoy
            $consulta_ingresos_hoy = $conexion->query("SELECT * FROM ventas_datos WHERE estado = 'liquidado' and local_id = '$sesion_local_id' and fecha BETWEEN '$desde' and '$hasta'");

            if ($consulta_ingresos_hoy->num_rows == 0)
            {
                $total_dia_hoy = 0;
                $total_propinas_hoy = 0;
            }
            else
            {
                $total_dia_hoy = 0;
                $total_propinas_hoy = 0;

                while ($fila_ingresos_hoy = $consulta_ingresos_hoy->fetch_assoc())
                {
                    $total_neto_hoy = $fila_ingresos_hoy['total_neto'];
                    $total_dia_hoy = $total_dia_hoy + $total_neto_hoy;

                    //encontrar el total de propinas de hoy
                    $total_bruto = $fila_ingresos_hoy['total_bruto'];
                    $propina = $fila_ingresos_hoy['propina'];

                    if ($propina <= 100)
                    {
                        $propina_valor = ($total_bruto * $propina)/100;
                        $propina_porcentaje = $propina;
                    }
                    else
                    {
                        $propina_valor = $propina;
                        $propina_porcentaje = ($propina_valor * 100) / $total_bruto;
                    }

                    $total_neto = $total_bruto + $propina_valor;

                    $total_propinas_hoy = $total_propinas_hoy + $propina_valor;                
                }
            }
            ?>

            <?php 
            //total sin propina
            $total_sin_propinas_hoy = $total_dia_hoy - $total_propinas_hoy;
            ?>

            <?php
            //ingresos de ayer        
            $consulta_ingresos_ayer = $conexion->query("SELECT * FROM ventas_datos WHERE estado = 'liquidado' and local_id = '$sesion_local_id' and fecha BETWEEN '$desde_anterior' and '$hasta_anterior'");        

            $total_dia_ayer = 0;

            while ($fila_ingresos_ayer = $consulta_ingresos_ayer->fetch_assoc())
            {
                $total_neto_ayer = $fila_ingresos_ayer['total_neto'];
                $total_dia_ayer = $total_dia_ayer + $total_neto_ayer;      
            }                
            ?>

            <?php
            //porcentaje de crecimiento                
            if ($total_dia_ayer == 0)
            {
               $porcentaje_crecimiento = "<h2 class='rdm-tarjeta--dashboard-subtitulo-neutral'>" . ucfirst($rango_anterior) . " sin ventas</h2>";
            }
            else
            {
                //$porcentaje_crecimiento = ($total_dia_hoy - $total_dia_ayer) / $total_dia_ayer * 100;
                $porcentaje_crecimiento = ($total_dia_hoy - $total_dia_ayer) / $total_dia_ayer * 100;
                $porcentaje_crecimiento = number_format($porcentaje_crecimiento, 1, ".", ".");
                $total_dia_ayer = number_format($total_dia_ayer, 0, ".", ".");
                

                if ($porcentaje_crecimiento > 1)
                {
                    $porcentaje_crecimiento = "<h2 class='rdm-tarjeta--dashboard-subtitulo-positivo'><i class='zmdi zmdi-long-arrow-up'></i> $porcentaje_crecimiento% " . ($rango_anterior) . " ($ $total_dia_ayer)</h2>";               
                }
                else
                {
                    if ($porcentaje_crecimiento == 0)
                    {
                        $porcentaje_crecimiento = "<h2 class='rdm-tarjeta--dashboard-subtitulo-neutral'>Igual que " . ($rango_anterior) . " ($ $total_dia_ayer)</h2>";
                    }
                    else
                    {
                        $porcentaje_crecimiento = "<h2 class='rdm-tarjeta--dashboard-subtitulo-negativo'><i class='zmdi zmdi-long-arrow-down'></i> " . abs($porcentaje_crecimiento) . "% " . ($rango_anterior) . " ($ $total_dia_ayer)</h2>";
                    }
                }
            }

            if ($total_dia_hoy == 0)
            {
               $porcentaje_crecimiento = "<h2 class='rdm-tarjeta--dashboard-subtitulo-neutral'>Aún no hay ventas</h2>";
            }
            ?>
        
        
            <h2 class="rdm-tarjeta--dashboard-titulo-positivo">$ <?php echo number_format($total_sin_propinas_hoy, 0, ",", ".");?></h2>
            <h2 class="rdm-tarjeta--titulo-largo">Propinas: $ <?php echo number_format($total_propinas_hoy, 0, ",", ".");?></h2>
            <?php echo "$porcentaje_crecimiento";?>
        </div>











        





        


        <?php 
        if ($total_dia_hoy != 0)
        {
        ?>


        <?php
        //ventas por locales
        $consulta = $conexion->query("SELECT count(local_id), local_id FROM ventas_datos WHERE fecha BETWEEN '$desde' and '$hasta' and estado = 'liquidado' GROUP BY local_id ORDER BY count(local_id) ASC");                

        if ($consulta->num_rows == 1)
        {

        }
        else
        {



            while ($fila = $consulta->fetch_assoc())
            {
                $local = $fila['local_id'];

                //consulto el total para cada local
                $consulta2 = $conexion->query("SELECT * FROM ventas_datos WHERE local_id = '$local' and fecha BETWEEN '$desde' and '$hasta' and estado = 'liquidado'");       

                $total_local = 0;
                $total_propinas_hoy_t = 0;

                while ($fila2 = $consulta2->fetch_assoc())
                {
                    $total_neto = $fila2['total_neto'];
                    $total_local = $total_local + $total_neto;
                    $total_local_t = "$ " . number_format($total_local, 0, ".", ".");

                    //encontrar el total de propinas de hoy
                    $total_bruto = $fila2['total_bruto'];
                    $propina = $fila2['propina'];

                    if ($propina <= 100)
                    {
                        $propina_valor = ($total_bruto * $propina)/100;
                        $propina_porcentaje = $propina;
                    }
                    else
                    {
                        $propina_valor = $propina;
                        $propina_porcentaje = ($propina_valor * 100) / $total_bruto;
                    }

                    $total_neto = $total_bruto + $propina_valor;

                    $total_propinas_hoy_t = $total_propinas_hoy_t + $propina_valor;  


                }
               
                //consulto el nombre del local
                $consulta3 = $conexion->query("SELECT * FROM locales WHERE id = '$local'");
                while ($fila3 = $consulta3->fetch_assoc())
                {
                    $local = $fila3['local'];
                }

                $porcentaje_local = ($total_local / $total_dia_hoy) * 100;
                $porcentaje_local = number_format($porcentaje_local, 0, ".", ".");

                ?>

                <?php 
                //total sin propinas
                $total_sin_propinas_local = $total_local - $total_propinas_hoy_t;
                ?>

                <article class="rdm-lista--item-porcentaje">
                    <div>
                        <div class="rdm-lista--izquierda-porcentaje">
                            <h2 class="rdm-lista--titulo-porcentaje"><?php echo ucfirst("$local"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario-porcentaje">$ <?php echo number_format($total_sin_propinas_local, 0, ".", "."); ?> (Propinas: $ <?php echo number_format($total_propinas_hoy_t, 0, ".", "."); ?>)</h2>
                        </div>
                        <div class="rdm-lista--derecha-porcentaje">
                            <h2 class="rdm-lista--texto-secundario-porcentaje"><?php echo "$porcentaje_local"; ?>%</h2>
                        </div>
                    </div>
                    
                    <div class="rdm-lista--linea-pocentaje-fondo" style="background-color: #B2DFDB">
                        <div class="rdm-lista--linea-pocentaje-relleno" style="width: <?php echo "$porcentaje_local"; ?>%; background-color: #009688;"> </div>
                    </div>
                </article>

                <?php
            }
        }
        ?>

    <?php 
    }
    ?>

    
    </section>


    <section class="rdm-lista--porcentaje">

        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">Costos <?php echo ($rango); ?></h1>
            <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo "$rango_texto"; ?></h2>

            <?php
            //consulto los productos vendidos en el rango para sacar el costo
            $consulta_producto = $conexion->query("SELECT * FROM ventas_productos WHERE fecha BETWEEN '$desde' and '$hasta' and local = '$sesion_local_id'");

            $total_costo = 0; 

            while ($fila_producto = $consulta_producto->fetch_assoc())
            {
                $producto_id = $fila_producto['producto_id'];
                $precio_final = $fila_producto['precio_final'];

                //consulto la composicion del producto
                $consulta_composicion = $conexion->query("SELECT * FROM composiciones WHERE producto = '$producto_id'");

                $subtotal_costo_producto = 0;

                while ($fila_composicion = $consulta_composicion->fetch_assoc())
                {
                    $composicion_id = $fila_composicion['id'];
                    $producto_id = $fila_composicion['producto'];
                    $componente = $fila_composicion['componente'];
                    $cantidad = $fila_composicion['cantidad'];

                    //consulto el componente
                    $consulta_componente = $conexion->query("SELECT * FROM componentes WHERE id = $componente");

                    if ($filas_componente = $consulta_componente->fetch_assoc())
                    {
                        $unidad = $filas_componente['unidad'];
                        $componente = $filas_componente['componente'];
                        $costo_unidad = $filas_componente['costo_unidad'];
                    }
                    else
                    {
                        $componente = "No se ha asignado un componente";
                    }

                    $subtotal_costo_unidad = $costo_unidad * $cantidad;
                    $subtotal_costo_producto = $subtotal_costo_producto + $subtotal_costo_unidad;                    
                }

                $total_costo = $total_costo + $subtotal_costo_producto;

            }
            ?>

            <h2 class="rdm-tarjeta--dashboard-titulo-negativo">$ <?php echo number_format($total_costo, 0, ",", ".");?></h2>

        </div>

        <div class="rdm-tarjeta--dashboard-cuerpo">


        </div>
        

    </section>


















    <section class="rdm-lista--porcentaje">

        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">Utilidad <?php echo ($rango); ?></h1>
            <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo "$rango_texto"; ?></h2>

            <?php 
            //resultado de hoy ingresos vs gastos
            $total_utilidad = $total_dia_hoy - $total_costo;
            ?>

            <h2 class="rdm-tarjeta--dashboard-titulo-positivo">$ <?php echo number_format($total_utilidad, 0, ",", ".");?></h2>

        </div>

        <div class="rdm-tarjeta--dashboard-cuerpo">


        </div>
        

    </section>




    <section class="rdm-lista--porcentaje">

        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">Gastos <?php echo ($rango); ?></h1>
            <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo "$rango_texto"; ?></h2>

            <?php
            //total de gastos del rango
            $consulta_gastos_hoy = $conexion->query("SELECT * FROM gastos WHERE fecha BETWEEN '$desde' and '$hasta' and local = '$sesion_local_id'");        

            $total_gastos_hoy = 0;

            while ($fila_gastos_hoy = $consulta_gastos_hoy->fetch_assoc())
            {
                $valor = $fila_gastos_hoy['valor'];
                $total_gastos_hoy = $total_gastos_hoy + $valor;      
            }
            ?>

            <h2 class="rdm-tarjeta--dashboard-titulo-negativo">$ <?php echo number_format($total_gastos_hoy, 0, ",", ".");?></h2>

        </div>

        <div class="rdm-tarjeta--dashboard-cuerpo">


        </div>

        <?php 
        if ($total_gastos_hoy != 0)
        {
        ?>

        <?php
        //lista de gastos
        $consulta_gastos = $conexion->query("SELECT * FROM gastos WHERE fecha BETWEEN '$desde' and '$hasta'");

        while ($fila_gastos = $consulta_gastos->fetch_assoc())
        {
            $concepto = $fila_gastos['concepto'];
            $valor = $fila_gastos['valor'];

            $porcentaje_gasto = ($valor / $total_gastos_hoy) * 100;
            $porcentaje_gasto = number_format($porcentaje_gasto, 0, ".", ".");

            ?>

            <article class="rdm-lista--item-porcentaje">
                <div>
                    <div class="rdm-lista--izquierda-porcentaje">
                        <h2 class="rdm-lista--titulo-porcentaje"><?php echo ucfirst($concepto); ?></h2>
                        <h2 class="rdm-lista--texto-secundario-porcentaje">$ <?php echo number_format($valor, 0, ",", ".");?></h2>
                    </div>
                    <div class="rdm-lista--derecha-porcentaje">
                        <h2 class="rdm-lista--texto-secundario-porcentaje"><?php echo "$porcentaje_gasto"; ?>%</h2>
                    </div>
                </div>
                
                <div class="rdm-lista--linea-pocentaje-fondo" style="background-color: #FFCDD2">
                    <div class="rdm-lista--linea-pocentaje-relleno" style="width: <?php echo "$porcentaje_gasto"; ?>%; background-color: #F44336;"></div>
                </div>
            </article>

            <?php
        }
        
        ?>

        <?php 
        }
        ?>

    </section>









    <section class="rdm-lista--porcentaje">

        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">Resultado <?php echo ($rango); ?></h1>
            <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo "$rango_texto"; ?></h2>

            <?php 
            //resultado de hoy ingresos vs gastos
            $total_resultado_hoy = $total_dia_hoy - $total_gastos_hoy - $total_costo;
            ?>

            

            <h2 class="rdm-tarjeta--dashboard-titulo-resultado">$ <?php echo number_format($total_resultado_hoy, 0, ",", ".");?></h2>

        </div>

        <div class="rdm-tarjeta--dashboard-cuerpo">


        </div>

        

        <article class="rdm-lista--item-porcentaje">
            <div>
                <div class="rdm-lista--izquierda-porcentaje">
                    <h2 class="rdm-lista--titulo-porcentaje">Ingresos <?php echo ($rango); ?></h2>
                    <h2 class="rdm-lista--texto-secundario-porcentaje">$ <?php echo number_format($total_dia_hoy, 0, ",", ".");?></h2>
                </div>
                <div class="rdm-lista--derecha-porcentaje">
                    <h2 class="rdm-lista--texto-secundario-porcentaje"></h2>
                </div>
            </div>
            
            <div class="rdm-lista--linea-pocentaje-fondo" style="background-color: #B2DFDB">
                <div class="rdm-lista--linea-pocentaje-relleno" style="width: 100%; background-color: #009688;"></div>
            </div>
        </article>

        <article class="rdm-lista--item-porcentaje">
            <div>
                <div class="rdm-lista--izquierda-porcentaje">
                    <h2 class="rdm-lista--titulo-porcentaje">Costos <?php echo ($rango); ?></h2>
                    <h2 class="rdm-lista--texto-secundario-porcentaje">$ <?php echo number_format($total_costo, 0, ",", ".");?></h2>
                </div>
                <div class="rdm-lista--derecha-porcentaje">
                    <h2 class="rdm-lista--texto-secundario-porcentaje"></h2>
                </div>
            </div>
            
            <div class="rdm-lista--linea-pocentaje-fondo" style="background-color: #FFCDD2">
                <div class="rdm-lista--linea-pocentaje-relleno" style="width: 100%; background-color: #F44336;"></div>
            </div>
        </article>

        <article class="rdm-lista--item-porcentaje">
            <div>
                <div class="rdm-lista--izquierda-porcentaje">
                    <h2 class="rdm-lista--titulo-porcentaje">Gastos <?php echo ($rango); ?></h2>
                    <h2 class="rdm-lista--texto-secundario-porcentaje">$ <?php echo number_format($total_gastos_hoy, 0, ",", ".");?></h2>
                </div>
                <div class="rdm-lista--derecha-porcentaje">
                    <h2 class="rdm-lista--texto-secundario-porcentaje"></h2>
                </div>
            </div>
            
            <div class="rdm-lista--linea-pocentaje-fondo" style="background-color: #FFCDD2">
                <div class="rdm-lista--linea-pocentaje-relleno" style="width: 100%; background-color: #F44336;"></div>
            </div>
        </article>

    </section>

        











       


        

    <h2 class="rdm-lista--titulo-largo">Periodos</h2>

    <section class="rdm-lista-sencillo">
        
        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?fecha_inicio=<?php echo date('Y-m-d', strtotime($jornada_desde . 'hour')); ?>&hora_inicio=<?php echo "$jornada_hora_inicio"; ?>&fecha_fin=<?php echo date('Y-m-d', strtotime($jornada_hasta . 'hour')); ?>&hora_fin=<?php echo "$jornada_hora_fin"; ?>&rango=jornada">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-time-countdown zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Jornada</h2>
                        <h2 class="rdm-lista--texto-secundario"><?php echo date('d/m/y', strtotime($jornada_desde . 'hour')); ?>, <?php echo date('ga', strtotime($jornada_hora_inicio)); ?> - <?php echo date('d/m/y', strtotime($jornada_hasta . 'hour')); ?>, <?php echo date('ga', strtotime($jornada_hora_fin)); ?></h2>
                    </div>
                </div>
                
            </article>

        </a>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?fecha_inicio=<?php echo date('Y-m-d', strtotime('now')); ?>&hora_inicio=00:00&fecha_fin=<?php echo date('Y-m-d', strtotime('now')); ?>&hora_fin=23:59&rango=hoy">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-calendar-alt zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Hoy</h2>
                        <h2 class="rdm-lista--texto-secundario"><?php echo date('d/m/y', strtotime('now')); ?>, 12:00am - 11:59pm</h2>
                    </div>
                </div>
                
            </article>

        </a>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?fecha_inicio=<?php echo date('Y-m-d', strtotime('last monday')); ?>&hora_inicio=00:00&fecha_fin=<?php echo date('Y-m-d', strtotime('next monday -1 day')); ?>&hora_fin=23:59&rango=semana">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-calendar-note zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Semana</h2>
                        <h2 class="rdm-lista--texto-secundario"><?php echo date('d/m/y', strtotime('last monday')); ?> - <?php echo date('d/m/y', strtotime('next monday -1 day')); ?></h2>
                    </div>
                </div>
                
            </article>

        </a>

        <a href="<?php echo $_SERVER['PHP_SELF']; ?>?fecha_inicio=<?php echo date('Y-m-d', strtotime('first day of this month')); ?>&hora_inicio=00:00&fecha_fin=<?php echo date('Y-m-d', strtotime('last day of this month')); ?>&hora_fin=23:59&rango=mes">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-calendar-check zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Mes</h2>
                        <h2 class="rdm-lista--texto-secundario"><?php echo date('d/m/y', strtotime('first day of this month')); ?> - <?php echo date('d/m/y', strtotime('last day of this month')); ?></h2>
                    </div>
                </div>
                
            </article>

        </a>

    </section>



    <h2 class="rdm-lista--titulo-largo">Periodo personalizado</h2>

    <section class="rdm-formulario">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <input type="hidden" name="rango" value="consulta">

            <p class="rdm-formularios--label"><label for="fecha_inicio">Desde*</label></p>
            
            <div class="rdm-formularios--fecha">
                <p><input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo "$fecha_inicio"; ?>" placeholder="Fecha" required></p>
                <p class="rdm-formularios--ayuda">Fecha</p>
            </div>
            <div class="rdm-formularios--fecha">
                <p><input type="time" id="hora_inicio" name="hora_inicio" value="<?php echo "$hora_inicio"; ?>" placeholder="Hora" required></p>
                <p class="rdm-formularios--ayuda">Hora</p>
            </div>

            <p class="rdm-formularios--label" style="margin-top: 0"><label for="fecha_fin">Hasta*</label></p>
            
            <div class="rdm-formularios--fecha">
                <p><input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo "$fecha_fin"; ?>" placeholder="Fecha" required></p>
                <p class="rdm-formularios--ayuda">Fecha</p>
            </div>
            <div class="rdm-formularios--fecha">
                <p><input type="time" id="hora_fin" name="hora_fin" value="<?php echo "$hora_fin"; ?>" placeholder="Hora" required></p>
                <p class="rdm-formularios--ayuda">Hora</p>
            </div>

            <div class="rdm-formularios--submit">
                <button type="submit" class="rdm-boton--plano">Mostrar</button>
            </div>

        </form>

    </section>


</main> 
   
<footer></footer>

</body>
</html>