<?php

$productos = [
    ["Nombre" => "Teclado","precio"=> 25,"stock"=> 10],
    ["Nombre" => "Ratón","precio"=> 15,"stock"=> 4],
    ["Nombre" => "Monitor","precio"=> 180,"stock"=> 2],
    ["Nombre" => "Webcam","precio"=> 45,"stock"=> 0],
    ["Nombre" => "SSD","precio"=> 75,"stock"=> 7],
];

$productoCaro = 0;
$resultadoCaro = "";

echo "1. Productos disponibles: <br><br>";
foreach ($productos as $producto) {
    if ($producto['stock'] != 0) {
        echo $producto['Nombre']. " - " . $producto['precio']. "€ - Stock: ". $producto['stock']. "<br>";
    }

    if ($producto['precio'] > $productoCaro) {
        $productoCaro = $producto['precio'];
        $resultadoCaro = $producto['Nombre']. " con: ". $producto['precio']. "€ <br>";
    }
}

function valorTotal($productos) {
    $total = 0;
    foreach ($productos as $producto) {
        $total += $producto['precio'] * $producto['stock'];
        echo $producto['Nombre']. " - ". $producto['precio'] * $producto['stock']. "€ de stock <br>";
    }

    echo "<br>Valor de inventario: ". $total . "<br>";
}

echo "<br>2 y 3 valor de inventario. <br><br>";
valorTotal($productos);

echo "<br>4 Producto mas caro: <br><br>";
echo $resultadoCaro;

echo "<br>5. Productos sin stock: <br><br>";
foreach ($productos as $producto) {
    if ($producto['stock'] == 0) {
        echo $producto['Nombre']. " - " . $producto['precio']. "€ - Stock: ". $producto['stock']. "<br>";
    }

}
