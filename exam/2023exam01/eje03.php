<?php

// lista de frutas a mostra en el formulario
$tfrutas = "";

// 1º Obtengo los valores actuales del cookie
if (isset($_COOKIE["galletadefrutas"])) {
  $tfrutas = $_COOKIE['galletadefrutas'];
}

// 2º Hay que modifica el cookie
if (isset($_GET["orden"])) {
  
  if ($_GET["orden"] == "cambiar") {
    $tfrutasnuevas = "";
    if (!empty($_GET['listafrutas'])) {
      // Se puede hacer con implode 
      foreach ($_GET['listafrutas'] as $fruta) {
        $tfrutasnuevas .= "," . $fruta;
      }
     // Nuevo valor del cookie
     setcookie("galletadefrutas", $tfrutasnuevas,time()+3600*24*30); // Un mes

    }
    
  } 
  // Vacio la lista
  if ($_GET["orden"] == "borrar"){
    $tfrutasnuevas = "";
    setcookie("galletadefrutas", $tfrutasnuevas,time()-60);
  }
  
  // En cualquier caso Actualizo la lista de frutas 
  $tfrutas = $tfrutasnuevas;
}

/**
 *  Método auxiliar para simplificar el html
 */
function sele($fruta)
{
  global $tfrutas;
  if (strstr($tfrutas, $fruta) !== false) {
    return " selected ";
  }
  return "";
}


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title> las frutas </title>
</head>

<body>
  <form>
    <fieldset>
      <legend>Sus frutas preferidas </legend>
      <label for="nombre">Lista de frutas:</label><br>
      <select name="listafrutas[]" multiple>
        <option value="Platano" <?= sele("Platano") ?>>Platano</option>
        <option value="fresa" <?= sele("fresa")   ?>>fresa</option>
        <option value="Naranja" <?= sele("Naranja")  ?>>Naranja</option>
        <option value="Melón" <?= sele("Melón")   ?>>Melón</option>
        <option value="Manzana" <?= sele("Manzana") ?>>Manzana</option>
      </select>
      <button name="orden" value="cambiar"> Cambiar </button>
      <button name="orden" value="borrar"> Borrar </button>

    </fieldset>
  </form>
</body>

</html>