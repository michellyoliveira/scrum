<?php

require "header.php";
session_start();
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];
if (isset($_SESSION['password']))
    $password = $_SESSION['password'];
if (!(empty($username) OR empty($password))) {
    include_once 'controles/usuarioControle.php';
    include 'controles/config.php';

    //$idUsuario = filter_input(INPUT_POST, 'idUsuario');
    $idUsuario = $_POST['idUsuario'];
    $idPapel = $_POST['idPapel'];

    foreach ($idUsuario as $idu) {

        $query = "UPDATE papel_sistema SET id_papel = $idPapel WHERE id_usuario = $idu";
        $result = mysqli_query($conn, $query);
        if ($result === TRUE) {           
            header('Location:administracao.php');
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
} else {
    echo "usuario não cadastrado, faça seu cadastro";
    echo "<a href= 'index.html'> Voltar </a>";
}


