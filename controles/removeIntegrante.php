<?php

//require "header.php";
session_start();
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];
if (isset($_SESSION['password']))
    $password = $_SESSION['password'];
if (!(empty($username) OR empty($password))) {
    include "timeControle.php";
    include_once 'config.php';

    $idUsuario = $_REQUEST['idUsuario'];
    $idProjeto = $_REQUEST['idProjeto'];
    $idPapel = $_REQUEST['idPapel'];

    if ($idPapel != 9) {
        foreach ($idUsuario as $idu) {
            removeIntegrante($idu, $idProjeto);
        }
    }
    header("Location:../projeto.php?idProjeto=$idProjeto");
} else {
    echo "usuario não cadastrado, faça seu cadastro";
    echo "<a href= 'index.php'> Voltar </a>";
}