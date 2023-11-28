<?php
include_once 'app/config.php';

// Cargo los datos segun el formato de configuración TIPO = txt / csv / json
function cargarDatos(): array
{
    $funcion = __FUNCTION__ . TIPO; //   Ejemplo: cargarDatostxt
    return $funcion();
}

// Vuelva los datos a ficheros segun el TIPO
function volcarDatos(array $valores)
{
    $funcion = __FUNCTION__ . TIPO;  //  volcarDatostxt
    $funcion($valores);
}

// ----------------------------------------------------
// FICHERO DE TEXT 
//Carga los datos de un fichero de texto
function cargarDatostxt(): array
{
    // Si no existe lo creo
    $tabla = [];
    if (!is_readable(FILEUSER)) {
        // El directorio donde se crea tiene que tener permisos adecuados
        $fich = @fopen(FILEUSER, "w") or die("Error al crear el fichero.");
        fclose($fich);
    }
    $fich = @fopen(FILEUSER, 'r') or die("ERROR al abrir fichero de usuarios"); // abrimos el fichero para lectura

    while ($linea = fgets($fich)) {
        $partes = explode('|', trim($linea));
        // Escribimos la correspondiente fila en tabla
        // La clave es el login  el primer campo del fichero de texto
        $tabla[$partes[0]] = [ $partes[1], $partes[2], $partes[3]];
    }
    fclose($fich);
    return $tabla;
}
//Vuelca los datos a un fichero de texto
function volcarDatostxt(array $tvalores)
{
    // <<<<  IMPLEMENTAR  >>>>>   

}

// ----------------------------------------------------
// FICHERO DE CSV

function cargarDatoscsv(): array
{
    // <<<<  IMPLEMENTAR  >>>>> 
    $tabla = [];
    return $tabla;
}

//Vuelca los datos a un fichero de csv
function volcarDatoscsv(array $tvalores)
{
    // <<<<  IMPLEMENTAR  >>>>> 

}

// ----------------------------------------------------
// FICHERO DE JSON
function cargarDatosjson(): array
{
    // <<<<  IMPLEMENTAR  >>>>> 
    $tabla = [];
    return $tabla;
}

function volcarDatosjson(array $tvalores)
{
    // <<<<  IMPLEMENTAR  >>>>> 


}




// MUESTRA LOS DATOS DE LA TABLA ALMACENADA EN LA SESSION 
function mostrarDatos (){
    
    $titulos = [ "login","Password","Nombre","Comentario"];
    $msg = "<table>\n";
     // Identificador de la tabla
    $msg .= "<tr>";
    foreach ($titulos as $nombreTitulo){
        $msg .= "<th>$nombreTitulo</th>";
    }  
    $msg .= "</tr>";
    $auto = $_SERVER['PHP_SELF'];
    
    foreach ( $_SESSION['tuser'] as $login => $datosusuario ){
        $msg .= "<tr>";
        $msg .= "<td>$login</td>";
        for ($j=0; $j < count($datosusuario); $j++){
            $msg .= "<td>$datosusuario[$j]</td>";
        }
        $msg .="<td><a href=\"#\" onclick=\"confirmarBorrar('$datosusuario[1]','$login');\" >Borrar</a></td>\n";
        $msg .="<td><a href=\"".$auto."?orden=Modificar&id=$login\">Modificar</a></td>\n";
        $msg .="<td><a href=\"".$auto."?orden=Detalles&id=$login\" >Detalles</a></td>\n";
        $msg .="</tr>\n";
        
    }
    $msg .= "</table>";
   
    return $msg;    
}
/*
 *  Funciones para limpiar la entrada de posibles inyecciones
 */


// Función para limpiar todos elementos de un array  $_POST / $_GET
function limpiarArrayEntrada(array &$entrada)
{
    // Sin implementar
    // <<<<  IMPLEMENTAR  >>>>> 

}


// Ckequea la existencia de token de seguridad para
// evitar ataques  CSRF, Cross-Site Request Forgery
function checkCSRF()
{
    // <<<<  IMPLEMENTAR  >>>>>
}
