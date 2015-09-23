<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="../../favicon.ico">

        <title>TeCoordena</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/estilo.css" rel="stylesheet">
    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-4 col-md-offset-4">
                    
                        <img src="images/logo7.png" class="img-responsive" alt="TeCoordena" > 
                        <h2 class="form-signin-heading">Faça seu login</h2>
                        <form class="form-signin" role="form" action="login.php" method="post">
                        <!--<label for="username" class="sr-only">Username</label>--> 
                        <input type="text"  name="username" id="inputUser" class="form-control" placeholder="Username" required="required" autofocus="autofocus">
                        <!--<label for="inputPassword" class="sr-only">Password</label>-->
                        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Senha" required="required" >
                        <button id="button-login" class="btn  btn-primary btn-block">Entrar</button>
                    </form>

                    <h2 >Ou</h2>
                    <!--<a href="novo_projeto.html" id="criar" class="btn btn-success  active" role="button"> Criar Projeto </a>-->
                    <button class="btn btn-success  btn-block " id="button-login" data-toggle="collapse" data-target="#cadastro"> Cadastre-se </button>

                </div>
            </div><!-- /row -->
            <div class="row">
                <div class="col-xs-12 col-md-4 col-md-offset-4">
                    <div id="cadastro" class="collapse">
                        <!-- //////////////////////////////////////////////////////////////////////////-->
                        <h3> Cadastro </h3>
                        <hr>
                        <form role="form" action="CadastroUsuario.php" method="post">
                            <div class="form-group">
                                <label for="inputNome" class="col-md-2 control-label">Nome</label>
                                <div class="col-md-12">
                                    <input class="form-control" type="text" name="nome" size="55" required="required" autofocus="autofocus" id="nome">
                                </div>
                            </div><br />
                            <div class="form-group">
                                <label for="inputUser" class="col-md-2 control-label">Username</label>
                                <div class="col-md-12">
                                    <input class="form-control" type="text" name="username" size="55" required="required" id="username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-md-2 control-label">Senha</label>
                                <div class="col-md-12">
                                    <input class="form-control"  type="password" name="password" size="55" required="required" id="senha"><!-- onKeyUp="validarSenha('senha', 'validarsenha', 'resultadoCadastro');"-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirmPwd" class="col-md-6 control-label">Confirmar Senha</label>
                                <div class="col-md-12">
                                    <input class="form-control" onKeyUp="validarSenha('senha', 'validarsenha', 'resultadoCadastro');" type="password" name="confmepassword" size="55" required="required" id="validarsenha">
                                </div>
                            </div>
                            <div class="form-group">
                               
                                <div class="col-md-12">
                                    <p id="resultadoCadastro" style="font-weight: bold;">&nbsp;</p>
                                </div>
                            </div>
                            <!--<div class="form-group">
                                    <label for="inputFoto" class="col-md-2 control-label">Foto</label>
                                    <div class="col-md-12">
                                    <input class="form-control" type="file" name="foto" size="55"  >	
                                    </div>
                            </div> -->
                            <div class="form-group">
                                <label for="inputPapel" class="col-md-2 control-label">Papel</label>
                                <div class="col-md-12" required="required">
                                    <label class="radio-inline" class="col-md-2 control-label" >
                                        <input type="radio" name="papel" value="7"> Aluno
                                    </label>
                                    <label class="radio-inline" class="col-md-2 control-label" >
                                        <input type="radio" name="papel" value="8"> Professor
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <p>
                                <div class="col-md-offset-8 col-md-4"> 
                                    <button type="submit" class="btn btn-success" id="salvar">Salvar</button>
                                </div>
                                <p>
                            </div>
                        </form>        
                    </div><!--/.cadastro-->
                    <!--//////////////////////////////////////////////////////////////////////////-->
                </div><!-- /.col-xs-12 col-md-4 col-md-offset-4  -->
            
        </div> <!-- /row -->
        </div><!-- /container -->

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

        <script src="js/jquery-2.1.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script> 
        <script src="js/meuscript.js"></script>
        <!--<script src="js/jquery-2.1.4.min.js"></script>-->
    </body>
</html>