<?php


//Array
$array = [
    ["code" => 1, "nombre" => "alvaro", "apellido" => "cruces", "edad" => 24, "profesion" => "programador"],
    [
        "code" => 2,
        "nombre" => "makumba",
        "apellido" => "madrigal",
        "edad" => 18,
        "profesion" => "veterinario"
    ],
    ["code" => 3, "nombre" => "vmax", "apellido" => "cabeza", "edad" => 19, "profesion" => "proplayer"]
];

if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["edad"]) && isset($_POST["profesion"])) {
    foreach ($array as $person) {
        if ($_GET["opcion"] == $person['code']) {

        }
    }
}


// creacion de la tabla
?>
<table>
    <tr>
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

<br><br><br>

<a href="?opcion=nuevo">Añadir una persona</a>
<br><br><br>

<?php
// compruebo que boton he pulsado
if (isset($_GET["opcion"])) {


    if ($_GET["opcion"] == "nuevo") {

        ?>
        <form action="" method="post">
            <?
            //formulario
            echo "<label>Nombre</label>" . "<input type='text' name='nombre'>";
            echo "<br><br>";
            echo "<label>Apellido</label>" . "<input type='text' name='apellido'>";
            echo "<br><br>";
            echo "<label>Edad</label>" . "<input type='text' name='edad'>";
            echo "<br><br>";
            echo "<label>Profesión</label>" . "<input type='text' name='profesion'>";
            echo "<br><br>";
            echo "<input type='submit'> ";
            ?>
        </form>
        <?
    } else {
        for ($i = 0; $i < count($array); $i++) {
            if ($_GET["opcion"] == $array[$i]["code"]) {

                ?>
                    <form action="" method="post">
                        <?
                        //formulario
                        echo "<label>Nombre</label>" . "<input type='text' name='nombre' value='" . $array[$i]["nombre"] . "'>";
                        echo "<br><br>";
                        echo "<label>Apellido</label>" . "<input type='text' name='apellido' value='" . $array[$i]["apellido"] . "'>";
                        echo "<br><br>";
                        echo "<label>Edad</label>" . "<input type='text' name='edad' value='" . $array[$i]["edad"] . "'>";
                        echo "<br><br>";
                        echo "<label>Profesión</label>" . "<input type='text' name='profesion' value='" . $array[$i]["profesion"] . "'>";
                        echo "<br><br>";
                        echo "<input type='submit'>";
                        ?>
                    </form>
                <?

            }
        }

    }

}
?>