<?php

/*talvez fazer insert? */    
//$documento = $_REQUEST['documento'];
    $txt = file_get_contents('php://input');
    //pega o conteúdo da requisição e coloca na variável txt
    $obj = json_decode($txt, true);
    //transforma a string em um objeto valido na linguagem php (true: vai ser decodificado como um vetor)
    $anvisa = $obj['anvisa'];
    $cpf = $obj['cpf'];
    //pega o indice unidade que veio da string obj
    $conexao = new pdo ('sqlite:banco.sqlite');
    //conecta no banco de dados
    $sql = "select p.id, v.produto
    from produto p
    join venda v
        on v.produto = p.id
    join cliente c
        on c.id = v.cliente
    where p.anvisa = '$anvisa'
    and c.cpf = '$cpf';";
    //executa esse comando no banco de dados
    $resultado = $conexao->query($sql)->fetchAll();
    //executa a inserção
    if(count($resultado)==0){
        $obj = ['status'=>"sem desconto"];
    }
    else{
        $obj = ['status'=>"com desconto"];
    }
    //monta a estrutura a ser retornada
    $txt = json_encode($obj);
    //codifica a estrutura de retorno como json
    print $txt;
    //dá retorno a requisição
    ?>