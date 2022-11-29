<?php require_once '../includes/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"     content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet"    href="../public/css/mainEjecutivo.css">
    <title>Panel del ejecutivo</title>
</head>
<body>
    <?php require '../views/navEjecutivo.php' ?>
    <section>
        <div class="body-content">
            <div class="content-tittle">
                <h1>¡Hola, <?php echo $user['name']; ?>!</h1>
            </div>
            <div class="content-customers">
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
                                <th class="tmp">Editar  </th>
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
    <script src="../../public/js/app.js"></script>
    <script src="../../public/js/nav.js"></script>
</body>
</html>