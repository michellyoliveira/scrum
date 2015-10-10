<?php
	include "missaoControle.php";
        include_once 'config.php';
        include "faseControle.php";
        
	$nome = test_input($_REQUEST["nome"]);
	$descricao = test_input($_REQUEST["descricao"]);
        $idFase = $_REQUEST['idFase'];
        
        $nome = mysqli_real_escape_string($conn, $_REQUEST["nome"]);
	$descricao = mysqli_real_escape_string($conn, $_REQUEST["descricao"]);

	//echo $idFase;
	criarMissao($nome, $descricao, $idFase);
	
?>

