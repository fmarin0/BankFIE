<?php $user = $this -> d['data']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado De Cuenta</title>
    <style>
        thead td {
            background-color: #384524;
            color: #fff;
        }

        table {
            width: 100%;
            margin-top: 15px;
            margin-bottom: 15px;
	        border-width: 1px;
	        border-spacing: 0px;
	        border-style: solid;
	        border-collapse: separate;
            background-color: #fff;   
        }

        tr, td {
            border-width: 1px;
            padding: 5px;
            border-style: solid;
            border-color: black;
            background-color: #fff;
        }

        .content {
  width: 100%;
  height: 100%;
  display: grid;
  padding: 0;
  grid-template-columns: repeat(5, 1fr);
  grid-area: repeat(4, 1fr);
  grid-template-areas: "header header header header header" "body body body body body" "body body body body body" "footer footer footer footer footer"; }
  .content header {
    grid-area: header;
    display: flex;
    justify-content: center; }
    .content header img {
      width: 120px;
      height: auto; }
  .content section {
    grid-area: body;
    display: grid;
    justify-content: center; }

      img {
            width: 150px;
            display:block;
            height: auto;
            margin:auto;
        }

        span {
            font-size: small;
        }
        .let span {
    text-transform: lowercase;
}

.let span:first-letter {
    text-transform: uppercase;
}
    
    </style>
</head>
<body>
    <div class="content">
        <header>
           <img src="<?php echo $this -> d['logo'];?>" alt="Logo BankFIE">
        </header>
        <section>
            <p> Número de cuenta:   <?php echo $user['NoCuenta'];               ?></p>
            <p><?php echo $user['name'];                                          ?><br>
            <?php echo $user['domicilio'];                                     ?><br>
            <?php echo $user['estado']; ?> C.P. <?php echo $user['codPostal']; ?> </p>
            <table>
                <thead>
                    <tr>
                        <td colspan="2" ><h3>Resumen <span>(Pesos MXN)</span></h3></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Saldo actual:</td>
                        <td>$<?php echo $user['saldo']; ?></td>
                    </tr>
                    <tr> 
                        <td>Depositos: </td>
                        <td>$<?php echo $user['transferencias']; ?></td>
                    </tr>
                    <tr>
                        <td>Retiros: </td>
                        <td>$<?php echo $user['retiros']; ?></td>
                    </tr>
                </tbody>
            </table>
            
            <table>   
                <thead>
                    <tr>
                        <td  colspan="6"><h3>Detalles de operación <span>(Pesos MXN)</span></h3></td>
                    </tr>
                    <tr>
                        <td style="background-color: #6c8546;">Fecha        </td>
                        <td style="background-color: #6c8546;">Concepto     </td>
                        <td style="background-color: #6c8546;">Retiros      </td>
                        <td style="background-color: #6c8546;">Depositos    </td>
                        <td style="background-color: #6c8546;">Otro         </td>
                        <td style="background-color: #6c8546;">Saldo        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $user['movimientos']; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>