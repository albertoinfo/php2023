<?php 
session_start();

// Si no existe lo creo con vacio.
if ( !isset ($_SESSION['lenguajes'])){
    $_SESSION['lenguajes']=[];
}

// Me envian nueva selección 
if (isset ($_POST['lenguajes'])){
    $_SESSION['lenguajes']=[];
    foreach ( $_POST['lenguajes'] as $leng ){
        // Añado el lenguaje
        $_SESSION['lenguajes'][]= $leng; 
    }
}

function estaLenguaje($lenguaje):bool {

    return ( in_array($lenguaje,$_SESSION['lenguajes']));
}

// Lista de lenguajes que se pueden seleccionar
$nombreLenguajes = ["Java","Javascript","Php","Python","Perl","C#"];

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Selección de personal</title>
</head>
<body>

<h2> Datos de candidato: Paso 2º </h2>
<form  action="seleccion2.php" method="POST">
<fieldset>
	<legend>Datos Profesionales </legend>
Lenguajes de programación:<br>
<!-- Este select se prodría generar por programa -->
<select name="lenguajes[]" multiple="multiple" size=6>
<?php foreach ($nombreLenguajes as $leng): ?>
     <option value="<?=$leng ?>" <?= estaLenguaje($leng)? "selected='selected'" :"" ?> > <?= $leng ?> </option>    
<?php endforeach ?>     
</select><br>
<input type="submit" value="Enviar">
</fieldset>
</form>
</body>
</html>

