<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Te coordena</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="../css/estilo.css" rel="stylesheet">

        <script src=".../js/jquery-2.1.1.min.js" type="text/javascript"></script> 
        <!--<script src="js/meuscript.js" type="text/javascript"></script>--> 
    </head>

    <body>
        <nav class="navbar navbar-fixed-top navbar-default" role="navigation">
            <div class="container ">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">TeCoordena</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="painel.php">Home</a></li>
                        <!-- <li><a href="#about">About</a></li>
                         <li><a href="#contact">Contact</a></li>-->
                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                        <!--        <li><a href="#">Link</a></li>-->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Gráficos</a></li>
                                <li><a href="#">Chat</a></li>
                                <li><a href="#">Configurações</a></li>
<!--                                <li class="divider"></li>
                                <li><a href="logout.php" id="sair">Sair</a></li>-->
                            </ul>
                        </li>
                        <li><a href="logout.php" id="sair">Sair</a></li>
                    </ul>

                </div><!-- /.nav-collapse -->

            </div><!-- /.container -->
        </nav><!-- /.navbar -->

        <div class="container painel-front">

            <div class="row row-offcanvas row-offcanvas-right">

                <div class="col-md-12 col-md-offset-*" >
<?php

//require "../header.php";
session_start();
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];
if (isset($_SESSION['password']))
    $password = $_SESSION['password'];
if (!(empty($username) OR empty($password))) {
    include_once 'timeControle.php';
    include 'config.php';

    $idPapel = $_POST['idPapel'];
    $idProjeto = $_POST['idProjeto'];
    $idUsuario = $_POST['idUsuario'];

    if (!empty($idUsuario)) {
        if ($idPapel == 2) {
            
            if (temLider($idProjeto) == 0) {
                
                $query = "UPDATE papel_projeto SET lider = 1 WHERE id_projeto = $idProjeto AND id_usuario = $idUsuario";
                $result = mysqli_query($conn, $query);
                if ($result === TRUE) {
                    header("Location:../projeto.php?idProjeto=$idProjeto");
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            } else{
                echo 'Este projeto já tem um líder <br>';
                echo "<a href= '../projeto.php?idProjeto= $idProjeto'> Voltar </a>";
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


