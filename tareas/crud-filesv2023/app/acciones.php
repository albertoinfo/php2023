<?php
// Borra el elemento indicado de tabla de usuarios
// Reordena indexa la tabla
function accionBorrar ($id){    
    
    $msg ="";
    if (isset ($_SESSION['tuser'][$id])){
        $nombre = $_SESSION['tuser'][$id][0];
        // Se elimina de la tabla
        unset($_SESSION['tuser'][$id]);
        $msg = " El usuario $nombre ha sido eliminado ";
    } else {
        $msg = " El usuario con $id no se existe";
    }
    
    $_SESSION['msg'] = $msg;
}

// Termina: Cierra sesión y vuelva los datos
function accionTerminar(){
        
        volcarDatos($_SESSION['tuser']);
        session_destroy();
       $_SESSION['msg'] = " Se han volcado todos los datos  ";
}
 

// Muestra un formularios cn los datos de un usuario de la posición $id de la tabla
function accionDetalles($id){
    $login=$id;
    $usuario = $_SESSION['tuser'][$id];
    $clave   = $usuario[0];
    $nombre  = $usuario[1];
    $comentario=$usuario[2];
    $orden = "Detalles";
    include_once "layout/formulario.php";
    exit();
}

// Muestra un el formularios con los datos permitiendo la modificación
function accionModificar($id){
    $login=$id;
    $usuario = $_SESSION['tuser'][$id];
    $clave    = $usuario[0];
    $nombre   = $usuario[1];
    $comentario=$usuario[2];
    $orden = "Modificar";
    include_once "layout/formulario.php";
    exit();
}

// Modifica los valores de la tabla a partir del formulario
function accionPostModificar(){

    $id = $_POST['login'];
    $nuevovalor = [ $_POST['clave'],$_POST['nombre'],$_POST['comentario']];
    // Chequeo por seguridad
    if ( isset($_SESSION['tuser'][$id])){
        $_SESSION['tuser'][$id] = $nuevovalor;
        $msg = " El usuario ha sido modificado.";

    } else {
        $msg = " Error: el usuario no existe.";
    }
    
    $_SESSION['msg'] = $msg;
}

// Muestra un el formulario con los datos vacios para realizar una alta
function accionAlta(){
    $nombre  = "";
    $login   = "";
    $clave   = "";
    $comentario = "";
    $orden= "Nuevo";
    include_once "layout/formulario.php";
    exit();
}

// Vuelvo a mostrar el formulario con los datos enviados
// pero indicando el error producido.
function accionRepetirAlta($msgformulario){
  
    $nombre  =  $_POST['nombre'];
    $login   =  $_POST['login'];
    $clave   =   $_POST['clave'];
    $comentario =  $_POST['comentario'];
    $orden= "Nuevo";
    $msg = $msgformulario;
    include_once "layout/formulario.php";
    exit();
}


// Proceso los datos del formularios guardandolo en la sesión
// Debe evitar que se puedan introducir dos usuarios con el mismo login
function accionPostAlta(){
 
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    
    
    $msgerror = "";
    if ( empty($_POST['nombre']) ||
         empty($_POST['login'])  ||
         empty($_POST['clave'])  ||
         empty($_POST['comentario']) ){
         $msgerror= "Todos los campos tienen que ser rellenados";
         accionRepetirAlta($msgerror);
         return;
    }
    
    $id = $_POST['login'];
    if ( isset($_SESSION['tuser'][$id])) {
        $msgerror = "  El usuario  con login $id ya existe ";
            accionRepetirAlta($msgerror);
            return;
        }

    $id = $_POST['login'];
    $nuevo = [ $_POST['clave'],$_POST['nombre'],$_POST['comentario']];
    $_SESSION['tuser'][$id]= $nuevo;  
    $msg = " Nuevo usuario añadido.";
    $_SESSION['msg'] = $msg;
}


