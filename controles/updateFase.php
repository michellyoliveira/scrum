<?php

//require "header.php";
session_start();
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];
if (isset($_SESSION['password']))
    $password = $_SESSION['password'];
if (!(empty($username) OR empty($password))) {
    include "faseControle.php";
    include_once 'config.php';

    $idFase = $_REQUEST['idFase'];
    $idProjeto = $_REQUEST['idProjeto'];

    $nome = test_input($_REQUEST["nome"]);
    $descricao = test_input($_REQUEST["descricao"]);
    $inicio = test_input($_REQUEST["inicio"]);
    $fim = test_input($_REQUEST["fim"]);

    $nome = mysqli_real_escape_string($conn, $_REQUEST["nome"]);
    $descricao = mysqli_real_escape_string($conn, $_REQUEST["descricao"]);
    $inicio = mysqli_real_escape_string($conn, $_REQUEST["inicio"]);
    $fim = mysqli_real_escape_string($conn, $_REQUEST["fim"]);

    $data = verificaData($idProjeto);
    if (is_array($data) || is_object($data)) {
//             print_r($data['inicio']) ;
//             exit;
        $dIniProjeto = DateTime::createFromFormat('Y-m-d', $data['inicio']);
        $dFimProjeto = DateTime::createFromFormat('Y-m-d', $data['fim']);

        $dIniFase = DateTime::createFromFormat('Y-m-d', $inicio);
        $dFinalFase = DateTime::createFromFormat('Y-m-d', $fim);

//        print_r($data['inicio']);
//        print_r($data['fim']);
//       // print_r($data);
//        print_r($inicio);
//        print_r($fim);
//        print_r($dFinalFase -> format('Y-m-d'));
//        print_r($dIniFase-> format('Y-m-d')) ;
//        print_r($dIniProjeto-> format('Y-m-d'));
//        print_r($dFimProjeto-> format('Y-m-d'));
//        exit();
        
        
        if (($dIniFase-> format('Y-m-d')) < ($dIniProjeto-> format('Y-m-d'))) {
           echo  '<script> alert("Data inicial da fase anterior que data inicial do projeto")</script>';
            header("Location: ../projeto.php?idProjeto=$idProjeto");
        } else if (($dFinalFase-> format('Y-m-d')) > ($dFimProjeto-> format('Y-m-d'))) {
           echo "<script> alert('Data final da fase posterior a data final do projeto')</script>";
            header("Location: ../projeto.php?idProjeto=$idProjeto");
        } else if (($dIniFase-> format('Y-m-d')) > ($dFinalFase-> format('Y-m-d'))) {
           echo " Data final da fase menor que a data inicial da fase";
           exit();
            header("Location: ../projeto.php?idProjeto=$idProjeto");
        } else {
            updateFase($idFase, $nome, $descricao, $inicio, $fim, $idProjeto);
        }
    }
} else {
    echo "usuario não cadastrado, faça seu cadastro";
    echo "<a href='../index.php'> Voltar </a>";
}