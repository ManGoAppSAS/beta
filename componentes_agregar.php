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

if(isset($_POST['unidad_compra'])) $unidad_compra = $_POST['unidad_compra']; elseif(isset($_GET['unidad_compra'])) $unidad_compra = $_GET['unidad_compra']; else $unidad_compra = null;
if(isset($_POST['unidad'])) $unidad = $_POST['unidad']; elseif(isset($_GET['unidad'])) $unidad = $_GET['unidad']; else $unidad = null;
if(isset($_POST['componente'])) $componente = $_POST['componente']; elseif(isset($_GET['componente'])) $componente = $_GET['componente']; else $componente = null;
if(isset($_POST['costo_unidad'])) $costo_unidad = $_POST['costo_unidad']; elseif(isset($_GET['costo_unidad'])) $costo_unidad = $_GET['costo_unidad']; else $costo_unidad = null;
if(isset($_POST['costo_unidad_compra'])) $costo_unidad_compra = $_POST['costo_unidad_compra']; elseif(isset($_GET['costo_unidad_compra'])) $costo_unidad_compra = $_GET['costo_unidad_compra']; else $costo_unidad_compra = null;
if(isset($_POST['proveedor'])) $proveedor = $_POST['proveedor']; elseif(isset($_GET['proveedor'])) $proveedor = $_GET['proveedor']; else $proveedor = 0;

if(isset($_POST['mensaje'])) $mensaje = $_POST['mensaje']; elseif(isset($_GET['mensaje'])) $mensaje = $_GET['mensaje']; else $mensaje = null;
if(isset($_POST['body_snack'])) $body_snack = $_POST['body_snack']; elseif(isset($_GET['body_snack'])) $body_snack = $_GET['body_snack']; else $body_snack = null;
if(isset($_POST['mensaje_tema'])) $mensaje_tema = $_POST['mensaje_tema']; elseif(isset($_GET['mensaje_tema'])) $mensaje_tema = $_GET['mensaje_tema']; else $mensaje_tema = null;
?>

<?php
//consulto el proveedor enviado desde el select del formulario
$consulta_proveedor_g = $conexion->query("SELECT * FROM proveedores WHERE id = '$proveedor'");           

if ($fila = $consulta_proveedor_g->fetch_assoc()) 
{    
    $proveedor_g = ucfirst($fila['proveedor']);
    $proveedor_g = "<option value='$proveedor'>$proveedor_g</option>";
}
else
{
    $proveedor_g = "<option value=''></option>";
}
?>

<?php
//agregar el componente
if ($agregar == 'si')
{
    $consulta = $conexion->query("SELECT * FROM componentes WHERE componente = '$componente' and proveedor = '$proveedor' LIMIT 1");

    if ($consulta->num_rows == 0)
    {
        //calculo la unidad con base a la unidad de compra
        if ($unidad_compra == "k")
        {
            $unidad = "g";
        }
        else
        {
            if (($unidad_compra == "l") or ($unidad_compra == "botella 375 ml") or ($unidad_compra == "botella 750 ml") or ($unidad_compra == "botella 1500 ml") or ($unidad_compra == "garrafa 2000 ml"))
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
                    $unidad = $unidad_compra;
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
                            $costo_unidad = $costo_unidad_compra;
                        }
                    }
                }
            }
        }        

        $insercion = $conexion->query("INSERT INTO componentes values ('', '$ahora', '$sesion_id', '$unidad', '$unidad_compra', '$componente', '$costo_unidad', '$costo_unidad_compra', '$proveedor', '0', 'comprado')");

        $mensaje = "Componente <b>" . ucfirst($componente) . "</b> agregado";
        $body_snack = 'onLoad="Snackbar()"';
        $mensaje_tema = "aviso";

        $id = $conexion->insert_id;
    }
    else
    {
        $mensaje = "El componente <b>" . ucfirst($componente) . "</b> ya existe, no es posible agregarlo de nuevo";
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
            <a href="componentes_ver.php"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Agregar componente</h2>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">
    
    <section class="rdm-formulario">

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            
            <p class="rdm-formularios--label"><label for="componente">Nombre*</label></p>
            <p><input type="text" id="componente" name="componente" value="<?php echo "$componente"; ?>" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Nombre del componente</p>

            <p class="rdm-formularios--label"><label for="proveedor">Proveedor*</label></p>
            <p><select id="proveedor" name="proveedor" required>
                <?php
                //consulto y muestro los proveedores
                $consulta = $conexion->query("SELECT * FROM proveedores ORDER BY proveedor");

                //si solo hay un registro lo muestro por defecto
                 if ($consulta->num_rows == 1)
                {
                    while ($fila = $consulta->fetch_assoc()) 
                    {
                        $id_proveedor = $fila['id'];
                        $proveedor = $fila['proveedor'];
                        $tipo = $fila['tipo'];
                        ?>

                        <option value="<?php echo "$id_proveedor"; ?>"><?php echo ucfirst($proveedor) ?></option>

                        <?php
                    }
                }
                else
                {   
                    //si hay mas de un registro los muestro todos menos el proveedor que acabe de guardar
                    $consulta = $conexion->query("SELECT * FROM proveedores WHERE id != $proveedor ORDER BY proveedor");

                    if (!($consulta->num_rows == 0))
                    {
                        ?>
                            
                        <?php echo "$proveedor_g"; ?>

                        <?php
                        while ($fila = $consulta->fetch_assoc()) 
                        {
                            $id_proveedor = $fila['id'];
                            $proveedor = $fila['proveedor'];
                            $tipo = $fila['tipo'];
                            ?>

                            <option value="<?php echo "$id_proveedor"; ?>"><?php echo ucfirst($proveedor) ?></option>

                            <?php
                        }
                    }
                    else
                    {
                        ?>

                        <option value="0">No se han agregado proveedores</option>

                        <?php
                    }
                }
                ?>
            </select></p>
            <p class="rdm-formularios--ayuda">Proveedor que suministra o vende el componente</p>
            
            <p class="rdm-formularios--label"><label for="unidad_compra">Unidad de compra*</label></p>
            <p><select id="unidad_compra" name="unidad_compra" required>
                <option value="<?php echo "$unidad_compra"; ?>"><?php echo $unidad_compra ?></option>
                <option value="">---------</option>
                <option value="g">g</option>
                <option value="ml">ml</option>
                <option value="mm">mm</option>
                <option value="">---------</option>
                <option value="k">k</option>
                <option value="l">l</option>
                <option value="m">m</option>
                <option value="">---------</option>             
                <option value="botella 375 ml">botella 375 ml</option>
                <option value="botella 750 ml">botella 750 ml</option>
                <option value="botella 1500 ml">botella 1500 ml</option>
                <option value="garrafa 2000 ml">garrafa 2000 ml</option>
                <<option value="">---------</option>
                <option value="unid">unid</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Unidad de compra del componente</p>

            <p class="rdm-formularios--label"><label for="costo_unidad_compra">Costo unidad de compra*</label></p>
            <p><input type="number" id="costo_unidad_compra" name="costo_unidad_compra" value="<?php echo "$costo_unidad_compra"; ?>" step="any" required /></p>
            <p class="rdm-formularios--ayuda">Costo de la unidad de compra</p>

            
            
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