<?php
    require 'db.php';
    $connect = new DB();
    global $connect;
    session_start();


    function getClients(){
        global $connect;
        $key=setNumClient();
        $data = '';
        
        if ($key !== NULL) {
            try {
                $query = $connect -> connect() -> prepare("SELECT * FROM clientes WHERE NoCuenta LIKE '" . $key ."%' ORDER BY status");
                $query -> execute();
                $clients = $query -> fetchAll(PDO::FETCH_OBJ);
                $data = '';
                
                
                foreach ($clients as $client) {
                    if ($_SESSION['user'] !== $client -> id) {
                        if ($client -> status === 'inactivo') {
                            $data .= '
                                     <tr>
                                        <td>'. $client -> id    .'</td>
                                        <td>'. $client -> name  .'</td>
                                        <td><span class="'.$client -> status.'"><i class="fa-solid fa-circle"></i></span></td>
                                        <td class="text-center">--</td>
                                        <td class="text-center">--</td>
                                        <td class="text-center">--</td>
                                    </tr>';
                        } else {

                            $data .= '
                                    <tr>
                                        <td>'. $client -> id    .'</td>
                                        <td>'. $client -> name  .'</td>
                                        <td><span class="'.$client -> status.'"><i class="fa-solid fa-circle"></i></span></td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="ver" value="'.$client -> id .'">
                                                <button type="submit" class="ver"><i class="fa-light fa-eye"></i></button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="editar" value="'.$client -> id .'">
                                                <button type="submit" class="editar"><i class="fa-light fa-user-pen"></i></button>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" id="FormEliminar'.$client -> id .'">
                                                <input  type="hidden" name="eliminar" value="'.$client -> id .'">
                                                <button type="button" class="eliminar" onclick="Eliminar('.$client -> id .')"><i class="fa-light fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>';        
                        }
                    }
                }

                return $data;
            } catch (PDOException $e) {
                return $e;
            }
        }
    }

    function setNumClient(){
        global $connect;
        try {
            $query = $connect -> connect() -> prepare('SELECT num_client FROM users WHERE id = :id');
            $query -> execute(['id' => $_SESSION['user']]);

            if ($query -> rowCount() == 1) {
                $client = $query -> fetch(PDO::FETCH_ASSOC);

                return $client['num_client'][0];
            }

            return NULL;

        } catch (PDOException $e) {
            echo $e;
            return NULL;
        }
    }

    echo json_encode(getClients());
    
?>