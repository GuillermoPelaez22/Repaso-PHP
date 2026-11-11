<?php
session_start();

// Creamos el array de sesión la primera vez
if (!isset($_SESSION['mascotas'])) {
    $_SESSION['mascotas'] = [];
}

$mensaje = "";

// FECHA ACTUAL: no se puede elegir otra fecha
$fecha = date("d-m-Y");
$cabecera = "#" . $fecha . "#";

// Si pulsamos AÑADIR MASCOTA
if (isset($_POST['anadir'])) {

    $nombre = trim($_POST['nombre']);
    $tipo = trim($_POST['tipo']);
    $edad = trim($_POST['edad']);

    if ($nombre != "" && $tipo != "" && $edad != "" && is_numeric($edad) && $edad >= 0) {

        // Guardamos la mascota en el array de sesión
        $_SESSION['mascotas'][$nombre] = [
            "tipo" => $tipo,
            "edad" => $edad
        ];

        $mensaje = "Mascota añadida correctamente.";

    } else {
        $mensaje = "Rellena todos los campos correctamente.";
    }
}

// Si pulsamos GRABAR EN EL FICHERO
if (isset($_POST['grabar'])) {

    if (count($_SESSION['mascotas']) > 0) {

        $nombreFichero = "mascotas.txt";

        // Comprobamos si el fichero existe y leemos su contenido
        if (file_exists($nombreFichero)) {
            $contenido = file_get_contents($nombreFichero);
        } else {
            $contenido = "";
        }

        // Abrimos el fichero en modo añadir
        $archivo = fopen($nombreFichero, "a");

        if ($archivo) {

            // Si el fichero no está vacío y no acaba en salto de línea
            if ($contenido != "" && substr($contenido, -1) != "\n") {
                fwrite($archivo, PHP_EOL);
            }

            // Comprobamos si ya existe la cabecera de hoy
            if (strpos($contenido, $cabecera) === false) {

                // Escribimos la cabecera de la fecha actual
                fwrite($archivo, $cabecera . PHP_EOL);
            }

            // Escribimos todas las mascotas de la sesión
            foreach ($_SESSION['mascotas'] as $nombre => $datos) {

                $linea = $nombre . "-" .
                         $datos['tipo'] . "-" .
                         $datos['edad'] . PHP_EOL;

                fwrite($archivo, $linea);
            }

            // Cerramos el fichero
            fclose($archivo);

            // Vaciamos el array de sesión
            $_SESSION['mascotas'] = [];

            $mensaje = "Mascotas guardadas correctamente.";

        } else {
            $mensaje = "No se ha podido abrir el fichero.";
        }

    } else {
        $mensaje = "No hay mascotas para guardar.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clínica veterinaria</title>
</head>
<body>

<h1>Clínica veterinaria</h1>

<h3>Fecha actual: <?php echo $fecha; ?></h3>

<h2>Añadir mascota</h2>

<form method="POST" action="index.php">

    Nombre:
    <input type="text" name="nombre" required>

    <br><br>

    Tipo de animal:
    <input type="text" name="tipo" required>

    <br><br>

    Edad:
    <input type="number" name="edad" min="0" required>

    <br><br>

    <input type="submit" name="anadir" value="Añadir mascota">

</form>

<p><?php echo htmlspecialchars($mensaje); ?></p>

<h2>Mascotas añadidas</h2>

<table border="1" cellpadding="10">

    <tr>
        <th>Nombre</th>
        <th>Tipo de animal</th>
        <th>Edad</th>
    </tr>

    <?php foreach ($_SESSION['mascotas'] as $nombre => $datos) { ?>

        <tr>
            <td><?php echo htmlspecialchars($nombre); ?></td>
            <td><?php echo htmlspecialchars($datos['tipo']); ?></td>
            <td><?php echo htmlspecialchars($datos['edad']); ?></td>
        </tr>

    <?php } ?>

</table>

<br>

<form method="POST" action="index.php">
    <input type="submit" name="grabar" value="Grabar mascotas en el fichero">
</form>

</body>
</html>
