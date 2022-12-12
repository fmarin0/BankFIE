<?php require_once '../../includes/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../public/css/registro.css">
    <title>Alta de clientes</title>
</head>
<body>
    <?php require '../../views/navEjecutivo.php' ?>
    <section>
        <div class="body-content">
            <div class="alta">
                <h1>Alta de clientes</h1>
                <div id="respuestas"></div>
                <div class="pasos">
                    <ul>
                        <li id="li1"  class="activo-li">Paso 1</li>
                        <li id="li2" >Paso 2</li>
                        <li id="li3" >Paso 3</li>
                    </ul>   
                </div>
                <div class="form-content">
                    <form id="datos" >
                        <section class="identificacion content-activo" id="content-identificacion">
                            <div class="avatar">
                                <div id="fileList">
                                    <div class="img-temp"></div>
                                </div>
                                <label for="img_client" class="btn-edit-img disabled" id="fileSelect"> 
                                    <span id="img"><i class="fa-solid fa-pen-to-square"></i></span>
                                </label> 
                            </div>
                            <input type="file" id="fileElem" accept=".jpg">
                            <div class="field">
                                <input type="text" name="nombre" id="nombre">
                                <label for="nombre">Nombre completo</label>
                            </div>
                            <div class="field">
                                <input type="text" name="CURP" id="CURP">
                                <label for="CURP">CURP</label>
                            </div>
                            <span class="fena">Fecha de nacimiento</span>
                            <input type="date" name="fena" id="fena">
                        </section>
                        <section class="domicilio" id="content-domicilio">
                            <div class="field">
                                <input type="number" name="codPostal" id="codPostal">
                                <label for="codPostal">Código postal</label>
                            </div>
                            <div class="field">
                                <input type="text"   name="municipio" id="municipio" >
                                <label for="municipio">Municipio</label>
                            </div>
                            <div class="field">
                                <input type="text"   name="estado" id="estado" >
                                <label for="estado">Estado</label>
                            </div>
                            <div class="field">
                                <input type="text" name="domicilio" id="domicilio">
                                <label for="domicilio">Domicilio</label>
                            </div>
                        </section>
                        <section class="contacto" id="content-contacto">
                            <div class="field">
                                <input type="email" name="email" id="email">
                                <label for="email">Correo</label>
                            </div>
                        </section>
                        <div class="btn">
                            <div class="align-left">
                                <button type="button" id="previous" class="btn-previous d-n"><i class="fa-solid fa-circle-left"></i></button>
                            </div>
                            <div class="align-right-btn">
                                <button type="button" id="next"     class="btn-next"><i class="fa-solid fa-circle-right"></i></button>
                                <button type="button" id="btn-submit" class="d-n">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="../../public/js/nav.js"></script>
    <script src="../../public/js/alta.js"></script>
</body>
</html>