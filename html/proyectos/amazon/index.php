<?php
session_start();


//Variables
$products = [
    ["id" => 1, "name" => "Teclado", "price" => 240, "category" => "Gaming", "stock" => 10, "information" => "Teclado mecánico con retroiluminación RGB y switches de alta calidad, ideal para gaming y escritura rápida."],
    ["id" => 2, "name" => "Ratón", "price" => 120, "category" => "Gaming", "stock" => 15, "information" => "Ratón ergonómico con sensor de alta precisión y botones programables, perfecto para juegos competitivos."],
    ["id" => 3, "name" => "Monitor", "price" => 400, "category" => "Informática", "stock" => 5, "information" => "Monitor de alta resolución con tecnología LED y ángulo de visión amplio."],
    ["id" => 4, "name" => "Webcam", "price" => 30, "category" => "Informática", "stock" => 1, "information" => "Webcam de alta calidad con capacidad de grabación en HD y micrófono incorporado."],
    ["id" => 5, "name" => "Auriculares", "price" => 60, "category" => "Gaming", "stock" => 3, "information" => "Auriculares gaming con sonido envolvente y micrófono de alta calidad."],
    ["id" => 6, "name" => "Alfombrilla", "price" => 20, "category" => "Informática", "stock" => 20, "information" => "Alfombrilla para ratón con superficie antideslizante y diseño ergonómico."],
];

$cart = [];

if (isset($_SESSION['products'])) {
    $products = $_SESSION['products'];
} else {
    $_SESSION['products'] = $products;
}

if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
} else {
    $_SESSION['cart'] = $cart;
}

// Cuando pulsas el boton de limpiar cesta
if (isset($_GET['empty'])) {
    $_SESSION['cart'] = [];
    $cart = [];
}

// Cuando se añada un producto lo inserto en el array de productos con sus respectivos datos
if (isset($_POST['add'])) {
    $idMax = 0;
    foreach ($products as $product) {
        if ($product['id'] > $idMax) {
            $idMax = $product['id'];
        }
    }
    $products[] = [
        "id" => $idMax + 1,
        "name" => (isset($_POST['name']) ? $_POST['name'] : null),
        "price" => (isset($_POST['price']) ? $_POST['price'] : null),
        "category" => (isset($_POST['category']) ? $_POST['category'] : null),
        "stock" => (isset($_POST['stock']) ? $_POST['stock'] : null),
        "information" => (isset($_POST['information']) ? $_POST['information'] : null)
    ];

    $_SESSION['products'] = $products;

    header("Location: ?opcion=1");
    exit;
}

// Cuando se pulsa el botón de añadir al carrito


// Cuando se pulsa el botón de añadir al carrito
if (isset($_GET['buy'])) {
    foreach ($products as $product) {
        if ($product['id'] == $_GET['buy']) {
            $cart[] = [
                "id" => $product['id'],
                "name" => $product['name'],
                "price" => $product['price'],
                "category" => $product['category'],
                "stock" => $product['stock'],
                "quantity" => (isset($_GET['quantity']) ? $_GET['quantity'] : 1)
            ];
    }
}
}

// Menu de con bootstrap
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="?opcion=1">Proyecto1</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="?opcion=1">Catálogo <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="?opcion=2">Añadir producto</a>
            <a class="nav-item nav-link" href="?opcion=3">Carrito</a>
            <a class="nav-item nav-link" href="?opcion=4">Vaciar carrito</a>
        </div>
    </div>
</nav>


<?php
// Compruebo que opcion del menu pulso
$opcion = $_GET["opcion"] ?? 1;

switch ($opcion) {
    // Si pulso la opcion 1 o 2 creo la tabla con la diferencia que en el 2 muestra un formulario
    case 1:
    case 2:
        ?>
        <div class="table-responsive">
            <!--Creo la tabla -->
            <table class="table">
                <tr align="center">
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Cantidad</th>
                </tr>
                <?php
                foreach ($products as $product) {
                    ?>
                    <tr>
                        </td>
                        <td align="center"><a
                                href="?opcion=1&product=<?php echo $product["id"]; ?>"><?php echo $product["id"]; ?></a>
                        </td>
                        <td align="center"><?php echo $product["name"]; ?></td>
                        <td align="center"><?php echo $product["price"]; ?></td>
                        <td align="center"><?php echo $product["category"]; ?></td>
                        <td align="center"><?php echo $product["stock"]; ?></td>
                        <form action="" method="get">
                            <td align="center">
                                <input type="number" name="quantity" value="1" min="1" max="<?php echo $product["stock"]; ?>">
                            </td>
                            <td align="center">
                                <button type="submit" name="buy" value="<?php echo $product["id"]; ?>">Añadir</button>
                            </td>
                        </form>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <br>
        <?php

        //Creo el formulario con bootstrap si es la opcion 2
        if ($_GET['opcion'] == 2) {
            ?>
            <form method="post" action="" style="margin-inline: 20px;">
                <div class="form-group">
                    <label for="name">Nombre del producto</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label for="price">Precio</label>
                    <input type="number" class="form-control" name="price" required>
                </div>
                <div class="form-group">
                    <label for="category">Categoría</label>
                    <input type="text" class="form-control" name="category" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" class="form-control" name="stock" required>
                </div>
                <div class="form-group">
                    <label for="information">Información</label>
                    <textarea class="form-control" name="information"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="add">Añadir producto</button>
            </form>
            <?php
        } else {

            // Si estoy en la opcion 1 y pulso en un producto aparece esta información
            if (isset($_GET['product'])) {
                foreach ($products as $product) {
                    if ($product['id'] == $_GET['product']) {
                        ?>
                        <div style="width: 18rem; border: 1px black solid; width: 300px; margin-left: 20px; padding: 20px;">
                            <div>
                                <h3><?php echo $product["name"]; ?></h3>
                                <p>Categoría: <?php echo $product["category"]; ?></p>
                                <p>Stock: <?php echo $product["stock"]; ?></p>
                                <p>Información: <?php echo $product["information"]; ?></p>
                                <br>
                                <h5>Precio: <?php echo $product["price"]; ?>€</h5>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
        }
        break;
    case 3:
        ?>
        <div class="table-responsive">
            <table class="table">
                <tr align="center">
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Cantidad</th>
                    <th></th>
                </tr>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <td align="center">
                            <a href="?opcion=1&product=<?php echo $product["id"]; ?>"><?php echo $product["id"]; ?></a>
                        </td>
                        <td align="center"><?php echo $product["name"]; ?></td>
                        <td align="center"><?php echo $product["price"]; ?></td>
                        <td align="center"><?php echo $product["category"]; ?></td>
                        <td align="center"><?php echo $product["stock"]; ?></td>
                        <form action="" method="get">
                            <td align="center">
                                <p name="quantity"></p>
                            </td>
                            <td align="center">
                                <button type="submit" name="delete" value="<?php echo $product["id"]; ?>">delete</button>
                            </td>
                        </form>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <?php
        break;
    case 4:

        //En la pagina de la opcion 4 creo una especie de aviso con bootstrap
        ?>
        <div class="alert alert-danger" role="alert" style="margin-inline: 20px;">
            <h4 class="alert-heading">¡Atención!</h4>
            <p>¿Estás seguro de que quieres vaciar el carrito?</p>
            <hr>
            <p class="mb-0">Esta acción no se puede deshacer.</p>
        </div>
        <form method="get" action="?opcion=4">
            <button type="submit" class="btn btn-danger" name="empty" style="margin-left: 20px;">Vaciar carrito</button>
        </form>
        <?php
        break;
}
?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>