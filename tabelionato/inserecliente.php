<?php

   var_dump($_FILES);
    $caminho = $_FILES['assinatura']['tmp_name'];
    $original = file_get_contents($caminho);
    $codificado = base64_encode($original);
    
    $obj = ['conteudo' => $codificado];
    $txt = json_encode($obj);
    $curl = curl_init('http://localhost:8082/entrada.php');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $txt);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type:application/json']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $txt = curl_exec($curl);
    $obj = json_decode($txt, true);
    $assinatura = $obj['id'];

    $nome = $_REQUEST['nome'];
    $cpf = $_REQUEST['cpf'];
    $sql = "insert into cliente values (null, '$nome', '$cpf', '$assinatura'); ";
    $conexao = new pdo('sqlite:tab');
    $resultado = $conexao->exec($sql);
    unset($conexao);
?>
<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="tabelionato.css" />
    </head>
    <body>
        <p>
            <a href="listacliente.php">Cliente</a>
        </p>
        <?php if ( $resultado > 0 ) { ?>
            <p>Cliente inserido com sucesso.</p>
        <?php } else { ?>
            <p>Não foi possível inserir o cliente. Tente novamente.</p>
        <?php } ?>
    </body>
</html>