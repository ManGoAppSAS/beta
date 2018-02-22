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
            $("#mostrar_consulta").load('zonas_entregas_entrada_consulta.php')
            }, 4000);
        });
    </script>
    <meta http-equiv="refresh" content="7;URL=zonas_entregas_entrada.php">
</head>

<body>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="index.php#zonas"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Zonas de entrega</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

<?php
//consulto y muestro las zonas de entregas activas en el local
$consulta = $conexion->query("SELECT distinct local, zona FROM ventas_productos WHERE local = '$sesion_local_id' and estado = 'confirmado' ORDER BY zona");

if ($consulta->num_rows == 0)
{
    ?>        

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

    <?php
}
else                 
{
    ?>

    <section class="rdm-lista">

    <?php

    while ($fila = $consulta->fetch_assoc())
    {
        $local = $fila['local'];
        $zona = $fila['zona'];

        //consulto el total de productos pedidos en la zona
        $consulta_productos = $conexion->query("SELECT * FROM ventas_productos WHERE zona = '$zona' and local = '$sesion_local_id' and estado = 'confirmado'");
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
        $consulta_ultimo = $conexion->query("SELECT * FROM ventas_productos WHERE zona = '$zona' and local = '$sesion_local_id' and estado = 'confirmado' ORDER BY fecha DESC LIMIT 1");

        while ($fila = $consulta_ultimo->fetch_assoc())
        {
            $fecha = date('d M', strtotime($fila['fecha']));
            $hora = date('h:i a', strtotime($fila['fecha']));

            //calculo el tiempo transcurrido
            $fecha = date('Y-m-d H:i:s', strtotime($fila['fecha']));
            include ("sis/tiempo_transcurrido.php");
        }

        //consulto la zona
        $consulta_zona = $conexion->query("SELECT * FROM zonas_entregas WHERE id = '$zona'");           

        if ($fila = $consulta_zona->fetch_assoc()) 
        {
            $zona_id = $fila['id'];
            $zona = $fila['zona'];
        }
        else
        {
            $zona_id = 0;
            $zona = "Principal";
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

                Push.config({
                    serviceWorker: './service-worker.js', // Sets a custom service worker script
                    fallback: function(payload) {
                    }
                });

                Push.create('Notificación', {
                    body: 'Nuevo pedido',
                    icon: 'img/a1.jpg',
                    link: '/#',
                    timeout: 10000,
                    vibrate: [200, 100, 200, 100, 200, 100, 200],
                    onClick: function () {
                        window.location = "zonas_entregas_entrada.php";
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

        <a href="zonas_entregas_ubicaciones.php?zona_id=<?php echo "$zona_id";?>&zona=<?php echo "$zona";?>">

            <article class="rdm-lista--item-sencillo" style="background-color: <?php echo $item_color_fondo ?>;">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-assignment-o zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo"><?php echo ucfirst("$zona"); ?></h2>
                        <h2 class="rdm-lista--texto-secundario">Último pedido hace <?php echo "$tiempo_transcurrido"; ?></h2>
                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <div class="rdm-lista--contador"><h2 class="rdm-lista--texto-contador"><?php echo ucfirst("$cantidad"); ?></h2></div>
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
    
<footer></footer>

</body>
</html>