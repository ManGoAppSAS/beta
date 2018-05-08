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
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;

if(isset($_POST['id'])) $id = $_POST['id']; elseif(isset($_GET['id'])) $id = $_GET['id']; else $id = null;
if(isset($_POST['nombre'])) $nombre = $_POST['nombre']; elseif(isset($_GET['nombre'])) $nombre = $_GET['nombre']; else $nombre = null;
if(isset($_POST['titulo'])) $titulo = $_POST['titulo']; elseif(isset($_GET['titulo'])) $titulo = $_GET['titulo']; else $titulo = null;
if(isset($_POST['regimen'])) $regimen = $_POST['regimen']; elseif(isset($_GET['regimen'])) $regimen = $_GET['regimen']; else $regimen = null;
if(isset($_POST['texto_superior'])) $texto_superior = $_POST['texto_superior']; elseif(isset($_GET['texto_superior'])) $texto_superior = $_GET['texto_superior']; else $texto_superior = null;
if(isset($_POST['resolucion_numero'])) $resolucion_numero = $_POST['resolucion_numero']; elseif(isset($_GET['resolucion_numero'])) $resolucion_numero = $_GET['resolucion_numero']; else $resolucion_numero = null;
if(isset($_POST['resolucion_fecha'])) $resolucion_fecha = $_POST['resolucion_fecha']; elseif(isset($_GET['resolucion_fecha'])) $resolucion_fecha = $_GET['resolucion_fecha']; else $resolucion_fecha = null;
if(isset($_POST['resolucion_prefijo'])) $resolucion_prefijo = $_POST['resolucion_prefijo']; elseif(isset($_GET['resolucion_prefijo'])) $resolucion_prefijo = $_GET['resolucion_prefijo']; else $resolucion_prefijo = null;
if(isset($_POST['resolucion_desde'])) $resolucion_desde = $_POST['resolucion_desde']; elseif(isset($_GET['resolucion_desde'])) $resolucion_desde = $_GET['resolucion_desde']; else $resolucion_desde = null;
if(isset($_POST['resolucion_hasta'])) $resolucion_hasta = $_POST['resolucion_hasta']; elseif(isset($_GET['resolucion_hasta'])) $resolucion_hasta = $_GET['resolucion_hasta']; else $resolucion_hasta = null;
if(isset($_POST['texto_inferior'])) $texto_inferior = $_POST['texto_inferior']; elseif(isset($_GET['texto_inferior'])) $texto_inferior = $_GET['texto_inferior']; else $texto_inferior = null;
if(isset($_POST['local'])) $local = $_POST['local']; elseif(isset($_GET['local'])) $local = $_GET['local']; else $local = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//actualizo la información de la plantilla de factura
if ($editar == "si")
{
    $actualizar = $conexion->query("UPDATE facturas_plantillas SET fecha = '$ahora', usuario = '$sesion_id', nombre = '$nombre', titulo = '$titulo', regimen = '$regimen', texto_superior = '$texto_superior', resolucion_numero = '$resolucion_numero', resolucion_fecha = '$resolucion_fecha', resolucion_prefijo = '$resolucion_prefijo', resolucion_desde = '$resolucion_desde', resolucion_hasta = '$resolucion_hasta', texto_inferior = '$texto_inferior', local = '$local' WHERE id = '$id'");

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
            <a href="facturas_plantillas_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo"><?php echo ucfirst("$nombre"); ?></h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto y muestro la plantillas de facturas
    $consulta = $conexion->query("SELECT * FROM facturas_plantillas WHERE id = '$id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Esta plantilla de factura ya no existe</p>
        </div>

        <?php
    }
    else
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $id_plantilla = $fila['id'];
            $fecha = date('d/m/Y', strtotime($fila['fecha']));
            $hora = date('h:i a', strtotime($fila['fecha']));
            $usuario = $fila['usuario'];
            $nombre = $fila['nombre'];
            $titulo = $fila['titulo'];
            $texto_superior = $fila['texto_superior'];
            $texto_inferior = $fila['texto_inferior'];
            $local = $fila['local'];
            $regimen = $fila['regimen'];
            $resolucion_numero = $fila['resolucion_numero'];
            $resolucion_fecha = date('Y-m-d', strtotime($fila['resolucion_fecha']));
            $resolucion_prefijo = $fila['resolucion_prefijo'];
            $resolucion_desde = $fila['resolucion_desde'];
            $resolucion_hasta = $fila['resolucion_hasta'];

            //consulto el local
            $consulta_local = $conexion->query("SELECT * FROM locales WHERE id = '$local'");           

            if ($fila = $consulta_local->fetch_assoc()) 
            {
                $local = $fila['local'];
                $local_texto = $fila['local'];
                $local_tipo = $fila['tipo'];
                $local_direccion = $fila['direccion'];
                $local_telefono = $fila['telefono'];
            }
            else
            {
                $local = $sesion_local;
                $local_texto = "Todos los locales";
                $local_tipo = $sesion_local_tipo;
                $local_direccion = $sesion_local_direccion;
                $local_telefono = $sesion_local_telefono;
            }

            //consulto el usuario que realizo la ultima modificacion
            $consulta_usuario = $conexion->query("SELECT * FROM usuarios WHERE id = '$usuario'");           

            if ($fila = $consulta_usuario->fetch_assoc()) 
            {
                $usuario = $fila['correo'];
            }
            ?>

            <section class="rdm-tarjeta">
            
                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst($titulo) ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo">Aplica en <?php echo ucfirst($local_texto) ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">
                    <p><b>Régimen</b> <br><?php echo ucfirst($regimen) ?></p>
                    <p><b>Texto superior</b> <br><?php echo nl2br($texto_superior) ?></p>

                    <?php
                    //si la resolución de facturacion no esta vacia muestro los datos de la resolución
                    if (($resolucion_numero != ""))
                    {
                    ?>

                    <p><b>Número de resolución</b> <br><?php echo ucfirst($resolucion_numero) ?></p>
                    <p><b>Fecha de resolución</b> <br><?php echo ucfirst($resolucion_fecha) ?></p>
                    <p><b>Prefijo de resolución</b> <br><?php echo ucfirst($resolucion_prefijo) ?></p>
                    <p><b>Rango</b> <br><?php echo ucfirst($resolucion_desde) ?> - <?php echo ucfirst($resolucion_hasta) ?></p>

                    <?php
                    }
                    ?>

                    <p><b>Texto inferior</b> <br><?php echo nl2br($texto_inferior) ?></p>
                    <p><b>Última modificación</b> <br><?php echo ucfirst("$fecha"); ?> - <?php echo ucfirst("$hora"); ?></p>
                    <p><b>Modificado por</b> <br><?php echo ("$usuario"); ?></p>
                </div>

            </section>  
            
            <?php
        }
    }
    ?>

    <h2 class="rdm-lista--titulo-largo">Vista previa</h2>

    <section class="rdm-factura">

        <article class="rdm-factura--contenedor">

            <div class="rdm-factura--texto">
                <h3><span class="rdm-formularios--ayuda">Titulo <br></span><?php echo ucfirst($titulo)?></h3>
                <h3><span class="rdm-formularios--ayuda">Texto superior <br></span><?php echo nl2br($texto_superior) ?></h3>
                <h3><span class="rdm-formularios--ayuda">Información tomada del local <br></span><?php echo ucfirst($local)?><br>
                <?php echo ucfirst($local_direccion)?><br>
                <?php echo ucfirst($local_telefono)?></h3>

                <h3><span class="rdm-formularios--ayuda">Resolución de facturación <br></span>Régimen <?php echo ucfirst($regimen)?><br>
                Resolución No <?php echo ucfirst($resolucion_numero)?><br>
                de <?php echo ucfirst($resolucion_fecha)?><br>
                Rango <?php echo ucfirst($resolucion_desde)?> - <?php echo ucfirst($resolucion_hasta)?></h3>
            </div>

            <div class="rdm-factura--izquierda"><b>Venta No <br>xxx</b></div>
            <div class="rdm-factura--derecha"><?php echo "$fecha"; ?><br> <?php echo "$hora"; ?></div>

            <div class="rdm-factura--texto">
                <p>Atendido por <b><?php echo ucwords($sesion_nombres); ?> <?php echo ucwords($sesion_apellidos); ?></b><br>
                En la ubicación <b>Mesa 1</b></p>
            </div>

            <p class="rdm-factura--izquierda"><b>Producto / Servicio</b></p>
            <p class="rdm-factura--derecha"><b>Precio</b></p>

            <section class="rdm-factura--item">
                <div class="rdm-factura--izquierda"><b>Xxxxxx</b></div>
                <div class="rdm-factura--derecha"><b>$ x.xxx</b></div>

                <div class="rdm-factura--izquierda">Base Imp.</div>
                <div class="rdm-factura--derecha">$ x</div>

                <div class="rdm-factura--izquierda">Valor Imp. (x %)</div>
                <div class="rdm-factura--derecha">$ x</div>
            </section>

            <section class="rdm-factura--item">
                <div class="rdm-factura--izquierda"><b>Xxxxxx</b></div>
                <div class="rdm-factura--derecha"><b>$ x.xxx</b></div>

                <div class="rdm-factura--izquierda">Base Imp.</div>
                <div class="rdm-factura--derecha">$ x</div>

                <div class="rdm-factura--izquierda">Valor Imp. (x %)</div>
                <div class="rdm-factura--derecha">$ x</div>
            </section>

            <br>

            <section class="rdm-factura--item">            
                <div class="rdm-factura--izquierda">Total Base Imp.</div>
                <div class="rdm-factura--derecha">$ x</div>            

                <div class="rdm-factura--izquierda">Total Valor Imp.</div>
                <div class="rdm-factura--derecha">$ x</div>        

                <div class="rdm-factura--izquierda"><b>Sub Total</b></div>
                <div class="rdm-factura--derecha"><b>$ x.xxx</b></div>
            </section>

            <br>

            <section class="rdm-factura--item">
                <div class="rdm-factura--izquierda">Descuento xx %</div>
                <div class="rdm-factura--derecha">- $ x.xxx</div>
            </section>

            <section class="rdm-factura--item">
                <div class="rdm-factura--izquierda">Propina xx %</div>
                <div class="rdm-factura--derecha"> $ xxx</div>
            </section>

            <section class="rdm-factura--item">
                <div class="rdm-factura--izquierda"><b>TOTAL A PAGAR</b></div>
                <div class="rdm-factura--derecha"><b>$ x.xxx</b></div>
            </section>

            <section class="rdm-factura--item">
                <div class="rdm-factura--izquierda">Dinero recibido</div>
                <div class="rdm-factura--derecha">$ x.xxx</div>
            </section>

            <section class="rdm-factura--item">
                <div class="rdm-factura--izquierda"><b>Cambio</b></div>
                <div class="rdm-factura--derecha"><b>$ x.xxx</b></div>
            </section>

            <section class="rdm-factura--item">
                <div class="rdm-factura--izquierda">Tipo de pago</div>
                <div class="rdm-factura--derecha">Efectivo</div>
            </section>

            <div class="rdm-factura--texto">
                <h3><span class="rdm-formularios--ayuda">Texto inferior <br></span><?php echo nl2br($texto_inferior) ?></h3>
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
    
    <a href="facturas_plantillas_editar.php?id=<?php echo "$id_plantilla"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-edit zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>