<?php require_once './includes/login.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./public/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./public/css/login.css">
    <title>Inicio de sesión</title>
</head>
<body>
<section>
        <div class="color"></div>
        <div class="color"></div>
        <div class="color"></div>
        <div class="box">
            <div class="fondo" style="--i:0;"></div>
            <div class="fondo" style="--i:1;"></div>
            <div class="fondo" style="--i:2;"></div>
            <div class="fondo" style="--i:3;"></div>
            <div class="fondo" style="--i:4;"></div>
            <div class="fondo" style="--i:5;"></div>
            <div class="contenedor">
                <div class="formulario">
                    <?php
                        if(count($array)>0){
                            echo '<p class="massageError"> '. $array[0] .' </p>';
                        } 
                    ?>
                    <h2>Iniciar Sesión</h2>
                    <form action="" method="POST">
                        <div class="input">
                            <input type="text" name="email" placeholder="Correo Electrónico" id="email">
                        </div>
                        <div class="input">
                            <input type="password" name="password" placeholder="Contraseña" id="password">
                        </div>
                        <div class="input">
                            <input type="submit" value="Iniciar Sesión" id="send" >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<script src="./public/js/login.js"></script>
</body>
</html>