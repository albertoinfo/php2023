
<?php
// CONTROLADOR CON CONTROL SESIONES
//////////////////////////////////////

session_start();
// PRIMERA APROXIMACIÓN AL MODELO VISTA CONTROLADOR. 
// Funciones auxiliars Ej- usuarioOK
include_once 'app/funciones.php';
$msg = ""; // Valor por defecto a pasar en los formularios

// No se ha identificado
/////////////////////////////////
if (!isset($_SESSION['usuario'])) {

    if (!isset($_REQUEST['orden']) || $_REQUEST['orden'] != "Entrar") {
        include_once 'app/entrada.php';
    } else if ($_REQUEST['orden'] == "Entrar") {
        // Chequear usuario
        if (
            isset($_REQUEST['nombre']) && isset($_REQUEST['contraseña']) &&
            usuarioOK($_REQUEST['nombre'], $_REQUEST['contraseña'])
        ) {
            // anoto en la sesión
            $_SESSION['usuario'] = $_REQUEST['nombre'];
            $msg = " Bienvenido <b>" . $_REQUEST['nombre'] . "</b><br>";
            include_once  'app/comentario.php';
        } else {
            $msg = " <br> Usuario no válido </br>";
            include_once 'app/entrada.php';
        }
    }
} else {
    // IDENTIFICADO
    ///////////////////////////////////////
    switch ($_REQUEST['orden']) {

        case "Nueva opinión":
            $msg = " Nueva opinión <br>";
            include_once  'app/comentario.php';
            break;
        case "Detalles": // Mensaje y detalles
            $msg = "Detalles de su opinión";
            limpiarEntrada($_REQUEST['comentario']);
            limpiarEntrada($_REQUEST['tema']);
            include_once 'app/comentariorelleno.php';
            break;
        case "Terminar": // Formulario inicial
            session_destroy();
            include_once 'app/entrada.php';
    }
}
