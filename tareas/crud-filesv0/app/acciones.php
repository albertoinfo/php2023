<?php
// Borra el elemento indicado de tabla de usuarios
// Reordena indexa la tabla
function accionBorrar ($id){    
     //<<<< COMPLETAR >>>>>>  
    
    $_SESSION['msg'] = "EL MÉTODO ".__FUNCTION__." NO  ESTA IMPLEMENTADO ";
}

// Termina: Cierra sesión y vuelva los datos
function accionTerminar(){
        //<<<< COMPLETAR >>>>>>  
       $_SESSION['msg'] = " EL MÉTODO ".__FUNCTION__." NO  ESTA IMPLEMENTADO ";
}
 

// Muestra un formularios cn los datos de un usuario de la posición $id de la tabla
function accionDetalles($id){
    $login=$id;
    $usuario = $_SESSION['tuser'][$id];
    $nombre  = $usuario[0];
    $clave   = $usuario[1];
    $comentario=$usuario[2];
    $orden = "Detalles";
    include_once "layout/formulario.php";
    exit();
}

// Muestra un el formularios con los datos permitiendo la modificación
function accionModificar($id){
        //<<<< COMPLETAR >>>>>>  
    
        $_SESSION['msg'] = " EL MÉTODO ".__FUNCTION__." NO  ESTA IMPLEMENTADO ";
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

// Proceso los datos del formularios guardandolo en la sesión
// Debe evitar que se puedan introducir dos usuarios con el mismo login
function accionPostAlta(){
 
    //<<<< COMPLETAR >>>>>>
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    
    //<<<< COMPLETAR y CORREGIR>>>>>>
    $id = $_POST['login'];
    $nuevo = [ $_POST['nombre'],$_POST['clave'],$_POST['comentario']];
    $_SESSION['tuser'][$id]= $nuevo;  
    $_SESSION['msg'] = " Nuevo usuario añadido.";
}


