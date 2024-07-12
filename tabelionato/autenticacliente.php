<?php
    $sql = "select id, nome, cpf from cliente;";
    $conexao = new pdo ('sqlite:tab');
    $resultado = $conexao->query($sql)->fetchAll(2);
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
        <p>A identificação desta imagem no repositório de imagens é <?php print $_REQUEST['repositorioid']; ?>.</p>
        <p>Aqui você deve consumir o serviço web do sistema de respositório de imagens para recuperar a imagem correspondente a esta identificação e mostrá-la na tela.</p>
        <p>O usuário vai indicar abaixo a conformidade da assinatura ou não.</p>
        <?php
            $obj=['id'=> $_REQUEST['repositorioid']];
            $txt = json_encode($obj);
            $curl = curl_init('http://localhost:8082/saida.php');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $txt);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type:application/json']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $txt = curl_exec($curl);
            $obj = json_decode($txt, true);
            $conteudo = $obj['conteudo'];
        ?>
        <img width="200" src="data:image/png;base64,<?php print $conteudo; ?>"/>
        <p>
            <a href="erro.php">Falso</a>
            <a href="formularioarquivo.php?cliente=<?php print $_REQUEST['id']; ?>">Verdadeiro</a>
        </p>
        
    </body>
</html>