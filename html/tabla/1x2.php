<?php

use Soap\Url;

$array = [
    ["code" => 1, "nombre" => "alvaro", "apellido" => "cruces", "edad" => 24, "profesion" => "programador"],
    ["code" => 2, "nombre" => "makumba", "apellido" => "madrigal", "edad" => 18, "profesion" => "veterinario"],
    ["code" => 3, "nombre" => "vmax", "apellido" => "cabeza", "edad" => 19, "profesion" => "proplayer"]
];

if (!isset($_SESSION["array"])) {
    $_SESSION["array"] = $array;
}

$array = $_SESSION["array"];



$code="";
$nombre = "";
$apellido = "";
$edad = "";
$profesion = "";


if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["edad"]) && isset($_POST["profesion"])) {
    for($i = 0; $i < count($array); $i++){
        if($_GET["opcion"] == $array[$i]["code"]){
            $array[$i]["code"] = $_POST("code");
            $array[$i]["nombre"] = $_POST("nombre");
            $array[$i]["apellido"] = $_POST("apellido");
            $array[$i]["edad"] = $_POST("edad");
            $array[$i]["profesion"] = $_POST("profesion");
        }
        
    }
}
?>

<table border="1px black solid">
    <tr align="center">
        <th>Code</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Edad</th>
        <th>Profesión</th>
    </tr>
    <?php
    foreach ($array as $row) {
        echo "<tr>";
        foreach ($row as $key => $value) {
            if ($key == "code") {
                echo "<td>" . "<a href='?opcion=" . $value . "'>" . $value . "</a>" . "</td>";
            } else {
                echo "<td>" . $value . "</td>";
            }
        }
    }
    ?>
</table>

<br>

<form action="" method="get">
    <button type="submit" name="nuevo">Añadir usuario</button>
</form>


<?php
// compruebo que boton he pulsado
if (isset($_GET["nuevo"]) || isset($_GET["opcion"])) {
    if(isset($_GET["opcion"])){
        foreach($array as $person){
            if($_GET["opcion"] == $person['code']){
                $code = $person['code'];
                $nombre = $person['nombre'];
                $apellido = $person['apellido'];
                $edad = $person['edad'];
                $profesion = $person['profesion'];
            }
        }
    }
    ?>
    <form action="" method="post">
        <label>Código</label><input type="text" name="code" value="<?echo $code;?>">
        <br><br>
        <label>Nombre</label><input type="text" name="nombre" value="<?echo $nombre;?>">
        <br><br>
        <label>Apellido</label> <input type="text" name="apellido" value="<?echo $apellido;?>">
        <br><br>
        <label>Edad</label> <input type="text" name="edad" value="<?echo $edad;?>">
        <br><br>
        <label>Profesión</label> <input type="text" name="profesion" value="<?echo $profesion;?>">
        <br><br>
        <button type="submit" name="guardar">Guardar</button>
        <?
}