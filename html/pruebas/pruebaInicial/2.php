<?php
function calculateDiscount($import){
    $discount = ($import >= 100) ? 10 : (($import >= 50 && $import <= 100) ? 5 : 0);
    $importDiscount = ($discount == 10) ? $import * 0.10: (($discount == 5) ? $import * 0.05 : 0);
    echo "Importe: ".$import."€<br> Descuento: ". $discount. "%<br> Importe del descuento: ". $importDiscount. "€<br> Precio final: ". $import - $importDiscount. "€";
}

calculateDiscount(120);
echo"<br><br>";
calculateDiscount(49);
echo"<br><br>";
calculateDiscount(50);
echo"<br><br>";
calculateDiscount(99.99);
echo"<br><br>";
calculateDiscount(100);
?>