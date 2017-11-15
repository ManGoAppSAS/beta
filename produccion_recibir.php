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
//variables de la sesion
include ("sis/variables_sesion.php");
?>

<?php
//capturo las variables que pasan por URL o formulario
if(isset($_POST['consultaBusqueda'])) $consultaBusqueda = $_POST['consultaBusqueda']; elseif(isset($_GET['consultaBusqueda'])) $consultaBusqueda = $_GET['consultaBusqueda']; else $consultaBusqueda = null;

if(isset($_POST['recibir'])) $recibir = $_POST['recibir']; elseif(isset($_GET['recibir'])) $recibir = $_GET['recibir']; else $recibir = null;

if(isset($_POST['componente_id'])) $componente_id = $_POST['componente_id']; elseif(isset($_GET['componente_id'])) $componente_id = $_GET['componente_id']; else $componente_id = null;
if(isset($_POST['componente'])) $componente = $_POST['componente']; elseif(isset($_GET['componente'])) $componente = $_GET['componente']; else $componente = null;
if(isset($_POST['unidad'])) $unidad = $_POST['unidad']; elseif(isset($_GET['unidad'])) $unidad = $_GET['unidad']; else $unidad = null;
if(isset($_POST['produccion_componente_id'])) $produccion_componente_id = $_POST['produccion_componente_id']; elseif(isset($_GET['produccion_componente_id'])) $produccion_componente_id = $_GET['produccion_componente_id']; else $produccion_componente_id = null;
if(isset($_POST['produccion_id'])) $produccion_id = $_POST['produccion_id']; elseif(isset($_GET['produccion_id'])) $produccion_id = $_GET['produccion_id']; else $produccion_id = null;
if(isset($_POST['cantidad'])) $cantidad = $_POST['cantidad']; elseif(isset($_GET['cantidad'])) $cantidad = $_GET['cantidad']; else $cantidad = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//consulto la información de la produccion
$consulta = $conexion->query("SELECT * FROM producciones WHERE id = '$produccion_id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $produccion_id = $fila['id'];
    $fecha = date('d M', strtotime($fila['fecha']));
    $hora = date('h:i:s a', strtotime($fila['fecha']));
    $destino = $fila['destino'];
    $estado = $fila['estado'];

    //consulto el local destino
    $consulta2 = $conexion->query("SELECT * FROM locales WHERE id = $destino");

    if ($filas2 = $consulta2->fetch_assoc())
    {
        $destino = $filas2['local'];
    }
    else
    {
        $destino = "No se ha asignado un local destino";
    }
}
?>

<?php
//agrego el componente producido al inventario del local o punto de venta
if ($recibir == 'si')
{
    $inventario_maximo = $cantidad;
    $inventario_minimo = floor(($cantidad * 20) / 100);

    //consutlo si ya existe este componente compuesto en el inventario
    $consulta_inventario = $conexion->query("SELECT * FROM inventario WHERE componente_id = '$componente_id' and local_id = '$sesion_local_id'");

    //si no existe lo creo en el inventario
    if ($consulta_inventario->num_rows == 0)
    {
        $crear_inventario = $conexion->query("INSERT INTO inventario values ('', '$ahora', '$sesion_id', '$componente_id', '$componente', '$cantidad', '$unidad', '$inventario_minimo', '$inventario_maximo', '$sesion_local_id')");

        $inventario_id = $conexion->insert_id;

        if ($crear_inventario)
        {
            $mensaje = number_format($cantidad, 0, ",", ".")." ".ucfirst($unidad)." de <b>".ucfirst($componente)."</b> creado en el inventario";
            $body_snack = 'onLoad="Snackbar()"';
            $mensaje_tema = "aviso";
        }

        $cantidad_actual = 0;
        $nueva_cantidad = $cantidad_actual + $cantidad;

        $operacion = "suma";
        $motivo = "primera produccion";
        $descripcion = "produccion No $produccion_id"; 
    }
    else
    {
        if ($fila_inventario = $consulta_inventario->fetch_assoc()) 
        {
            $inventario_id = $fila_inventario['id'];
            $cantidad_actual = $fila_inventario['cantidad'];
        }

        $nueva_cantidad = $cantidad_actual + $cantidad;

        $inventario_maximo = $nueva_cantidad;
        $inventario_minimo = floor(($nueva_cantidad * 20) / 100);

        $operacion = "suma";
        $motivo = "produccion";
        $descripcion = "produccion No $produccion_id"; 

        $actualizar_inventario = $conexion->query("UPDATE inventario SET fecha = '$ahora', cantidad = '$nueva_cantidad', componente = '$componente', minimo = '$inventario_minimo', maximo = '$inventario_maximo'  WHERE componente_id = '$componente_id' and local_id = '$sesion_local_id'");

        if ($actualizar_inventario)
        {
            $mensaje = number_format($cantidad, 0, ",", ".")." ".ucfirst($unidad)." de <b>".ucfirst($componente)."</b> actualizado en el inventario";
            $body_snack = 'onLoad="Snackbar()"';
            $mensaje_tema = "aviso";
        }
    }

    //actualizo el estado del componente en la produccion a recibido
    $actualizo_componente = $conexion->query("UPDATE producciones_componentes SET estado = 'recibido' WHERE id = '$produccion_componente_id'");

    echo "$produccion_componente_id";

    //genero la novedad
    $insertar_novedad = $conexion->query("INSERT INTO inventario_novedades values ('', '$ahora', '$sesion_id', '$inventario_id', '$cantidad_actual', '$operacion', '$cantidad', '$nueva_cantidad', '$motivo', '$descripcion')");
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
            <a href="inventario_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Recibir producción</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">    
    
    <?php
    //consulto los componentes
    $consulta = $conexion->query("SELECT * FROM producciones_componentes WHERE produccion_id = '$produccion_id' and estado = 'enviado' ORDER BY fecha DESC");

    if ($consulta->num_rows == 0)
    {
        //si ya no hay componentes por recibir cambio el estado del despacho a recibido
        $actualizo_produccion = $conexion->query("UPDATE producciones SET fecha_recibe = '$ahora', estado = 'recibido', usuario_recibe = '$sesion_id' WHERE id = '$produccion_id'");

        header("location:inventario_ver.php");        
    }

    else
    {   ?>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc()) 
        {
            $produccion_componente_id = $fila['id'];
            $fecha = date('Y/m/d', strtotime($fila['fecha']));
            $hora = date('h:i:s a', strtotime($fila['fecha']));
            $componente_id = $fila['componente_id'];
            $cantidad = $fila['cantidad'];
            $cantidadx = $fila['cantidad'];

            //consulto el componente
            $consulta2 = $conexion->query("SELECT * FROM componentes WHERE id = $componente_id");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $componente = $filas2['componente'];
                $unidad = $filas2['unidad'];
            }
            else
            {
                $componente = "No se ha asignado un componente";
            }

            //consulto el inventario actual en el destino
            $consulta3 = $conexion->query("SELECT * FROM inventario WHERE local_id = $sesion_local_id and componente_id = '$componente_id'");

            if ($filas3 = $consulta3->fetch_assoc())
            {
                $inventario_id = ucfirst($filas3['id']);
                $cantidad_actual = ucfirst($filas3['cantidad']);

                //si la cantidad actual es cero o negativa
                if ($cantidad_actual <= 0)
                {
                    $cantidad_actual = 0;
                }
            }
            else
            {
                $cantidad_actual = "0";
                $inventario_id = 1;
            }

            $cantidad_nueva = $cantidad_actual + $cantidad;
            
            ?>

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-shape zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo"><?php echo ucfirst("$componente"); ?></h2>
                        <h2 class="rdm-lista--texto-secundario"><?php echo number_format($cantidad_actual, 0, ",", "."); ?> + <span class="rdm-lista--texto-resaltado"><?php echo number_format($cantidad, 0, ",", "."); ?></span> = <?php echo number_format($cantidad_nueva, 0, ",", "."); ?> <?php echo ucfirst("$unidad"); ?></h2>
                    </div>
                </div>
                <div class="rdm-lista--derecha">
                    <a href="produccion_recibir.php?recibir=si&produccion_componente_id=<?php echo "$produccion_componente_id";?>&componente_id=<?php echo "$componente_id";?>&componente=<?php echo "$componente";?>&unidad=<?php echo "$unidad";?>&cantidad=<?php echo "$cantidadx";?>&produccion_id=<?php echo "$produccion_id";?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-check zmdi-hc-2x"></i></div></a>
                </div>
            </article>
               
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
    
<footer>

</footer>

</body>
</html>