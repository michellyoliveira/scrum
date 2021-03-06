<?php
require "header.php";
session_start();
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];
if (isset($_SESSION['idUsuario']))
    $idUsuario = $_SESSION['idUsuario'];
if (isset($_SESSION['password']))
    $password = $_SESSION['password'];
if (!(empty($username) OR empty($password))) {
    include_once "controles/config.php";
    require "controles/projetoControle.php";
    include_once 'controles/usuarioControle.php';
    include "controles/faseControle.php";
    include "controles/timeControle.php";
    $idProjeto = $_REQUEST['idProjeto'];
    $_SESSION['idProjeto'] = $idProjeto;
    echo "idProjeto = " . $idProjeto;
    
    $idPapelProjeto = verificaIdPapelPapelProjeto($idProjeto);
    if($idPapelProjeto == 9){
        $idPapel = $idPapelProjeto;
    }
    elseif($idPapelProjeto == 10){
        $idPapel = $idPapelProjeto;
    }
    else{
        if (isset($_SESSION['idPapel']))
            $idPapel = $_SESSION['idPapel'];
    }
    echo 'id_usuario-> ' . $idUsuario;
        echo 'id_papel = ' . $idPapel;
        echo 'username = ' . $username;
    ?>
    <div class="row">
        <!--///////////////////////////Fases////////////////////////////////////////-->
        <div class="col-md-4">
            <h2>Fases</h2>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModalFase" id="criarfase">
                Adicionar
            </button>

            <!-- Modal -->
            <div class="modal fade" id="myModalFase" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Criar fase</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form class="form-horizontal" role="form" action="controles/dadosFase.php" method="POST">
                                    <div class="form-group">
                                        <label for="inputNome" class="col-md-2 control-label">Nome</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="nome" id="nome" required="required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDescricao" class="col-md-2 control-label">Descrição</label>
                                        <div class="col-md-8">
                                            <textarea class="form-control" rows="3" name="descricao" id="texto"></textarea>
                                        </div>
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
                                    <input type="hidden" id="idProjeto" name="idProjeto" value="<?php echo $idProjeto; ?>" />     
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
            <hr>
            <?php
            $fase = listaFases($idProjeto);
            if (is_array($fase) || is_object($fase)) {
                $i = 0; //garante a troca de fase para edicao no foreach
                foreach ($fase as $f => $f_value) {
                    $i++;
                    ?>
                    <div class="row">
                        <form id="formListaFase" class="form-horizontal" role="form" action="kanban.php" method="post">
                            <div id="dadosFaseForm" class="col-md-12 control-label" >
                                <label for="Nome" class="col-md-5 control-label  pull-left"> <?php echo $f_value['nome']; ?> </label>
                                <label for="idFase" class="col-md-1 control-label  pull-left"><?php echo $f_value['id_fase']; ?> </label>
                                <input type="hidden" id="idFase<?php echo $f_value['id_fase']; ?>" name="idFase" value="<?php echo $f_value['id_fase']; ?>" />
                                <label class="col-md-3 control-label ">
                                    <button type="submit" class="btn btn-info pull-left" >Detalhes</button>
                                </label>
                                <label class="col-md-3 control-label " id="editarFase">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalEditarFase<?php echo $i ?>" >
                                        Modificar
                                    </button>  
                                </label>
                            </div><!-- dadosFaseForm -->
                        </form>  
                    </div><!-- row -->
                    <?php
                    modalEditarFase($f_value['id_fase'], $i);
                }
            }
            ?>	
        </div><!-- /col-md-4 -->
        <!--///////////////////////////Time////////////////////////////////////////-->
        <div class="col-md-4">
            <h2>Time</h2>
            <!--            ////////////////  Modal Time /////////////////////////////////
                         Button trigger modal -->
            <button type="button" class="btn btn-success  pull-right" data-toggle="modal" data-target="#myModal" id="criarTime">
                Criar / Editar
            </button>
            <hr> 
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Criar Time</h4>
                        </div>
                        <div class="modal-body">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form id="banco" action="controles/aprovaTime.php" method="post">    
                                                <div class="form-group">
                                                    <label for="inputPapel" class="col-md-2 control-label"><h4>Banco</h4></label>
                                                    <div class="col-md-12" required="required">
                                                        <?php bancoSelect("idUsuario[]", "banco", $idProjeto) ?>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="idProjeto" value="<?php echo $idProjeto; ?>" /> 
                                                <input type="hidden" name="idPapel" value="10" />  
                                                <div class="form-group col-md-2">
                                                    <button type="submit" class="btn btn-primary" id="autorizar">Escalar</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form id="time" action="controles/removeIntegrante.php" method="post">    
                                                <div class="form-group">
                                                    <label for="inputPapel" class="col-md-2 control-label"><h4>Time</h4></label>
                                                    <div class="col-md-12" required="required">
                                                        <?php timeSelect("idUsuario[]", "time", $idProjeto) ?>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="idProjeto" value="<?php echo $idProjeto; ?>" /> 
                                                <input type="hidden" name="idPapel" value="4" />  
                                                <div class="form-group col-md-2">
                                                    <button type="submit" class="btn btn-primary" id="autorizar">Remover</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <hr>
                                        <div class="col-md-6">
                                            <form id="liderTime" action="controles/aprovaTime.php" method="post">    
                                                <div class="form-group">
                                                    <label for="inputPapel" class="col-md-2 control-label"><h4>Time</h4></label>
                                                    <div class="col-md-12" required="required">
                                                        <?php liderSelect("idUsuario", "liderTime", $idProjeto) ?>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="idProjeto" value="<?php echo $idProjeto; ?>" /> 
                                                <input type="hidden" name="idPapel" value="2" />  
                                                <div class="form-group col-md-2">
                                                    <button type="submit" class="btn btn-primary" id="autorizar">Escolher</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form id="liderRemove" action="controles/removeLider.php" method="post">    
                                                <div class="form-group">
                                                    <label for="inputPapel" class="col-md-2 control-label"><h4>Lider</h4></label>
                                                    <div class="col-md-12" required="required">
                                                        <?php
                                                        $lider = verLider($idProjeto);
                                                        if (is_array($lider) || is_object($lider)) {
                                                            echo '<input type="hidden" name="idUsuario" value= "' . $lider['id_usuario'] . '">';
                                                            echo $lider['username'] . '<br><br>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="idProjeto" value="<?php echo $idProjeto; ?>" /> 
                                                <div class="form-group col-md-2">
                                                    <button type="submit" class="btn btn-primary" id="autorizar">Remover</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- row-->
                                </div> <!--/col-md12 -->

                            </div>  <!--row -->
                        </div>
                    </div>
                </div>
            </div><!--
            //////////////// Fim Modal  /////////////////////////////////-->  
            <div>
                <?php
                $time = listaTime($idProjeto);
                if (is_array($time) || is_object($time)) {

                    foreach ($time as $t => $t_value) {
                        //$t_value['id_usuario'];
                        if ($t_value['lider'] == 1) {
                            echo $t_value['username'] . ' &nbsp;&nbsp; -&nbsp;&nbsp; L&iacute;der <br>';
                        } else {
                            echo $t_value['username'] . '<br>';
                        }
                    }
                }
                ?>
            </div>
        </div>
            <!--////////////////////////Dados Projeto//////////////////////////////////-->
            <div class="col-md-4">
                <div class="row">
                <h2>Dados do Projeto</h2>
                
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModalEditarProjeto" id="editarProjeto">
                    Modificar
                </button>
                 <hr>
               <?php
                    modalEditarProjeto($idProjeto); 
                
                    $projeto = detalheProjeto($idProjeto);
                    if (is_array($projeto) || is_object($projeto)) {

                    foreach ($projeto as $p => $p_value) {

                            echo '<h4> Nome: ' . $p_value['nome'] . '</h4>';
                            echo 'Criador: '.$p_value['username'] . '<br>';
                            echo 'Descrição: '.$p_value['descricao'] . '<br>';
                            echo 'Inicio: '.$p_value['inicio'] . '<br>';
                      
                            echo 'Fim: ' .$p_value['fim'] . '<br>';
                          //      echo 'Inicio: '.date('d/m/Y', $p_value['inicio']) . '<br>';
                    }
                }
                ?>
                </div>
                <!--        <hr>
                <dic class="row">
                        //////////////////////// Reunioes //////////////////////////////////
                        <h2>Reuniões</h2>
                         Button trigger modal 
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModalReuniao">
                            Marcar
                        </button>
            
                         Modal 
                        <div class="modal fade" id="myModalReuniao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Marcar Reunião</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <form class="form-horizontal" role="form" action="EditarProjetoController.php" method="POST">
                                                <div class="form-group">
                                                    <label for="inputNome" class="col-md-2 control-label">Assunto</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="nome" id="nomeReu" required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputDescricao" class="col-md-2 control-label">Descrição</label>
                                                    <div class="col-md-8">
                                                        <textarea class="form-control" rows="3" name="descricao" id="textoReu"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputInicio3" class="col-sm-2 control-label">Início</label>
                                                    <div class="col-sm-4">
                                                        <input type="date" class="form-control" name="inicio" placeholder="dd/mm/yyyy" id="diniReu" required="required">
                                                    </div>
                                                    <label for="inputFim" class="col-sm-1 control-label">Fim</label>
                                                    <div class="col-sm-4">
                                                        <input type="date" class="form-control" name="fim" placeholder="dd/mm/yyyy" id="dfimReu" required="required" >
                                                    </div>
                                                </div>
                                                <input type="hidden" id="idProjeto" name="idProjeto" value="<?php // echo $idProjeto;      ?>" />     
                                        </div>  row
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success" id="salvarFase">Salvar</button>
                                    </div>
                                    </form>
                                </div> modal content 
                            </div> modal dialog 
                        </div> fade 
                        <hr>
                        <p>Nenhuma reunião cadastrada.</p>
                        <p><a class="btn btn-primary" href="#" role="button">View details</a></p>-->
            </div> <!--/col-lg-4 -->
        </div> <!--/row  -->
            <!--<div id="conteudo-ajax"></div>-->
            <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
            <!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
<script>
        $(document).ready(function () {
            var idPapel = <?php echo $idPapel; ?>;
            //alert(idPapel);
            switch (idPapel) {
                case 1:
                case 2:
                    $("#criarfase").hide();
                    $("#editarFase").hide();
                    $("#editarProjeto").hide();
                    $("#criarTime").hide();
                    //$("input[name='botao_apagar']").hide();
                    //$("#projetosPertenco").show();
                    break;
                case 3:
                    break;
                case 4:
                    $("#criarfase").hide();
                    $("#editarProjeto").hide();
                    $("#editarFase").hide();
                    $("#criarTime").hide();
                case 5:
                case 6:
                case 7:
                case 8:
                    $("#linha").hide();
                    $("#criarfase").hide();
                    $("#editarFase").hide();
                    $("#editarProjeto").hide();
                    $("#criarTime").hide();
                    alert("Você não tem permissão para estar aqui");
                case 9:
                    break;
                case 10:
                    $("#criarfase").hide();
                    $("#editarFase").hide();
                    $("#editarProjeto").hide();
                    $("#criarTime").hide();
                    break;
                default:
                    // $("#linha").hide();

            }

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
            //include_once "footer.php";
        } else {
            echo "usuario não cadastrado, faça seu cadastro";
            echo "<a href= 'index.php'> Voltar </a>";
        }
        ?>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
        ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 

</body>
</html>