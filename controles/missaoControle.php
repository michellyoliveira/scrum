<?php

function criarMissao($nome, $descricao, $idFase) {
    include 'config.php';

    $insere = "INSERT INTO missao (nome, descricao, id_fase) VALUES ('$nome','$descricao','$idFase')";

    $result = mysqli_query($conn, $insere);

    if ($result === false) {
        echo "Não foi possível inserir os dados" . mysql_error() . "<br />";
    } else {
        // echo "dados inserido com sucesso!";
        //listaMissoes($idFase);
        header("Location: ../kanban.php?idFase=$idFase");
    }
//$libera = mysql_free_result($result);	
}

function listaMissoes($idFase) {
    include "config.php";

//echo $fkIdFase;

    $query = "SELECT id_missao, nome FROM missao WHERE id_fase = '$idFase'";

// Executa consulta
    $result = mysqli_query($conn, $query);

    $numlinha = mysqli_num_rows($result);

    if ($numlinha > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nome = $row['nome'];
            $idMissao = $row['id_missao'];
            ?>
            <tr>
                <th scope="row" aling="left">
            <div class="row">
                <div id="divMissao" class="col-md-9" >
            <?php echo $row['nome']; ?>
            <?php echo $row['id_missao']; ?>
                </div>
                <div id="divIconesMissao" class="col-md-1 control-label ">               
                    <!--//////////////////// modal criar tarefa /////////////////////////////-->
                    <span title="Criar tarefa" data-toggle="tooltip" data-placement="right"> 
                        <a href="#" data-toggle="modal" data-target="#myModalTarefa" id="m2"> 
                            <span class="glyphicon glyphicon-list-alt" aria-hidden="true" aria-label="Right Align"></span>                        
                        </a>                  
                    </span>
                    <!-- Modal -->
                    <div class="modal fade" id="myModalTarefa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Criar Tarefa</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <form class="form-horizontal" role="form" action="RecebeDadosTarefa.php" method="POST">
                                            <div class="form-group">
                                                <label for="inputNome" class="col-md-2 control-label">Nome:</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="nome" id="nomeMissao" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputDescricao" class="col-md-2 control-label">Descrição:</label>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" rows="3" name="descricao" id="descricaoMissao"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputNome" class="col-md-6 control-label">Responsavel</label>
                                                <div class="col-md-3"><?php listaResponsavel("idUsuario") ?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputInicio3" class="col-sm-2 control-label">Início</label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control" name="inicio" placeholder="dd/mm/yyyy" id="diniFase" required="required">
                                                </div>
                                                <label for="inputFim" class="col-sm-1 control-label">Fim</label>
                                                <div class="col-sm-4">
                                                    <input type="date" class="form-control" name="fim" placeholder="dd/mm/yyyy" id="dfimFase" required="required" >
                                                </div>
                                            </div>
                                            <input type="hidden" name="idMissao" value="<?php echo $idMissao; ?>" />     
                                    </div> <!-- row-->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success" id="salvarFase">Salvar</button>
                                </div>
                                </form>
                            </div><!-- modal content -->
                        </div><!-- modal dialog -->
                    </div><!-- fade -->    
                    <!--//////////////////// fim modal criar tarefa /////////////////////////////-->  
                    <!--</form>-->
                    <form id="formEditarMissao" class="form-horizontal" role="form" action="editarMissao.php" method="post"> 
                        <a href="#"  id="m2" data-toggle="tooltip" data-placement="right" title="Editar missão">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true" aria-label="Right Align"></span>
                        </a>
                    </form>
                    <form id="formDeletarMissao" class="form-horizontal" role="form" action="excluirMissao.php" method="post"> 
                        <a href="#" id="m3" data-toggle="tooltip" data-placement="right" title="Excluir missão">
                            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true" aria-label="Right Align"></span>
                        </a>
                    </form>
                </div><!-- divIconesMissao -->
            </div><!-- row-->
            </th>
            <td id="afazer" class="danger" ondrop="drop(event)" ondragover="allowDrop(event)"><div id="testeDrag" draggable="true" ondragstart="drag(event)"></div></td>
            <td id="desenvolvendo"class="warning" ondrop="drop(event)" ondragover="allowDrop(event)"></td>
            <td id="verificando" class="info" ondrop="drop(event)" ondragover="allowDrop(event)"></td>
            <td id="pronto" class="success" ondrop="drop(event)" ondragover="allowDrop(event)"> </td>
            </tr>
            <?php
        }
    } else {
        echo '<script>
            window.alert("Voce não tem nenhuma missão cadastrada. " );
         </script>';
    }
//}
    $libera = mysqli_free_result($result);
}

function updateMissao($idFase, $nome, $descricao, $idMissao) {
    include "config.php";
    $altera = "UPDATE missao
              SET nome='$nome', descricao='$descricao'
              WHERE id_missao=$idMissao";
    // Executa consulta
    $result = mysqli_query($conn, $altera);
    // Mensagem caso a consulta falhe.
    if ($result === false) {
        echo "Não foi possível alterar os dados" . mysql_error() . "<br />";
    } else {
        //echo "dados alterados com sucesso!";
        //$libera = mysqli_free_result($result);
        header("Location: ../kanban.php?idFase=$idFase");
    }
}

function modalEditarMissao($idMissao, $i) {
    include "config.php";   
    $query = "SELECT * FROM missao WHERE id_missao = '$idMissao'";
    print_r($idMissao);
    // Executa consulta
    $result = mysqli_query($conn, $query);
    $numlinha = mysqli_num_rows($result);

    if ($numlinha > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['id_missao'];
        ?>  
        <!-- Modal editar dados missao -->
        <div class="modal fade" id="myModalEditarMissao<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Editar Missao</h4> <?php echo $row['id_missao']; ?>
                    </div>
                    <form class="form-horizontal" role="form" action="controles/updateMissao.php" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <!--<div class="row">-->
                                <div class="form-group">
                                    <label for="inputNome" class="col-md-2 control-label">Nome</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo $row['nome']; ?>">
                                    </div>
                                </div>
                                <br><br>
                                <!--</div>-->
                                <!--<div class="row">-->
                                <div class="form-group">
                                    <label for="inputDescricao" class="col-md-2 control-label">Descrição</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" rows="3" name="descricao" id="texto"><?php echo $row['descricao']; ?></textarea>
                                    </div>
                                </div>
                                <!--</div>-->
                                <!--                                <div class="form-group">
                                                                    <label for="inputInicio3" class="col-sm-2 control-label">Início</label>
                                                                    <div class="col-sm-4">
                                                                        <input type="date" class="form-control" name="inicio" placeholder="" value="<?php //echo $row['inicio'];  ?>" id="dini" placeholder="<?php echo $row['inicio']; ?>" >
                                                                    </div>
                                                                    <label for="inputFim" class="col-sm-1 control-label">Fim</label>
                                                                    <div class="col-sm-4">
                                                                        <input type="date" class="form-control" name="fim" value ="<?php //echo $row['fim'];  ?>" id="dfim">
                                                                    </div>
                                                                </div>-->
                                <input type="hidden" id="idFase" name="idMissao" value="<?php echo $row['id_missao']; ?>" />   
                                <input type="hidden" id="idProjeto" name="idFase" value="<?php echo $row['id_fase']; ?>" /> 
                            </div> <!--row-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="salvarFase">Salvar</button>
                            <!--<label class="col-md-3 control-label pull-right">-->
                            <a class="btn btn-danger pull-right" href="controles/apagarMissao.php?idMissao=<?php echo $row['id_missao'] ?>&idFase=<?php echo $row['id_fase']; ?>" role="button" id="botaoApagar" >Apagar</a>
                            <!--</label>-->
                        </div>
                    </form>
                </div> <!--modal content -->
            </div> <!--modal dialog  -->
        </div> <!-- fade -->
        <?php
    } else {
        ?>
        <script>
            window.alert("Voce não tem fase para editar ");
        </script>
        <?php
    }
    $libera = mysqli_free_result($result);
}

function apagarMissao($idFase, $idMissao) {
    include 'config.php';
    $query = "DELETE FROM missao WHERE id_missao= $idMissao";
    // Executa consulta
    $result = mysqli_query($conn, $query);
    if ($result === false) {
        echo "Não foi possível apagar os dados" . mysql_error() . "<br />";
    } else {
        //echo "dados apagados com sucesso!";
        header("Location: ../kanban.php?idFase=$idFase");
    }
}

