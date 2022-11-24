<?php
    include("../conexao.php");

   
    $tipo_doacao = $_POST['tipo_doacao'];
    $sql = array();
  
    // Procura titulos no banco relacionados ao valor
    if(!empty($tipo_doacao)){
        $sql = mysqli_query($conexao, "SELECT item_instituicao FROM itens_instituicao ORDER BY $tipo_doacao DESC");
    }

    //Necesidade de casa instituicao
    $instituicao = array();
    $item = array();
    $necessidade = mysqli_query($conexao, "SELECT $tipo_doacao, item_instituicao FROM itens_instituicao ORDER BY $tipo_doacao DESC");
    if (mysqli_num_rows($necessidade) > 0){
        while($row = mysqli_fetch_assoc($necessidade)){
            $instituicao[]  = $row["item_instituicao"];
            $item[] = $row[$tipo_doacao];
        } 
    }

    

    $endereco = array();
    $nome_intituicao = array();

    // Exibe os enderecos encontrados
    $i = 0;
    while($id_instituicao = mysqli_fetch_assoc($sql)){
        //print_r($id_instituicao);echo "<br/><br/>";
        $sql2 = mysqli_query($conexao, "SELECT nome, logradouro, numero, bairro, cidade, uf FROM doador where  $instituicao[$i]= doador_id");
        
        while($row2 = mysqli_fetch_assoc($sql2)){
            $adress = $row2["logradouro"] . " ". $row2["numero"] . " ". $row2["bairro"] . " " . $row2["cidade"] . " - " . $row2["uf"];
            $endereco[] = $adress;
            $nome_intituicao[] = $row2["nome"];
        }
        $i++;
    }

    $latitude = array();
    $longitude = array();

    echo "tipo de doacao escolhida: "; print_r($tipo_doacao);

    echo "<br/><br/>nome das instituicoes <br/>";
    print_r($nome_intituicao);
    echo "<br/> <br/>enderecos<br/>";
    print_r($endereco);


    // Consulta o endereco e pega a latitude e longitude para colocar no marcador (mapa)
    $u = 0;
    foreach ($endereco as &$valor){
        $valor = urlencode($valor);
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$valor.'&key=AIzaSyABhih0Q4FRIRmCQTWQq0JJ_a_DiHs9YCo');
        $output= json_decode($geocode);
        $latitude[] = $output->results[0]->geometry->location->lat;
        $longitude[] = $output->results[0]->geometry->location->lng;
    }
    $locations[] = array('nome' => $nome_intituicao, 'lat' => $latitude, 'log' => $longitude);

    echo "<br/><br/>latitude <br/>";
    print_r($latitude);
    echo "<br/> <br/>longitude<br/>";
    print_r($longitude);

    $nome = json_encode($nome_intituicao);
    $lat = json_encode($latitude);
    $lon = json_encode($longitude);

    $loc = json_encode($locations);
?> 

 


    