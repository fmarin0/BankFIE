<?php require_once '../includes/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"     content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet"    href="../public/css/mainEjecutivo.css">
    <link rel="stylesheet"    href="../public/css/modal.css">
    <title>Panel del ejecutivo</title>
</head>
<body>
    <?php require '../views/navEjecutivo.php' ?>
    <section>
        <div class="body-content">
            <div class="content-tittle">
                <h1>¡Hola, <?php echo $usuario['name']; ?>!</h1>
            </div>
            <div class="content-customers">
                <p id="respuesta"></p>
                <div>
                    <h2>Cartera de clientes</h2>
                </div>
                <div class="body-table">
                    <table>
                        <thead>
                            <tr>
                                <th>#       </th>
                                <th>Nombre  </th>
                                <th class="tmp">Estatus </th>
                                <th class="tmp">Ver     </th>
                                <th class="tmp">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <div id="modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="title">
                    <h2>Cliente <span id="NoCuenta"></span></h2>
                </div>
                <div class="closed">
                    <i class="fa-solid fa-circle-xmark" id="btn-closed"></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="avatar">
                    <img src="./../public/img/avatar.jpeg" alt="Imagen del cliente" title="Imagen del cliente">
                </div>
                <div class="align-right">
                    <button type="button" id="btn-editar">Editar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../../public/js/app.js"></script>
    <script src="../../public/js/nav.js"></script>
</body>
</html>