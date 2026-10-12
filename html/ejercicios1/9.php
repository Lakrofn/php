<?php

function esPar($num) {
    if ($num % 2 == 0) {
        return "Es par";
    } else {
        return "No es par";
    }
}

echo esPar(10);

?>