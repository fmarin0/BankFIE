<?php require_once '../includes/sessionCliente.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./../public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet"    href="./../public/css/ejecutivo.css">                     
    <link rel="stylesheet"    href="./../public/css/cliente.css">                     
    <title>Panel de cliente</title>
</head>
<body>
    <?php require '../views/nav.php' ?>
    <section>
        <div class="body-content">
            <div class="content-tittle">
                <h1 class="mb-1 mt-1">¡Hola, <?php echo $user['name']; ?>!</h1>
            </div>
            <div class="content-customers">
                <p id="respuesta"></p>
                <div>
                    <h2 class="text-center mb-1">Prestamos</h2>
                </div>
                <div class="body-table">
                    <table>
                        <thead>
                            <tr>
                                <th>#       </th>
                                <th>Monto  </th>
                                <th class="tmp">Interes </th>
                                <th class="tmp">plazo   </th>
                                <th class="tmp">ver     </th>
                                <th class="tmp">pagar   </th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="modal" class="modal" >
        <div class="modal-content" id="content">
            <div class="head">
                <div class="title">
                    <h2>Prestamo - <span id="NoPrestamo"></span></h2>
                </div>
                <div class="closed">
                    <i class="fa-solid fa-circle-xmark" id="btn-closed"></i>
                </div>
            </div>
            <div class="modal-body">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha de pago</th>
                            <th>Estatus</th>    
                            <th>Monto</th>    
                        </tr>
                    </thead>
                    <tbody id="desglose">
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </section>
    <script src="../../public/js/nav.js"></script>
    <script src="../../public/js/consulta.js"></script>
</body>
</html>