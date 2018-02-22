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

<?php
//consulto el total de locales agregados y el total a pagar
$consulta = $conexion->query("SELECT * FROM locales");
$locales = $consulta->num_rows;
$valor_mes = 100000;
$total_pago = $valor_mes * $locales;
?>

    <header>
        <div class="header_contenedor">
            <div class="cabezote_col_izq">
                <h2><a href="ajustes.php#pago"><div class="flecha_izq"></div> <span class="logo_txt"> Ajustes</span></a></h2>
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
            <div class="img_arriba_ajustes" style="background-image: url('img/sis/tipos_pago.jpg');"></div>
            <h2 class="cab_texto">Pagar</h2>
            <div class="bloque_margen">

                <p>Aquí podrás realizar el pago de tu servicio con ManGo! Podrás realizarlo a través de tarjeta débito, tarjeta crédito u otros métodos de pago.</p>
                



                    <form id="frm_botonePayco" name="frm_botonePayco" method="post" action="https://secure.payco.co/checkout.php"> 
                        <input name="p_cust_id_cliente" type="hidden" value="10072">
                        <input name="p_key" type="hidden" value="8d73d2d2ec3c98b311a8123f9cc8c3548827c943">
                        <input name="p_id_invoice" type="hidden" value="">
                        <input name="p_description" type="hidden" value=" Pago de servicio mensual de aplicación web ManGo! App SAS">
                        <input name="p_currency_code" type="hidden" value="COP">
                        <input name="p_amount" id="p_amount" type="hidden" value="100000.00">
                        <input name="p_tax" id="p_tax" type="hidden" value="0">
                        <input name="p_amount_base" id="p_amount_base" type="hidden" value="0">
                        <input name="p_test_request" type="hidden" value="FALSE">
                        <input name="p_url_response" type="hidden" value="respuesta_cliente.php"> 
                        <input name="p_url_confirmation" type="hidden" value="confirmacion_pago.php"> 
                        <input name="p_signature" type="hidden" id="signature"  value="6a016d38030fc4406a2ab4223aa0e16a" />
                        <input name="idboton"type="hidden" id="idboton"  value="1100" />  
                        <p class="alineacion_botonera"><input type="image" id="imagen" class="proceder" value="Realizar pago" /></p>
                    </form>








   






            </div>
        </article>

        <article class="bloque">
            <div class="bloque_margen">
                <h2>Valor a pagar</h2>
                <p class="ingresos_texto">$100.000</p>
            </div>
        </article>  

    </section>
    <footer></footer>
</body>
</html>