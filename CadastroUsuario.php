<?php

//inclui a conexão com o banco
include_once "header.php";

include_once 'controles/config.php';
include_once 'controles/cadastroControle.php';

//recebe os dados
//$nome = $_POST["nome"];
//$username = $_POST["username"];
//$password = md5($_POST["password"]);
//$idPapel = $_POST["papel"];

$nome = mysqli_real_escape_string($conn, $_REQUEST["nome"]);
$username = mysqli_real_escape_string($conn, $_REQUEST["username"]);
$pass = mysqli_real_escape_string($conn, $_REQUEST["password"]);
$password = md5($pass);
$idPapel = $_POST["papel"];

if (strstr($password, ' ') != false) {
    echo "A senha não pode conter espaços em branco <br />";
    echo "<a href= 'index.html'> Voltar </a>";
} else {
    // Faz a inserção dos dados////////////////////////////////////////////////////////////////////
    //verifica se o username já esta cadastrado

    if (usuarioJaCadastrado($username) == TRUE) {
        echo "<h3>Usuario já existe, volte e escolha outro username  </h3><br />"; // . mysql_error()."
    } else {

        $sql = "INSERT INTO usuario (username, password, nome) VALUES ('$username','$password','$nome')";
        //$result = mysqli_query($conn, $sql);
        if (mysqli_query($conn, $sql)) {
           // echo "New record created successfully";

            $query = "SELECT id_usuario FROM usuario WHERE username LIKE '$username'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $idUsuario = $row['id_usuario'];
            
//            echo $idUsuario;
//            exit;           

            $inserePapel = "INSERT INTO papel_sistema (id_usuario, id_papel) VALUES ('$idUsuario','$idPapel')";
            $res = mysqli_query($conn, $inserePapel);
            if ($res == true) {
                echo 'Dados inseridos com sucesso! <br>';
                echo 'Cadastro sujeito a aprovação, por favor agurade a liberação do seu acesso.';
               
            } else {
                echo "Não foi possível inserir papel os dados";
                echo "<a href= 'index.php'> Voltar </a>";
            }
        } else {
            echo "Não foi possível inserir o usuario os dados";
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        $libera = mysqli_free_result($result);
       // $libera = mysqli_free_result($inserePapel);
        //$libera = mysqli_free_result($res);
    }

    echo "<a href= 'index.php'> Voltar </a>";

    // $libera = mysql_free_result($resultado);
}
include_once 'footer.php';
