function validarSenha(senha1, senha2, campo) {
    var resultado = document.getElementById(campo);

    senhaPrimaria = document.getElementById(senha1).value;
    senhaSecundaria = document.getElementById(senha2).value;

    if (senhaPrimaria == senhaSecundaria && senhaPrimaria.length > 3 && senhaSecundaria.length > 3) {
        resultado.innerHTML = "Senhas iguais";
    } else {
        resultado.innerHTML = "Senhas Incorretas";
    }
}

function validaData(dini, dfim) {
            //var erros = "";
            var dataInicial = (document.getElementById(dini).value);
            var dataFinal = (document.getElementById(dfim).value);
            //var dataInicial = ($("#dini").val()).split("/");
            //var dataFinal = ($("#dfim").val()).split("/");
            var dataInicialInformada = new Date(dataInicial[2], dataInicial[1] - 1, dataInicial[0]);
            var dataFinalInformada = new Date(dataFinal[2], dataFinal[1] - 1, dataFinal[0]);

            if (dataFinalInformada < dataInicialInformada) {
                //erros +="Data Final menor qua a Data Inicial. <br />" ;
                alert("Data Final menor qua a Data Inicial");
            }
            
             if (dataFinalInformada === dataInicialInformada) {
                //erros += "Data Final igual a Data Inicial. <br />";
                 alert("Data Final igual a Data Inicial.");
            }
            //return erros;
        }