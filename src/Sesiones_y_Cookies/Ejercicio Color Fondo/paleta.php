<?php
session_start();

// Si no existe el array, lo creamos vacío
if (!isset($_SESSION['colores'])) {
    $_SESSION['colores'] = array();
}

// Si se pulsa una celda de la tabla
if (isset($_POST['indice'])) {

    $indice = $_POST['indice'];

    // Comprobamos que el índice existe
    if (isset($_SESSION['colores'][$indice])) {

        // Cambiamos el color de fondo
        $_SESSION['color_fondo'] = $_SESSION['colores'][$indice];
    }
}

// Si se pulsa el botón para destruir la sesión
if (isset($_POST['nueva'])) {

    session_unset();
    session_destroy();

    // Volvemos a la página principal
    header("Location: principal.php");
    exit;
}

// Color de fondo actual
$fondo = isset($_SESSION['color_fondo'])
    ? $_SESSION['color_fondo']
    : "#FFFFFF";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mi paleta de colores</title>
</head>

<body style="background-color: <?php echo $fondo; ?>;">

    <h1>Paleta de colores</h1>

    <table border="1" cellpadding="15">

        <?php

        // Recorremos todos los colores
        for ($i = 0; $i < count($_SESSION['colores']); $i++) {

            // Abrimos una fila cada 5 colores
            if ($i % 5 == 0) {
                echo "<tr>";
            }

            $color = $_SESSION['colores'][$i];

            echo "<td style='background-color: $color;'>";

            // Cada celda es un formulario que envía su índice
            echo "<form action='paleta.php' method='POST'>";

            echo "<input type='hidden' name='indice' value='$i'>";

            echo "<input type='submit' value='$color'
                  style='background-color: $color; border: none;
                  padding: 20px; cursor: pointer;'>";

            echo "</form>";

            echo "</td>";

            // Cerramos la fila cada 5 colores
            if (($i + 1) % 5 == 0) {
                echo "</tr>";
            }
        }

        // Cerramos la última fila si no tiene 5 celdas
        if (count($_SESSION['colores']) % 5 != 0) {
            echo "</tr>";
        }

        ?>

    </table>

    <br>

    <!-- Botón para volver a la página principal -->
    <form action="principal.php" method="GET">
        <input type="submit" value="Volver a la página principal">
    </form>

    <br>

    <!-- Botón para destruir la sesión -->
    <form action="paleta.php" method="POST">
        <input type="submit" name="nueva"
               value="Destruir sesión y crear nueva paleta">
    </form>

</body>
</html>
