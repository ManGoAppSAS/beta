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
if(isset($_POST['unidad'])) $unidad = $_POST['unidad']; elseif(isset($_GET['unidad'])) $unidad = $_GET['unidad']; else $unidad = null;
if(isset($_POST['unidad_compra'])) $unidad_compra = $_POST['unidad_compra']; elseif(isset($_GET['unidad_compra'])) $unidad_compra = $_GET['unidad_compra']; else $unidad_compra = null;
if(isset($_POST['componente'])) $componente = $_POST['componente']; elseif(isset($_GET['componente'])) $componente = $_GET['componente']; else $componente = null;
if(isset($_POST['costo_unidad'])) $costo_unidad = $_POST['costo_unidad']; elseif(isset($_GET['costo_unidad'])) $costo_unidad = $_GET['costo_unidad']; else $costo_unidad = null;
if(isset($_POST['costo_unidad_compra'])) $costo_unidad_compra = $_POST['costo_unidad_compra']; elseif(isset($_GET['costo_unidad_compra'])) $costo_unidad_compra = $_GET['costo_unidad_compra']; else $costo_unidad_compra = null;
if(isset($_POST['proveedor'])) $proveedor = $_POST['proveedor']; elseif(isset($_GET['proveedor'])) $proveedor = $_GET['proveedor']; else $proveedor = null;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//actualizo la información del componente
if ($editar == "si")
{
    //calculo la unidad con base a la unidad de compra
    if (($unidad_compra == "k") or ($unidad_compra == "arroba 12.5 k") or ($unidad_compra == "bulto 25 k") or ($unidad_compra == "bulto 50 k"))
    {
        $unidad = "g";
    }
    else
    {
        if (($unidad_compra == "l") or ($unidad_compra == "botella 375 ml") or ($unidad_compra == "botella 750 ml") or ($unidad_compra == "botella 1500 ml") or ($unidad_compra == "garrafa 2000 ml") or ($unidad_compra == "galon 3.7 l") or ($unidad_compra == "botella 5 l") or ($unidad_compra == "botellon 18 l") or ($unidad_compra == "botellon 20 l") or ($unidad_compra == "botella 3 l"))
        {
            $unidad = "ml";
        }
        else
        {
            if ($unidad_compra == "m")
            {
                $unidad = "mm";
            }
            else
            {
                if (($unidad_compra == "par") or ($unidad_compra == "trio") or ($unidad_compra == "decena") or ($unidad_compra == "docena") or ($unidad_compra == "quincena") or ($unidad_compra == "treintena") or ($unidad_compra == "centena"))
                {
                    $unidad = "unid";
                }
                else
                {
                    $unidad = $unidad_compra;
                }
            }
        }
    }

    //si la unidad es kilos, litros o metros se divide por mil para obtener la unidad minima
    if (($unidad_compra == "k") or ($unidad_compra == "l") or ($unidad_compra == "m"))
    {
        $costo_unidad = $costo_unidad_compra / 1000;
    }
    else
    {
        if ($unidad_compra == "botella 375 ml")
        {
            $costo_unidad = $costo_unidad_compra / 375;
        }
        else
        {
            if ($unidad_compra == "botella 750 ml")
            {
                $costo_unidad = $costo_unidad_compra / 750;
            }
            else
            {
                if ($unidad_compra == "botella 1500 ml")
                {
                    $costo_unidad = $costo_unidad_compra / 1500;
                }
                else
                {
                    if ($unidad_compra == "garrafa 2000 ml")
                    {
                        $costo_unidad = $costo_unidad_compra / 2000;
                    }
                    else
                    {
                        if ($unidad_compra == "arroba 12.5 k")
                        {
                            $costo_unidad = $costo_unidad_compra / 12500;
                        }
                        else
                        {
                            if ($unidad_compra == "bulto 25 k")
                            {
                                $costo_unidad = $costo_unidad_compra / 25000;
                            }
                            else
                            {
                                if ($unidad_compra == "bulto 50 k")
                                {
                                    $costo_unidad = $costo_unidad_compra / 50000;
                                }
                                else
                                {
                                    if ($unidad_compra == "galon 3.7 l")
                                    {
                                        $costo_unidad = $costo_unidad_compra / 3785;
                                    }
                                    else
                                    {
                                        if ($unidad_compra == "botella 5 l")
                                        {
                                            $costo_unidad = $costo_unidad_compra / 5000;
                                        }
                                        else
                                        {
                                            if ($unidad_compra == "botellon 18 l")
                                            {
                                                $costo_unidad = $costo_unidad_compra / 18000;
                                            }
                                            else
                                            {
                                                if ($unidad_compra == "botellon 20 l")
                                                {
                                                    $costo_unidad = $costo_unidad_compra / 20000;
                                                }
                                                else
                                                {
                                                    if ($unidad_compra == "botella 3 l")
                                                    {
                                                        $costo_unidad = $costo_unidad_compra / 3000;
                                                    }
                                                    else
                                                    {
                                                        if ($unidad_compra == "par")
                                                        {
                                                            $costo_unidad = $costo_unidad_compra / 2;
                                                        }
                                                        else
                                                        {
                                                            if ($unidad_compra == "trio")
                                                            {
                                                                $costo_unidad = $costo_unidad_compra / 3;
                                                            }
                                                            else
                                                            {
                                                                if ($unidad_compra == "decena")
                                                                {
                                                                    $costo_unidad = $costo_unidad_compra / 10;
                                                                }
                                                                else
                                                                {
                                                                    if ($unidad_compra == "docena")
                                                                    {
                                                                        $costo_unidad = $costo_unidad_compra / 12;
                                                                    }
                                                                    else
                                                                    {
                                                                        if ($unidad_compra == "quincena")
                                                                        {
                                                                            $costo_unidad = $costo_unidad_compra / 15;
                                                                        }
                                                                        else
                                                                        {
                                                                            if ($unidad_compra == "treintena")
                                                                            {
                                                                                $costo_unidad = $costo_unidad_compra / 30;
                                                                            }
                                                                            else
                                                                            {
                                                                                if ($unidad_compra == "centena")
                                                                                {
                                                                                    $costo_unidad = $costo_unidad_compra / 100;
                                                                                }
                                                                                else
                                                                                {
                                                                                    $costo_unidad = $costo_unidad_compra;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }  
        
    $actualizar = $conexion->query("UPDATE componentes SET fecha = '$ahora', usuario = '$sesion_id', unidad = '$unidad', unidad_compra = '$unidad_compra', componente = '$componente', costo_unidad = '$costo_unidad', costo_unidad_compra = '$costo_unidad_compra', proveedor = '$proveedor' WHERE id = '$id'");

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
            <a href="componentes_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo"><?php echo ucfirst("$componente"); ?></h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <?php
    //consulto y muestro el componente
    $consulta = $conexion->query("SELECT * FROM componentes WHERE id = '$id'");

    if ($consulta->num_rows == 0)
    {
        ?>

        <div class="rdm-vacio--caja">
            <i class="zmdi zmdi-alert-circle-o zmdi-hc-4x"></i>
            <p class="rdm-tipografia--subtitulo1">Esta componente ya no existe</p>
        </div>

        <?php
    }
    else             
    {
        while ($fila = $consulta->fetch_assoc())
        {
            $id_componente = $fila['id'];
            $fecha = date('d/m/Y', strtotime($fila['fecha']));
            $hora = date('h:i a', strtotime($fila['fecha']));
            $usuario = $fila['usuario'];
            $unidad = $fila['unidad'];
            $unidad_compra = $fila['unidad_compra'];
            $componente = $fila['componente'];
            $costo_unidad = $fila['costo_unidad'];
            $costo_unidad_compra = $fila['costo_unidad_compra'];
            $proveedor = $fila['proveedor'];            

            //calculo el costro de la unidad maxima con base en el costo de la unidad
            if ($unidad == "unid")
            {
                $costo_unidad_maxima = $costo_unidad;
            }
            else
            {
                $costo_unidad_maxima = $costo_unidad * 1000;
            } 

            //consulto el proveedor
            $consulta_proveedor = $conexion->query("SELECT * FROM proveedores WHERE id = '$proveedor'");           

            if ($fila = $consulta_proveedor->fetch_assoc()) 
            {
                $proveedor = $fila['proveedor'];
            }
            else
            {
                $proveedor = "No se ha asignado un proveedor";
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
                    <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucfirst("$componente"); ?></h1>
                    <h2 class="rdm-tarjeta--subtitulo-largo">Vendido por <?php echo ucfirst($proveedor) ?></h2>
                </div>

                <div class="rdm-tarjeta--cuerpo">                    
                    <p><b>Costo unidad de compra</b> <br>$<?php echo number_format($costo_unidad_compra, 2, ",", "."); ?> x <?php echo ("$unidad_compra"); ?></p>
                    <p><b>Costo unidad mínima</b> <br>$<?php echo number_format($costo_unidad, 2, ",", "."); ?> x <?php echo ("$unidad"); ?></p>
                    <p><b>Proveedor</b> <br><?php echo ucfirst("$proveedor"); ?></p>
                    <p><b>Última modificación</b> <br><?php echo ucfirst("$fecha"); ?> - <?php echo ucfirst("$hora"); ?></p>
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
    
    <a href="componentes_editar.php?id=<?php echo "$id_componente"; ?>"><button class="rdm-boton--fab" ><i class="zmdi zmdi-edit zmdi-hc-2x"></i></button></a>

</footer>

</body>
</html>