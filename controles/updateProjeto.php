<?php

//require "header.php";
session_start();
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];
if (isset($_SESSION['password']))
    $password = $_SESSION['password'];
if (!(empty($username) OR empty($password))) {
    include 'config.php';
    include "faseControle.php";
    include "projetoControle.php";

    $nome = test_input($_REQUEST["nome"]);
    $descricao = test_input($_REQUEST["descricao"]);
    $inicio = test_input($_REQUEST["inicio"]);
    $fim = test_input($_REQUEST["fim"]);
    
    $idProjeto = mysqli_real_escape_string($conn, $_POST['idProjeto']);
    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $descricao = mysqli_real_escape_string($conn, $_POST["descricao"]);
    $inicio = mysqli_real_escape_string($conn, $_POST["inicio"]);
    $fim = mysqli_real_escape_string($conn, $_POST["fim"]);

    updateProjeto($idProjeto, $nome, $descricao, $inicio, $fim);
} else {
    echo "usuario não cadastrado, faça seu cadastro";
    echo "<a href= '../index.php'> Voltar </a>";
}
?>