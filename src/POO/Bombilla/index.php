<?php

// CLASE BOMBILLA
class Bombilla {

    // Atributos privados
    private $encendida;
    private $potencia;
    private $ubicacion;

    // Estado del interruptor general (compartido por todas)
    private static $interruptorGeneral = true;

    // Constructor
    public function __construct($potencia, $ubicacion) {

        $this->encendida = false;
        $this->potencia = $potencia;
        $this->ubicacion = $ubicacion;
    }

    // GETTERS

    public function getEncendida() {
        return $this->encendida;
    }

    public function getPotencia() {
        return $this->potencia;
    }

    public function getUbicacion() {
        return $this->ubicacion;
    }

    // SETTERS

    public function setEncendida($encendida) {
        $this->encendida = $encendida;
    }

    public function setPotencia($potencia) {
        $this->potencia = $potencia;
    }

    public function setUbicacion($ubicacion) {
        $this->ubicacion = $ubicacion;
    }

    // Comprueba si la bombilla está encendida realmente
    public function estaEncendida() {
        return $this->encendida && self::$interruptorGeneral;
    }

    // Métodos del interruptor general

    public static function setInterruptorGeneral($estado) {
        self::$interruptorGeneral = $estado;
    }

    public static function getInterruptorGeneral() {
        return self::$interruptorGeneral;
    }
}


// INICIAMOS LA SESIÓN
session_start();

// Creamos las bombillas la primera vez
if (!isset($_SESSION['bombillas'])) {

    $_SESSION['bombillas'] = [];

    $_SESSION['bombillas'][] = new Bombilla(60, "Salón");
    $_SESSION['bombillas'][] = new Bombilla(40, "Cocina");
    $_SESSION['bombillas'][] = new Bombilla(50, "Dormitorio");
    $_SESSION['bombillas'][] = new Bombilla(30, "Baño");

    // Interruptor general encendido
    $_SESSION['interruptor'] = true;
}

// Recuperamos el estado del interruptor general
Bombilla::setInterruptorGeneral($_SESSION['interruptor']);


// SI PULSAMOS EL BOTÓN DE UNA BOMBILLA
if (isset($_POST['cambiarBombilla'])) {

    $indice = (int) $_POST['indice'];

    if (isset($_SESSION['bombillas'][$indice])) {

        $bombilla = $_SESSION['bombillas'][$indice];

        // Cambiamos su estado individual
        $bombilla->setEncendida(!$bombilla->getEncendida());

    }

    header("Location: index.php");
    exit;
}


// SI PULSAMOS EL INTERRUPTOR GENERAL
if (isset($_POST['cambiarGeneral'])) {

    // Cambiamos el estado general
    $_SESSION['interruptor'] = !$_SESSION['interruptor'];

    // Actualizamos el estado de la clase
    Bombilla::setInterruptorGeneral($_SESSION['interruptor']);

    header("Location: index.php");
    exit;
}


// CALCULAMOS LA POTENCIA CONSUMIDA
$potenciaTotal = 0;

foreach ($_SESSION['bombillas'] as $bombilla) {

    if ($bombilla->estaEncendida()) {

        $potenciaTotal += $bombilla->getPotencia();

    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Casa inteligente</title>

    <style>

        body {
            font-family: Arial;
            text-align: center;
            background-color: #eeeeee;
        }

        .bombilla {
            display: inline-block;
            background-color: white;
            border: 2px solid #cccccc;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            width: 150px;
        }

        .luz {
            font-size: 50px;
        }

        .encendida {
            color: orange;
        }

        .apagada {
            color: grey;
        }

        .general {
            background-color: white;
            padding: 20px;
            margin: 20px;
        }

    </style>

</head>

<body>

<h1>CASA INTELIGENTE</h1>


<!-- INTERRUPTOR GENERAL -->

<div class="general">

    <h2>Interruptor general</h2>

    <?php if (Bombilla::getInterruptorGeneral()) { ?>

        <p>Fusibles: ACTIVADOS</p>

        <form method="POST">
            <input type="submit"
                   name="cambiarGeneral"
                   value="Apagar interruptor general">
        </form>

    <?php } else { ?>

        <p>Fusibles: SALTADOS</p>

        <form method="POST">
            <input type="submit"
                   name="cambiarGeneral"
                   value="Reparar fusibles">
        </form>

    <?php } ?>

</div>


<!-- BOMBILLAS DE LA CASA -->

<h2>Bombillas</h2>

<?php foreach ($_SESSION['bombillas'] as $indice => $bombilla) { ?>

    <div class="bombilla">

        <h3>
            <?php echo htmlspecialchars($bombilla->getUbicacion()); ?>
        </h3>

        <?php if ($bombilla->estaEncendida()) { ?>

            <div class="luz encendida">💡</div>
            <p>ENCENDIDA</p>

        <?php } else { ?>

            <div class="luz apagada">💡</div>
            <p>APAGADA</p>

        <?php } ?>

        <p>
            Potencia:
            <?php echo $bombilla->getPotencia(); ?> W
        </p>

        <form method="POST">

            <input type="hidden"
                   name="indice"
                   value="<?php echo $indice; ?>">

            <input type="submit"
                   name="cambiarBombilla"
                   value="Encender / Apagar">

        </form>

    </div>

<?php } ?>


<!-- POTENCIA TOTAL -->

<h2>
    Potencia consumida:
    <?php echo $potenciaTotal; ?> W
</h2>

</body>
</html>
