<?php

    $txt = file_get_contents('php://input');
    $obj = json_decode( $txt, true );
    // [ "cpf" : "12345678910" ]
    $cpf = $obj['cpf'];
    include 'funcoes.php';
    $obj = [ "status" => "invalido" ];    
    if(valida_cpf($entrada)){
        $obj=["status" => "cpf"];
    }
    elseif(valida_cnpj($entrada)){
        $obj = ["status" => "cnpj"];
    }
    $txt = json_encode( $obj );
    print $txt;
    /*the kombucha mushroom people
    sitting around all day
    who can believe you
    who can believe you
    let your mother pray
    sugar
    */