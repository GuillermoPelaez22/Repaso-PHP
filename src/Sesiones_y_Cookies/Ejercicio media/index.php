<?php
session_start();

// Inicializamos las variables de sesión
if (!isset($_SESSION['suma'])) {
    $_SESSION['suma'] = 0;
    $_SESSION['contador'] = 0;
}

// Variables para mostrar el resultado
$media = null;
$mensaje = "";

// Comprobamos si se ha enviado el formulario
if (isset($_POST['numero'])) {

    $numero = $_POST['numero'];

    // Si introduce un número negativo, terminamos
    if ($numero < 0) {

        if ($_SESSION['contador'] > 0) {
            $media = $_SESSION['suma'] / $_SESSION['contador'];
        } else {
            $mensaje = "No se han introducido números positivos.";
        }

        // Borramos los datos de la sesión
        unset($_SESSION['suma']);
        unset($_SESSION['contador']);

    } else if ($numero > 0) {

        // Acumulamos el número y contamos uno más
        $_SESSION['suma'] += $numero;
        $_SESSION['contador']++;

    } else {
        $mensaje = "El cero no es un número positivo.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Media de números</title>
</head>
<body>

    <h2>Calculadora de media</h2>

    <?php
    if ($media !== null) {
        echo "La media es: " . $media;
    } else if ($mensaje != "") {
        echo $mensaje;
    } else {
    ?>

        <p>Introduce números positivos. Para terminar, introduce uno negativo.</p>

        <form action="index.php" method="POST">
            Número:
            <input type="number" name="numero" step="any" required>
            <input type="submit" value="Enviar">
        </form>

        <?php
        echo "Suma actual: " . $_SESSION['suma'];
        echo "<br>";
        echo "Cantidad de números: " . $_SESSION['contador'];
        ?>

    <?php
    }
    ?>

</body>
</html>