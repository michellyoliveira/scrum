<?php

//inclui o cabeçalho
include_once "header.php";

//inclui a conexão com o banco
require_once 'controles/config.php';

//recebe os dados
$username = mysqli_real_escape_string($conn, $_REQUEST["username"]);
$pass = mysqli_real_escape_string($conn, $_REQUEST["password"]);
$password = md5($pass);

// Faz a selecao dos dados do usuario com o papel no sistema//////////////////////////////////////////////
$query = "SELECT u.*, ps.id_papel FROM usuario AS u "
        . "JOIN papel_sistema AS ps ON u.id_usuario = ps.id_usuario "
        . "WHERE u.username LIKE '$username'";

// Executa consulta
$result = mysqli_query($conn, $query);
$rows = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

// Mensagem caso nao encontre registro.
if ($rows == 0) {
    echo "<h2>Usuario nao encontrado  </h2><br />"; // . mysqli_error()."
} else if ($password != $row['password']) {
    echo " <br /><h2>Senha incorreta</h2> <br />";
} else {
    // usuario senha corretos
    //redireciona para as páginas
    if ($rows > 0) {
       // echo 'linha maior que zeri<br>';
        $idUsuario = $row['id_usuario'];
        $username = $row['username'];
        $idPapel = $row['id_papel'];
        $password = $row['password'];
        
        session_start();
        $_SESSION['idUsuario'] = $row['id_usuario'];
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['idPapel'] = $idPapel;

        switch ($idPapel) {
            case 1:
                header('Location:painel.php');
                //$titulo = "aluno";
                break;
            case 2:
                header('Location:painel.php');
                //$titulo = "lider";
                break;
            case 3:
                header('Location:painel.php');
                //$titulo = "professor";
                break;
            case 4:
                header('Location:painel.php');
                //$titulo = "criador";
                break;
            case 5:
                header('Location:administracao.php');
                //$titulo = "administrador";
                break;
            default:
                echo 'Você precisa de permissão para acessar esta página';
                //$titulo = "usuario";
        }
    } else {
        echo 'não encontrou nada';
    }

    //header("Location: painel.php");
}


echo "<a href= 'index.php'> Voltar </a>";
$libera = mysqli_free_result($result);
include_once 'footer.php';
?>