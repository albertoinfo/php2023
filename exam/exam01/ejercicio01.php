<?php
define('NUMCONTROL', 401);
define('CUENTAFICHERO', 'misaldo.txt');

// Tratamiento del cookie de firma
if (!isset($_COOKIE['token'])) {
    header('Location: acceso.php?msg=Error+de+acceso 1');
    exit();
}

$numt = $_COOKIE['token'];
if (is_numeric($numt) && $numt % NUMCONTROL != 0) {
    header("Location: acceso.php?msg=Error+de+acceso 2");
    exit();
}

// Obtengo el saldo actual
$saldo = file_get_contents(CUENTAFICHERO);

if ($_POST['Orden'] == "Ver saldo"){
    $msg = " Su saldo actual es:$saldo ";
    header("Location: acceso.php?msg=" . urlencode($msg));
    exit();
}

$importe = $_POST['importe'];
// Compruebo que el saldo es correcto
if (!is_numeric($importe) || $importe <= 0) {
    $msg = "Error: Importe erróneo o Inferior a cero";
    header("Location: acceso.php?msg=" . urlencode($msg));
    exit();
}

$error = false;
switch ($_POST['Orden']) {
    case "Ingreso":
        $saldo += $importe;
        $msg = "Operación realizada";
        break;
    case "Reintegro":
        if ($importe <= $saldo) {
            $saldo -= $importe;
            $msg = "Operación realizada";
        } else {
            $error = true;
            $msg = "Error: Importe superior al saldo";
        }
        break;
}
// Si no hay error
if (!$error) {
    // Actualizo el saldo.
    file_put_contents(CUENTAFICHERO, $saldo);
}
header("Location: acceso.php?msg=" . urlencode($msg));
