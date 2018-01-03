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
if(isset($_POST['entregar'])) $entregar = $_POST['entregar']; elseif(isset($_GET['entregar'])) $entregar = $_GET['entregar']; else $entregar = null;
if(isset($_POST['entregar_uno'])) $entregar_uno = $_POST['entregar_uno']; elseif(isset($_GET['entregar_uno'])) $entregar_uno = $_GET['entregar_uno']; else $entregar_uno = null;
if(isset($_POST['id'])) $id = $_POST['id']; elseif(isset($_GET['id'])) $id = $_GET['id']; else $id = null;
if(isset($_POST['venta_id'])) $venta_id = $_POST['venta_id']; elseif(isset($_GET['venta_id'])) $venta_id = $_GET['venta_id']; else $venta_id = null;
if(isset($_POST['ubicacion'])) $ubicacion = $_POST['ubicacion']; elseif(isset($_GET['ubicacion'])) $ubicacion = $_GET['ubicacion']; else $ubicacion = null;
if(isset($_POST['atendido'])) $atendido = $_POST['atendido']; elseif(isset($_GET['atendido'])) $atendido = $_GET['atendido']; else $atendido = null;
if(isset($_POST['producto'])) $producto = $_POST['producto']; elseif(isset($_GET['producto'])) $producto = $_GET['producto']; else $producto = null;
if(isset($_POST['zona'])) $zona = $_POST['zona']; elseif(isset($_GET['zona'])) $zona = $_GET['zona']; else $zona = null;
if(isset($_POST['zona_id'])) $zona_id = $_POST['zona_id']; elseif(isset($_GET['zona_id'])) $zona_id = $_GET['zona_id']; else $zona_id = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//entrego el producto o servicio del pedido
if ($entregar == "si")
{
    $actualizar = $conexion->query("UPDATE ventas_productos SET estado = 'entregado' WHERE venta_id = '$venta_id' and estado = 'confirmado' and zona = '$zona_id'");

    $mensaje = "Productos de <b>".ucfirst($ubicacion)."</b> entregados exitosamente a <b>".ucfirst($atendido)."</b>";
    $body_snack = 'onLoad="Snackbar()"';
    $mensaje_tema = "aviso";
}
?>

<?php
//entrego el producto o servicio del pedido
if ($entregar_uno == "si")
{
    $actualizar = $conexion->query("UPDATE ventas_productos SET estado = 'entregado' WHERE venta_id = '$venta_id' and id = '$id'");

    $mensaje = "Producto <b>".ucfirst($producto)."</b> entregado exitosamente a <b>".ucfirst($atendido)."</b>";
    $body_snack = 'onLoad="Snackbar()"';
    $mensaje_tema = "aviso";
}
?>

<?php
//consulto el total de productos pedidos en la zona
$consulta_productos = $conexion->query("SELECT * FROM ventas_productos WHERE zona = '$zona_id' and local = '$sesion_local_id' and estado = 'confirmado'");
$total_productos = $consulta_productos->num_rows;
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
    $(document).ready(function(){
        setInterval(function(){
            $("#mostrar_consulta").load('zonas_entregas_ubicaciones_consulta.php?zona_id=<?php echo "$zona_id";?>&zona=<?php echo "$zona";?>')
            }, 3000);
        });
    </script>

    <meta http-equiv="refresh" content="7;URL=zonas_entregas_ubicaciones.php?zona_id=<?php echo "$zona_id";?>&zona=<?php echo "$zona";?>">
</head>

<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="zonas_entregas_entrada.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo"><?php echo ucfirst($zona) ;?></h2>
        </div>
        <div class="rdm-toolbar--derecha">
            <h2 class="rdm-toolbar--titulo">Pendientes: <?php echo ($total_productos); ?></h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-zona">



<div style="width: 100%; display: flex; justify-content: space-between;">
    
    
<div>

<?php
//consulto y muestro los productos o servicios pedidos en esta zona
$consulta = $conexion->query("SELECT distinct ubicacion_id FROM ventas_productos WHERE zona = '$zona_id' and local = '$sesion_local_id' and estado = 'confirmado' ORDER BY fecha ASC");

if ($consulta->num_rows == 0)
{
    //header("location:zonas_entregas_entrada.php");

    ?>

    <div class="rdm--contenedor">
        <section class="rdm-lista">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-assignment-o zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">No hay pedidos</h2>
                    </div>
                </div>
            </article>

        </section>
    </div>

    

    <?php
}
else                 
{
    
    while ($fila = $consulta->fetch_assoc())
    {                        
        $ubicacion_id = $fila['ubicacion_id'];

        //consulto los datos de la ubicacion
        $consulta_ubicacion = $conexion->query("SELECT * FROM ubicaciones WHERE id = '$ubicacion_id'");           

        if ($fila_ubicacion = $consulta_ubicacion->fetch_assoc()) 
        {
            $ubicacion_id = $fila_ubicacion['id'];
            $ubicacion = $fila_ubicacion['ubicacion'];
            $ubicada = $fila_ubicacion['ubicada'];
            $tipo = $fila_ubicacion['tipo'];
        }

        //consulto los datos de la ubicacion dentro de la venta
        $consulta_ubicacion_v = $conexion->query("SELECT * FROM ventas_productos WHERE ubicacion_id = '$ubicacion_id' and estado = 'confirmado'");

        if ($fila_ubicacion_v = $consulta_ubicacion_v->fetch_assoc()) 
        {                            
            $usuario = $fila_ubicacion_v['usuario'];
            $venta_id = $fila_ubicacion_v['venta_id'];

            //consulto los datos de la venta
            $consulta_venta = $conexion->query("SELECT * FROM ventas_datos WHERE id = '$venta_id'");

            if ($fila_venta = $consulta_venta->fetch_assoc()) 
            {                            
                $cliente_id = $fila_venta['cliente_id'];
                $observaciones = $fila_venta['observaciones'];

                //consulto el cliente que tiene la venta
                $consulta_cliente = $conexion->query("SELECT * FROM clientes WHERE id = '$cliente_id'");           

                if ($fila_cliente = $consulta_cliente->fetch_assoc()) 
                {
                    $ubicacion_texto = ucwords($fila_cliente['nombre']);
                }
                else
                {
                    $ubicacion_texto = "$ubicacion";
                }
            }

            //consulto el usuario que tiene la venta
            $consulta_usuario = $conexion->query("SELECT * FROM usuarios WHERE id = '$usuario'");

            if ($fila = $consulta_usuario->fetch_assoc()) 
            {
                $nombres = $fila['nombres'];
                $apellidos = $fila['apellidos'];
                $atendido = "".ucwords($nombres)." ".ucwords($apellidos)."";
            }
        }

        //consulto el total de productos pedidos en la zona
        $consulta_productos = $conexion->query("SELECT * FROM ventas_productos WHERE ubicacion_id = '$ubicacion_id' and local = '$sesion_local_id' and estado = 'confirmado' and zona = '$zona_id'");
        $total_productos = $consulta_productos->num_rows;

        if ($consulta_productos->num_rows == 0)
        {
            $cantidad = "";
        }
        else
        {
            if ($consulta_productos->num_rows == 1)
            {
                $cantidad = $consulta_productos->num_rows;
            }
            else
            {
                $cantidad = $consulta_productos->num_rows;
            }
        }

        //consulto el ultimo pedido hecho
        $consulta_ultimo = $conexion->query("SELECT * FROM ventas_productos WHERE ubicacion_id = '$ubicacion_id' and local = '$sesion_local_id' and estado = 'confirmado' and zona = '$zona_id' ORDER BY fecha DESC LIMIT 1");

        while ($fila = $consulta_ultimo->fetch_assoc())
        {
            $fecha = date('d M', strtotime($fila['fecha']));
            $hora = date('h:i a', strtotime($fila['fecha']));

            //calculo el tiempo transcurrido
            $fecha = date('Y-m-d H:i:s', strtotime($fila['fecha']));
            include ("sis/tiempo_transcurrido.php");


        }

        //alerta y vibración si el pedido lleva menos de 10 segundos
        if ($segundos_transcurridos < 13)
        {               
            ?>

            <audio autoplay controls style="display: none;">
              <source src="alerta.mp3" type="audio/mpeg">
            </audio>

            <script>
            if (window.navigator && window.navigator.vibrate) {
                   navigator.vibrate([100, 100, 100, 100, 100, 100, 100, 100, 100, 100]);
            }
            </script>


            <script type="text/javascript">
                window.onload = function(){
                    Push.Permission.request();
                }

                Push.create('Notificación', {
                    body: 'Nuevo pedido',
                    icon: 'img/a1.jpg',
                    link: '/#',
                    timeout: 10000,
                    vibrate: [200, 100, 200, 100, 200, 100, 200],
                    onClick: function () {
                        window.location = "zonas_entregas_ubicaciones.php?zona_id=<?php echo "$zona_id";?>&zona=<?php echo "$zona";?>";
                        this.close();
                    }
                    
                });
                
            </script>

            <?php
            
        }

        if ($segundos_transcurridos < 26)
        {
            $item_color_fondo = "#FFEB3B";
        }
        else
        {
            $item_color_fondo = "#fff";
        }
                                
        ?>        

        

            <section class="rdm-tarjeta--zona">
                    
                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst("$ubicacion_texto"); ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo">Hace <?php echo "$tiempo_transcurrido"; ?></h2>
                    <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo ucfirst("$cantidad"); ?> Platos</h2>
                    
                    <p style="color: #F44336"><b><?php echo ucfirst("$observaciones"); ?></b></p>
                </div>



                <div class="rdm-tarjeta--cuerpo">

                    

                    

                    <?php 
                    //consulto y muestro los productos o servicios pedidos en esta zona
                    $consulta_pro = $conexion->query("SELECT * FROM ventas_productos WHERE ubicacion_id = '$ubicacion_id' and local = '$sesion_local_id' and venta_id = '$venta_id' and (estado = 'confirmado' or estado = 'entregado') and zona = '$zona_id' ORDER BY fecha, ubicacion ASC");

                    while ($fila_pro = $consulta_pro->fetch_assoc())
                    {
                        $id = $fila_pro['id'];
                        $producto = $fila_pro['producto_id'];
                        $categoria = $fila_pro['categoria'];
                        $estado = $fila_pro['estado'];

                        

                        //consulto los datos del producto
                        $consulta_producto = $conexion->query("SELECT * FROM productos WHERE id = '$producto'");           

                        if ($fila = $consulta_producto->fetch_assoc()) 
                        {
                            $producto_id = $fila['id'];
                            $producto = $fila['producto'];
                        }

                        if ($estado == "entregado")
                        {
                            $texto_pedido = '<p style="color: #009688"><strike>' . ucfirst($producto) . ' </strike></p>';                    
                        }
                        else
                        {
                            $texto_pedido = '<p style="color: none">' . ucfirst($producto) . '</p>';
                        }

                        

                        ?>

                        <a href="zonas_entregas_ubicaciones.php?entregar_uno=si&venta_id=<?php echo $venta_id ?>&id=<?php echo $id ?>&ubicacion_id=<?php echo $ubicacion_id ?>&ubicacion=<?php echo $ubicacion ?>&zona_id=<?php echo "$zona_id";?>&zona=<?php echo "$zona";?>&atendido=<?php echo "$atendido";?>&producto=<?php echo "$producto";?>">

                            <?php echo "$texto_pedido"; ?>

                        </a>

                    <?php 
                    }   
                    ?>

                    <div class="rdm-tarjeta--acciones-izquierda">            
                        <a href="zonas_entregas_ubicaciones.php?entregar=si&venta_id=<?php echo $venta_id ?>&id=<?php echo $id ?>&ubicacion_id=<?php echo $ubicacion_id ?>&ubicacion=<?php echo $ubicacion ?>&zona_id=<?php echo "$zona_id";?>&zona=<?php echo "$zona";?>&atendido=<?php echo "$atendido";?>&producto=<?php echo "$producto";?>"><button class="rdm-boton--resaltado">Listo</button></a>
                    </div>


                </div>

            </section>



        <?php
    }
    
}
?>




</div>




<div>


<?php
//consulto y muestro los productos o servicios pedidos en esta zona
$consulta = $conexion->query("SELECT distinct zona FROM ventas_productos WHERE zona = '$zona_id' and local = '$sesion_local_id' and estado = 'confirmado' ORDER BY fecha ASC");

if ($consulta->num_rows == 0)
{
    //header("location:zonas_entregas_entrada.php");

    ?>

    

    <?php
}
else                 
{
    
    while ($fila = $consulta->fetch_assoc())
    {                        
        $zona = $fila['zona'];

        //consulto los datos de la zona
        $consulta_zona = $conexion->query("SELECT * FROM zonas_entregas WHERE id = '$zona'");           

        if ($fila_zona = $consulta_zona->fetch_assoc()) 
        {
            $zona_id = $fila_zona['id'];
            $zona = $fila_zona['zona'];
        }     
                                
        ?>        

        

            <section class="rdm-tarjeta--zona">
                    
                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo">Resúmen <?php echo ucfirst("$zona"); ?></h1>
                </div>

                <div class="rdm-tarjeta--cuerpo">
                    <?php 
                    //consulto y muestro los productos o servicios pedidos en esta zona
                    $consulta_pro = $conexion->query("SELECT distinct producto_id FROM ventas_productos WHERE zona = '$zona_id' and local = '$sesion_local_id' and estado = 'confirmado' ORDER BY fecha, ubicacion ASC");

                    while ($fila_pro = $consulta_pro->fetch_assoc())
                    {
                        $producto_id = $fila_pro['producto_id'];                       

                        //consulto los datos del producto
                        $consulta_producto = $conexion->query("SELECT * FROM productos WHERE id = '$producto_id'");           

                        if ($fila = $consulta_producto->fetch_assoc()) 
                        {
                            $producto_id = $fila['id'];
                            $producto = $fila['producto'];
                        }

                        //consulto el total de productos
                        $consulta_productos = $conexion->query("SELECT * FROM ventas_productos WHERE zona = '$zona_id' and local = '$sesion_local_id' and estado = 'confirmado' and producto_id = '$producto_id'");
                        $total_productos = $consulta_productos->num_rows;

                        ?>

                        <p><b><?php echo "$total_productos"; ?></b> <?php echo ucfirst($producto) ?></p>

                    <?php 
                    }   
                    ?>


                </div>

            </section>



        <?php
    }
    
}
?>

</div>

</div>
   

</main>
    
<div id="rdm-snackbar--contenedor">
    <div class="rdm-snackbar--fila">
        <div class="rdm-snackbar--primario-<?php echo $mensaje_tema; ?>">
            <h2 class="rdm-snackbar--titulo"><?php echo "$mensaje"; ?></h2>
        </div>
    </div>
</div>
    
<footer></footer>

</body>
</html>