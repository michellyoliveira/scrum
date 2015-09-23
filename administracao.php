<?php
require_once "header.php";
session_start();
if (isset($_SESSION['username']))
    $username = $_SESSION['username'];
if (isset($_SESSION['password'])) {
    $password = $_SESSION['password'];
    $idPapel = $_SESSION['idPapel'];
}
if (!(empty($username) OR empty($password))) {
    require_once 'controles/config.php';
    include_once 'controles/usuarioControle.php';
    ?>
    <h3>Área administrativa</h3>
    <div class="row">
        <div class="col-md-6" >
            <div class="panel panel-info ">
                <div class="panel-heading">
                    <h3 class="panel-title">Gerenciar Aluno</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-6 pull-left">
                        <h4>Autorizar Aluno</h4>
                        <form id="aseraluno" action="aprovaPapel.php" method="post">    
                            <div class="form-group">
                                <?php listaUserSelect("idUsuario[]", "aseraluno", 7) ?>
                            </div>
                            <input type="hidden" name="idPapel" value="1" />  
                            <button type="submit" class="btn btn-primary" id="autorizar">Autorizar</button>
                        </form>
                    </div>
                    <div class="col-md-6 pull-right">
                        <h4 >Alunos Autorizados</h4>
                        <form id="voltarAluno" action="aprovaPapel.php" method="post">
                            <div class="form-group">
                                <div class="col-md-12" required="required">
                                    <?php listaUserSelect("idUsuario[]", "voltarAluno", 1) ?>
                                </div>
                            </div>
                            <input type="hidden" name="idPapel" value="7" /> 
                            <div class="form-group col-md-2 pul-right">
                                <button type="submit" class="btn btn-primary" id="autorizar">Modificar</button>
                            </div>
                        </form>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6" >
            <div class="panel panel-success ">
                <div class="panel-heading">
                    <h3 class="panel-title">Gerenciar Professor</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-6 pull-left">
                        <form id="aserprofessor" action="aprovaPapel.php" method="post">  
                            <h4>Autorizar Professor</h4>
                            <div class="form-group">
                                <!--<label for="inputNome" class="col-md-6 control-label">Autorizar Aluno</label>-->
                                <?php listaUserSelect("idUsuario[]", "aserprofessor", 8) ?>
                            </div>
                            <input type="hidden" name="idPapel" value="3" />  
                            <button type="submit" class="btn btn-success" id="salvar">Autorizar</button>
                        </form>
                    </div>
                    <div class="col-md-6 pull-right">
                        <form id="voltarProfe" action="aprovaPapel.php" method="post">
                            <h4>Professores Autorizados</h4>
                            <div class="form-group">
                                <div class="col-md-12" required="required">
                                    <?php listaUserSelect("idUsuario[]", "voltarProfe", 3) ?>
                                </div>
                            </div>
                            <input type="hidden" name="idPapel" value="8" /> 
                            <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-success" id="autorizar">Modificar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    echo "<a href= 'index.php' class='footer'> Voltar </a>";
    include_once 'footer.php';
}
