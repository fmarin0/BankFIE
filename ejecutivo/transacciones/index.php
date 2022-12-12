<?php require_once '../../includes/session.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../public/css/transacciones.css">
    <title>Transacciones</title>
</head>
<body>
   <?php include_once '../../views/navEjecutivo.php'; ?>  
    <section>
        <div class="body-content">
            <h1 class="h1">Transacciones</h1>
            <div class="form-content">
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
                        <div class="message"><h1 class="alert">Correcto</h1><p class="p">Operación realizada correctamente.</p></div>
                    </div>
                </div>
                <div id="respuesta"></div>
                <form id="transacciones" class="">
                    <input type="text" name="NoCuenta" id="NoCuenta" placeholder="Numero de cuenta">
                    <div class="d-n" id="acciones">
                        <input type="radio" name="accion" id="retiro" value="1">
                        <label for="retiro">Retiro <i class="fa-regular fa-money-from-bracket"></i></label>
                        <input type="radio" name="accion" id="deposito" value="3">
                        <label for="deposito">Deposito <i class="fa-solid fa-money-bill-transfer"></i></label>
                        
                        <input type="number" name="cantidad" id="cantidad" placeholder="Cantidad en pesos mxn">
                        <input type="text" name="cuentaDestino" id="cuentaDestino" placeholder="Cuenta destino" class="d-n mt-1">
                        <span class="d-n" id="getSaldo"></span>
                        <button type="button" id="btn-submit">Generar referencia</button>
                    </div>
                </form>
            </div>
        </div>
        
    </section>
    <script src="../../public/js/nav.js"></script>
    <script src="../../public/js/transacciones.js"></script>
</body>
</html>
