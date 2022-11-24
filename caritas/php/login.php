<?php 
    
    include("../conexao.php");
    
    if(empty($_POST['email']) || empty(($_POST['senha']))) {
        header('Location: ../index.html');
        exit();
    }

    $email = mysqli_real_escape_string($conexao, strtolower($_POST['email']));
    $senha = mysqli_real_escape_string($conexao, md5($_POST['senha']));
    #$opcao = mysqli_real_escape_string($conexao, $_POST['opcao']);
    
    $checaEmail = mysqli_query($conexao, "SELECT email, senha, nome, opcao FROM doador WHERE email = '$email' AND senha = '$senha'");
    $num_rows = mysqli_num_rows($checaEmail);

    if($num_rows == 1){ 
        session_start();

        // Salva os dados encontrados na variável $resultado
        $resultado = mysqli_fetch_assoc($checaEmail);

        // Salva os dados encontrados na sessão
        $_SESSION['email'] = $resultado['email'];
        $_SESSION['senha'] = $resultado['senha'];
        $_SESSION['nome'] = $resultado['nome'];
        $_SESSION['opcao'] = $resultado['opcao'];
        
        if($resultado['opcao'] == 'doador'){
            $_SESSION['email'] = $email;
            header('Location: ../html/mapa.php');
            exit();
        } elseif($resultado['opcao'] == 'instituicao'){
            $_SESSION['email'] = $email;
            header('Location: ../html/menuInstituicao.html');
            exit();
        }
    } else {
        echo "<script>alert('Usuario ou senha incorreto');window.location='../index.html';</script>";
        exit();
    }
?>