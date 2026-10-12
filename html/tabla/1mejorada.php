<?php

session_start();

$array = [
    ["cod" => "1", "nombre" => "Carlos", "apellido" => "Morales", "edad" => 32, "profesion" => "Mecánico"],
    ["cod" => "2", "nombre" => "Adrián", "apellido" => "Cabeza", "edad" => 22, "profesion" => "Programador"],
    ["cod" => "3", "nombre" => "Reyes", "apellido" => "Aguilar", "edad" => 25, "profesion" => "Programadora"]
];

if (!isset($_SESSION["array"])) {
    $_SESSION["array"] = $array;
}

$array = $_SESSION["array"];



$cod = isset($_GET["cod"]) ? $_GET["cod"] : "";

$persona = null;
if (
    isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["edad"])
    && isset($_POST["profesion"])
) {
    // Si me pasa todos los datos, entonces tengo que cambiar el array
    for ($i = 0; $i < count($array); $i++) {
        if ($array[$i]["cod"] === $cod) {
            $array[$i]["nombre"] = $_POST["nombre"];
            $array[$i]["apellido"] = $_POST["apellido"];
            $array[$i]["edad"] = $_POST["edad"];
            $array[$i]["profesion"] = $_POST["profesion"];
            $persona = $array[$i];
        }
    }
    $_SESSION["array"] = $array; // guardamos el cambio en sesión para que persista
} else {
    if (isset($cod)) {
        foreach ($array as $valor) {
            if ($valor["cod"] === $cod) {
                $persona = $valor;
            }
        }
    }
}

?>

<table>
    <tr>
        <th>Cod</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Edad</th>
        <th>Profesión</th>
    </tr>
    <?php foreach ($array as $valor) { ?>
        <tr>
            <td><a href="?cod=<?php echo $valor["cod"] ?>"><?php echo $valor["cod"] ?></a></td>
            <td><?php echo $valor["nombre"] ?></td>
            <td><?php echo $valor["apellido"] ?></td>
            <td><?php echo $valor["edad"] ?></td>
            <td><?php echo $valor["profesion"] ?></td>
        </tr>
    <?php } ?>
</table>

<?php if ($persona !== null) { ?>

    <br>
    <hr><br>

    <form method="post" action="">
        <label>Nombre:
            <input type="text" name="nombre" value="<?php echo $persona["nombre"]; ?>">
        </label><br>
        <label>Apellido:
            <input type="text" name="apellido" value="<?php echo $persona["apellido"]; ?>">
        </label><br>
        <label>Edad:
            <input type="number" name="edad" value="<?php echo $persona["edad"]; ?>">
        </label><br>
        <label>Profesión:
            <input type="text" name="profesion" value="<?php echo $persona["profesion"]; ?>">
        </label><br>
        <button type="submit" name="button" value="G">Guardar cambios</button>
    </form>
<?php } ?>