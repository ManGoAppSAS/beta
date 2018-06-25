<?php
//variables de la conexion y de sesion
include ("sis/nombre_sesion.php");
include ("sis/variables_sesion.php");

//Variable de búsqueda
$consultaBusqueda = $_POST['valorBusqueda'];

//Filtro anti-XSS
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
$consultaBusqueda = str_replace($caracteres_malos, $caracteres_buenos, $consultaBusqueda);

//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";

//Comprueba si $consultaBusqueda está seteado
if (isset($consultaBusqueda))
{	
    $consulta_resaltada = "$consultaBusqueda";
    
	$consulta = mysqli_query($conexion, "SELECT * FROM ventas_datos WHERE consecutivo LIKE '%$consultaBusqueda%' and estado = 'pendiente' ORDER BY fecha ASC LIMIT 10");

	//Obtiene la cantidad de filas que hay en la consulta
	$filas = mysqli_num_rows($consulta);

	//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
	if ($filas === 0)
    {
        $mensaje = 'No se ha encontrado <b>'.$consultaBusqueda.'</b>';

        ?>
        
        <section class="rdm-lista">

            <article class="rdm-lista--item-sencillo">
                <div class="rdm-lista--izquierda-sencillo">
                    <div class="rdm-lista--contenedor">
                        <h2 class="rdm-lista--mensaje"><?php echo "$mensaje"; ?></h2>
                    </div>
                </div>
            </article>

        </section>

        <?php
    }
    else 
    {
        ?>
        
        <section class="rdm-lista">

        <?php

		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
		while($fila = mysqli_fetch_array($consulta))
		{
		  	$venta_id = $fila['id'];
            $fecha = date('d/m/Y', strtotime($fila['fecha']));
            $hora = date('h:i a', strtotime($fila['fecha']));
            $venta_consecutivo = $fila['consecutivo'];
            $estado = $fila['estado'];
            $total_neto = $fila['total_neto'];
            $saldo_pendiente = $fila['saldo_pendiente'];
            
            ?>

            <a href="cuentas_cobrar_detalle.php?venta_id=<?php echo "$venta_id"; ?>&venta_consecutivo=<?php echo "$venta_consecutivo"; ?>">

                <article class="rdm-lista--item-doble">
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <div class="rdm-lista--icono"><i class="zmdi zmdi-case zmdi-hc-2x"></i></div>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo">Venta No <?php echo preg_replace("/$consultaBusqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($venta_consecutivo)); ?></h2>
                            <h2 class="rdm-lista--texto-secundario">A pagar: $ <?php echo number_format($total_neto, 2, ",", "."); ?></h2>
                            <h2 class="rdm-lista--texto-valor">Pendiente: $ <?php echo number_format($saldo_pendiente, 2, ",", "."); ?></h2>
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
}
?>
<h2 class="rdm-lista--titulo-largo">Cuentas por cobrar</h2>