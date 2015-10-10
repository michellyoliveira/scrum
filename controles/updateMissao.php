<?php
require "../header.php";
session_start();
if(isset($_SESSION['username']))
	$username = $_SESSION['username'];
if(isset($_SESSION['password']))
	$password = $_SESSION['password'];
if(!(empty($username) OR empty($password)))
{ 
    include "faseControle.php";
    include "missaoControle.php";
    include "config.php";

    $idMissao = mysqli_real_escape_string($conn,$_REQUEST['idMissao']);
    $idFase = mysqli_real_escape_string($conn,$_REQUEST['idFase']);
    $nome = test_input($_REQUEST["nome"]);
    $descricao = test_input($_REQUEST["descricao"]);

    $nome = mysqli_real_escape_string($conn, $_REQUEST["nome"]);
    $descricao = mysqli_real_escape_string($conn, $_REQUEST["descricao"]);
//    $inicio = mysqli_real_escape_string($conn, $_REQUEST["inicio"]);
//    $fim = mysqli_real_escape_string($conn, $_REQUEST["fim"]);

    updateMissao($idFase, $nome, $descricao, $idMissao);
	
}else{
	echo "usuario não cadastrado, faça seu cadastro";
	echo "<a href= 'index.php'> Voltar </a>";
	}