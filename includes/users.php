<?php 

    require 'db.php';
    $connect = new DB();
    global $connect;

    if(isset($_POST['eliminar'])){
        $data = '';

        try {
            $query = $connect -> connect() -> prepare("UPDATE clientes SET status = 'inactivo' WHERE id = :id");
            $query -> execute(['id' => $_POST['eliminar']]);

            $data = 'Borrado con exito';

        } catch (PDOException $e) {
            $data = $e;
        }

        die(json_encode($data));
    }

?>