<?php

$error = $_GET['error'] ?? "";
$exito = $_GET['exito'] ?? "";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>E1 - Cifrado</title>
</head>

<body>
    <h1>Ejercicio 1 - Cifrar y descifrar mensajes</h1>

    <form method="post">
        <label for="mensaje">Mensaje:</label><br>
        <input type="text" id="mensaje" name="mensaje" value="<?= $_GET['mensaje'] ?? '' ?>" required><br>

        <label for="semilla">Semilla:</label><br>
        <input type="text" id="semilla" name="semilla" value="<?= $_GET['semilla'] ?? '' ?>" required><br><br>

        <button class="btn-cifrar" type="submit" formaction="./cifrar.php">Cifrar</button>

        <button class="btn-descifrar" type="submit" formaction="./descifrar.php">Descifrar</button>
    </form>
    <br>
    <?php if (!empty($error)): ?>
        <div class="resultado alerta-error">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($exito)): ?>
        <div class="resultado alerta-exito">
            <?= $exito; ?>
        </div>
    <?php endif; ?>
</body>

</html>