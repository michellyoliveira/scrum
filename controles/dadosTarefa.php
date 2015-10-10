<?php
include "tarefaControle.php";

        $idMissao = $_POST['idMissao'];
	
        $responsavel = test_input($_REQUEST["responsavel"]);        
        $nome = test_input($_REQUEST["nome"]);
	$descricao = test_input($_REQUEST["descricao"]);
	$inicio = test_input($_REQUEST["inicio"]);
	$fim = test_input($_REQUEST["fim"]);
        
        $responsavel = mysqli_real_escape_string($conn, $_REQUEST["responsavel"]);
        $nome = mysqli_real_escape_string($conn, $_REQUEST["nome"]);
	$descricao = mysqli_real_escape_string($conn, $_REQUEST["descricao"]);
	$inicio = mysqli_real_escape_string($conn, $_REQUEST["inicio"]);
	$fim = mysqli_real_escape_string($conn, $_REQUEST["fim"]);
        
	echo $idMissao;
        echo $nome;
        echo $fim;
	
        criarTarefa($nome, $descricao, $inicio, $fim, $idMissao,$responsavel);

