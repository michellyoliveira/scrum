<?php

function criarTime($idProjeto, $idUsuario) {
    include "config.php";

    $insere = "INSERT INTO time (id_projeto, id_usuario) VALUES ('$idProjeto','$idUsuarioA')";

    // Executa consulta
    $result = mysql_query($insere, $link);
    // Mensagem caso a consulta falhe.
    if ($result === false) {
        echo "Não foi possível inserir os dados" . mysql_error() . "<br />";
    } else {
        echo "dados inserido com sucesso!";
        header("Location: Projeto.php?idProjeto=$idProjeto");
    }
    $libera = mysqli_free_result($result);
}

function updateTime($idProjeto, $idUsuario) {
    include "config.php";
    $altera = "UPDATE time
              SET id_usuario='$idUsuario'
              WHERE id_projeto='$idProjeto'";
    // Executa consulta
    $result = mysql_query($altera, $link);
    // Mensagem caso a consulta falhe.
    if ($result === false) {
        echo "Não foi possível alterar os dados" . mysql_error() . "<br />";
    } else {
        echo "dados alterados com sucesso!";
        header("Location: Projeto.php?idProjeto=$idProjeto");
    }
    $libera = mysqli_free_result($result);
}

function bancoSelect($name, $idForm, $idProjeto) {
    include "controles/config.php";
    $query = "SELECT DISTINCT tabela1.id_usuario, tabela1.username
    FROM 
    (SELECT usuario.id_usuario, usuario.username FROM papel_projeto
    RIGHT JOIN usuario ON papel_projeto.id_usuario = usuario.id_usuario
    WHERE papel_projeto.id_usuario is NULL 
    OR papel_projeto.id_projeto <> $idProjeto) AS tabela1
    INNER JOIN
    (SELECT papel_sistema.id_usuario FROM papel_sistema 
    WHERE papel_sistema.id_papel NOT IN (5,7,8)) AS tabela2
    WHERE tabela2.id_usuario = tabela1.id_usuario
    GROUP BY tabela1.id_usuario ";
    //echo $query;
    $result = mysqli_query($conn, $query);
    $linha = mysqli_num_rows($result);
    if ($linha > 0) {
        echo '<select name="' . $name . '" form="' . $idForm . '"  multiple="multiple">';
        //echo ' <option value="Selecione">Selecione</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo ' <option value="' . $row['id_usuario'] . '">' . $row['username'] . '</option>';
        }
        echo '</select><br><br>';
    } else {
        echo "nenhum usuario cadastrado";
    }
    //$libera = mysqli_free_result($result);
}

function timeSelect($name, $idForm, $idProjeto) {
    //echo $idProjeto;

    include "config.php";
    $query = "SELECT u.username, u.id_usuario
            FROM usuario AS u
            LEFT JOIN papel_projeto AS pp ON pp.id_usuario = u.id_usuario
            WHERE pp.id_projeto = $idProjeto";

    $result = mysqli_query($conn, $query);
    $linha = mysqli_num_rows($result);
    if ($linha > 0) {
        echo '<select name="' . $name . '" form="' . $idForm . '"  multiple="multiple">';
        //echo ' <option value="Selecione">Selecione</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo ' <option value="' . $row['id_usuario'] . '">' . $row['username'] . '</option>';
        }
        echo '</select><br><br>';
    } else {
        echo "nenhum usuario cadastrado";
    }
}

function liderSelect($name, $idForm, $idProjeto) {
    include "config.php";
    $query = "SELECT u.username, u.id_usuario
            FROM usuario AS u
            LEFT JOIN papel_projeto AS pp ON pp.id_usuario = u.id_usuario
            WHERE pp.id_projeto = $idProjeto";

    $result = mysqli_query($conn, $query);
    $numlinha = mysqli_num_rows($result);
    if ($numlinha > 0) {
        echo '<select name="' . $name . '" form="' . $idForm . '" >';
        //echo ' <option value="Selecione">Selecione</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo ' <option value="' . $row['id_usuario'] . '">' . $row['username'] . '</option>';
        }
        echo '</select><br><br>';
        //$libera = mysqli_free_result($result);
    } else {
        echo "nenhum usuario cadastrado";
    }
}

function listaTime($idProjeto) {

    include "config.php";
    $username = array();
    $query = "SELECT u.username, u.id_usuario, pp.id_papel, pp.lider
            FROM usuario AS u
            INNER JOIN papel_projeto AS pp
            WHERE pp.id_projeto = $idProjeto
            AND (u.id_usuario = pp.id_usuario) ORDER BY u.username ASC";

    $result = mysqli_query($conn, $query);
    $numlinha = mysqli_num_rows($result);
    if ($numlinha == FALSE) {
        echo 'Este time ainda não tem nenhum membro';
    } else {
        if ($numlinha > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $time[] = $row;
            }
            return $time;
        } else {
            echo 'Você não tem nenhum time cadastrado';
            return;
        }
        $libera = mysqli_free_result($result);
    }
}

function removeIntegrante($idUsuario, $idProjeto) {
    include "config.php";

    $query = "DELETE FROM papel_projeto WHERE id_projeto= $idProjeto AND id_usuario = $idUsuario";
    // Executa consulta
    $result = mysqli_query($conn, $query);
    if ($result === false) {
        echo "Não foi possível apagar os dados" . mysql_error() . "<br />";
    } else {
        //echo "dados apagados com sucesso!";
        header("Location: ../projeto.php?idProjeto=$idProjeto");
    }
}


function verLider($idProjeto) {
    include "config.php";
    $query = "SELECT u.username, u.id_usuario
            FROM usuario AS u
            LEFT JOIN papel_projeto AS pp ON pp.id_usuario = u.id_usuario
            WHERE pp.id_projeto = $idProjeto AND pp.lider = 1";
    $result = mysqli_query($conn, $query);
    $numlinha = mysqli_num_rows($result);

    if ($numlinha == FALSE) {
        echo 'Time sem l&iacute;der';
    } else {
        if ($numlinha > 0) {

            $row = mysqli_fetch_assoc($result);
            return $row;
        } else {
            echo 'Você não tem l&iacute;der eleito';
            return;
        }
        $libera = mysqli_free_result($result);
    }
}

function removeLider($idProjeto, $idUsuario) {
    include "config.php";
    $query = "UPDATE papel_projeto SET lider = 0 WHERE id_projeto = $idProjeto AND id_usuario = $idUsuario";
    $result = mysqli_query($conn, $query);
    if ($result === TRUE) {
        header("Location:../projeto.php?idProjeto=$idProjeto");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

function temLider($idProjeto){
    include "config.php";
    $query = "SELECT lider FROM papel_projeto
        WHERE id_projeto = $idProjeto AND lider = 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_num_rows($result);
    if ($row == FALSE) {
        return 0;
    } else {
        return $row;
    }
    
}