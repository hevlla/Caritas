
//Habilita o botao de Cadastrar, apos todos os campos serem preenchidos
	
function checkInputs(inputs) {
    var filled = true;

    inputs.forEach(function(input) {
      if(input.value === "") {
          filled = false;
      }
    });
    
    return filled; 
  }
  
  var inputs = document.querySelectorAll("input");
  var button = document.querySelector("button");
  
  inputs.forEach(function(input) {
    input.addEventListener("keyup", function() {
  
      if(checkInputs(inputs)) {
        button.disabled = false;
      } else {
        button.disabled = true;
      }
    });
});

function mascara(telefone){   
    if(telefone.value.length == 0)
        telefone.value = '(' + telefone.value; //quando começamos a digitar, o script irá inserir um parênteses no começo do campo.
    if(telefone.value.length == 3)
        telefone.value = telefone.value + ') '; //quando o campo já tiver 3 caracteres (um parênteses e 2 números) o script irá inserir mais um parênteses, fechando assim o código de área.

    if(telefone.value.length == 9)
        telefone.value = telefone.value + '-'; //quando o campo já tiver 10 caracteres, o script irá inserir um tracinho, para melhor visualização do telefone.

}

function mascar(cep){ 
    if(cep.value.length == 5)
        cep.value = cep.value + '-'; //quando o campo já tiver 5 caracteres, o script irá inserir um tracinho, para melhor visualização do telefone.

}

function ApenasLetras(e, t) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        } else if (e) {
            var charCode = e.which;
        } else {
            return true;
        }
        if (
            (charCode == 32) ||
            (charCode > 64 && charCode < 91) || 
            (charCode > 96 && charCode < 123) ||
            (charCode > 191 && charCode <= 255) // letras com acentos
        ){
            return true;
        } else {
            return false;
        }
    } catch (err) {
        alert(err.Description);
    }
}
