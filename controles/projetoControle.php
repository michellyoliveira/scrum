<?php

//variável global que guarda o id_projeto;
//$idProjeto , $username;

function listaProjetos($idUsuario) {
    include "config.php";

    $query = "SELECT p.*
            FROM projeto AS p
            LEFT JOIN papel_projeto AS pap
            ON p.id_projeto = pap.id_projeto
            WHERE pap.id_usuario = $idUsuario AND pap.id_papel = 9";
    
    // Executa consulta
    $result = mysqli_query($conn, $query);

    $numlinha = mysqli_num_rows($result);
    if ($numlinha == FALSE) {
        echo 'Você não tem nenhum projeto cadastrado';
    } else {
    if ($numlinha > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $projeto[] = $row;  
        }
        return $projeto;

    } else {

        echo 'Você não possui nenhum projeto de dua autoria.';
        return;
    }
    $libera = mysqli_free_result($result);
}
}
function listaProjetosFacoParte($idUsuario){
    include 'config.php';
   
  $query = " SELECT p.id_projeto, p.nome
            FROM projeto AS p
            LEFT JOIN papel_projeto AS pap
            ON pap.id_projeto = p.id_projeto
            WHERE pap.id_usuario = $idUsuario AND pap.id_papel = 10 ";
  //echo $query . '<br>';
  
    $result = mysqli_query($conn,$query);
    $numlinha = mysqli_num_rows($result);
if ($numlinha == FALSE) {
        echo 'Você nã está associado a nenhum projeto';
    } else {
   if ($numlinha > 0) {   
        while ($row = mysqli_fetch_assoc($result)) {
            $projeto[] = $row; 
        }
        return $projeto;
    } else {
        
        echo "Voce não faz parte de nenhum projeto. ";
        return FALSE;
    }
    $libera = mysqli_free_result($result);
}
}
function criarProjeto($nome, $descricao, $inicio, $fim, $idUsuario) {
    include "config.php";

    $insere = "INSERT INTO projeto (nome, descricao, inicio, fim) VALUES ('$nome','$descricao','$inicio','$fim')";
    // Executa consulta
    $result = mysqli_query($conn, $insere); 
    
    $idProjeto = mysqli_insert_id($conn);
    // Mensagem caso a consulta falhe.
    if ($result === false) {
        echo "Não foi possível inserir os dados" . mysqli_error() . "<br />";
    } else {
        //echo " Last inserted ID is: " . $last_id;
        //echo "dados inserido com sucesso!";
        //exit();
        relacionaProjetoUsuarioPapel($idUsuario, 9, $idProjeto);
        //header("Location: painel.php");
    }
    $libera = mysqli_free_result($result);
}

function relacionaProjetoUsuarioPapel($idUsuario, $idPapel, $idProjeto) {
    include "config.php"; 
    
    $insere = "INSERT INTO papel_projeto (id_usuario, id_papel, id_projeto) VALUES ('$idUsuario','$idPapel','$idProjeto')";
    
    $result = mysqli_query($conn, $insere); 
    
    if ($result === false) {
        echo "Não foi possível inserir os dados" . mysqli_error() . "<br />";
    } else {
//        echo "dados inserido com sucesso!";
//        exit();
        header("Location: ../painel.php");
    }
    $libera = mysqli_free_result($result);
}

function detalheProjeto($idProjeto, $idPapel, $idUsuario) {
    include "config.php";
    
    echo $idProjeto;
    echo 'chegeui na funcao';
    exit;
    $query = "SELECT * FROM projeto As p 
            INNER JOIN papel_projeto AS pap ON pap.id_usuario = $idUsuario AND pap.id_papel = $idPapel AND pap.id_projeto = $idProjeto "
            . "INNER JOIN usuario as u  ON u.id_usuario = $idUsuario "
            . "WHERE  p.id_projeto = $idProjeto";
       echo $query;//
       exit;
    $busca = "SELECT DATE_FORMAT(inicio,'%d/%m/%Y') AS inicio, DATE_FORMAT(fim,'%d/%m/%Y') AS fim "
            . "FROM projeto WHERE id_projeto = $idProjeto";
    
   // Executa consulta
    $resultData = mysqli_query($conn,$busca);
    $result = mysqli_query($conn,$query);
    
    $numlinha = mysqli_num_rows($result);
    $numlinhaData = mysqli_num_rows($resultData);
    if ($numlinha == FALSE) {
        echo 'Você não tem dados cadastrados';
    } else {
    if ($numlinha >= 1 && $numlinhaData >0) {
        while ($row = mysqli_fetch_assoc($result)) {  
            $row2 = mysqli_fetch_assoc($resultData);
            echo '<div class="row">
                    <div class="col-md-12">
                    <h4>';
            echo 'Nome: ' . $row['nome'] . '</h4>';
            echo '<!--<a class="btn btn-primary pull-right" href="#" role="button">Editar</a>-->
                    </div><!--/.col-md-12--></div><!--/row--><div class="row">
                    <div class="col-md-12">';
            echo 'Criador: '.$row['username'].'<br />';
            echo 'Descrição: ' . $row['descricao'];
            echo '</div><!--/.col-md-12--></div><!--/row--><div class="row">
                  <div class="col-md-12">';
           
            echo 'Inicio: '.$row2['inicio']; //date('d/m/Y', $row['inicio']); // ;
            echo '</div><!--/.col-md-12--></div><!--/row--><div class="row">
		  <div class="col-md-12"> ';
            
            echo 'Fim: ' .$row2['fim']; //date('d/m/Y', $row['fim']);//$fim;
            echo '</div><!--/.col-md-12-->
		 </div><!--/row-->';
        }
    } else {
        ?>
        <script>
            window.alert("Voce não tem nenhum projeto cadastrado. ");
        </script>
        <?php

        //echo "Voce não tem nenhum projeto cadastrado. ";
    }
    //}
    $libera = mysqli_free_result($result);
    }
}

function updateProjeto($idProjeto, $nome, $descricao, $inicio, $fim) {
    include "config.php";
    $altera = "UPDATE projetos
                SET nome='$nome', descricao='$descricao', inicio='$inicio', fim='$fim'
                WHERE id_projeto='$idProjeto'";
    // Executa consulta
    $result = mysqli_query($altera, $link);
    // Mensagem caso a consulta falhe.
    if ($result === false) {
        echo "Não foi possível alterar os dados" . mysqli_error() . "<br />";
    } else {
        echo "dados alterados com sucesso!";
        header("Location: Projeto.php?idProjeto=$idProjeto");
    }
    $libera = mysqli_free_result($result);
}

function modalEditarProjeto($idProjeto){
    include "config.php";

    //$query = "SELECT id_projeto, nome, descricao , DATE_FORMAT(inicio,'%d/%m/%Y') AS inicio, DATE_FORMAT(fim,'%d/%m/%Y') AS fim FROM projetos WHERE id_projeto = '$idProjeto'";
   $query = "SELECT * FROM projeto WHERE id_projeto = '$idProjeto'";
// Executa consulta
    $result = mysqli_query($conn,$query);
    $numlinha = mysqli_num_rows($result);
    if ($numlinha == FALSE) {
        echo 'Este projeto não pode ser editado';
    } else {
    if ($numlinha > 0) {
        $row = mysqli_fetch_assoc($result);  
          ?>  
            <!-- Modal editar dados projeto -->
            <div class="modal fade" id="myModalEditarProjeto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Editar Projeto</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal" role="form" action="updateProjeto.php" method="POST">
                                    <div class="form-group">
                                        <label for="inputNome" class="col-md-2 control-label">Nome</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nome" id="nome" value="<?php echo $row['nome']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDescricao" class="col-md-2 control-label">Descrição</label>
                                        <div class="col-md-8">
                                            <textarea class="form-control" rows="3" name="descricao" id="texto"><?php echo $row['descricao']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputInicio3" class="col-sm-2 control-label">Início</label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" name="inicio" placeholder="" id="diniProj" required="required" value="<?php echo $row['inicio']; ?>">
                                        </div>
                                        <label for="inputFim" class="col-sm-1 control-label">Fim</label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" name="fim" value ="<?php echo $row['fim']; ?>" id="dfimProj" required="required" >
                                        </div>
                                    </div>
                                    <input type="hidden" id="idProjeto" name="idProjeto" value="<?php echo $row['id_projeto']; ?>" />     
                            </div> <!-- row-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="salvarProjeto">Salvar</button>
                        </div>
                        </form>
                    </div><!-- modal content -->
                </div><!-- modal dialog -->
            </div><!-- fade -->
            
          <?php         
  
     } else {
        ?>
        <script>
            window.alert("Voce não tem nenhum projeto cadastrado. ");
        </script>
        <?php
    }
    $libera = mysqli_free_result($result);
    }
}

function selecionaIdCriador($username){
    include 'config.php';
    $query = "SELECT id_usuario FROM usuario WHERE username = '$username'";
    
    $result = mysqli_query($conn,$query);
    $numlinha = mysqli_num_rows($result);
    if ($numlinha > 0) {
        $row = mysqli_fetch_assoc($result);
        $idCriador = $row['id_usuario'];
        //echo $idCriador;
        return $idCriador;
    }
    else{
        echo "Usuario não encontrado";
    }
    $libera = mysqli_free_result($result);
}

function apagarProjeto($idProjeto,$idPapel){
    include 'config.php';
    //fazer tres deletes
    $query = "DELETE FROM projeto WHERE id_projeto= '$idProjeto'";
    // Executa consulta
    $result = mysqli_query($conn, $query);
    if ($result === false) {
        echo "Não foi possível apagar os dados" . mysql_error() . "<br />";
        
    } else {
        //echo "dados apagados com sucesso!";
        //printf("Registros Excluídos: %d\n", mysql_affected_rows());
        header("Location: ../painel.php?idProjeto=$idProjeto");
    }

}
//converter no código php
//$data_formatada = date(‘d/m/Y H:i:s’, $row[‘mysqli_data’]);
//Esse exemplo retorna a data no formato: DD/MM/AAAA HH:MM:SS.