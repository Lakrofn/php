<?php

$productos = [
    ["nombre" => "Camiseta", "precio" => 15.99, "stock" => 10],
    ["nombre" => "Pantalón", "precio" => 35.5, "stock" => 0],
    ["nombre" => "Zapatos", "precio" => 55.0, "stock" => 5],
    ["nombre" => "Gorra", "precio" => 12.0, "stock" => 20],
];

function hayProductoEnStock($productos) {
    $productosEnStock = [];
    foreach ($productos as $producto) {
        if ($producto["stock"] > 0) {
            $productosEnStock[] = $producto["nombre"];
        }
    }
    return $productosEnStock;
}

function valorTotal($productos) {
    $total = 0;
    foreach ($productos as $producto) {
        $total += $producto["precio"] * $producto["stock"];
    }
    return $total;
}

usort($productos, function ($a, $b) {
    return $a["precio"] <=> $b["precio"];
});


echo "Productos en stock: " . implode(", ", hayProductoEnStock($productos)) . "<br>";
echo "Valor total: " . valorTotal($productos) . "<br>";
echo print_r($productos);
