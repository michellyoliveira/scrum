<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function criarFase($nome, $descricao, $inicio, $fim, $idProjeto) {
    include "config.php";

    $insere = "INSERT INTO fase (nome, descricao, inicio, fim, id_projeto) VALUES ('$nome','$descricao','$inicio','$fim','$idProjeto')";

    // Executa consulta
    $result = mysqli_query($conn, $insere);
    // Mensagem caso a consulta falhe.

    if ($result === false) {
        echo "Não foi possível inserir os dados" . mysql_error() . "<br>";
    } else {
        echo "dados inserido com sucesso!";
        header("Location: ../projeto.php?idProjeto=$idProjeto");
    }

}

function listaFases($idProjeto) {
    include "config.php";

    $query = "SELECT id_fase, nome FROM fase WHERE id_projeto = '$idProjeto'";
    $result = mysqli_query($conn, $query);
    $numlinha = mysqli_num_rows($result);
//echo 'chegeui na lista fase';
//exit();
    if ($numlinha == FALSE) {
        echo 'Você não tem nenhuma fase cadastrada';
    } else {
        if ($numlinha > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $fase[] = $row;
            }
            return $fase;
        } else {
            echo 'Você não tem nenhuma fase cadastrada';
            return;
        }
        $libera = mysql_free_result($result);
    }
}

function updateFase($idFase, $nome, $descricao, $inicio, $fim, $idProjeto) {
    include "config.php";
    $query = "UPDATE fase
              SET nome='$nome', descricao='$descricao', inicio='$inicio', fim='$fim'
              WHERE id_fase='$idFase'";
    // Executa consulta
    $result = mysqli_query($conn, $query);
    // Mensagem caso a consulta falhe.
    if ($result === false) {
        echo "Não foi possível alterar os dados" . mysql_error() . "<br />";
    } else {
        //echo "dados alterados com sucesso!";
        $libera = mysqli_free_result($result);
        header("Location: ../projeto.php?idProjeto=$idProjeto");
    }
}
function verificaData($idProjeto){
    include 'config.php';
     $query = "SELECT inicio, fim FROM projeto WHERE id_projeto = '$idProjeto'";
     $result = mysqli_query($conn, $query);
     
     $row = mysqli_fetch_assoc($result);
     
     return $row;
}

function modalEditarFase($idFase) {
    include "config.php";
    //$query = "SELECT id_fase, nome, descricao , DATE_FORMAT(inicio,'%d/%m/%Y') AS inicio, DATE_FORMAT(fim,'%d/%m/%Y') AS fim, id_projeto FROM fase WHERE id_fase = $idFase";
    $query = "SELECT * FROM fase WHERE id_fase = '$idFase'";
    // Executa consulta
    $result = mysqli_query($conn, $query);
    $numlinha = mysqli_num_rows($result);

    if ($numlinha > 0) {
        $row = mysqli_fetch_assoc($result);
        $idFase = $row['id_fase'];
        $nome = $row['nome'];
        $descricao = $row['descricao'];
        $inicio = $row['inicio'];
        $fim = $row['fim'];
        $idProjeto = $row['id_projeto'];
        ?>  
        <!-- Modal editar dados fase -->
        <div class="modal fade" id="myModalEditarFase" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Editar Fase</h4> <?php echo $idFase; ?>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <form class="form-horizontal" role="form" action="controles/updateFase.php" method="POST">
                                <div class="form-group">
                                    <label for="inputNome" class="col-md-2 control-label">Nome</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo $nome; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputDescricao" class="col-md-2 control-label">Descrição</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" rows="3" name="descricao" id="texto"><?php echo $descricao; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputInicio3" class="col-sm-2 control-label">Início</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="inicio" placeholder="" value="<?php echo $inicio; ?>" id="dini" placeholder="<?php echo $inicio; ?>" >
                                    </div>
                                    <label for="inputFim" class="col-sm-1 control-label">Fim</label>
                                    <div class="col-sm-4">
                                        <input type="date" class="form-control" name="fim" value ="<?php echo $fim; ?>" id="dfim">
                                    </div>
                                </div>
                                <input type="hidden" id="idFase" name="idFase" value="<?php echo $idFase; ?>" />   
                                <input type="hidden" id="idProjeto" name="idProjeto" value="<?php echo $idProjeto; ?>" /> 
                        </div> <!--row-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" id="salvarFase">Salvar</button>
                        <!--<label class="col-md-3 control-label pull-right">-->
                        <a class="btn btn-danger pull-right" href="controles/apagarFase.php?idFase=<?php echo $idFase ?>&idProjeto=<?php echo $idProjeto;  ?>" role="button" id="botaoApagar" >Apagar</a>
                        <!--</label>-->
                    </div>
                    </form>
                </div> <!--modal content -->
            </div> <!--modal dialog  -->
        </div> <!-- fade -->
<!--        <script src="js/meuscript.js"></script> -->
        <script>
        $(document).ready(function () {
            $("#dini, #dfim").change(function () {
                var dataInicial = ($("#dini").val()).split("-");
                var dataFinal = ($("#dfim").val()).split("-");
                var dataInicialInformada = new Date(dataInicial[2], dataInicial[1] - 1, dataInicial[0]);
                var dataFinalInformada = new Date(dataFinal[2], dataFinal[1] - 1, dataFinal[0]);

                if (dataFinalInformada === dataInicialInformada) {
                    alert("Data Final igual a Data Inicial.");
                }
                if (dataFinalInformada < dataInicialInformada) {
                    alert("Data Final menor qua a Data Inicial.");
                }
            });  
        });
        </script>
        <?php
    } else {
        ?>
        <script>
            window.alert("Voce não tem fase para editar ");
        </script>
        <?php
        $libera = mysql_free_result($result);
    }
}

function apagarFase($idFase, $idProjeto) {
    include 'config.php';
    $query = "DELETE FROM fase WHERE id_fase= '$idFase'";
    // Executa consulta
    $result = mysqli_query($conn, $query);
    if ($result === false) {
        echo "Não foi possível apagar os dados" . mysql_error() . "<br />";
    } else {
        //echo "dados apagados com sucesso!";
        header("Location: ../projeto.php?idProjeto=$idProjeto");
    }
}
