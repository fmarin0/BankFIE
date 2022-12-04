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
        <div class="modal-content" id="content">
            <div class="head">
                <div class="title">
                    <h2>Cliente <span id="NoCuenta"></span></h2>
                </div>
                <div class="closed">
                    <i class="fa-solid fa-circle-xmark" id="btn-closed"></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="respuestas-editar">
                    <ul id="respuestas">
                        
                    </ul>
                </div>
                <form action="#" id="FormEditar">
                    <input type="hidden" name="key" id="key" value="">
                    <div class="avatar">
                        <div id="setImg">
                            
                        </div>
                        <label for="img_client" class="btn-edit-img disabled" id="img-btn"> 
                            <span id="img"><i class="fa-solid fa-pen-to-square"></i></span>
                        </label> 
                    </div>
                    <input type="file" name="img_client" id="img_client">
                    <div class="align-center">
                        <label for="name" id="label-name">Nombre completo</label>
                        <input type="text" name="name" id="name" value="" disabled>
                        <label for="CURP" id="label-CURP">CURP</label>
                        <input type="text" name="CURP" id="CURP" value="" disabled>
                    </div>
                    <div class="columnas">
                        <div class="columana">
                            <label for="fena">Fecha de nacimiento</label>
                            <input type="text" name="fena" id="fena" value="" disabled>
                            <label for="estado">Estado</label>
                            <input type="text" name="estado" id="estado" value="" disabled>
                            <label for="domicilio">Domicilio</label>
                            <input type="text" name="domicilio" id="domicilio" value="" disabled>
                        </div>
                        <div class="columana">
                            <label for="edad">Edad</label>
                            <input type="text" name="edad" id="edad" value="" disabled>
                            <label for="municipio">Municipio</label>
                            <input type="text" name="municipio" id="municipio" value="" disabled>
                            <label for="codPostal">C.P.</label>
                            <input type="text" name="codPostal" id="codPostal" value="" disabled>
                        </div>
                    </div>
                    <div class="align-right">
                        <button type="button" id="btn-submit" class="disabled btn-enviar">Guardar</button>
                    </div>
                </form>
            </div>
            <div class="align-right">
                <button type="button" id="btn-editar">Editar</button>
                <button type="button" id="btn-volver" class="disabled btn-black">Volver</button>
            </div>
        </div>
    </div>
    <script src="../../public/js/app.js"></script>
    <script src="../../public/js/nav.js"></script>
</body>
</html>