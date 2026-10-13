<?php

$array = array(4,8,3,7,5,9,6,2,1);

function promedio($num1) {
    $contador = 0;
    $total = 0;
    foreach ($num1 as $num2) {
        $contador++;
        $total += $num2;
    }
    return $total / $contador;
}

echo promedio($array);