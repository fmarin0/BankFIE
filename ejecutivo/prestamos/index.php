<?php require_once '../../includes/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../public/css/prestamos.css">
    <title>Prestamos</title>
</head>
<body>
    <?php require '../../views/navEjecutivo.php' ?>
    <section>
        <div class="body-content">
            <div id="respuestas-solicitud"></div>
            <form id="info">
                <h3>Simular Prestamos</h3>
                <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad en pesos MXN">
                <input type="number" name="plazo"    id="plazo"    placeholder="Plazo en meses">
            </form>
            <div id="tabla-amortizacion">
                
            </div>
        </div>
    </section>
    <div id="container" class="d-n">
        <div id="success-box">
            <div class="dot"></div>
            <div class="dot two"></div>
            <div class="face">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth happy"></div>
            </div>
            <div class="shadow scale"></div>
            <div class="message"><h1 class="alert">Correcto</h1><p class="p">Prestamo aprobado.</p></div>
        </div>
    </div>
    <script src="../../public/js/nav.js"></script>
    <script src="../../public/js/prestamos.js"></script>
</body>
</html>
