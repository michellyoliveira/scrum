<?php

//require "header.php";
session_start();
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];
if (isset($_SESSION['password']))
    $password = $_SESSION['password'];
if (!(empty($username) OR empty($password))) {
    include "projetoControle.php";
    include_once 'config.php';

    $idFase = $_REQUEST['idUsuario'];
    $idProjeto = $_REQUEST['idProjeto'];

    apagarProjeto($idProjeto, $idUsuario);
} else {
    echo "usuario não cadastrado, faça seu cadastro";
    echo "<a href= 'index.php'> Voltar </a>";
}