<?php
require "header.php";
session_start();
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];
if (isset($_SESSION['idUsuario']))
    $idUsuario = $_SESSION['idUsuario'];
if (isset($_SESSION['idPapel']))    
    $idPapel = $_SESSION['idPapel'];
    echo 'id_usuario->' .$idUsuario;
    echo '<br>id_papel='.$idPapel;
    echo '<br>username = ' .$username;
if (isset($_SESSION['password']))
    $password = $_SESSION['password'];
if (!(empty($idUsuario) OR empty($password))) {
    
    include_once "controles/config.php";
    require_once "controles/projetoControle.php";
	
	$nome = mysqli_real_escape_string($conn, $_REQUEST["nome"]);
	$descricao = mysqli_real_escape_string($conn, $_REQUEST["descricao"]);
	$inicio = mysqli_real_escape_string($conn, $_REQUEST["inicio"]);
	$fim = mysqli_real_escape_string($conn, $_REQUEST["fim"]);

	criarProjeto($nome, $descricao, $inicio, $fim, $idUsuario, $idPapel);	
	
}else{
	echo "usuario não cadastrado, faça seu cadastro";
	echo "<a href= 'index.html'> Voltar </a>";
	}
