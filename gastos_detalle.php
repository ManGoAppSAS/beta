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
?>

<?php
//capturo las variables que pasan por URL o formulario
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;

if(isset($_POST['id'])) $id = $_POST['id']; elseif(isset($_GET['id'])) $id = $_GET['id']; else $id = null;
if(isset($_POST['tipo'])) $tipo = $_POST['tipo']; elseif(isset($_GET['tipo'])) $tipo = $_GET['tipo']; else $tipo = null;
if(isset($_POST['concepto'])) $concepto = $_POST['concepto']; elseif(isset($_GET['concepto'])) $concepto = $_GET['concepto']; else $concepto = null;
if(isset($_POST['valor'])) $valor = $_POST['valor']; elseif(isset($_GET['valor'])) $valor = $_GET['valor']; else $valor = null;
if(isset($_POST['local'])) $local = $_POST['local']; elseif(isset($_GET['local'])) $local = $_GET['local']; else $local = 0;

if(isset($_POST['fecha'])) $fecha = $_POST['fecha']; elseif(isset($_GET['fecha'])) $fecha = $_GET['fecha']; else $fecha = date('Y-m-d');
if(isset($_POST['hora'])) $hora = $_POST['hora']; elseif(isset($_GET['hora'])) $hora = $_GET['hora']; else $hora = date('H:i');

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//actualizo la información del gasto
if ($editar == "si")
{   
    $fecha_gasto = date("$fecha $hora:s");
    $valor = str_replace('.','',$valor);

    $actualizar = $conexion->query("UPDATE gastos SET fecha = '$fecha_gasto', usuario = '$sesion_id', tipo = '$tipo', concepto = '$concepto', valor = '$valor', local = '$local' WHERE id = '$id'");

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
            <a href="gastos_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo"><?php echo ucfirst("$concepto"); ?></h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">
            
    <?php
    //consulto y muestro el gasto
    $consulta = $conexion->query("SELECT * FROM gastos WHERE id = '$id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Este gasto ya no existe</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $id = $fila['id'];
            $fecha = date('d/m/Y', strtotime($fila['fecha']));
            $hora = date('h:i a', strtotime($fila['fecha']));
            $usuario = $fila['usuario'];
            $tipo = $fila['tipo'];
            $concepto = $fila['concepto'];
            $valor = $fila['valor'];
            $local = $fila['local'];                        

            //consulto el local
            $consulta_local = $conexion->query("SELECT * FROM locales WHERE id = '$local'");           

            if ($fila = $consulta_local->fetch_assoc()) 
            {
                $local = $fila['local'];
                $local_tipo = ucfirst($fila['tipo']);
                $local_tipo = "($local_tipo)";
            }
            else
            {
                $local = "No se ha asignado un local";
                $local_tipo = null;
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
                    <h1 class="rdm-tarjeta--titulo-largo">$ <?php echo number_format($valor, 0, ",", "."); ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo ucfirst($tipo) ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">
                    <p><b>Local</b> <br><?php echo ucfirst($local) ?> <?php echo ucfirst($local_tipo) ?></p>
                    <p><b>Fecha</b> <br><?php echo ucfirst("$fecha"); ?> - <?php echo ucfirst("$hora"); ?></p>
                    <p><b>Modificado por</b> <br><?php echo ("$usuario"); ?></p>
                </div>

            </section>
            
            <?php
        }
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
    
    <a href="gastos_editar.php?id=<?php echo "$id"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-edit zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>