<?php

/*talvez fazer insert? */    
//$documento = $_REQUEST['documento'];
    $txt = file_get_contents('php://input');
    //pega o conteúdo da requisição e coloca na variável txt
    $obj = json_decode($txt, true);
    //transforma a string em um objeto valido na linguagem php (true: vai ser decodificado como um vetor)
    $un = $obj['unidade'];
    //pega o indice unidade que veio da string obj
    $conexao = new pdo ('sqlite:bancodedados.dat');
    //conecta no banco de dados
    $sql = "insert into covidcases values (null, '$un', date('now'));";
    //executa esse comando no banco de dados
    $resultado = $conexao->exec($sql);
    //executa a inserção
    $obj = ['status' => $resultado];
    //monta a estrutura a ser retornada
    $txt = json_encode($obj);
    //codifica a estrutura de retorno como json
    print $txt;
    //dá retorno a requisição
    ?>