<?php
//inicio la sesión
session_start();

//verifico si la sesión está creada y si no lo está lo envio al logueo
if (!isset($_SESSION['correo']))
{
    header("location:logueo.php");
}
?>

<?php
//variables de la conexion y de sesion
include ("sis/conexion.php");
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
</head>
<body>

    <header>
        <div class="header_contenedor">
            <div class="cabezote_col_izq">
                <h2><a href="index.php"><div class="flecha_izq"></div> <span class="logo_txt"> Inicio</span></a></h2>
            </div>
            <div class="cabezote_col_cen">
                <h2><a href="index.php"><div class="logo_img"></div> <span class="logo_txt">ManGo!</span></a></h2>
            </div>
            <div class="cabezote_col_der">
                <h2></h2>
            </div>
        </div>
    </header>

    <section id="contenedor">

        <article class="bloque">
            <div class="img_arriba_ajustes" style="background-image: url('img/sis/ajustes.jpg');"></div>
            <h2 class="cab_texto">Ajustes</h2>
            <div class="bloque_margen">
                <p>Puedes ajustar toda la información necesaria para que ManGo! funcione como tu quieras en este lugar. Si es la primera vez que usas ManGo! te recomendamos seguir los ajustes en el siguiente orden…</p>
            </div>
        </article>        

        <article class="bloque">
            <div class="bloque_margen">
                <h2>1. Locales</h2>
                <p>Los locales son todos los puntos de venta que puedes tener en tu negocio, por ejemplo: punto de venta Bogotá, punto de venta Medellín, punto de venta barrio poblado, punto de venta centro comercial del norte, etc.</p>
                <?php
                //consulto los locales                
                $consulta = $conexion->query("SELECT * FROM locales");

                if ($consulta->num_rows)
                {
                    ?>

                    <p><a href="locales_ver.php"><input type="button" class="proceder" value="Ver los <?php echo ($consulta->num_rows); ?> locales"></a></p>

                    <?php
                }

                else
                {
                    ?>

                    <p><a href="locales_agregar.php"><input type="button" class="neutral" value="Agregar un local"></a></p>

                    <?php 
                }
                ?>
            </div>
        </article>

        <article class="bloque">
            <div class="bloque_margen">
                <h2>2. Usuarios</h2>
                <p>Los usuarios son todas las personas que interactúan en tu negocio, por ejemplo: meseros, vendedores, socios, administradores, etc.</p>
                <?php
                //consulto los usuarios                
                $consulta = $conexion->query("SELECT * FROM usuarios");

                if ($consulta->num_rows)
                {
                    ?>

                    <p><a href="usuarios_ver.php"><input type="button" class="proceder" value="Ver los <?php echo ($consulta->num_rows); ?> usuarios"></a></p>

                    <?php
                }

                else
                {
                    ?>

                    <p><a href="usuarios_agregar.php"><input type="button" class="neutral" value="Agregar un usuario"></a></p>

                    <?php 
                }
                ?>
            </div>
        </article>
        <article class="bloque">
            <div class="bloque_margen">
                <h2>3. Ubicaciones</h2>
                <p>Las ubicaciones son los distintos lugares desde los cuales puedes atender a tus clientes en un punto de venta todas las ventas siempre comienzan desde una ubicación, por ejemplo: mesas, barras, habitaciones, cajas registradoras, etc.</p>
                <?php
                //consulto las ubicaciones                
                $consulta = $conexion->query("SELECT * FROM ubicaciones");

                if ($consulta->num_rows)
                {
                    ?>

                    <p><a href="ubicaciones_ver.php"><input type="button" class="proceder" value="Ver las <?php echo ($consulta->num_rows); ?> ubicaciones"></a></p>

                    <?php
                }

                else
                {
                    ?>

                    <p><a href="ubicaciones_agregar.php"><input type="button" class="neutral" value="Agregar una ubicacion"></a></p>

                    <?php 
                }
                ?>
            </div>
        </article>
        <article class="bloque">
            <div class="bloque_margen">
                <h2>4. Impuestos</h2>
                <p>Los impuestos son todas las obligaciones tributarias que tus productos o servicios generan, por ejemplo: IVA, impuesto gastronómico, impuesto de licores, etc.</p>
                <?php
                //consulto los impuestos                
                $consulta = $conexion->query("SELECT * FROM impuestos");

                if ($consulta->num_rows)
                {
                    ?>

                    <p><a href="impuestos_ver.php"><input type="button" class="proceder" value="Ver los <?php echo ($consulta->num_rows); ?> impuestos"></a></p>

                    <?php
                }

                else
                {
                    ?>

                    <p><a href="impuestos_agregar.php"><input type="button" class="neutral" value="Agregar un impuesto"></a></p>

                    <?php 
                }
                ?>
            </div>
        </article>
        <article class="bloque">
            <div class="bloque_margen">
                <h2>5. Tipos de pago</h2>
                <p>Los tipos de pagos son los diferentes medios de cambio que recibes en tu negocio cuando tus clientes hacen una compra, por ejemplo: efectivo, tarjeta débito, cheque, canje de servicios, etc.</p>
                <?php
                //consulto los tipos de pago                
                $consulta = $conexion->query("SELECT * FROM tipos_pagos");

                if ($consulta->num_rows)
                {
                    ?>

                    <p><a href="tipos_pagos_ver.php"><input type="button" class="proceder" value="Ver los <?php echo ($consulta->num_rows); ?> tipos de pago"></a></p>

                    <?php
                }

                else
                {
                    ?>

                    <p><a href="tipos_pagos_agregar.php"><input type="button" class="neutral" value="Agregar un tipo de pago"></a></p>

                    <?php 
                }
                ?>
            </div>
        </article>
        <article class="bloque">
            <div class="bloque_margen">
                <h2>6. Descuentos</h2>
                <p>Los descuentos son los valores y porcentajes de regalo que puedes generar para tus clientes cuando ellos hagan una compra, por ejemplo: mitad de precio, hora feliz, cumpleaños, etc.</p>
                <?php
                //consulto los descuentos                
                $consulta = $conexion->query("SELECT * FROM descuentos");

                if ($consulta->num_rows)
                {
                    ?>

                    <p><a href="descuentos_ver.php"><input type="button" class="proceder" value="Ver los <?php echo ($consulta->num_rows); ?> descuentos"></a></p>

                    <?php
                }

                else
                {
                    ?>

                    <p><a href="descuentos_agregar.php"><input type="button" class="neutral" value="Agregar un descuento"></a></p>

                    <?php 
                }
                ?>
            </div>
        </article>
        <article class="bloque">
            <div class="bloque_margen">
                <h2>7. Categorías</h2>
                <p>Las categorías son los grupos o familias en los que están divididos los productos o servicios que vendes en tu negocio, por ejemplo: carnes, bebidas, licores, postres, etc.</p>
                <?php
                //consulto las categorias                
                $consulta = $conexion->query("SELECT * FROM productos_categorias");

                if ($consulta->num_rows)
                {
                    ?>

                    <p><a href="categorias_ver.php"><input type="button" class="proceder" value="Ver las <?php echo ($consulta->num_rows); ?> categorías"></a></p>

                    <?php
                }

                else
                {
                    ?>

                    <p><a href="categorias_agregar.php"><input type="button" class="neutral" value="Agregar una categoría"></a></p>

                    <?php 
                }
                ?>
            </div>
        </article>
        <article class="bloque">
            <div class="bloque_margen">
                <h2>8. Productos</h2>
                <p>Los productos son todos los artículos o servicios que vendes en tu negocio, estos estarán divididos en las categorías que crees, por ejemplo: gaseosa pequeña, hamburguesa mediana, postre de fresa, etc.</p>
                <?php
                //consulto los productos                
                $consulta = $conexion->query("SELECT * FROM productos");

                if ($consulta->num_rows)
                {
                    ?>

                    <p><a href="productos_ver.php"><input type="button" class="proceder" value="Ver los <?php echo ($consulta->num_rows); ?> productos"></a></p>

                    <?php
                }

                else
                {
                    ?>

                    <p><a href="productos_agregar.php"><input type="button" class="neutral" value="Agregar un producto"></a></p>

                    <?php 
                }
                ?>
            </div>
        </article>        
    </section>    
    <footer></footer>
</body>
</html>