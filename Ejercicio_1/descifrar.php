<?php
$alfabeto = [
    "A",
    "B",
    "C",
    "D",
    "E",
    "F",
    "G",
    "H",
    "I",
    "J",
    "K",
    "L",
    "M",
    "N",
    "Ñ",
    "O",
    "P",
    "Q",
    "R",
    "S",
    "T",
    "U",
    "V",
    "W",
    "X",
    "Y",
    "Z"
];
$mensaje = "";
$semilla = "";
$mensajeDescifrado = "";
$error = "";
$exito = "";
$f = "UTF-8";

function descifrarLetraSemNum(string $letra, int $semilla, array $alfabeto): string
{
    $pos = array_search($letra, $alfabeto);
    $posAlfabeto = (($pos - $semilla) + 27) % 27;
    $letraCif = $alfabeto[$posAlfabeto];
    return $letraCif;
}

function descifrarSemNum(string $mensaje, int $semilla, array $alfabeto, string $f): string
{
    $mensCif = "";
    for ($i = 0; $i < mb_strlen($mensaje, $f); $i++) {
        $letraN = mb_substr($mensaje, $i, 1, $f);
        $letraCif = descifrarLetraSemNum($letraN, $semilla, $alfabeto);
        $mensCif .= $letraCif;
    }
    return $mensCif;
}

if (isset($_POST['mensaje'], $_POST['semilla'])) {
    $mensaje = trim($_POST['mensaje']);
    $semilla = trim($_POST['semilla']);
} else {
    header("Location: index.php?error=Los+campos+son+obligatorios");
    exit();
}

if (preg_match('/^[a-zA-ZñÑ]+$/u', $mensaje)) {
    if (preg_match('/^[a-zA-ZñÑ]+$/u', $semilla)) {

        $mensaje = mb_strtoupper($mensaje, $f);

        for ($i = 0; $i < mb_strlen($mensaje, $f); $i++) {
            $letra = mb_substr($mensaje, $i, 1, $f);
            $posSemilla = $i % mb_strlen($semilla, $f);
            $letraSem = mb_strtoupper(mb_substr($semilla, $posSemilla, 1, $f), $f);
            $posicionSem = array_search($letraSem, $alfabeto);
            $posicion = array_search($letra, $alfabeto);
            $nuevaPosicion = ($posicion + 1) - ($posicionSem + 1);
            if ($nuevaPosicion < 1) {
                $nuevaPosicion = $nuevaPosicion + 27;
            }
            $letraDescifrada = $alfabeto[$nuevaPosicion - 1];
            $mensajeDescifrado .= $letraDescifrada;
        }

        $exito = "Mensaje recibido: " . $mensaje
            . "<br>Semilla recibida: " . $semilla
            . "<br>Mensaje descifrado: " . $mensajeDescifrado;
    } else if (is_numeric($semilla)) {
        $mensajeDescifrado = descifrarSemNum($mensaje, (int) $semilla, $alfabeto, $f);
        $exito = "Mensaje recibido: " . $mensaje
            . "<br>Semilla recibida: " . $semilla
            . "<br>Mensaje descifrado: " . $mensajeDescifrado;
    } else {
        $error = "La semilla no puede contener caracteres y letras a la vez.";
    }
} else {
    $error = "El mensaje no puede tener caracteres que no sean letras.";
}

if ($error != "") {
    header("Location: index.php?error=" . urlencode($error));
} else {
    header("Location: index.php?exito=" . urlencode($exito)
        . "&mensaje=" . urlencode($mensajeDescifrado)
        . "&semilla=" . urlencode($semilla));
}
exit();
