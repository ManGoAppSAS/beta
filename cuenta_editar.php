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
//consulto la información del usuario
$consulta = $conexion2->query("SELECT * FROM clientes_datos WHERE id = '$id'");

if ($fila = $consulta->fetch_assoc()) 
{
    $id = $fila['id'];
    $correo = $fila['correo'];
    $contrasena = $fila['contrasena'];
    $nombre = $fila['nombre'];

    $razon_social = $fila['razon_social'];
    $documento_tipo = $fila['documento_tipo'];
    $documento = $fila['documento'];
    $telefono = $fila['telefono'];
    $celular = $fila['celular'];
    $pais = $fila['pais'];
    $ciudad = $fila['ciudad'];

    $ejecutivo_comercial = $fila['ejecutivo_comercial'];
    $imagen = $fila['imagen'];
    $imagen_nombre = $fila['imagen_nombre'];    
}
else
{
    header("location:ajustes.php");
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
            <a href="cuenta_detalle.php?id=<?php echo "$id"; ?>&nombres=<?php echo "$nombres"; ?>&apellidos=<?php echo "$apellidos"; ?>"><div class="rdm-toolbar--icono"><i class="zmdi zmdi-arrow-left zmdi-hc-2x"></i></div></a>
            <h2 class="rdm-toolbar--titulo">Editar cuenta</h2>
        </div>
        <div class="rdm-toolbar--derecha">
            <a href="usuarios_eliminar.php?id=<?php echo "$id"; ?>&nombres=<?php echo "$nombres"; ?>&apellidos=<?php echo "$apellidos"; ?>"><div class="rdm-lista--icono"><i class="zmdi zmdi-delete zmdi-hc-2x"></i></div></a>
        </div>
    </div>
</header>

<main class="rdm--contenedor-toolbar">

    <section class="rdm-formulario">

        <form action="usuarios_detalle.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="image" />
            <input type="hidden" name="id" value="<?php echo "$id"; ?>" />
            <input type="hidden" name="imagen" value="<?php echo "$imagen"; ?>" />
            <input type="hidden" name="imagen_nombre" value="<?php echo "$imagen_nombre"; ?>" />
            
            <p class="rdm-formularios--label"><label for="correo">Correo electrónico*</label></p>
            <p><input type="email" id="correo" name="correo" value="<?php echo "$correo"; ?>" spellcheck="false" required autofocus /></p>
            <p class="rdm-formularios--ayuda">Correo electrónico para ingresar a ManGo!</p>
            
            <p class="rdm-formularios--label"><label for="contrasena">Contraseña*</label></p>
            <p><input type="text" id="contrasena" name="contrasena" value="<?php echo "$contrasena"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Contraseña para ingresar a ManGo!</p>
            
            <p class="rdm-formularios--label"><label for="nombre">Nombre*</label></p>
            <p><input type="text" id="nombre" name="nombre" value="<?php echo "$nombre"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Nombre el contacto principal</p>

            <p class="rdm-formularios--label"><label for="razon_social">Razón social*</label></p>
            <p><input type="text" id="razon_social" name="razon_social" value="<?php echo "$razon_social"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Razón social de la empresa</p>
            
            <p class="rdm-formularios--label"><label for="documento_tipo">Tipo de documento*</label></p>
            <p><select id="documento_tipo" name="documento_tipo" required>
                <option value="<?php echo "$documento_tipo"; ?>"><?php echo ucfirst($documento_tipo) ?></option>
                <option value=""></option>
                <option value="CC">CC</option>
                <option value="cedula extranjeria">Cédula de extranjería</option>
                <option value="NIT">NIT</option>
                <option value="pasaporte">Pasaporte</option>
                <option value="TI">TI</option>
            </select></p>
            <p class="rdm-formularios--ayuda">Tipo de documento, CC, NIT, TI, etc.</p>

            <p class="rdm-formularios--label"><label for="documento">Documento*</label></p>
            <p><input type="tel" id="documento" name="documento" value="<?php echo "$documento"; ?>" required /></p>
            <p class="rdm-formularios--ayuda">Documento de identificación del cliente</p>
            
            <p class="rdm-formularios--label"><label for="telefono">Teléfono*</label></p>
            <p><input type="text" id="telefono" name="telefono" value="<?php echo "$telefono"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Teléfono de contacto</p>

            <p class="rdm-formularios--label"><label for="celular">Celular*</label></p>
            <p><input type="text" id="celular" name="celular" value="<?php echo "$celular"; ?>" spellcheck="false" required /></p>
            <p class="rdm-formularios--ayuda">Celular de contacto</p>
            
            <p class="rdm-formularios--label"><label for="archivo">Imagen</label></p>
            <p><input type="file" id="archivo" name="archivo"  /></p>
            <p class="rdm-formularios--ayuda">Usa una imagen para identificarlo</p>
            
            <button type="submit" class="rdm-boton--fab" name="editar" value="si"><i class="zmdi zmdi-check zmdi-hc-2x"></i></button>
        </form>

    </section>

<footer></footer>

</body>
</html>