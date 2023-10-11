

<?php
//  Elaborar programa (01.php) en php que procese un formulario (01.html) 
//  que solicita al usuario un nombre y una clave. El programa php tendrá un array asociativo
//  con 3 pares de valores de usuario => contraseña.  Se comprobará consultando la tabla si 
//  los datos son válidos, en este caso se debe mostrar un mensaje de bienvenida con nombre introducido,
//  en otro caso se mostrar un mensaje de error para que usuario pueda volver a introducir nuevos datos.
//  
//  Se muestran dos formas para volver a la página anterior 01.html si se produce un error: 
//  mediante javascript y modificado la respuesta en  la cabecera http

$error = false;
$acceso = false;
$usuario ="";
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $tusuarios = [
        'pepe' => '1234',
        "luis" => "siul",
        "admin" => "admin"
    ];
    
    $msg = "";
    
    
    if (empty($_REQUEST['nombre']) ||  empty($_REQUEST['clave'])) {
        $msg = "Error: falta valores, introducir el  usuario y  la contraseña.<br> ";
        $error = true;
    } else {
        // PELIGRO: No controlo la seguridad de las entradas
        $usuario = trim($_REQUEST['nombre']);
        $clave   = $_REQUEST['clave'];
        if (array_key_exists($usuario, $tusuarios) &&  $tusuarios[$usuario] == $clave) {
            $msg = " Bienvenido $usuario al sistema ";
            $acceso = true;
        } else {
            $msg = "Error: Usuario y contraseña no válidos.<br> ";
            $error = true;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="container" style="width: 380px;">
		<div id="header">
			<h1><?=($acceso)? "BIENVENIDO" :"FORMULARIO DE ACCESO" ?></h1>
		</div>

		<div id="content">
            <?php if ($acceso): ?>
                Bienvenido Usuario <?=$usuario ?>
            <?php else :?>    
            <?= ($error)?$msg:"" ?>
			<form name='entrada' method="POST" action="01.php">
				<table  style="border: node; ">
					<tr>
						<td>Nombre:</td>
						<td><input type="text" name="nombre" value="<?=$usuario?>" size="20"></td>
					</tr> 
					<tr>
						<td>Contraseña:</td>
						<td><input type="password" name="clave" size="20"></td>
					</tr>
				</table>
				<input type="submit" name="orden" value="Entrar">
			</form>
            <?php endif ?>
		</div>
	</div>
</body>
</html>
