<?php
	if ( !isset($_REQUEST['entidade']) ) {
		print 'Erro.';
		exit;
	}
	$sql = " select * from ".$_REQUEST['entidade']." limit 1; ";
	$conexao = new pdo ('sqlite:database');
	$conexao->exec("pragma foreign_keys = ON;");
	$meta = $conexao->query( $sql );
	$c = $meta->columnCount();
	$columns = [];
	$values = [];
	for ( $i = 0 ; $i < $c ; $i++ ) {
		if ( in_array ($meta->getColumnMeta($i)['name'], ['id'] ) ) {
			continue;
		}
		$columns[] = $meta->getColumnMeta($i)['name'];
		$values[] = $_REQUEST[$meta->getColumnMeta($i)['name']];
	}
	if(isset($_REQUEST['cpf'])){
		$curl = curl_init('http://localhost:8081/servico.php');
		//cria a requisição
		curl_setopt($curl, CURLOPT_POSTFIELDS, $txt);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type:application/json']);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$txt = curl_exec($curl);
		$obj=json_decode($txt, true);
		if($obj['status'!='cpf']){
			print 'cpf invalido';
			exit;
		}
	}
	if(isset($_REQUEST['cnpj'])){
		$curl = curl_init('http://localhost:8081/servico.php');
		//cria a requisição
		curl_setopt($curl, CURLOPT_POSTFIELDS, $txt);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type:application/json']);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$txt = curl_exec($curl);
		$obj=json_decode($txt, true);
		if($obj['status'!='cnpj']){
			print 'cnpj invalido';
			exit;
		}
		
	}
	$sql = " insert into ".$_REQUEST['entidade']." (".implode(", ", $columns).") values ('".implode("', '", $values)."'); ";
	$resultado = $conexao->exec($sql);
	if ( $resultado == 0 ) {
		print 'Erro.';
		exit;
	}
	unset($conexao);
	header('Location: lista.php?entidade='.$_REQUEST['entidade'].'&rotulo='.$_REQUEST['rotulo'].(isset($_REQUEST['view']) ? '&view' : ''));