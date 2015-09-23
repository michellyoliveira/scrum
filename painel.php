<?php
require "header.php";
session_start();
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];
if (isset($_SESSION['idUsuario']))
    $idUsuario = $_SESSION['idUsuario'];
if (isset($_SESSION['idPapel']))
    $idPapel = $_SESSION['idPapel'];
echo 'id_usuario->' . $idUsuario;
echo 'id_papel=' . $idPapel;
echo 'username = ' . $username;
if (isset($_SESSION['password']))
    $password = $_SESSION['password'];
if (!(empty($username) OR empty($password))) {
    include_once "controles/config.php";
    require "controles/projetoControle.php";
    include_once 'controles/usuarioControle.php';
    ?>
    <div class="row" id="linha">
        <div class="col-md-6">
            <div id="criarProjeto">
                <a haref="#"  data-toggle="collapse" data-target="#dados"><h2>Criar Projetos</h2></a>
                <!--class="btn btn-default btn-block" role="button"-->
                <!--<button type="button" class="btn btn-success " id="criar" data-toggle="collapse" data-target="#dados">Criar Projeto</button>-->
                <div id="dados" class="collapse">
                    <!--/////////////////////////////////////////////////////////////-->
                    <hr>
                    <div class="row">
                        <form class="form-horizontal" role="form" action="controles/dadosProjeto.php" method="POST">
                            <div class="form-group">
                                <label for="inputNome" class="col-md-2 control-label">Nome</label>
                                <div class="col-md-8">
                                    <input type="tex" class="form-control" name="nome" id="nome" required="required">
                                </div>
                            </div>  
                            <input type="hidden" id="idCriador" name="idCriador" value="<?php echo $idUsuario ?>" /><?php // echo selecionaIdCriador($username);            ?> 
                            <div class="form-group">
                                <label for="inputPassword3" class="col-md-2 control-label">Descrição</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" rows="3" name="descricao" id="texto"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputInicio3" class="col-sm-2 control-label">Início</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="inicio" placeholder="dd/mm/yyyy" id="dini" required="required" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputFim" class="col-sm-2 control-label">Fim</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="fim" placeholder="dd/mm/yyyy" id="dfim" required="required">
                                </div>
                            </div>                           
                            <div class="form-group">
                                <div class="col-md-offset-7 col-md-5"> 
                                    <button type="submit" class="btn btn-success" id="salvar">Salvar Projeto</button>
                                </div>
                            </div>
                        </form>
                    </div><!--/row-->
                    <hr>
                    <!--////////////////////////////////////////////////////////////////////-->
                </div>  <!--/dados -->
            </div>
            <!--<hr>-->

            <div class="panel panel-success" id="meusProjetos" >
                <div class="panel-heading">
                    <h3 class="panel-title">Meus Projetos </h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $projeto = listaProjetos($idUsuario);
                            //trata o erro caso seja vetor nulo
                            if (is_array($projeto) || is_object($projeto)) {
                                $i = 0;
                                foreach ($projeto as $x => $x_value) {
                                    //                  echo  $x . ') ';
                                    //                  foreach ($x_value as $key => $value) {                   
                                    //                        echo  $key." :  ".$value . '<br>';
                                    //                    } 
                                    // echo $x_value['id_projeto'].'  '. $x_value['nome'].'<br>';
                                    //                    foreach ($x_value as $value) {
                                    //                        echo $value . '<br>';
                                    //                    }
                                    ?>
                                    <div class="row">
                                        <form id="idProj" class="form-horizontal" role="form" action="projeto.php" method="post"> 

                                            <label for="Nome" class="col-md-4 control-label"><?php echo $x_value['nome'] ?> </label>
                                            <input type="hidden" name="idProjeto" value="<?php echo $x_value['id_projeto'] ?>" /> 
                                            <label class="col-md-2 control-label">
                                                <button type="submit" class="btn btn-primary" id="detalhes">Detalhes </button></label>
                                            <label class="col-md-2 control-label" name="botao_apagar" id="botaoApagar<?php echo $i++; ?>">
                                                <a class="btn btn-danger  " href="controles/apagarProjeto.php?idProjeto=<?php echo $x_value['id_projeto']; ?>&idUsuario=<?php echo $idUsuario; ?>" role="button" >Apagar</a></label>
                                        </form>
                                    </div><!-- row -->
                                    <?php
                                }
                            }
                            ?>
                        </div >
                    </div><!--/row-->	
                </div><!-- panel body-->
            </div><!-- panel -->
            <!--<hr>-->
            <div class="panel panel-success" id="projetosPertenco">
                <div class="panel-heading">
                    <h3 class="panel-title">Projetos que faço parte </h3>
                </div>
            <!--<span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>-->
                <div class="panel-body">	 
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $projetoFacoParte = listaProjetosFacoParte($idUsuario);
                            if (is_array($projeto) || is_object($projeto)) {
                                foreach ($projetoFacoParte as $p => $p_value) {
                                    ?>
                                    <div class="row">
                                        <form id="idProj" class="form-horizontal" role="form" action="projeto.php" method="post">

                                            <label for="Nome" class="col-md-4 control-label"><?php echo $p_value['nome'] ?></label>

                                            <input type="hidden" id="idProjeto" name="idProjeto" value="<?php echo $p_value['id_projeto'] ?>" /> 
                                            <label class="col-md-2 control-label">
                                                <button type="submit" class="btn btn-primary" id="detalhes">Detalhes</button></label>
                                            <div class="apagar">
                                                <label class="col-md-2 control-label" name="botao_apagar"><a class="btn btn-danger " href="#" role="button" id="botaoApagar" >Apagar</a></label>
                                            </div>
                                        </form>
                                    </div><!-- row -->
                                    <?php
                                }
                            }
                            ?>
                        </div >
                    </div><!--/row-->
                </div><!-- panel body-->
            </div><!-- panel -->
        </div><!--/.col-xs-12.col-sm-9-->
        <div class="col-md-6" id="ladoDireito">
            <!--            <div class="panel panel-success">
                            <div class="panel-heading">
                                <a haref="#" data-toggle="collapse" data-target="#dados">Criar Projetos</a>
                                Criar Projetos
                            </div>
                            <div class="panel-body">
                                <button type="button" class="btn btn-success " id="criar" data-toggle="collapse" data-target="#dados">Criar Projeto</button>
                                <div id="dados" >class="collapse"
                                     /////////////////////////////////////////////////////////////
                                    
                                    <div class="row">
                                        <form class="form-horizontal" role="form" action="dadosProjeto.php" method="POST">
                                            <div class="form-group">
                                                <label for="inputNome" class="col-md-2 control-label">Nome</label>
                                                <div class="col-md-8">
                                                    <input type="tex" class="form-control" name="nome" id="nome" required="required">
                                                </div>
                                            </div>  
                                            <input type="hidden" id="idCriador" name="idCriador" value="<?php // echo $idUsuario            ?>" /><?php // echo selecionaIdCriador($username);            ?> 
                                            <div class="form-group">
                                                <label for="inputPassword3" class="col-md-2 control-label">Descrição</label>
                                                <div class="col-md-8">
                                                    <textarea class="form-control" rows="3" name="descricao" id="texto"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputInicio3" class="col-sm-2 control-label">Início</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" name="inicio" placeholder="dd/mm/yyyy" id="dini" required="required">
                                                </div>
                                                <label for="inputFim" class="col-sm-2 control-label">Fim</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" name="fim" placeholder="dd/mm/yyyy" id="dfim" required="required" >
                                                </div>
                                            </div>                           
                                            <div class="form-group">
                                                <div class="col-md-offset-7 col-md-5"> 
                                                    <button type="submit" class="btn btn-success" id="salvar">Salvar Projeto</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>/row
                                    ////////////////////////////////////////////////////////////////////
                                </div> /dados 
                            </div>
                        </div>-->
            <!--</div>   /caixa -->
            <!--<hr>-->
            <h2> Administrar Alunos</h2>
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <h3 class="panel-title">Gerenciar Papel Criador de Projeto </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 pull-left">
                            <form id="aserCriador" action="controles/aprovacriador.php" method="post">    
                                <div class="form-group">
                                    <label for="inputPapel" class="col-md-2 control-label"><h4>Aluno</h4></label>
                                    <div class="col-md-12" required="required">
                                        <?php listaUserSelect("idUsuario[]", "aserCriador", 1) ?>
                                    </div>
                                </div>
                                <input type="hidden" name="idPapel" value="4" />  
                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-primary" id="autorizar">Autorizar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 pull-right">
                            <form id="voltarAluno" action="controles/aprovacriador.php" method="post">
                                <div class="form-group">
                                    <label for="inputPapel" class="col-md-2 control-label"><h4>Criador</h4></label>
                                    <div class="col-md-12" required="required">
                                        <?php listaUserSelect("idUsuario[]", "voltarAluno", 4) ?>
                                    </div>
                                </div>
                                <input type="hidden" name="idPapel" value="1" /> 
                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-primary" id="autorizar">Modificar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--            <div class="panel panel-success ">
                            <div class="panel-heading">
                                <h3 class="panel-title">Gerenciar Papel Líder de Time</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6 pull-left">
                                        <form id="aserLider" action="aprovaPapel.php" method="post">    
                                            <div class="form-group">
                                                <label for="inputPapel" class="col-md-2 control-label"><h4>Aluno</h4></label>
                                                <div class="col-md-12" required="required">
            <?php // listaUserSelect("idUsuario[]", "aserLider", 1) ?>
                                                </div>
                                            </div>
                                            <input type="hidden" name="idPapel" value="2" />  
                                            <div class="form-group col-md-2">
                                                <button type="submit" class="btn btn-primary" id="autorizar">Autorizar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6 pull-right">
                                        <form id="alunoNovamente" action="aprovaPapel.php" method="post">
                                            <div class="form-group">
                                                <label for="inputPapel" class="col-md-2 control-label"><h4>Criador</h4></label>
                                                <div class="col-md-12" required="required">
            <?php // listaUserSelect("idUsuario[]", "voltarAluno", 4) ?>
                                                </div>
                                            </div>
                                            <input type="hidden" name="idPapel" value="1" /> 
                                            <div class="form-group col-md-2">
                                                <button type="submit" class="btn btn-primary" id="autorizar">Modificar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        
                                </div>-->
        </div>




    </div><!-- lado direito -->
    </div><!--/row-->
    </div>
    </div><!--/.sidebar-offcanvas--> 
    </div><!--/row off canvas-->
    </div><!-- md-offset-1-->  
    </div><!--/.container-->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    <script>
        $(document).ready(function () {
            var idPapel = <?php echo $idPapel; ?>;
            //alert(idPapel);
            switch (idPapel) {
                case 1:
                case 2:
                    $("#criarProjeto").hide();
                    $("#meusProjetos").hide();
                    $("#ladoDireito").hide();
                    $(".apagar").hide();
                    //$("input[name='botao_apagar']").hide();
                    //$("#projetosPertenco").show();
                    break;
                case 4:
                    $("#ladoDireito").hide();
                    break;
                case 3:
                    break;
                case 5:
                case 6:
                case 7:
                case 8:
                    $("#linha").hide();
                    alert("Você não tem permissão para estar aqui");
                default:
                    // $("#linha").hide();

            }

            $("#ljçlkjçlk").click(function () {
                $.post("remove.php",
                        {
                            idProjeto: "Donald Duck",
                            idUsuario: "Duckburg",
                            idPapel: "blabla"
                        },
                function (result) {
                    alert("Data: " + result);
                });
            });


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
    echo "<a href= 'index.html'> Voltar </a>";
}
?>
</body>
</html>