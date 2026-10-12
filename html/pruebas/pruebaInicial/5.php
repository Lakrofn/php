<?php
$productos = [
    ["Nombre" => "Teclado","precio"=> 30,"Descuento"=> 10],
    ["Nombre" => "Monitor","precio"=> 180,"Descuento"=> 15],
    ["Nombre" => "Disco SSD","precio"=> 75,"Descuento"=> 5]
];
function calcularPrecioFinal($precio, $descuento){
    return $precio - ($precio * ($descuento /100));
}

foreach ($productos as $producto) {
    echo $producto['Nombre']. ": ". calcularPrecioFinal($producto['precio'], $producto['Descuento']). "€<br>";
}  
?>