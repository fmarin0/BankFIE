<?php

    require 'db.php';
    $conexion = new DB();
    global $conexion;

    session_start();

    if (!isset($_SESSION['user'])) { header('Location: http://bankfie.com');}

    $consulta = $conexion -> connect() -> prepare('SELECT * FROM users WHERE id = :id');
    $consulta -> execute(['id' => $_SESSION['user']]);
    $respueta = $consulta -> fetch(PDO::FETCH_ASSOC);

    $usuario = null;

    if (count($respueta) > 0) {$usuario = $respueta;}

?>