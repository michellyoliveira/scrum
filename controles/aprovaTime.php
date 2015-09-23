<?php

require "../header.php";
session_start();
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];
if (isset($_SESSION['password']))
    $password = $_SESSION['password'];
if (!(empty($username) OR empty($password))) {
    include_once 'usuarioControle.php';
    include 'config.php';

    //$idUsuario = filter_input(INPUT_POST, 'idUsuario');
    $idUsuario = $_POST['idUsuario'];
    $idPapel = $_POST['idPapel'];
    //$idPapel = 10;
    $idProjeto = $_POST['idProjeto'];


    print_r($idProjeto);
    print_r($idUsuario);
    //print_r($idPapel);
    //exit;
    if (!empty($idUsuario)) {
        if ($idPapel == 2) {
            $query = "UPDATE papel_projeto SET id_papel = $idPapel WHERE id_projeto = $idProjeto AND id_usuario = $idUsuario";
            $result = mysqli_query($conn, $query);
                if ($result === TRUE) {
                    header("Location:../projeto.php?idProjeto=$idProjeto");
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
        } else {
            foreach ($idUsuario as $idu) {
                
                $query = "INSERT INTO papel_projeto (id_usuario, id_papel, id_projeto) VALUES ($idu,$idPapel,$idProjeto)";
                $result = mysqli_query($conn, $query);
                if ($result === TRUE) {
                    header("Location:../projeto.php?idProjeto=$idProjeto");
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
        }
    }
} else {
    echo "usuario não cadastrado, faça seu cadastro";
    echo "<a href= 'index.php'> Voltar </a>";
}


