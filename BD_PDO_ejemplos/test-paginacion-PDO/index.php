<?php
require_once "app/Cliente.php";
require_once  "app/AccesoDAO.php";
session_start();

if (!isset($_SESSION['posini'])) {
    $_SESSION['posini'] = 0;
}

define('FPAG', 10); // Número de clientes por página

$db = AccesoDAO::getModelo();
$total = $db->totalClientes();

$primero = $_SESSION['posini'];
if ($_GET['orden']) {

    switch ($_GET['orden']) {
        case "Primero":
            $primero = 0;
            break;
        case "Siguiente":
            $primero += FPAG;
            if ($primero >= $total) $primero -= FPAG;
            break;
        case "Anterior":
            $primero -= FPAG;
            if ($primero < 0) $primero = 0;
            break;
        case "Ultimo":
            $primero = $total - FPAG;
            break;
    }
    $_SESSION['posini'] = $primero;
}


$tclientes = $db->getClientes($primero, FPAG);
include "app/plantillas/principal.php";
