<?php
function multiplosDe3($numero) {
    $contador = 0;
    $suma = 0;
    for ($i = 1; $i <= $numero; $i++) {
        if($i % 3 == 0) {
            echo $i. "<br>";
            $contador++;
            $suma += $i;
        }
    }
    echo "Cantidad de múltiplos: ". $contador ."<br> Suma: ". $suma;
}

multiplosDe3(15);
?>