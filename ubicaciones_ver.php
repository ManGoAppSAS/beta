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
if(isset($_POST['eliminar'])) $eliminar = $_POST['eliminar']; elseif(isset($_GET['eliminar'])) $eliminar = $_GET['eliminar']; else $eliminar = null;
if(isset($_POST['consultaBusqueda'])) $consultaBusqueda = $_POST['consultaBusqueda']; elseif(isset($_GET['consultaBusqueda'])) $consultaBusqueda = $_GET['consultaBusqueda']; else $consultaBusqueda = null;

if(isset($_POST['id'])) $id = $_POST['id']; elseif(isset($_GET['id'])) $id = $_GET['id']; else $id = null;
if(isset($_POST['ubicacion'])) $ubicacion = $_POST['ubicacion']; elseif(isset($_GET['ubicacion'])) $ubicacion = $_GET['ubicacion']; else $ubicacion = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//elimino la ubicación
if ($eliminar == "si")
{
    $borrar = $conexion->query("DELETE FROM ubicaciones WHERE id = '$id'");

    if ($borrar)
    {
        $mensaje = "Ubicación eliminada";
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

    <script>
    $(document).ready(function() {
        $("#resultadoBusqueda").html('');
    });

    function buscar() {
        var textoBusqueda = $("input#busqueda").val();
     
         if (textoBusqueda != "") {
            $.post("ubicaciones_buscar.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
                $("#resultadoBusqueda").html(mensaje);
             }); 
         } else { 
            $("#resultadoBusqueda").html('');
            };
    };
    </script>
</head>

<body <?php echo $body_snack; ?>>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="ajustes.php#ubicaciones"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Ubicaciones</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto y muestro las ubicaciones
    if ($sesion_tipo == "socio")
    {
        $consulta = $conexion->query("SELECT * FROM ubicaciones ORDER BY local, ubicacion");
    }
    else
    {
        $consulta = $conexion->query("SELECT * FROM ubicaciones WHERE local = '$sesion_local_id' ORDER BY local, ubicacion");
    }    

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">No se han agregado ubicaciones</p>
            <p class="rdm-tipografia--cuerpo1--margen-ajustada">Las ubicaciones son los distintos lugares desde donde puedes atender a tus clientes en un punto de venta. Todas las ventas siempre comienzan desde una ubicación, por ejemplo: mesas, barras, habitaciones, cajas registradoras, etc.</p>
        </div>

        <?php
    }
    else
    {
        ?>

        <input type="search" name="busqueda" id="busqueda" value="<?php echo "$consultaBusqueda"; ?>" placeholder="Buscar" maxlength="30" autofocus autocomplete="off" onKeyUp="buscar();" onFocus="buscar();" />

        <div id="resultadoBusqueda"></div>

        <section class="rdm-lista">

        <?php
        while ($fila = $consulta->fetch_assoc())
        {
            $id = $fila['id'];
            $ubicacion = $fila['ubicacion'];
            $ubicada = $fila['ubicada'];
            $estado = $fila['estado'];
            $tipo = $fila['tipo'];
            $local = $fila['local'];

            //consulto el local
            $consulta2 = $conexion->query("SELECT * FROM locales WHERE id = $local");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $local = $filas2['local'];
                $local_tipo = $filas2['tipo'];
            }
            else
            {
                $local = "No se ha asignado un local";
                $local_tipo = "--";
            }

            //muestro el icono según el tipo de ubicación
            if ($tipo == "barra")
            {
                $imagen = '<div class="rdm-lista--icono"><i class="zmdi zmdi-cocktail zmdi-hc-2x"></i></div>';
            }
            else
            {
                if ($tipo == "caja")
                {
                    $imagen = '<div class="rdm-lista--icono"><i class="zmdi zmdi-laptop zmdi-hc-2x"></i></div>';
                }
                else
                {
                    if ($tipo == "habitacion")
                    {
                        $imagen = '<div class="rdm-lista--icono"><i class="zmdi zmdi-hotel zmdi-hc-2x"></i></div>';
                    }
                    else
                    {
                        if ($tipo == "mesa")
                        {
                            $imagen = '<div class="rdm-lista--icono"><i class="zmdi zmdi-cutlery zmdi-hc-2x"></i></div>';
                        }
                        else
                        {
                            if ($tipo == "persona")
                            {
                                $imagen = '<div class="rdm-lista--icono"><i class="zmdi zmdi-face zmdi-hc-2x"></i></div>';
                            }
                            else
                            {
                                $imagen = '<div class="rdm-lista--icono"><i class="zmdi zmdi-seat zmdi-hc-2x"></i></div>';
                            }
                        }
                    }
                }
            }
            ?>

            <a href="ubicaciones_detalle.php?id=<?php echo "$id"; ?>&ubicacion=<?php echo "$ubicacion"; ?>">

                <article class="rdm-lista--item-sencillo">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst("$ubicacion"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst("$local"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario">Ubicada en <?php echo ucfirst("$ubicada"); ?></h2>
                        </div>
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
    
<footer>
    
    <a href="ubicaciones_agregar.php"><button class="rdm-boton--fab" ><i class="zmdi zmdi-plus zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>