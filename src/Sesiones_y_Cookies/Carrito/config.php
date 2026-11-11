<?php
session_start();

// Creamos los porductos solamente la primera vez
if (!isset($_SESSION['productos'])) {

    $_SESSION['productos'] = [
        "raton" => [
            "precio" => 6,
            "detalle" => "Ratón inalámbrico para ordenador",
            "imagen" => "raton.png"
        ],

        "teclado" => [
            "precio" => 11,
            "detalle" => "Teclado para ordenador",
            "imagen" => "teclado.png"
        ],

        "monitor" => [
            "precio" => 80,
            "detalle" => "Monitor de pantalla plana",
            "imagen" => "monitor.png"
        ],

         "joystick" => [
            "precio" => 33,
            "detalle" => "Mando para videojuegos.",
            "imagen" => "joystick.png"
        ]
    ];
}

// Función para recuperar la cesta desde la cookie
function leerCesta() {

    $cesta = [];

    if (isset($_COOKIE['cesta'])) {

    $datos = json_decode($_COOKIE['cesta'], true);

    if (is_array($datos)) {
        foreach ($datos as $producto => $cantidad) {

            if (
                isset($_SESSION['productos'][$producto]) &&
                is_numeric($cantidad) &&
                (int)$cantidad > 0
            ){
                $cesta[$producto] = (int)$cantidad;
            }
        }
    }
    }
    return $cesta;
}

// Función para guardar la cesta en una cookie
function guardarCesta($cesta) {

    setcookie(
        "cesta",
        json_encode($cesta),
        time() + (30 * 24 * 60 * 60),
        "/"
    );
}
?>