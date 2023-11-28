<?php
define ("FICHERO","contactos.txt");
function checkCSRF()
{
    if (
        !isset($_REQUEST['token']) ||
        $_REQUEST['token'] != $_SESSION['token']
    ) {
        exit(); // Termina sin dar nada de información
    }
}

function cargardatos(): array
{
    $tabla = [];

    if (!is_readable(FICHERO)) {
        die(" Error el fichero no existe o no se puede leer.");
    }

    $tlineas = file(FICHERO);

    foreach ($tlineas as $linea) {
        $valor = explode(',', $linea);
        // Clave nombre, valor teléfono
        $tabla[$valor[0]] = $valor[1];
    }

    return $tabla;
}


function anotar($nombre, $telefono): void
{
    if (!is_writable(FICHERO)) {
        die(" Error no existe o no se puede escribir ");
    }
    $valores = $nombre .",". $telefono."\n";
    file_put_contents(FICHERO,$valores, FILE_APPEND);
}

// -----------------------------------------------------------------------------------
// OTRA FORMA ---> USANDO CSV <-------------------------------------------------------
function cargardatos2(): array
{
    $tabla = [];
    $fich = @fopen(FICHERO,"r");
    if (!$fich ){
        die (" Error no se puede abrir el fichero de contactos.");
    }

    while ( $valores = fgetcsv($fich)){
        $tabla[$valores[0]]=$valores[1];
    }
    fclose($fich);
    return $tabla;
}

function anotar2($nombre, $telefono): void
{

    $fich = @fopen(FICHERO, "a");
    if (!$fich) {
        die(" Error no se puede abrir el fichero de contactos.");
    }
    $valores = [$nombre, $telefono];
    fputcsv($fich, $valores);
    fclose($fich);
}

/// PROGRAMA PRINCIPAL ///
session_start();

$msg="";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Los primero es controlar el posible ataque.
    checkCSRF();

    $datosagenda = cargardatos();

    if (!empty($_POST['nombre']) && isset($_POST["orden"]) && $_POST["orden"] == "Consultar") {
        if (array_key_exists($_POST['nombre'], $datosagenda)) {
            $msg = " El teléfono de " . $_POST['nombre'] . " es " . $datosagenda[$_POST['nombre']];
        } else {
            $msg = " No se encuentra " . $_POST['nombre'] . " en la agenda ";
        }
    }

    if (!empty($_POST['nombre']) && isset($_POST["orden"]) && $_POST["orden"] == "Añadir") {
        if (empty($_POST['telefono']) || !is_numeric($_POST['telefono'])) {
            $msg = " Debé introducir un teléfono correcto";
        } else {
            anotar($_POST['nombre'], $_POST['telefono']);
            $msg = " Contacto anotado.";
        }
    }
}

// Genero el nuevo token
$token = md5(uniqid(mt_rand(), true));
// Guardo nuevo token generado.
$_SESSION['token'] = $token;



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title> Agenda App </title>
</head>

<body>
    <form method="POST">
        <fieldset>
            <legend>Su agenda personal</legend>
            <label for="nombre">Nombre:</label><br>
            <input type='text' name='nombre' size=20 value="<?= empty($_POST['nombre']) ? '' : $_POST['nombre'] ?>">
            <input type='submit' name="orden" value="Consultar"><br>
            <label for="telefono">Teléfono:</label><br>
            <input type='tel' name='telefono' size=20 value="<?= empty($_POST['telefono']) ? '' : $_POST['telefono'] ?>">
            <input type='submit' name="orden" value="Añadir">
            <input type="hidden" name="token" value="<?= $token ?>">
        </fieldset>
    </form>
    <p>
    <?= $msg ?>
    </p>
</body>

</html>