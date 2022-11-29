<?php require_once '../../includes/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../public/css/transacciones.css">
    <title>Alta de clientes</title>
</head>
<body>
    <?php require '../../views/navEjecutivo.php' ?>
    <section>
        <div class="body-content">
            <div id="respuestas"> </div>
            <h1>Alta de clientes</h1>
            <div class="form-content">
                <form id="datos">
                    <input type="text"     name="nombre"  placeholder="Ingrese el nombre del cliente"     required>
                    <input type="email"    name="email"   placeholder="Ingrese el correo del cliente"     required>
                    <input type="text"     name="curp"    placeholder="Ingrese la curp del cliente"       required>
                    <input type="password" name="pass" placeholder="Ingrese el la contraseña del cliente" required>

                    <button type="button" id="btn-submit">Dar de alta</button>
                </form>
            </div>
        </div>
    </section>

    <script src="../../public/js/nav.js"></script>
    <script src="../../public/js/alta.js"></script>
</body>
</html>