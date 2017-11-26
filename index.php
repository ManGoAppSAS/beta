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
//rangos de reportes
include ("sis/reportes_rangos.php");
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
    #grafico1, #grafico2 {        
        height: 10em;
        margin: 0 auto
    }
    </style>
</head>
<body>

<header class="rdm-toolbar--contenedor">    
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="logueo_salir.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-power zmdi-hc-2x"></i></div></a>
        </div>
        <div class="rdm-toolbar--centro">
            <a href="index.php"><h2 class="rdm-toolbar--titulo-centro"><span class="logo_img"></span> ManGo!</h2></a>
        </div>
        <div class="rdm-toolbar--derecha">

            <?php
            //le doy acceso al modulo segun el perfil que tenga
            if (($sesion_tipo == "administrador") or ($sesion_tipo == "socio"))
            {

            ?>

            <a href="ajustes.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-settings zmdi-hc-2x"></i></div></a>

            <?php
            }
            ?>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <section class="rdm-tarjeta">


        <div class="rdm-tarjeta--primario">
            <div class="rdm-tarjeta--primario-contenedor">
                <?php echo "$sesion_imagen"; ?>
            </div>

            <div class="rdm-tarjeta--primario-contenedor">
                <h1 class="rdm-tarjeta--titulo"><?php echo ucwords($sesion_nombres) ?> <?php echo ucwords($sesion_apellidos) ?></h1>
                <h2 class="rdm-tarjeta--subtitulo"><?php echo ucfirst($sesion_tipo);?> en <?php echo ucfirst($sesion_local);?></h2>
            </div>
        </div>

        <?php echo "$sesion_local_imagen"; ?>
        
    </section>











    <h2 class="rdm-lista--titulo-largo">Actividades</h2>

    <section class="rdm-lista-sencillo">

        <a class="ancla" name="ventas"></a>
        
        <a href="ventas_ubicaciones.php">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-inbox zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Ventas</h2>
                        <h2 class="rdm-lista--texto-secundario">Hacer o continuar una venta</h2>
                    </div>
                </div>
                
            </article>

        </a>

        <a class="ancla" name="base"></a>

        <a href="bases_ver.php">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-money zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Base</h2>
                        <h2 class="rdm-lista--texto-secundario">Ingresar la base de la jornada</h2>
                    </div>
                </div>
                
            </article>

        </a>

        <a class="ancla" name="cierre"></a>

        <a href="cierres_ver.php">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-time zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Cierre</h2>
                        <h2 class="rdm-lista--texto-secundario">Ingresar el cierre de la jornada</h2>
                    </div>
                </div>
                
            </article>

        </a>

        <a class="ancla" name="zonas"></a>

        <a href="zonas_entregas_entrada.php">            

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-assignment-o zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Zonas de entregas</h2>
                        <h2 class="rdm-lista--texto-secundario">Mostrar zonas de entrega</h2>
                    </div>
                </div>
                
            </article>

        </a>

        <a class="ancla" name="despachos"></a>

        <a href="despachos_ver.php">           

        <article class="rdm-lista--item-sencillo">
            <div class="rdm-lista--izquierda">
                <div class="rdm-lista--contenedor">
                    <div class="rdm-lista--icono"><i class="zmdi zmdi-truck zmdi-hc-2x"></i></div>
                </div>
                <div class="rdm-lista--contenedor">
                    <h2 class="rdm-lista--titulo">Despachos</h2>
                    <h2 class="rdm-lista--texto-secundario">Hacer o continuar un despacho</h2>
                </div>
            </div>
            
        </article>

        </a>

        <a class="ancla" name="producciones"></a>

        <a href="producciones_inicio.php">           

        <article class="rdm-lista--item-sencillo">
            <div class="rdm-lista--izquierda">
                <div class="rdm-lista--contenedor">
                    <div class="rdm-lista--icono"><i class="zmdi zmdi-invert-colors zmdi-hc-2x"></i></div>
                </div>
                <div class="rdm-lista--contenedor">
                    <h2 class="rdm-lista--titulo">Producciones</h2>
                    <h2 class="rdm-lista--texto-secundario">Hacer o continuar una producción</h2>
                </div>
            </div>
            
        </article>

        </a>

        <a class="ancla" name="inventario"></a>

        <a href="inventario_ver.php">            

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-storage zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Inventario</h2>
                        <h2 class="rdm-lista--texto-secundario">Ver inventario y recibir despachos</h2>
                    </div>
                </div>
                
            </article>

        </a>

        <a class="ancla" name="inventario_p"></a>

        <a href="inventario_p_ver.php">            

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-storage zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Inventario de productos</h2>
                        <h2 class="rdm-lista--texto-secundario">Ver inventario y recibir producciones</h2>
                    </div>
                </div>
                
            </article>

        </a>

        <a class="ancla" name="reportes"></a>

        <a href="reportes.php">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-chart-donut zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Reportes</h2>
                        <h2 class="rdm-lista--texto-secundario">Consultar los datos de mi negocio</h2>
                    </div>
                </div>
                
            </article>

        </a>

        <a class="ancla" name="gastos"></a>

        <a href="gastos_ver.php">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-balance-wallet zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Gastos</h2>
                        <h2 class="rdm-lista--texto-secundario">Agregar y consultar gastos</h2>
                    </div>
                </div>
                
            </article>

        </a>

        <a class="ancla" name="clientes"></a>

        <a href="clientes_ver.php">            

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-favorite zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Clientes</h2>
                        <h2 class="rdm-lista--texto-secundario">Ver clientes</h2>
                    </div>
                </div>
                
            </article>

        </a>

        

        

    </section>

















    <section class="rdm-lista--porcentaje">

        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">Base <?php echo ($rango); ?></h1>
            <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo "$rango_texto"; ?></h2>

            <?php
            //total de la base
            $consulta_base_hoy = $conexion->query("SELECT * FROM bases_datos WHERE fecha BETWEEN '$desde' and '$hasta' and local = '$sesion_local_id'");        

            $total_base_hoy = 0;

            while ($fila_base_hoy = $consulta_base_hoy->fetch_assoc())
            {
                $total_base_hoy = $fila_base_hoy['base'];
            }
            ?>

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

            <?php 
            //base actual
            $base_actual = $total_base_hoy - $total_gastos_hoy;
            ?>

            <h2 class="rdm-tarjeta--dashboard-titulo-positivo">$ <?php echo number_format($base_actual, 0, ",", ".");?></h2>
            <h2 class="rdm-tarjeta--titulo-largo">Inicial: $ <?php echo number_format($total_base_hoy, 0, ",", ".");?></h2>
            <h2 class="rdm-tarjeta--titulo-largo">Gastos: $ <?php echo number_format($total_gastos_hoy, 0, ",", ".");?></h2>

        </div>

        <div class="rdm-tarjeta--dashboard-cuerpo">


        </div>
        

    </section>



    

    <section class="rdm-lista--porcentaje">

        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">Ingresos <?php echo ($rango); ?></h1>
            <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo "$rango_texto"; ?></h2>

            <?php
            //ingresos de hoy
            $consulta_ingresos_hoy = $conexion->query("SELECT * FROM ventas_datos WHERE fecha BETWEEN '$desde' and '$hasta'");

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
            //ingresos de ayer        
            $consulta_ingresos_ayer = $conexion->query("SELECT * FROM ventas_datos WHERE estado = 'liquidado' and fecha BETWEEN '$desde_anterior' and '$hasta_anterior'");        

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
        
        
            <h2 class="rdm-tarjeta--dashboard-titulo-positivo">$ <?php echo number_format($total_dia_hoy, 0, ",", ".");?></h2>
            <h2 class="rdm-tarjeta--titulo-largo">Propinas: $ <?php echo number_format($total_propinas_hoy, 0, ",", ".");?></h2>
            <?php echo "$porcentaje_crecimiento";?>
        </div>











        





        <?php 
        if ($total_dia_hoy != 0)
        {
        ?>

        <div class="rdm-tarjeta--cuerpo">
            
            <div id="grafico1"></div>
                
                <script type="text/javascript">

                Highcharts.chart('grafico1', {

                    credits: {
                        enabled: false
                    },

                    title: {
                        text: null
                    },

                    subtitle: {
                        text: null
                    },

                    chart: {
                        type: 'area',
                        borderWidth: 0,
                        plotBorderWidth: 0,
                        marginTop: 0
                    },

                    navigation: {
                        buttonOptions: {
                            enabled: false
                        }
                    },

                    xAxis: {

                        labels: {
                            enabled: false,

                            formatter:function(){
                           
                                if((this.isFirst == true) || (this.isLast == true))
                                {
                                   return this.value;
                                }
                                
                            }
                        },

                        categories: [


                        <?php
                        //ordenado por cantidad de registros encontrados UNA CHIMBA!!
                        $consulta = $conexion->query("SELECT HOUR(fecha), fecha FROM ventas_datos WHERE fecha BETWEEN '$desde' and '$hasta' and local_id = '$sesion_local_id' and estado = 'liquidado' GROUP BY HOUR(fecha) ORDER BY fecha ASC");

                        if ($consulta->num_rows == 0)
                        {
                            echo "no hay registros";
                        }
                        else
                        {
                            $total = $consulta->num_rows;

                            while ($fila = $consulta->fetch_assoc())
                            {
                                $hora = $fila['HOUR(fecha)'];
                                $hora2 = date('h A', strtotime($fila['fecha']));

                                echo "'$hora2', ";
                            }
                        }
                        ?>

                        ]
                    },
                    
                    yAxis: {
                        gridLineColor: null,

                        title: {
                            text: null
                        },

                        labels: {
                            enabled: false,
                            formatter: function() {
                            return '$ ' + this.value;
                            }
                        },
                    },

                    legend: {
                        enabled: false,
                        floating: true,
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },

                    tooltip: {
                        valueSuffix: 'mil',
                        backgroundColor: '#f5f5f5',
                        borderColor: '#999999',
                        borderRadius: 3,
                        borderWidth: 1,
                        crosshairs: true,
                        formatter: function() {
                        return this.x + '<br> <b>Ventas: '  + this.y + '</b>';
                        }
                    },                    

                    plotOptions: {
                        series: {
                            color: '#009688',
                            marker: {
                                enabled: false,
                            },
                            fillOpacity: 0.1,
                            lineWidth: 1,
                            radius: 0,
                        }
                    },


                    
                    series: [{

                        name: 'Ventas',
                        data: [


                        <?php
                        //ordenado por cantidad de registros encontrados UNA CHIMBA!!
                        $consulta = $conexion->query("SELECT HOUR(fecha), fecha FROM ventas_datos WHERE fecha BETWEEN '$desde' and '$hasta' and local_id = '$sesion_local_id' and estado = 'liquidado' GROUP BY HOUR(fecha) ORDER BY fecha ASC");

                        if ($consulta->num_rows == 0)
                        {
                            echo "no hay registros";
                        }
                        else
                        {
                            $total = $consulta->num_rows;

                            while ($fila = $consulta->fetch_assoc())
                            {
                                $hora = date('H', strtotime($fila['fecha']));
                                $hora2 = date('h a', strtotime($fila['fecha']));

                                $desde_x = date(("Y-m-d $hora"), strtotime($desde));
                                $hasta_x = date(("Y-m-d $hora"), strtotime($hasta));

                                $consulta2 = $conexion->query("SELECT * FROM ventas_datos WHERE fecha like '%$desde_x%' or fecha like '%$hasta_x%'");
                                $total2 = $consulta2->num_rows;                            

                                echo "$total2,";
                            }
                        }
                        ?>



                        ]



                    }

                    ],



                });
            </script>              

        </div>

        

        <?php
        }
        ?>


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

                <article class="rdm-lista--item-porcentaje">
                    <div>
                        <div class="rdm-lista--izquierda-porcentaje">
                            <h2 class="rdm-lista--titulo-porcentaje"><?php echo ucfirst("$local"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario-porcentaje"><?php echo "$total_local_t"; ?> (Propinas: $ <?php echo number_format($total_propinas_hoy_t, 0, ".", ".");; ?>)</h2>
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
            $total_resultado_hoy = $total_dia_hoy - $total_costo;
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

        

    </section>
    














    


    <?php 
    if ($total_dia_hoy != 0)
    {
    ?>

    <section class="rdm-lista--porcentaje">
        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">Productos vendidos</h1>
        </div>


        <?php
        //total de productos
        $consulta_ingresos_hoy = $conexion->query("SELECT * FROM ventas_productos WHERE local = '$sesion_local_id' and (estado = 'liquidado' or  estado = 'entregado') and fecha BETWEEN '$desde' and '$hasta'");
        $total_productos = $consulta_ingresos_hoy->num_rows;
        ?>

        <?php
        //ventas por cada producto
        $consulta = $conexion->query("SELECT count(producto), producto FROM ventas_productos WHERE local = '$sesion_local_id' and (estado = 'liquidado' or  estado = 'entregado') and fecha BETWEEN '$desde' and '$hasta' GROUP BY producto ORDER BY count(producto) DESC");                

        while ($fila = $consulta->fetch_assoc())
        {
            $producto = $fila['producto'];

            //consulto el total para cada producto
            $consulta2 = $conexion->query("SELECT * FROM ventas_productos WHERE local = '$sesion_local_id' and (estado = 'liquidado' or  estado = 'entregado') and producto = '$producto' and fecha BETWEEN '$desde' and '$hasta'");
            $total_producto = $consulta2->num_rows;

            $total_precio_final = 0;
            while ($fila2 = $consulta2->fetch_assoc())
            {
                $precio_final = $fila2['precio_final'];

                $total_precio_final = $total_precio_final + $precio_final;
            }

            $total_precio_final_t = "$ " . number_format($total_precio_final, 0, ".", ".");
            

            $porcentaje_producto = ($total_producto / $total_productos) * 100;
            $porcentaje_producto = number_format($porcentaje_producto, 1, ".", ".");

            ?>

            <article class="rdm-lista--item-porcentaje">
                <div>
                    <div class="rdm-lista--izquierda-porcentaje">
                        <h2 class="rdm-lista--titulo-porcentaje"><?php echo ucfirst($producto); ?></h2>
                        <h2 class="rdm-lista--texto-secundario-porcentaje"><?php echo "$total_producto"; ?> (<?php echo "$total_precio_final_t"; ?>)</h2>
                    </div>
                    <div class="rdm-lista--derecha-porcentaje">
                        <h2 class="rdm-lista--texto-secundario-porcentaje"><?php echo "$porcentaje_producto"; ?>%</h2>
                    </div>
                </div>
                
                <div class="rdm-lista--linea-pocentaje-fondo" style="background-color: #B2DFDB">
                    <div class="rdm-lista--linea-pocentaje-relleno" style="width: <?php echo "$porcentaje_producto"; ?>%; background-color: #009688;"></div>
                </div>
            </article>

            <?php
        }
        
        ?>

    </section>
    
    <?php 
    }
    ?>





    <section class="rdm-lista--porcentaje">

        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo">Ingresos Mes</h1>

            

        </div>

        <div class="rdm-tarjeta--dashboard-cuerpo">




            <div class="rdm-tarjeta--cuerpo">
            
            <div id="grafico2"></div>
                
                <script type="text/javascript">

                Highcharts.setOptions({
                        lang: {
                            thousandsSep: '.'
                        }
                    });

                Highcharts.chart('grafico2', {

                    credits: {
                        enabled: false
                    },

                    title: {
                        text: null
                    },

                    subtitle: {
                        text: null
                    },

                    chart: {
                        type: 'area',
                        borderWidth: 0,
                        plotBorderWidth: 0,
                        marginTop: 0
                    },

                    navigation: {
                        buttonOptions: {
                            enabled: false
                        }
                    },

                    xAxis: {

                        labels: {
                            enabled: false,

                            formatter:function(){
                           
                                if((this.isFirst == true) || (this.isLast == true))
                                {
                                   return this.value;
                                }
                                
                            }
                        },

                        categories: [


                        
                        <?php
                        //ordenado por cantidad de registros encontrados UNA CHIMBA!!

                        $desde = date('Y-m-d 00:00:00', strtotime('first day of this month'));
                        $hasta = date('Y-m-d 23:59:59', strtotime('last day of this month'));

                        $consulta_mes = $conexion->query("SELECT DAY(fecha), fecha FROM ventas_datos WHERE (fecha BETWEEN '$desde' and '$hasta') and local_id = '$sesion_local_id' and estado = 'liquidado' GROUP BY DAY(fecha) ORDER BY fecha ASC");

                        if ($consulta_mes->num_rows == 0)
                        {
                            echo "no hay registros";
                        }
                        else
                        {
                            $total_mes = $consulta_mes->num_rows;

                            while ($fila_mes = $consulta_mes->fetch_assoc())
                            {
                                $dia = $fila_mes['DAY(fecha)'];
                                $dia_letras = date('D', strtotime($fila_mes['fecha']));
                                $dia_numero = date('d', strtotime($fila_mes['fecha']));
                                $mes_letras = date('M', strtotime($fila_mes['fecha']));

                                //traduccioon de días
                                if ($dia_letras == "Mon")
                                {
                                    $dia_letras = "Lun";
                                }
                                if ($dia_letras == "Tue")
                                {
                                    $dia_letras = "Mar";
                                }
                                if ($dia_letras == "Wed")
                                {
                                    $dia_letras = "Mie";
                                }
                                if ($dia_letras == "Thu")
                                {
                                    $dia_letras = "Jue";
                                }
                                if ($dia_letras == "Fri")
                                {
                                    $dia_letras = "Vie";
                                }
                                if ($dia_letras == "Sat")
                                {
                                    $dia_letras = "Sab";
                                }
                                if ($dia_letras == "Sun")
                                {
                                    $dia_letras = "Dom";
                                }                                

                                //traduccioon de meses
                                if ($mes_letras == "Jan")
                                {
                                    $mes_letras = "Ene";
                                }
                                if ($mes_letras == "Apr")
                                {
                                    $mes_letras = "Abr";
                                }
                                if ($mes_letras == "Aug")
                                {
                                    $mes_letras = "Ago";
                                }
                                if ($mes_letras == "Dec")
                                {
                                    $mes_letras = "Dic";
                                }

                                echo "'$dia_letras $dia_numero de $mes_letras', ";
                            }
                        }
                        ?>

                        ]
                    },
                    
                    yAxis: {
                        gridLineColor: null,

                        title: {
                            text: null
                        },

                        labels: {
                            enabled: false,
                        },

                        


                    },

                    legend: {
                        enabled: false,
                        floating: true,
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },

                    tooltip: {
                        valueSuffix: 'mil',
                        backgroundColor: '#f5f5f5',
                        borderColor: '#999999',
                        borderRadius: 3,
                        borderWidth: 1,
                        crosshairs: true,
                        formatter: function() {
                        return this.x + '<br> <b>$' + ' '  + Highcharts.numberFormat(this.y, 0) + '</b>';
                        }


                    },                    

                    plotOptions: {
                        series: {
                            color: '#009688',
                            marker: {
                                enabled: false,
                            },
                            fillOpacity: 0.1,
                            lineWidth: 1,
                            radius: 0,
                        }
                    },


                    
                    series: [{

                        name: 'Total del día',
                        data: [


                        


                        <?php
                        //ordenado por cantidad de registros encontrados UNA CHIMBA!!

                        $desde = date('Y-m-d 00:00:00', strtotime('first day of this month'));
                        $hasta = date('Y-m-d 23:59:59', strtotime('last day of this month'));

                        $consulta_mes = $conexion->query("SELECT DAY(fecha), fecha FROM ventas_datos WHERE (fecha BETWEEN '$desde' and '$hasta') and local_id = '$sesion_local_id' and estado = 'liquidado' GROUP BY DAY(fecha) ORDER BY fecha ASC");

                        if ($consulta_mes->num_rows == 0)
                        {
                            echo "no hay registros";
                        }
                        else
                        {
                            $total_mes = $consulta_mes->num_rows;

                            while ($fila_mes = $consulta_mes->fetch_assoc())
                            {
                                $dia = $fila_mes['DAY(fecha)'];
                                $dia_letras = date('d', strtotime($fila_mes['fecha']));
                                $mes_letras = date('M', strtotime($fila_mes['fecha']));
                                $dia_numeros = date('Y-m-d', strtotime($fila_mes['fecha']));
                                $dia_corto = date('d', strtotime($fila_mes['fecha']));

                                //consulto el total para cada local
                                $consulta2 = $conexion->query("SELECT * FROM ventas_datos WHERE fecha like '%$dia_numeros%'");
                                $transacciones = $consulta2->num_rows;

                                $total_dia = 0;

                                while ($fila2 = $consulta2->fetch_assoc())
                                {
                                    $total_neto = $fila2['total_neto'];

                                    $total_dia = $total_dia + $total_neto;
                                }

                                
                                echo "$total_dia, ";

                            }
                        }
                        ?>



                        ]



                    }

                    ],



                });
            </script>              

        </div>



        


        </div>
        

    </section>















    
    






    





</main>
   
<footer></footer>

</body>
</html>