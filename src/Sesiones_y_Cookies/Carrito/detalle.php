
<?php
require_once "config.php";

// Recogemos el producto de la URL
$nombre = $_GET['producto'] ?? '';

// Comprobamos que existe
if (!isset($_SESSION['productos'][$nombre])) {
    header("Location: index.php");
    exit;
}

$producto = $_SESSION['productos'][$nombre];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detalle del producto</title>
</head>
<body>

<h1><?php echo htmlspecialchars($nombre); ?></h1>

<img
    src="imagenes/<?php echo htmlspecialchars($producto['imagen']); ?>"
    width="300"
    alt="<?php echo htmlspecialchars($nombre); ?>"
>

<h2>Precio: <?php echo $producto['precio']; ?> euros</h2>

<p>
    <?php echo htmlspecialchars($producto['detalle']); ?>
</p>

<a href="index.php">Volver a la tienda</a>

</body>
</html>
