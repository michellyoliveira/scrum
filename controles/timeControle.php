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

//function listaUserSelect($name, $idForm) {
//    include "config.php";
//    $query = "SELECT * FROM usuario"; //sprintf("SELECT * FROM info")
//    $result = mysqli_query($conn, $query);
//    if ($result === false) {
//        echo "Não foi possível buscar os dados" . mysql_error() . "<br />";
//    } else {
//        $numlinha = mysqli_num_rows($result);
//        if ($numlinha > 0) {
//            echo '<select name="'.$name.'" form="'.$idForm.'" >';
//            echo ' <option value="">Selecione</option>';
//            while ($row = mysql_fetch_assoc($result)) {
//                echo ' <option value="'.$row['id_usuario']. '">'. $row['username'].'</option>';
//            }
//            echo '</select><br />';    
//        } else {
//            echo "nenhum usuario cadastrado";
//        }
//    }
//    $libera = mysqli_free_result($result);
//}

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
    $query = "SELECT DISTINCT tabela1.id_usuario, tabela1.nome
    FROM 
    (SELECT usuario.id_usuario, usuario.nome FROM papel_projeto
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
            echo ' <option value="' . $row['id_usuario'] . '">' . $row['nome'] . '</option>';
        }
        echo '</select><br />';
    } else {
        echo "nenhum usuario cadastrado";
    }
     $libera = mysqli_free_result($result);
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
        echo '</select><br />';
    } else {
        echo "nenhum usuario cadastrado";
    }
}

function listaTime($idProjeto) {
    
    include "config.php";
    $username = array();
    $query = "SELECT u.username, u.id_usuario
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
            echo 'Você não tem nenhuma fase cadastrada';
            return;
        }
        $libera = mysql_free_result($result);
    }
}

//function listaTime($idProjeto) {
//    
//    include "config.php";
//    $username = array();
//    $query = "SELECT u.username, u.id_usuario, pp.id_projeto
//            FROM usuario AS u
//            INNER JOIN papel_projeto AS pp
//            WHERE pp.id_projeto = $idProjeto
//            AND (u.id_usuario = pp.id_usuario)";
//
//    $result = mysqli_query($conn, $query);
//    $numlinha = mysqli_num_rows($result);
//    if ($numlinha == FALSE) {
//        echo 'Este time ainda não tem nenhum membro';
//    } else {
//        if ($numlinha > 0) {
//            while ($row = mysql_fetch_assoc($result)) {
//                $username = $row['username'];
//                $idProjeto = $row['id_projeto'];
//                $idUsuario = $row['id_usuario'];
//
//                echo '<div class="row">	';
//                echo '<div id="dadosForm" class="col-md-12 control-label" >';
//                echo '<form id="formListaTime" class="form-horizontal" role="form" action="UpdateDadosTime.php" method="post"> ';
//
//                echo '<label for="Nome" class="col-md-6 control-label  pull-left">' . $username . '</label>';
//
//                echo '<input type="hidden" id="idUsuario" name="idUsuario" value="' . $idUsuario . '" /> ';
//                echo '<input type="hidden" id="idProjeto" name="idProjeto" value="' . $idProjeto . '" /> ';
//                echo '<label class="col-md-3 control-label"><button type="submit" class="btn btn-primary pull-left" '
//                . 'id="mudarMembro">Modificar</button></label>';
//                echo '<label class="col-md-3 control-label">'
//                . '<a class="btn btn-danger" href="ApagarTime.php?idProjeto=' . $idProjeto . '" '
//                . 'role="button" id="botaoApagar" >Remover</a></label>';
//                echo ' 
//                </form>
//            </div><!-- dadosForm-->   
//        </div><!-- row -->';
//            }
//            $libera = mysqli_free_result($result);
//        } else {
//            echo 'Este projeto ainda não tem nenhum membro';
//        }
//    }
//}

function verificaProjetoTemTime($idProjeto) {
    include "config.php";
    $query = "SELECT id_projeto FROM time WHERE id_projeto = '$idProjeto'"; //sprintf("SELECT * FROM info")
    $result = mysqli_query($conn, $query);
    if ($result === false) {
        echo "Não foi possível buscar os dados" . mysql_error() . "<br />";
    } else {
        $numlinha = mysqli_num_rows($result);
        if ($numlinha > 0) {
            ?>
            <script>
                window.alert("Este projeto já tem time. ");
            </script>
            <?php

            //header("Location: Projeto.php?idProjeto=$idProjeto");
        }
        //else {
//            //caso não tenha nenhum time cadastrado, cria o time
//              //criarTime($idProjeto, $idUsuario);
//        }
    }
    $libera = mysqli_free_result($result);
}

function listaTimeSelect($idProjeto, $name, $idForm) {
    include "config.php";
    $username = array();
    $query = "SELECT usuario.username, usuario.id_usuario, time.id_projeto
                FROM usuario
                INNER JOIN time
                WHERE time.id_projeto = '$idProjeto'";
//                AND (time.integranteUm = usuario.id_usuario 
//                     OR time.integranteDois = usuario.id_usuario 
//                     OR time.integranteTres = usuario.id_usuario 
//                     OR time.integranteQuatro = usuario.id_usuario)";

    $result = mysqli_query($conn, $query);
    $numlinha = mysqli_num_rows($result);

    if ($numlinha > 0) {
        
    }
}
