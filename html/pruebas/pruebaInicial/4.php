<?php

function temperatures($temperaturas)
{
    $maxima = 0;

    $minima = 0;

    $suma = 0;

    $contador22 = 0;

    for ($i = 0; $i < count($temperaturas); $i++) {
        if ($i == 0) {
            $maxima = $temperaturas[$i];
            $minima = $temperaturas[$i];
        } else {
            if ($temperaturas[$i] > $maxima) {
                $maxima = $temperaturas[$i];
            } else if ($temperaturas[$i] < $minima) {
                $minima = $temperaturas[$i];
            }
        }

        if ($temperaturas[$i] > 22) {
            $contador22++;
        }

        $suma += $temperaturas[$i];
    }

    echo "Temperatura máxima: " . $maxima . "<br> Temperatura mínima: " . $minima .
        "<br> Temperatura media: " . $suma / count($temperaturas) . "<br> Días con temperatura superior a 22: " . $contador22;
}

temperatures([18, 21, 19, 25, 27, 23, 20]);
?>