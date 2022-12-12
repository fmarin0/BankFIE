<?php
    require 'loanModel.php';

    if (isset($_POST['ver'])) {
        $loan = new LoanModel();
        $data = $loan -> getDesglose($_POST['ver']);

        die(json_encode($data));
    }
    
?>