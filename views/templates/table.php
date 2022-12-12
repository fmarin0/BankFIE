<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Amortización</title>
    <style>
        img {
            width: 150px;
            display:block;
            height: auto;
            margin:auto;
        }
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

    </style>
</head>
<body>
    <img src="<?php echo $this -> d['imagen']; ?>">
    <table>
        <thead>
            <tr>
                <td colspan="2">Préstamo Resultados</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pago Mensual</td>
                <td>$<?php echo $this -> d['pago'];?></td>
            </tr>
            <tr>
                <td>Cantidad del Préstamo</td>
                <td>$<?php echo $this -> d['cantidad'];?></td>
            </tr>
            <tr>
                <td>Tasa de interés</td>
                <td>7.5%</td>
            </tr>
            <tr>
                <td>Término</td>
                <td><?php echo $this -> d['termino'];?> Meses</td>
            </tr>
            <tr>
                <td>Total de los intereses pagados</td>
                <td>$<?php echo $this -> d['totalIntereses'];?></td>
            </tr>
            <tr>
                <td>Total de los pagos</td>
                <td>$<?php echo $this -> d['total'];?></td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <td>#</td>
                <td class="">Saldo Inicial</td>
                <td class="text-center">Cuota fija</td>
                <td class="text-center">Interes</td>
                <td class="text-center">Abono a capital</td>
                <td class="text-center">Saldo Final</td>
            </tr>
        </thead>
        <tbody>
            <?php echo $this -> d['tabla'];?>
        </tbody>
    </table>
</body>
</html>