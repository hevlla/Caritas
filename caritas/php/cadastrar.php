<?php 
    
    include("../conexao.php");

    $opcao = $_POST['opcao'];
    $nome = strtolower($_POST['nome']);
    $telefone= deixarNumero($_POST['telefone']);
    $cep = deixarNumero($_POST['cep']);
    $logradouro = strtolower($_POST['logradouro']);
    $numero = strtolower($_POST['numero']);
    $bairro = strtolower($_POST['bairro']);
    $cidade = strtolower($_POST['cidade']);
    $uf = strtolower($_POST['uf']);
    $email = strtolower($_POST['email']);
    $senha = md5($_POST['senha']);

    $checaEmail = mysqli_query($conexao, "SELECT * FROM doador WHERE email = '$email'");
    $num_rows = mysqli_num_rows($checaEmail);


    if(!$num_rows > 0){
        $sql = "INSERT INTO doador(opcao, nome, telefone, cep, logradouro, numero, bairro, cidade, uf, email, senha) 
                VALUES ('$opcao', '$nome', $telefone, $cep, '$logradouro', $numero, '$bairro', '$cidade', '$uf', '$email', '$senha')"; 
    } else {
        echo "<script>alert('Email já cadastrado'); window.location='../index.html';</script>";
    }
    
    //print_r($sql);

    if(mysqli_query($conexao, $sql)){
        echo '<script>window.alert("Cadastro Finalizado");window.location="../index.html";</script>';
    }
    else{
        echo "Erro".mysqli_error($conexao);
        //exit();   
    }

    function deixarNumero($string){
        return preg_replace("/[^0-9]/", "", $string);
    }

    mysqli_close($conexao);

?>