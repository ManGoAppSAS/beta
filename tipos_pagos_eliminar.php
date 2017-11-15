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
if(isset($_POST['id'])) $id = $_POST['id']; elseif(isset($_GET['id'])) $id = $_GET['id']; else $id = null;
?>

<?php
//consulto la información del tipo de pago
$consulta = $conexion->query("SELECT * FROM tipos_pagos WHERE id = '$id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $id = $fila['id'];
    $tipo_pago = $fila['tipo_pago'];
    $tipo = $fila['tipo'];
}
else
{
    header("location:tipos_pagos_ver.php");
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
<body>

<header class="rdm-toolbar--contenedor">
    <div class="rdm-toolbar--fila">
        <div class="rdm-toolbar--izquierda">
            <a href="tipos_pagos_editar.php?id=<?php echo "$id"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Eliminar tipo de pago</h2>
        </div>
        
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <section class="rdm-tarjeta">        

        <div class="rdm-tarjeta--primario-largo">
            <h1 class="rdm-tarjeta--titulo-largo"><?php echo ucwords($tipo_pago) ?></h1>
            <h2 class="rdm-tarjeta--subtitulo-largo"><?php echo ucfirst($tipo); ?></h2>
        </div>

        <div class="rdm-tarjeta--cuerpo">
            ¿Eliminar tipo de pago?
        </div>

        <div class="rdm-tarjeta--acciones-izquierda">
            <a href="tipos_pagos_editar.php?id=<?php echo "$id"; ?>&tipo_pago=<?php echo "$tipo_pago"; ?>"><button class="rdm-boton--plano">Cancelar</button></a>
            <a href="tipos_pagos_ver.php?eliminar=si&id=<?php echo "$id"; ?>&tipo_pago=<?php echo "$tipo_pago"; ?>"><button class="rdm-boton--plano-resaltado">Eliminar</button></a>
        </div>

    </section>

</main>

<footer></footer>

</body>
</html>