
<?php
require_once "config.php";

$cesta = leerCesta();

// Si pulsamos Eliminar
if (isset($_POST['eliminar'])) {

    $producto = $_POST['producto'];

    if (isset($cesta[$producto])) {

        // Quitamos una unidad
        $cesta[$producto]--;

        // Si llega a cero, eliminamos el producto
        if ($cesta[$producto] == 0) {
            unset($cesta[$producto]);
        }
    }

    guardarCesta($cesta);

    header("Location: cesta.php");
    exit;
}

// Si pulsamos Vaciar cesta
if (isset($_POST['vaciar'])) {

    setcookie("cesta", "", time() - 3600, "/");

    header("Location: index.php");
    exit;
}

$productos = $_SESSION['productos'];

$totalUnidades = 0;
$totalPrecio = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mi cesta</title>
</head>
<body>

<h1>PRODUCTOS EN TU CESTA</h1>

<table border="1" cellpadding="15">

<tr>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Producto e importe</th>
    <th>Eliminar</th>
</tr>

<?php foreach ($cesta as $nombre => $cantidad) {

    $precio = $productos[$nombre]['precio'];

    $subtotal = $precio * $cantidad;

    $totalUnidades += $cantidad;
    $totalPrecio += $subtotal;

?>

<tr>

    <td>
        <?php echo htmlspecialchars($nombre); ?>
    </td>

    <td>
        <?php echo $cantidad; ?>
    </td>

    <td>
        <img
            src="imagenes/<?php echo htmlspecialchars($productos[$nombre]['imagen']); ?>"
            width="80"
            alt="<?php echo htmlspecialchars($nombre); ?>"
        >

        <br>

        <?php echo htmlspecialchars($nombre); ?>

        <br>

        <?php echo $precio; ?> euros
    </td>

    <td>

        <form method="POST" action="cesta.php">

            <input
                type="hidden"
                name="producto"
                value="<?php echo htmlspecialchars($nombre); ?>"
            >

            <input type="submit" name="eliminar" value="Eliminar">

        </form>

    </td>

</tr>

<?php } ?>

<tr>
    <th>Total</th>
    <td><?php echo $totalUnidades; ?></td>
    <td><?php echo $totalPrecio; ?> euros</td>
    <td>
        <form method="POST" action="cesta.php">
            <input type="submit" name="vaciar" value="Vaciar cesta">
        </form>
    </td>
</tr>

</table>

<br>

<a href="index.php">Volver a la tienda</a>

</body>
</html>
