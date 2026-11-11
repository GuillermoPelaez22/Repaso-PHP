<?php
session_start();

// Creamos el array de colores si todavía no existe
if (!isset($_SESSION['colores'])) {
    $_SESSION['colores'] = array();
}

// Si se pulsa el botón Añadir color
if (isset($_POST['añadir'])) {

    // Generamos un color hexadecimal aleatorio
    $color = sprintf("#%06X", random_int(0, 16777215));

    // Lo añadimos al array de sesión
    $_SESSION['colores'][] = $color;
}

// Color de fondo de la página
$fondo = isset($_SESSION['color_fondo'])
    ? $_SESSION['color_fondo']
    : "#FFFFFF";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Generador de colores</title>
</head>

<body style="background-color: <?php echo $fondo; ?>">
    <h1>Generador de colores</h1>

    <form action="principal.php" method="POST">
        <input type="submit" name="añadir"
                value="Añadir color">
    </form>

     <br>

    <form action="paleta.php" method="GET">
        <input type="submit"
               value="Mostrar paleta creada">
    </form>

    <p>
        Colores generados:
        <?php echo count($_SESSION['colores']); ?>
    </p>
</body>
</html>