<?php
//require "header.php";
session_start();
if(isset($_SESSION['username']))
	$username = $_SESSION['username'];
if(isset($_SESSION['password']))
	$password = $_SESSION['password'];
if(!(empty($username) OR empty($password)))
{ 
	include "faseControle.php";
        include_once 'config.php';

	$idFase = $_REQUEST['idFase'];
        $idProjeto = $_REQUEST['idProjeto'];
	
	apagarFase($idFase, $idProjeto);
}else{
	echo "usuario não cadastrado, faça seu cadastro";
	echo "<a href= 'index.php'> Voltar </a>";
	}