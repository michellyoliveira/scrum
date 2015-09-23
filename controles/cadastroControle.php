<?php

function selecionaUsername($username) {
    include_once 'config.php';

    $query = "SELECT username FROM usuario WHERE username = '$username'";
    $result = mysql_query($query, $link);
    $row = mysql_fetch_assoc($result);

    return ($row['username']);
}

function selecionaIdUsuario($username) {
    include_once 'config.php';

    $query = "SELECT id_usuario FROM usuario WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    return ($row['id_usuario']);
}

function usuarioJaCadastrado($username) {
    include_once 'config.php';
    $query = "SELECT username FROM usuario WHERE username = '$username'";
    $result = mysql_query($query, $link);
    $rows = mysql_num_rows($result);

    if ($rows != 0) {
        return true;
    } else {
        return false;
    }
}

function insereUsuario($username, $password, $nome) {
    include 'controles/config.php';
    $sql = "INSERT INTO usuario (username, password, nome) VALUES ('$username','$password','$nome')";
    //$result = mysqli_query($conn, $sql); 
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    //return $result;
}

function inserePapelSistema($idUsuario, $idPapel) {
    include_once 'config.php';
    $insere = "INSERT INTO papel_sistema (id_usuario, id_papel) VALUES ('$idUsuario','$idPapel')";
    $res = mysql_query($insere, $link);

    return $res;
}
