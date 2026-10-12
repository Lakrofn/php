<?php
/**
 * Ejercicio 1. Gestión de una cesta de productos
 * Única página PHP: catálogo, producto, formulario, cesta, vaciar y comprar.
 */
session_start();

const IVA = 0.21;

/* ------------------------------------------------------------------
 * 1. CATÁLOGO (array asociativo multidimensional)
 *    Se copia a la sesión la primera vez para que el stock que se
 *    descuente al comprar se mantenga entre peticiones.
 * ------------------------------------------------------------------ */
if (!isset($_SESSION['catalogo']) || !is_array($_SESSION['catalogo'])) {
    $_SESSION['catalogo'] = [
        1 => ['id' => 1, 'nombre' => 'Teclado',      'precio' => 29.90,  'categoria' => 'Periféricos', 'stock' => 10],
        2 => ['id' => 2, 'nombre' => 'Ratón',        'precio' => 15.50,  'categoria' => 'Periféricos', 'stock' => 15],
        3 => ['id' => 3, 'nombre' => 'Monitor',      'precio' => 149.99, 'categoria' => 'Pantallas',   'stock' => 5],
        4 => ['id' => 4, 'nombre' => 'Webcam',       'precio' => 39.95,  'categoria' => 'Vídeo',       'stock' => 8],
        5 => ['id' => 5, 'nombre' => 'Auriculares',  'precio' => 24.90,  'categoria' => 'Audio',       'stock' => 12],
        6 => ['id' => 6, 'nombre' => 'Alfombrilla',  'precio' => 7.95,   'categoria' => 'Accesorios',  'stock' => 20],
    ];
}
$catalogo = &$_SESSION['catalogo'];

// La cesta vive en sesión: [id_producto => cantidad]
if (!isset($_SESSION['cesta']) || !is_array($_SESSION['cesta'])) {
    $_SESSION['cesta'] = [];
}

/* ------------------------------------------------------------------
 * Funciones auxiliares
 * ------------------------------------------------------------------ */
function e($texto): string
{
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}

function euros(float $importe): string
{
    return number_format($importe, 2, ',', '.') . ' €';
}

/** Devuelve el id (int) si es un entero positivo válido y existe en el catálogo; si no, null. */
function validarIdProducto($valor, array $catalogo): ?int
{
    if (!is_string($valor) && !is_int($valor)) {
        return null;
    }
    $valor = (string)$valor;
    if (!ctype_digit($valor)) {
        return null;
    }
    $id = (int)$valor;
    return isset($catalogo[$id]) ? $id : null;
}

/* ------------------------------------------------------------------
 * Menú (array indexado de arrays asociativos)
 * ------------------------------------------------------------------ */
$menu = [
    ['texto' => 'Catálogo',          'url' => 'index.php'],
    ['texto' => 'Añadir productos',  'url' => 'index.php?accion=anadir'],
    ['texto' => 'Ver cesta',         'url' => 'index.php?accion=cesta'],
    ['texto' => 'Vaciar cesta',      'url' => 'index.php?accion=vaciar'],
    ['texto' => 'Comprar',           'url' => 'index.php?accion=comprar'],
];

/* ------------------------------------------------------------------
 * 2. CONTROL DE PETICIONES
 *    $vista decide qué se pinta; $errores y $avisos son arrays indexados.
 * ------------------------------------------------------------------ */
$vista    = 'catalogo';
$errores  = [];
$avisos   = [];
$producto = null;   // datos del producto consultado
$factura  = null;   // datos de la factura tras comprar

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    /* ---------------- PETICIÓN POST: añadir productos a la cesta ---------------- */
    $vista = 'anadir';

    $seleccionados = $_POST['productos'] ?? [];
    $cantidades    = $_POST['cantidad'] ?? [];

    if (!is_array($seleccionados) || !is_array($cantidades)) {
        $errores[] = 'Los datos enviados no son válidos.';
    } elseif (count($seleccionados) === 0) {
        $errores[] = 'No has seleccionado ningún producto.';
    } else {
        $anadidos = 0;
        foreach ($seleccionados as $valor) {
            $id = validarIdProducto($valor, $catalogo);
            if ($id === null) {
                $errores[] = 'Se ha recibido un producto que no existe y se ha ignorado.';
                continue;
            }
            $nombre = $catalogo[$id]['nombre'];

            // Cantidad: debe existir, ser entera y mayor que 0
            $cantidadBruta = (is_array($cantidades) && isset($cantidades[$id])) ? $cantidades[$id] : null;
            $cantidad = filter_var($cantidadBruta, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            if ($cantidad === false || $cantidad === null) {
                $errores[] = "La cantidad indicada para «" . e($nombre) . "» no es válida.";
                continue;
            }

            // Stock suficiente teniendo en cuenta lo que ya hay en la cesta
            $yaEnCesta = $_SESSION['cesta'][$id] ?? 0;
            if ($yaEnCesta + $cantidad > $catalogo[$id]['stock']) {
                $errores[] = "No hay stock suficiente de «" . e($nombre) . "» (stock: "
                    . $catalogo[$id]['stock'] . ", ya en cesta: $yaEnCesta).";
                continue;
            }

            $_SESSION['cesta'][$id] = $yaEnCesta + $cantidad;
            $anadidos++;
        }
        if ($anadidos > 0) {
            $avisos[] = "Se han añadido $anadidos producto(s) a la cesta.";
        }
    }

} elseif (!empty($_GET)) {
    /* ---------------- PETICIÓN GET CON PARÁMETROS ---------------- */
    if (isset($_GET['producto'])) {
        // Consulta de un producto concreto (no se muestra el catálogo)
        $vista = 'producto';
        $id = validarIdProducto($_GET['producto'], $catalogo);
        if ($id === null) {
            $errores[] = 'El producto solicitado no existe.';
        } else {
            $producto = $catalogo[$id];
        }

    } elseif (isset($_GET['accion']) && is_string($_GET['accion'])) {
        $accion = $_GET['accion'];

        if ($accion === 'anadir') {
            $vista = 'anadir';

        } elseif ($accion === 'cesta') {
            $vista = 'cesta';

        } elseif ($accion === 'vaciar') {
            $_SESSION['cesta'] = [];
            $vista = 'cesta';
            $avisos[] = 'La cesta se ha vaciado correctamente.';

        } elseif ($accion === 'comprar') {
            $vista = 'factura';
            $cesta = $_SESSION['cesta'];

            if (count($cesta) === 0) {
                $errores[] = 'La cesta está vacía, no hay nada que comprar.';
            } else {
                // 1) Comprobar que se pueden comprar TODOS los artículos
                foreach ($cesta as $id => $cantidad) {
                    if (!isset($catalogo[$id])) {
                        $errores[] = "El producto con id $id ya no existe.";
                    } elseif ($cantidad > $catalogo[$id]['stock']) {
                        $errores[] = "Stock insuficiente de «" . e($catalogo[$id]['nombre'])
                            . "» (pedido: $cantidad, disponible: " . $catalogo[$id]['stock'] . ").";
                    }
                }

                // 2) Si todo es correcto: descontar stock, generar factura y vaciar cesta
                if (count($errores) === 0) {
                    $lineas = [];
                    $base = 0.0;
                    foreach ($cesta as $id => $cantidad) {
                        $catalogo[$id]['stock'] -= $cantidad;
                        $subtotal = $catalogo[$id]['precio'] * $cantidad;
                        $base += $subtotal;
                        $lineas[] = [
                            'nombre'   => $catalogo[$id]['nombre'],
                            'precio'   => $catalogo[$id]['precio'],
                            'cantidad' => $cantidad,
                            'subtotal' => $subtotal,
                        ];
                    }
                    $iva = round($base * IVA, 2);
                    $factura = [
                        'numero' => 'F-' . date('Ymd-His'),
                        'fecha'  => date('d/m/Y H:i'),
                        'lineas' => $lineas,
                        'base'   => $base,
                        'iva'    => $iva,
                        'total'  => $base + $iva,
                    ];
                    $_SESSION['cesta'] = [];
                }
            }
        } else {
            $errores[] = 'La acción solicitada no existe.';
            $vista = 'catalogo';
        }

    } else {
        // Parámetros GET inesperados
        $errores[] = 'Los parámetros recibidos no son válidos.';
        $vista = 'catalogo';
    }
}
// else: GET sin parámetros -> catálogo completo (vista por defecto)

// Datos para pintar la cesta
$lineasCesta   = [];
$totalCesta    = 0.0;
$unidadesCesta = 0;
foreach ($_SESSION['cesta'] as $id => $cantidad) {
    if (isset($catalogo[$id])) {
        $subtotal = $catalogo[$id]['precio'] * $cantidad;
        $lineasCesta[] = [
            'nombre'   => $catalogo[$id]['nombre'],
            'precio'   => $catalogo[$id]['precio'],
            'cantidad' => $cantidad,
            'subtotal' => $subtotal,
        ];
        $totalCesta    += $subtotal;
        $unidadesCesta += $cantidad;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda - Cesta de productos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding-top: 60px; background: #f4f6f8; color: #222; }
        nav { position: fixed; top: 0; left: 0; right: 0; background: #1f3a5f; padding: 0 20px; z-index: 10; }
        nav a { display: inline-block; color: #fff; text-decoration: none; padding: 18px 14px; }
        nav a:hover { background: #2f5a96; }
        nav .cesta-info { float: right; color: #cfe0f5; padding: 18px 0; }
        main { max-width: 900px; margin: 20px auto; background: #fff; padding: 20px 30px; border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,.15); }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { border-bottom: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #eef2f7; }
        td.num, th.num { text-align: right; }
        .error { background: #fdecea; border-left: 4px solid #d32f2f; padding: 10px 14px; margin: 10px 0; }
        .ok    { background: #e8f5e9; border-left: 4px solid #2e7d32; padding: 10px 14px; margin: 10px 0; }
        .info  { background: #fff8e1; border-left: 4px solid #f9a825; padding: 10px 14px; margin: 10px 0; }
        button { background: #1f3a5f; color: #fff; border: 0; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-size: 1em; }
        button:hover { background: #2f5a96; }
        input[type=number] { width: 70px; padding: 4px; }
        .total { font-size: 1.1em; font-weight: bold; }
    </style>
</head>
<body>

<nav>
    <?php foreach ($menu as $opcion): ?>
        <a href="<?= e($opcion['url']) ?>"><?= e($opcion['texto']) ?></a>
    <?php endforeach; ?>
    <span class="cesta-info">🛒 <?= $unidadesCesta ?> ud. · <?= euros($totalCesta) ?></span>
</nav>

<main>
<?php
// Mensajes comunes
foreach ($errores as $mensaje) {
    echo '<div class="error">' . $mensaje . '</div>';
}
foreach ($avisos as $mensaje) {
    echo '<div class="ok">' . e($mensaje) . '</div>';
}
?>

<?php if ($vista === 'catalogo'): ?>
    <!-- ================= CATÁLOGO COMPLETO ================= -->
    <h1>Catálogo de productos</h1>
    <table>
        <tr><th>ID</th><th>Nombre</th><th>Categoría</th><th class="num">Precio</th><th class="num">Stock</th><th></th></tr>
        <?php foreach ($catalogo as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= e($p['nombre']) ?></td>
                <td><?= e($p['categoria']) ?></td>
                <td class="num"><?= euros($p['precio']) ?></td>
                <td class="num"><?= $p['stock'] ?></td>
                <td><a href="index.php?producto=<?= $p['id'] ?>">Ver información</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php elseif ($vista === 'producto'): ?>
    <!-- ================= PRODUCTO CONCRETO ================= -->
    <h1>Información del producto</h1>
    <?php if ($producto !== null): ?>
        <table>
            <tr><th>Identificador</th><td><?= $producto['id'] ?></td></tr>
            <tr><th>Nombre</th><td><?= e($producto['nombre']) ?></td></tr>
            <tr><th>Categoría</th><td><?= e($producto['categoria']) ?></td></tr>
            <tr><th>Precio</th><td><?= euros($producto['precio']) ?></td></tr>
            <tr><th>Stock</th><td><?= $producto['stock'] ?></td></tr>
        </table>
    <?php endif; ?>
    <p><a href="index.php">← Volver al catálogo</a></p>

<?php elseif ($vista === 'anadir'): ?>
    <!-- ================= FORMULARIO ÚNICO (POST) ================= -->
    <h1>Añadir productos a la cesta</h1>
    <form action="index.php" method="post">
        <table>
            <tr><th></th><th>Producto</th><th class="num">Precio</th><th class="num">Stock</th><th>Cantidad</th></tr>
            <?php foreach ($catalogo as $p): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="productos[]" value="<?= $p['id'] ?>"
                               id="p<?= $p['id'] ?>" <?= $p['stock'] < 1 ? 'disabled' : '' ?>>
                    </td>
                    <td><label for="p<?= $p['id'] ?>"><?= e($p['nombre']) ?></label></td>
                    <td class="num"><?= euros($p['precio']) ?></td>
                    <td class="num"><?= $p['stock'] ?></td>
                    <td>
                        <input type="number" name="cantidad[<?= $p['id'] ?>]" value="1"
                               min="1" max="<?= $p['stock'] ?>" <?= $p['stock'] < 1 ? 'disabled' : '' ?>>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit">Añadir a la cesta</button>
    </form>

<?php elseif ($vista === 'cesta'): ?>
    <!-- ================= CONSULTA DE LA CESTA ================= -->
    <h1>Tu cesta</h1>
    <?php if (count($lineasCesta) === 0): ?>
        <div class="info">La cesta está vacía.</div>
    <?php else: ?>
        <table>
            <tr><th>Producto</th><th class="num">Precio</th><th class="num">Cantidad</th><th class="num">Subtotal</th></tr>
            <?php foreach ($lineasCesta as $l): ?>
                <tr>
                    <td><?= e($l['nombre']) ?></td>
                    <td class="num"><?= euros($l['precio']) ?></td>
                    <td class="num"><?= $l['cantidad'] ?></td>
                    <td class="num"><?= euros($l['subtotal']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p>Número de productos distintos: <strong><?= count($lineasCesta) ?></strong>
           · Unidades totales: <strong><?= $unidadesCesta ?></strong></p>
        <p class="total">Importe total (sin IVA): <?= euros($totalCesta) ?></p>
        <p>
            <a href="index.php?accion=comprar">Comprar</a> ·
            <a href="index.php?accion=vaciar">Vaciar cesta</a>
        </p>
    <?php endif; ?>

<?php elseif ($vista === 'factura'): ?>
    <!-- ================= COMPRA / FACTURA ================= -->
    <?php if ($factura !== null): ?>
        <h1>Factura</h1>
        <p>Nº: <strong><?= e($factura['numero']) ?></strong> · Fecha: <?= e($factura['fecha']) ?></p>
        <table>
            <tr><th>Producto</th><th class="num">Precio</th><th class="num">Cantidad</th><th class="num">Subtotal</th></tr>
            <?php foreach ($factura['lineas'] as $l): ?>
                <tr>
                    <td><?= e($l['nombre']) ?></td>
                    <td class="num"><?= euros($l['precio']) ?></td>
                    <td class="num"><?= $l['cantidad'] ?></td>
                    <td class="num"><?= euros($l['subtotal']) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr><td colspan="3" class="num">Base imponible</td><td class="num"><?= euros($factura['base']) ?></td></tr>
            <tr><td colspan="3" class="num">IVA (21%)</td><td class="num"><?= euros($factura['iva']) ?></td></tr>
            <tr class="total"><td colspan="3" class="num">TOTAL</td><td class="num"><?= euros($factura['total']) ?></td></tr>
        </table>
        <div class="ok">¡Compra realizada con éxito! La cesta ha quedado vacía.</div>
    <?php else: ?>
        <h1>No se ha podido realizar la compra</h1>
        <p><a href="index.php?accion=cesta">Revisar la cesta</a></p>
    <?php endif; ?>
<?php endif; ?>
</main>

</body>
</html>
