<?php 
    
    include("../conexao.php");

    $tempo = filter_input(INPUT_POST, 'tipo_doacaoT');
    $roupa = filter_input(INPUT_POST, 'tipo_doacaoR');
    $produto_higiene = filter_input(INPUT_POST, 'tipo_doacaoPH');
    $alimento = filter_input(INPUT_POST, 'tipo_doacaoA');
    $enxoval = filter_input(INPUT_POST, 'tipo_doacaoE');
    $dinheiro = filter_input(INPUT_POST, 'tipo_doacaoD');

    session_start();

    $retorna_email = $_SESSION['email']; 

    $checaEmail = mysqli_query($conexao, "SELECT doador_id FROM doador WHERE email = '$retorna_email'");
    $num_rows = mysqli_fetch_array ($checaEmail);
    $idInstituicao = $num_rows['doador_id'];

    $checaEmail1 = mysqli_query($conexao, "SELECT item_instituicao FROM itens_instituicao WHERE item_instituicao = $idInstituicao");
    $num_rows1 = mysqli_fetch_array ($checaEmail1);
    $idInstituicao1 = $num_rows1['item_instituicao'];



    if($idInstituicao1 == 0){    
        $sql = "INSERT INTO itens_instituicao(tempo, roupa, produto_higiene, alimento, enxoval, dinheiro, item_instituicao) 
                VALUES ($tempo, $roupa, $produto_higiene, $alimento, $enxoval, $dinheiro, $idInstituicao)"; 
    } else {
        $sql = "UPDATE itens_instituicao SET tempo = $tempo, roupa = $roupa, produto_higiene= $produto_higiene, alimento = $alimento, enxoval = $enxoval, dinheiro = $dinheiro, item_instituicao = $idInstituicao WHERE item_instituicao = $idInstituicao";  
    }

    if(mysqli_query($conexao, $sql)){
        echo '<script>window.alert("Obrigada, informações enviadas."); window.location="../index.html";</script>';
    }
    else{ 
        echo "Erro".mysqli_error($conexao);
        //exit();   
    }


    mysqli_close($conexao);

?>
