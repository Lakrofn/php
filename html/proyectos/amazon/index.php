<?php
session_start();

$_SESSION['products'] = [
    ["id" => 1, "name" => "Teclado", "price" => 240, "category" => "Gaming", "stock" => 10, "information" => "Teclado mecánico con retroiluminación RGB y switches de alta calidad, ideal para gaming y escritura rápida."],
    ["id" => 2, "name" => "Ratón", "price" => 120, "category" => "Gaming", "stock" => 15, "information" => "Ratón ergonómico con sensor de alta precisión y botones programables, perfecto para juegos competitivos."],
    ["id" => 3, "name" => "Monitor", "price" => 400, "category" => "Informática", "stock" => 5, "information" => "Monitor de alta resolución con tecnología LED y ángulo de visión amplio."],
    ["id" => 4, "name" => "Webcam", "price" => 30, "category" => "Informática", "stock" => 1, "information" => "Webcam de alta calidad con capacidad de grabación en HD y micrófono incorporado."],
    ["id" => 5, "name" => "Auriculares", "price" => 60, "category" => "Gaming", "stock" => 3, "information" => "Auriculares gaming con sonido envolvente y micrófono de alta calidad."],
    ["id" => 6, "name" => "Alfombrilla", "price" => 20, "category" => "Informática", "stock" => 60, "information" => "Alfombrilla para ratón con superficie antideslizante y diseño ergonómico."],
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    foreach ($_POST['elements'] as $id) {

        if (isset($_POST["quantity"][$id])) {

            $quantityItem = $_POST["quantity"][$id];

            foreach ($_SESSION['products'] as $i => $product) {

                if ($product['id'] == $id) {

                    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $quantityItem;

                    $_SESSION['products'][$i]["stock"] -= $quantityItem;
                    
                }
            }
        }
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<nav class="nav bg-dark px-3 py-2 mb-4">
    <a class="nav-link text-white" href="index.php">Catalogo</a>
    <a class="nav-link text-white" href="?buy">Comprar</a>
    <a class="nav-link text-white" href="?cart">Cesta</a>
</nav>

<div class="container">

<?php if (!isset($_GET["buy"]) && !isset($_GET["cart"])) { ?>
    <table class="table table-striped table-hover">
        <tr class="table-dark">
            <th>id</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Categoría</th>
            <th>Stock</th>
        </tr>
        <?php
        foreach ($_SESSION["products"] as $product) {
            if (!isset($_GET["cod"]) || $product["id"] == $_GET["cod"]) {
                ?>
                <tr>
                    <td><a href="?cod=<?php echo $product["id"] ?>"><?php echo $product["id"] ?></a></td>
                    <td><?php echo $product["name"] ?></td>
                    <td><?php echo $product["price"] ?>€</td>
                    <td><?php echo $product["category"] ?></td>
                    <td><?php echo $product["stock"] ?></td>
                    <?php
            }
        }
        ?>
        </tr>
    </table>
    <?php
}

if (isset($_GET["buy"])){

?>
    <table class="table table-striped table-hover">
        <tr class="table-dark">
            <th>Elegir</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Categoría</th>
            <th>Stock</th>
            <th>Cantidad</th>
        </tr>
        <form action="" method="post">
            <?php
            foreach ($_SESSION["products"] as $product) {
                ?>
                <tr>
                    <td><input class="form-check-input" type="checkbox" name="elements[]" value="<?php echo $product["id"] ?>"></td>
                    <td><?php echo $product["name"] ?></td>
                    <td><?php echo $product["price"] ?> €</td>
                    <td><?php echo $product["category"] ?></td>
                    <td><?php echo $product["stock"] ?></td>
                    <td><input class="form-control form-control-sm" type="number" name="quantity[<?php echo $product["id"] ?>]" value="1" min="1"
                            max="<?php echo $product["stock"] ?>"></td>
                </tr>


                <?php
            }


            ?>
            <button class="btn btn-primary mb-3" type="submit">Añadir</button>
        </form>
    </table>

    <?php
}
if (isset($_GET['cart'])) {
    ?>
    <table class="table table-striped table-hover">
        <tr class="table-dark">
            <th>Nombre</th>
            <th>Precio</th>
            <th>Categoría</th>
            <th>Cantidad</th>
        </tr>
        <?php
        $selecteds = $_SESSION['cart'] ?? [];
        $precioTotal = 0;

        foreach ($selecteds as $id => $cantidad) {
            $key = $id;
            foreach ($_SESSION['products'] as $product) {
                if ($product['id'] == $key) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $product["name"] ?>
                        </td>
                        <td>
                            <?php echo $product["price"] ?>€
                        </td>
                        <td>
                            <?php echo $product["category"] ?>
                        </td>
                        <td>
                            <?php echo $cantidad ?>
                        </td>
                        <?php
                        $precioTotal += $cantidad * $product['price'];
                        ?>
                    </tr>


                    <?php
                }
            }

        }
        ?>
        <tr class="table-light">
            <td>
                total: 
                <?php
                echo $precioTotal;
                ?>€
            </td>
        </tr>

    </table>
    <?php
}
?>

</div>