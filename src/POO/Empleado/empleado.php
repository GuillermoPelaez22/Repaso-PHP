<?php

class Empleado {
    // Atributos
    private $nombre;
    private $sueldo;

    // Constructos
    public function __construct($nombre, $sueldo) {
        $this->nombre = $nombre;
        $this->sueldo = $sueldo;
    }

    // Método asigna
    public function asigna($nombre, $sueldo) {
        // Comprobamos que el nombre coincide
        if ($nombre == $this->nombre) {
            // Actualizamos el sueldo
            $this->sueldo = $sueldo;
        }
    }

    // Método para comprobar los impuestos
    public function impuestos() {
        echo "Empleado: " . $this->nombre . "<br>";

        if ($this->sueldo > 3000) {
            echo "Debe pagar impuestos";
        } else {
            echo "No debe pagar impuestos";
        }
    }
}

// Creamos un objeto empleado
$empleado1 = new Empleado("Jose", 4444);

// Actualizamos su sueldo
$empleado1->asigna("Jose", 1300);

// Mostramos si debe pagar impuestos
$empleado1->impuestos();

?>