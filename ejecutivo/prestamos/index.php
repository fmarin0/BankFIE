<?php
    require_once '../../includes/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../public/css/global.css">
    <title>Prestamos</title>
</head>
<body>
    <?php require '../../views/navEjecutivo.php' ?>
    <section>
        <div class="body-content">
            <div id="respuestas"> </div>
            <h1>Generar un depósito</h1>
            <div class="form-content">
                <form id="form">
                    <input type="text" name="NoCuenta" id="" placeholder="Numero de cuenta">
                    <input type="text" name="Cantidad" id="" placeholder="Cantidad a depositar">
                    <button type="button">
                        Generar Depósito
                    </button>
                </form>
            </div>
        </div>
    </section>
    <script src="../../public/js/nav.js"></script>
    <script src="../../public/js/prestamos.js"></script>
</body>
</html>