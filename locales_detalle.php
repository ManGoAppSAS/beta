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
include('sis/subir.php');

$carpeta_destino = (isset($_GET['dir']) ? $_GET['dir'] : 'img/avatares');
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $carpeta_destino);
?>

<?php
//capturo las variables que pasan por URL o formulario
if(isset($_POST['editar'])) $editar = $_POST['editar']; elseif(isset($_GET['editar'])) $editar = $_GET['editar']; else $editar = null;
if(isset($_POST['archivo'])) $archivo = $_POST['archivo']; elseif(isset($_GET['archivo'])) $archivo = $_GET['archivo']; else $archivo = null;

if(isset($_POST['id'])) $id = $_POST['id']; elseif(isset($_GET['id'])) $id = $_GET['id']; else $id = null;
if(isset($_POST['local'])) $local = $_POST['local']; elseif(isset($_GET['local'])) $local = $_GET['local']; else $local = null;
if(isset($_POST['direccion'])) $direccion = $_POST['direccion']; elseif(isset($_GET['direccion'])) $direccion = $_GET['direccion']; else $direccion = null;
if(isset($_POST['telefono'])) $telefono = $_POST['telefono']; elseif(isset($_GET['telefono'])) $telefono = $_GET['telefono']; else $telefono = null;
if(isset($_POST['tipo'])) $tipo = $_POST['tipo']; elseif(isset($_GET['tipo'])) $tipo = $_GET['tipo']; else $tipo = null;
if(isset($_POST['apertura'])) $apertura = $_POST['apertura']; elseif(isset($_GET['apertura'])) $apertura = $_GET['apertura']; else $apertura = null;
if(isset($_POST['cierre'])) $cierre = $_POST['cierre']; elseif(isset($_GET['cierre'])) $cierre = $_GET['cierre']; else $cierre = null;
if(isset($_POST['imagen'])) $imagen = $_POST['imagen']; elseif(isset($_GET['imagen'])) $imagen = $_GET['imagen']; else $imagen = null;
if(isset($_POST['imagen_nombre'])) $imagen_nombre = $_POST['imagen_nombre']; elseif(isset($_GET['imagen_nombre'])) $imagen_nombre = $_GET['imagen_nombre']; else $imagen_nombre = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//actualizo la información del local
if ($editar == "si")
{
    if (!(isset($archivo)) && ($_FILES['archivo']['type'] == "image/jpeg") || ($_FILES['archivo']['type'] == "image/png"))
    {
        $imagen = "si";
        $imagen_nombre = $ahora_img;
        $imagen_ref = "locales";

        //si han cargado el archivo subimos la imagen        
        include('imagenes_subir.php');
    }
    else
    {
        $imagen = $imagen;
        $imagen_nombre = $imagen_nombre;
    }

    $actualizar = $conexion->query("UPDATE locales SET fecha = '$ahora', usuario = '$sesion_id', local = '$local', direccion = '$direccion', telefono = '$telefono', tipo = '$tipo', apertura = '$apertura', cierre = '$cierre', imagen = '$imagen', imagen_nombre = '$imagen_nombre' WHERE id = '$id'");

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
            <a href="locales_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo"><?php echo ucwords("$local"); ?></h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">
    
    <?php
    //consulto y muestro el local
    $consulta = $conexion->query("SELECT * FROM locales WHERE id = '$id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Este local ya no existe</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $id_local = $fila['id'];
            $fecha = date('d/m/Y', strtotime($fila['fecha']));
            $hora = date('h:i a', strtotime($fila['fecha']));
            $usuario = $fila['usuario'];
            $local = $fila['local'];
            $direccion = $fila['direccion'];
            $telefono = $fila['telefono'];
            $tipo = $fila['tipo'];
            $apertura = date('h:i a', strtotime($fila['apertura']));
            $cierre = date('h:i a', strtotime($fila['cierre']));
            $imagen = $fila['imagen'];
            $imagen_nombre = $fila['imagen_nombre'];

            if ($imagen == "no")
            {
                $imagen = "";
            }
            else
            {
                $imagen = "img/avatares/locales-$id_local-$imagen_nombre.jpg";
                $imagen = '<div class="rdm-tarjeta--media" style="background-image: url('.$imagen.');"></div>';
            }

            //consulto el usuario que realizo la ultima modificacion
            $consulta_usuario = $conexion->query("SELECT * FROM usuarios WHERE id = '$usuario'");           

            if ($fila = $consulta_usuario->fetch_assoc()) 
            {
                $usuario = $fila['correo'];
            }
            ?>

            <section class="rdm-tarjeta">

                <?php echo "$imagen"; ?>

                <div class="rdm-tarjeta--primario-largo">
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst($tipo) ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo ucfirst($direccion) ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">
                    <p><b>Teléfono</b> <br><?php echo ucfirst($telefono) ?></p>
                    <p><b>Horario de atención</b> <br><?php echo ucfirst($apertura) ?> - <?php echo ucfirst($cierre) ?></p>
                    <p><b>Última modificación</b> <br><?php echo ucfirst("$fecha"); ?> - <?php echo ucfirst("$hora"); ?></p>
                    <p><b>Modificado por</b> <br><?php echo ("$usuario"); ?></p>
                </div>

            </section>
            
            <?php
        }
    }
    ?>

    <h2 class="rdm-lista--titulo-largo">Usuarios relacionados</h2>

    <section class="rdm-lista">

        <?php
        //consulto los usuarios
        $consulta = $conexion->query("SELECT * FROM usuarios WHERE local = '$id_local' ORDER BY nombres");

        if ($consulta->num_rows == 0)
        {
            ?>

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-account zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Vacio</h2>

                    </div>
                </div>
            </article>

            <?php
        }
        else
        {   
            while ($fila = $consulta->fetch_assoc())
            {
                $id_usuario = $fila['id'];
                $nombres = $fila['nombres'];
                $apellidos = $fila['apellidos'];
                $tipo = $fila['tipo'];
                $imagen = $fila['imagen'];
                $imagen_nombre = $fila['imagen_nombre'];                

                if ($imagen == "no")
                {
                    $imagen = '<div class="rdm-lista--icono"><i class="zmdi zmdi-account zmdi-hc-2x"></i></div>';
                }
                else
                {
                    $imagen = "img/avatares/usuarios-$id_usuario-$imagen_nombre-m.jpg";
                    $imagen = '<div class="rdm-lista--avatar" style="background-image: url('.$imagen.');"></div>';
                }
                ?>                       

                <article class="rdm-lista--item-sencillo">
                    <div class="rdm-lista--izquierda-sencillo">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucwords("$nombres"); ?> <?php echo ucwords("$apellidos"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo ucfirst("$tipo"); ?></h2>
                        </div>
                    </div>
                </article>
                
                <?php
            }
        }
        ?>

    </section>
    

    <h2 class="rdm-lista--titulo-largo">Ubicaciones relacionadas</h2>

    <section class="rdm-lista">

        <?php
        //consulto y muestro las ubicaciones
        $consulta = $conexion->query("SELECT * FROM ubicaciones WHERE local = '$id_local' ORDER BY ubicada, ubicacion");

        if ($consulta->num_rows == 0)
        {
            ?>

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <div class="rdm-lista--icono"><i class="zmdi zmdi-seat zmdi-hc-2x"></i></div>
                    </div>
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--titulo">Vacio</h2>

                    </div>
                </div>
            </article>

            <?php
        }
        else
        {
            while ($fila = $consulta->fetch_assoc())
            {
                $id = $fila['id'];
                $fecha = date('d M', strtotime($fila['fecha']));
                $hora = date('h:i:s a', strtotime($fila['fecha']));
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

                if ($tipo == "barra")
                {
                    $imagen = '<div class="rdm-lista--icono"><i class="zmdi zmdi-drink zmdi-hc-2x"></i></div>';
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

                <article class="rdm-lista--item-sencillo">
                    <div class="rdm-lista--izquierda-sencillo">
                        <div class="rdm-lista--contenedor">
                            <?php echo "$imagen"; ?>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo ucfirst("$ubicacion"); ?></h2>
                            <h2 class="rdm-lista--texto-secundario">Ubicada en <?php echo ucfirst("$ubicada"); ?></h2>
                        </div>
                    </div>
                </article>
                
                <?php
            }
        }
        ?>

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
    
    <a href="locales_editar.php?id=<?php echo "$id_local"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-edit zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>