<?php
require_once "config.php";

// Si pulsamos el botón Comprar
if (isset($_POST['comprar'])) {

    $producto = $_POST['producto'];

    $cesta = leerCesta();

    // Si ya está en la cesta, aumentamos la cantidad
    if (isset($cesta[$producto])) {
        $cesta[$producto]++;
    } else {
        // Si no está, lo añadimos con cantidad 1
        $cesta[$producto] = 1;
    }

    guardarCesta($cesta);

    header("Location: index.php");
    exit;
}

$productos = $_SESSION['productos'];
$cesta = leerCesta();

$totalProductos = array_sum($cesta);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tienda</title>
</head>
<body>

<h1>La tiendecita</h1>

<h3>
    <a href="cesta.php">
        CESTA (<?php echo $totalProductos; ?> productos)
    </a>
</h3>

<table border="1" cellpadding="15">

<tr>
    <th>Producto</th>
    <th>Precio</th>
    <th>Imagen</th>
    <th>Comprar</th>
</tr>

<?php foreach ($productos as $nombre => $datos) { ?>

<tr>

    <td>
        <?php echo htmlspecialchars($nombre); ?>
    </td>

    <td>
        <?php echo $datos['precio']; ?> euros
    </td>

    <td>
        <a href="detalle.php?producto=<?php echo urlencode($nombre); ?>">
            <img
                src="imagenes/<?php echo htmlspecialchars($datos['imagen']); ?>"
                width="80"
                alt="<?php echo htmlspecialchars($nombre); ?>"
            >
        </a>
    </td>

    <td>
        <form method="POST" action="index.php">

            <input
                type="hidden"
                name="producto"
                value="<?php echo htmlspecialchars($nombre); ?>"
            >

            <input type="submit" name="comprar" value="Comprar">

        </form>
    </td>

</tr>

<?php } ?>

</table>

</body>
</html>
