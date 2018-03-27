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

    //consulto el proveedor previamente para la busqueda
    $consulta_previa = $conexion->query("SELECT * FROM proveedores WHERE proveedor like '%$consultaBusqueda%'");

    if ($filas_previa = $consulta_previa->fetch_assoc())
    {
        $proveedor = $filas_previa['id'];
    }
    else
    {
        $proveedor = null;
    }

    $consulta = mysqli_query($conexion, "SELECT * FROM componentes WHERE (unidad LIKE '%$consultaBusqueda%' or componente LIKE '%$consultaBusqueda%' or proveedor LIKE '$proveedor') and tipo = 'comprado' ORDER BY componente");

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
		  	$id = $fila['id'];
            $unidad = $fila['unidad'];
            $componente = $fila['componente'];
            $proveedor = $fila['proveedor'];
            $costo_unidad = $fila['costo_unidad'];

            //calculo la unidad maxima con base en la unidad
            if ($unidad == "g")
            {
                $unidad_maxima = "k";
            }
            else
            {
                if ($unidad == "ml")
                {
                    $unidad_maxima = "l";
                }
                else
                {
                    if ($unidad == "mm")
                    {
                        $unidad_maxima = "m";
                    }
                    else
                    {
                        $unidad_maxima = "unid";
                    }
                }
            }

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
            $consulta2 = $conexion->query("SELECT * FROM proveedores WHERE id = $proveedor");

            if ($filas2 = $consulta2->fetch_assoc())
            {
                $proveedor = $filas2['proveedor'];
            }
            else
            {
                $proveedor = "No se ha asignado un proveedor";
            }
            ?>

            <a href="componentes_detalle.php?id=<?php echo "$id"; ?>&componente=<?php echo "$componente"; ?>">

                <article class="rdm-lista--item-doble">
                
                    <div class="rdm-lista--izquierda">
                        <div class="rdm-lista--contenedor">
                            <div class="rdm-lista--icono"><i class="zmdi zmdi-widgets zmdi-hc-2x"></i></div>
                        </div>
                        <div class="rdm-lista--contenedor">
                            <h2 class="rdm-lista--titulo"><?php echo preg_replace("/$consultaBusqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($componente)); ?></h2>
                            <h2 class="rdm-lista--texto-secundario"><?php echo preg_replace("/$consultaBusqueda/i", "<span class='rdm-resaltado'>\$0</span>", ucfirst($proveedor)); ?></h2>
                            <h2 class="rdm-lista--texto-valor">$<?php echo number_format($costo_unidad, 2, ",", "."); ?> x <?php echo ("$unidad"); ?></h2>
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
<h2 class="rdm-lista--titulo-largo">Componentes agregados</h2>