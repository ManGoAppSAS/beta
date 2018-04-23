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
//declaro las variables que pasan por formulario o URL
if(isset($_POST['agregar'])) $agregar = $_POST['agregar']; elseif(isset($_GET['agregar'])) $agregar = $_GET['agregar']; else $agregar = null;

if(isset($_POST['nombre'])) $nombre = $_POST['nombre']; elseif(isset($_GET['nombre'])) $nombre = $_GET['nombre']; else $nombre = null;
if(isset($_POST['titulo'])) $titulo = $_POST['titulo']; elseif(isset($_GET['titulo'])) $titulo = $_GET['titulo']; else $titulo = null;
if(isset($_POST['regimen'])) $regimen = $_POST['regimen']; elseif(isset($_GET['regimen'])) $regimen = $_GET['regimen']; else $regimen = null;
if(isset($_POST['texto_superior'])) $texto_superior = $_POST['texto_superior']; elseif(isset($_GET['texto_superior'])) $texto_superior = $_GET['texto_superior']; else $texto_superior = null;
if(isset($_POST['resolucion_numero'])) $resolucion_numero = $_POST['resolucion_numero']; elseif(isset($_GET['resolucion_numero'])) $resolucion_numero = $_GET['resolucion_numero']; else $resolucion_numero = null;
if(isset($_POST['resolucion_fecha'])) $resolucion_fecha = $_POST['resolucion_fecha']; elseif(isset($_GET['resolucion_fecha'])) $resolucion_fecha = $_GET['resolucion_fecha']; else $resolucion_fecha = null;
if(isset($_POST['resolucion_rango'])) $resolucion_rango = $_POST['resolucion_rango']; elseif(isset($_GET['resolucion_rango'])) $resolucion_rango = $_GET['resolucion_rango']; else $resolucion_rango = null;
if(isset($_POST['texto_inferior'])) $texto_inferior = $_POST['texto_inferior']; elseif(isset($_GET['texto_inferior'])) $texto_inferior = $_GET['texto_inferior']; else $texto_inferior = null;
if(isset($_POST['local'])) $local = $_POST['local']; elseif(isset($_GET['local'])) $local = $_GET['local']; else $local = 0;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php 
//consulto el local enviado desde el select del formulario
$consulta_local_g = $conexion->query("SELECT * FROM locales WHERE id = '$local'");           

if ($fila = $consulta_local_g->fetch_assoc()) 
{    
    $local_g = ucfirst($fila['local']);
    $local_tipo_g = ucfirst($fila['tipo']);
    $local_g = "<option value='$local'>$local_g ($local_tipo_g)</option>";
}
else
{
    $local_g = "<option value='0'>Todos los locales</option>";
    $local_tipo_g = null;
}
?>

<?php
//agregar la plantilla de factura
if ($agregar == 'si')
{
    $consulta = $conexion->query("SELECT * FROM facturas_plantillas WHERE local = '$local'");

    if ($consulta->num_rows == 0)
    {
        $insercion = $conexion->query("INSERT INTO facturas_plantillas values ('', '$ahora', '$sesion_id', '$nombre', '$titulo', '$regimen', '$texto_superior', '$resolucion_numero', '$resolucion_fecha', '$resolucion_rango', '$texto_inferior', '$local')");

        $mensaje = "Plantilla de factura <b>" . ucfirst($nombre) . "</b> agregada";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";

        $id = $conexion->insert_id;
    }
    else
    {
        $mensaje = "La plantilla de factura <b>" . ucfirst($nombre) . "</b> ya existe, no es posible agregarla de nuevo";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "error";
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
            <h2 class="rdm-toolbar--titulo">Agregar plantilla de factura</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">
    
    <section class="rdm-formulario">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

            <p class="rdm-formularios--label"><label for="nombre">Nombre*</label></p>
            <p><input type="text" id="nombre" name="nombre" value="<?php echo "$nombre"; ?>" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre de la plantilla</p>

            <p class="rdm-formularios--label"><label for="regimen">Régimen*</label></p>
            <p><select id="regimen" name="regimen" required>
                <option value="<?php echo "$regimen"; ?>"><?php echo ucfirst("$regimen"); ?></option>
                <option value="común">Común</option>
                <option value="simplificado">Simplificado</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Régimen de facturación.</p>
            
            <p class="rdm-formularios--label"><label for="titulo">Titulo*</label></p>
            <p><input type="text" id="titulo" name="titulo" value="<?php echo "$titulo"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Ej: Factura de venta, Recibo, Cuenta de cobro, etc.</p>
            
            <p class="rdm-formularios--label"><label for="texto_superior">Texto superior*</label></p>
            <p><textarea rows="8" id="texto_superior" name="texto_superior"><?php echo "$texto_superior"; ?></textarea></p>
            <p class="rdm-formularios--ayuda">Ej: Nit xxxxxx-x, somos regimen xxx, resolución de faturación No xxx, etc.</p>

             <p class="rdm-formularios--label"><label for="resolucion_numero">Número de resolución</label></p>
            <p><input type="text" id="resolucion_numero" name="resolucion_numero" value="<?php echo "$resolucion_numero"; ?>" /></p>
            <p class="rdm-formularios--ayuda">Número de resolución de facturación.</p>

            <p class="rdm-formularios--label"><label for="resolucion_fecha">Fecha de resolución</label></p>
            <p><input type="date" id="resolucion_fecha" name="resolucion_fecha" value="<?php echo "$resolucion_fecha"; ?>" placeholder="Fecha" /></p>
            <p class="rdm-formularios--ayuda">Fecha de resolución de facturación.</p>

            <p class="rdm-formularios--label"><label for="resolucion_rango">Rango de resolución</label></p>
            <p><input type="text" id="resolucion_rango" name="resolucion_rango" value="<?php echo "$resolucion_rango"; ?>" /></p>
            <p class="rdm-formularios--ayuda">Rango de resolución de facturación.</p>
            
            <p class="rdm-formularios--label"><label for="texto_inferior">Texto inferior*</label></p>
            <p><textarea rows="8" id="texto_inferior" name="texto_inferior"><?php echo "$texto_inferior"; ?></textarea></p>
            <p class="rdm-formularios--ayuda">Ej: Gracias por su compra, vuelva pronto, propina voluntaria, etc.</p>
            
            <p class="rdm-formularios--label"><label for="local">Local*</label></p>
            <p><select id="local" name="local" required>
                <?php
                //consulto y muestro los locales
                $consulta = $conexion->query("SELECT * FROM locales ORDER BY local");

                //si solo hay un registro lo muestro por defecto
                 if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $id_local = $fila['id'];
                        $local = $fila['local'];
                        $tipo = $fila['tipo'];
                        ?>

                        <option value="<?php echo "$id_local"; ?>"><?php echo ucfirst($local) ?> (<?php echo ucfirst($tipo) ?>)</option>

                        <?php
                    }
                }
                else
                {   
                    //si hay mas de un registro los muestro todos menos el local que acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM locales WHERE id != $local ORDER BY local");

                    if (!($consulta->num_rows == 0))
                    {
                        ?>
                            
                        <?php echo "$local_g"; ?>

                        <?php
                        while ($fila = $consulta->fetch_assoc()) 
                        {
                            $id_local = $fila['id'];
                            $local = $fila['local'];
                            $tipo = $fila['tipo'];
                            ?>

                            <option value="<?php echo "$id_local"; ?>"><?php echo ucfirst($local) ?> (<?php echo ucfirst($tipo) ?>)</option>

                            <?php
                        }
                    }
                    else
                    {
                        ?>

                        <option value="">No se han agregado locales</option>

                        <?php
                    }
                }
                ?>
            </select></p>
            
            <p class="rdm-formularios--ayuda">Local al que se relaciona la plantilla</p>
            
            <button type="submit" class="rdm-boton--fab" name="agregar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>
        </form>

    </section>
    
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