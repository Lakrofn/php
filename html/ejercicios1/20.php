<?php
$alumnos = [
    ["nombre" => "Ana", "edad" => 19, "nota" => 7.5],
    ["nombre" => "Luis", "edad" => 21, "nota" => 6.8],
    ["nombre" => "Marta", "edad" => 18, "nota" => 9.2],
    ["nombre" => "Carlos", "edad" => 20, "nota" => 5.4]
];


if (isset($_GET["opcion"])) {
    switch ($_GET["opcion"]) {
        case 1:
            function notaMasAlta($alumnos)
            {
                $alta = 0;
                $actual = "";
                foreach ($alumnos as $alumno) {
                    if ($alumno["nota"] > $alta) {
                        $alta = $alumno["nota"];
                        $actual = $alumno["nombre"];
                    }
                }
                return $actual . " con nota " . $alta;
            }
            echo "La nota más alta es " . notaMasAlta($alumnos) . "<br>";
            break;
        case 2:
            function notaMedia($alumnos)
            {
                $media = 0;
                $contador = 0;
                foreach ($alumnos as $alumno) {
                    $media += $alumno["nota"];
                    $contador++;
                }
                return $media / $contador;
            }
            echo "La nota media es " . notaMedia($alumnos) . "<br>";
            break;
        case 3:
            function alumnosMayoresDeEdad($alumnos)
            {
                $mayores = [];
                foreach ($alumnos as $alumno) {
                    if ($alumno["edad"] > 19) {
                        $mayores[] = $alumno["nombre"];
                    }
                }
                return $mayores;
            }
            echo "Los alumnos mayores de 19 son: " . implode(", ", alumnosMayoresDeEdad($alumnos)) . "<br>";
            break;
    }
}
?>

<a href="?opcion=1">Nota más alta</a><br><br>
<a href="?opcion=2">Nota media</a><br><br>
<a href="?opcion=3">Alumnos mayores de edad</a>
