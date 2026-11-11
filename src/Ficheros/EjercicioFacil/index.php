<?php

function escribirTresNumeros($num1, $num2, $num3) {

    // Abrimos el archivo en modo escritura
    $archivo = fopen("datosEjercicio.txt", "w");

    // Escribimos los tres números en líneas diferentes
    fwrite($archivo, $num1 . "\n");
    fwrite($archivo, $num2 . "\n");
    fwrite($archivo, $num3 . "\n");

    // Cerramos el archivo
    fclose($archivo);
}

// Llamamos a la función pasando tres números
escribirTresNumeros(10, 20, 30);

?>
