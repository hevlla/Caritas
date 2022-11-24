<?php ?>
<!DOCTYPE html>
<html lang="pt-br">
    
    <head>
        <meta charset=utf-8>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CaritasNet- Pesquisar</title>
        <!-- Load Roboto font -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <!-- Load css styles -->
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="../css/bootstrap-responsive.css" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/pluton.css" />
        <link rel="stylesheet" type="text/css" href="../css/localizarInstituicoes.css"/>

        <link rel="stylesheet" type="text/css" href="../css/jquery.cslider.css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery.bxslider.css" />
        <link rel="stylesheet" type="text/css" href="../css/animate.css" />

        <!-- Icones -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/ico/apple-touch-icon.png">
        <link rel="apple-touch-icon-precomposed" href="../images/ico/android-chrome-192x192.png">
        <link rel="apple-touch-icon-precomposed" href="../images/ico/android-chrome-384x384.png">
        <link rel="shortcut icon" href="../images/ico/CaritasFavicon.ico"> 
      
    </head>
    
    <body>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <a href="../index.html" class="brand">
                        <img src="../images/logoCaritas.png" alt="Logo" />
                        <!-- Logo do Caritas -->
                    </a>
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <i class="icon-menu"></i>
                    </button>
                    <!-- Main navigation -->
                    <div class="nav-collapse collapse pull-right">
                        <ul class="nav" id="top-navigation">
                            <li class="nav-item dropdown"><a href="../php/logout.php">Sair</a>                        
                            </li>
                        </ul>
                    </div>
                    <!-- End main navigation -->
                </div>
            </div>
        </div>
        <!-- Inicio secao Doar -->
        
        <div class="section secondary-section " id="instituicoes">
            <div class="triangle"></div>
            <div class="container">
                <div class=" title">
                    <h1>Localizar Instituições</h1>
                    <!-- <p>Duis mollis placerat quam, eget laoreet tellus tempor eu. Quisque dapibus in purus in dignissim.</p> --> 
                </div>
                <form action="" method="POST">
                    <ul class="nav nav-pills">
                        <label for="tipo_doacao" style="color: rgb(63, 63, 63); margin-left: 0px; font-size: large;"><span>Selecione o que deseja doar:</span><br><br>
                            <select name="tipo_doacao" id="tipo_doacao" class="linked-drop-down" autocomplete="off" style="margin-left: 10px;background-color:#f5cf38; color: rgb(39, 38, 38);">
                            <option hidden disabled selected value >Selecione</option>
                            <option value="tempo">Tempo</option>
                            <option value="roupa">Roupas</option>
                            <option value="produto_higiene"> Produto de Higiene</option>
                            <option value="alimento">Alimento</option>
                            <option value="enxoval">Enxoval</option>
                            <option value="dinheiro">Dinheiro</option>		 
                            </select></label>    
                    </ul>
                    
                    <p style = "margin-left: 43%; margin-right: 45%;margin-top: -5%; margin-bottom: 3.8%;">
                        <button style="background-color: #0A5517; color: white; padding: 12px 20px; border: none; border-radius: 5px;"
                        type="submit" >Mostrar</button>
                    </p> 
                </form> 

                <?php include("../conexao.php");
                    $tipo_doacao = " ";
                    $sql = array();

                    if(isset ($_POST['tipo_doacao'])){
                        $tipo_doacao= $_POST['tipo_doacao'];
                        $sql = mysqli_query($conexao, "SELECT item_instituicao FROM itens_instituicao ORDER BY $tipo_doacao DESC");
                    }else{
                        $tipo_doacao = 'tempo';
                        $sql = mysqli_query($conexao, "SELECT item_instituicao FROM itens_instituicao ORDER BY $tipo_doacao DESC");
                    }
                
                    //Necesidade de casa instituicao
                    $instituicao = array();
                    $item = array();
                    $necessidade = mysqli_query($conexao, "SELECT $tipo_doacao, item_instituicao FROM itens_instituicao ORDER BY $tipo_doacao DESC");
                    if (mysqli_num_rows($necessidade) > 0){
                        while($row = mysqli_fetch_assoc($necessidade)){
                            if($row[$tipo_doacao] > 0){
                                $instituicao[]  = $row["item_instituicao"];
                                $item[] = $row[$tipo_doacao];
                            }
                        } 
                    }

                   
                    //Array criado para armazenar os indices dos número repetidos
                    $indice = array();
                    $posicao_instituicao = array();
                    for ($i=0; $i < count($item); $i++){
                        if ($i > 0 and $i< count($item)-1){ 
                            if ($item[$i] == $item[$i-1] or $item[$i] == $item[$i+1]){
                                $indice[$i]= $instituicao[$i];
                            }
                        }                      
                    }
                    
                    

                    $cepEu ="";
                    $sql6 = mysqli_query($conexao, "SELECT cep as cep FROM doador d where email = 'hevlla@gmail.com'");
                    while($row6 = mysqli_fetch_assoc($sql6)){
                        $cepEu= $row6["cep"];
                    }
                    
                    $cepa=array();
                    foreach ($indice as $x => $value){
                        $sql5 = mysqli_query($conexao, "SELECT cep FROM doador  where doador_id = $value");
                        while($row5 = mysqli_fetch_assoc($sql5)){
                            $cep= $row5["cep"];
                            $cepa[$x] = $cep;
                        }
                    }

                    $distancias=array();
                    foreach ($cepa as $y => $valor){
                        $distancia=file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$valor.'&destinations='.$cepEu.'&mode=driving&language=pt-BR&sensor=false&key=AIzaSyABhih0Q4FRIRmCQTWQq0JJ_a_DiHs9YCo");
                        $armazena = json_decode($distancia);
                        $elements = $armazena->rows[0]->elements;
                        $distancias[$y] = $elements[0]->duration->text;
                    }

                    

                    $min = min($distancias);
                    $max = max($distancias);

                    $posicaomax = array_search($max, $distancias);
                    $posicaomin= array_search($min, $distancias);


                    $indice_novo = array();
                    $posy=[];
                    $posmin = 0; $meio =0; $posmax=0;
                    $posicoes=array();
                    foreach ($distancias as $y => $valor){
                        $posicoes[] =$y;
                        if($valor == $min){
                            $posmin = $indice[$y];
                        }
                        if($valor == $max){
                            $posmax = $indice[$y];
                        }
                        if($valor != $min and $valor!=$max){
                            $meio = $indice[$y];
                        }
                    }

                    $i=0;
                    foreach($distancias as $y=>$value){
                        if ($posicoes[$i]== $y and $i==0){
                            $indice_novo[$y] = $posmin;
                        }
                        if ($i== count($distancias)-1){
                            $indice_novo[$y] = $posmax;
                        }
                        if (count($distancias) > 2 and $i==1) 
                            $indice_novo[$y]= $meio;
                        $i++;
                    }

                    echo $tipo_doacao;
                    
                    echo 'Itens<br>';
                    print_r($item);
                    echo '<br>';
                    echo 'Instituicoes<br>';
                    print_r($instituicao);
                    echo '<br>Itens com o mesmo valor';
                    echo '<br>';
                    print_r($indice);
                    echo '<br>Distancias<br>';
                    print_r($distancias);
                    echo '<br>Nova ordem Instituicoes';
                    echo '<br>';
                    
                    foreach($indice_novo as $y=>$value){
                        array_search($y, $instituicao);
                        $instituicao[$y]=$value;}

                    print_r($instituicao);

                    $endereco = array();
                    $nome_intituicao = array();              
                    // Exibe os enderecos encontrados
                    for ($i=0; $i< count($instituicao); $i++){
                            $sql2 = mysqli_query($conexao, "SELECT nome, logradouro, numero, bairro, cidade, uf FROM doador where  $instituicao[$i]= doador_id");
                        
                            while($row2 = mysqli_fetch_assoc($sql2)){
                                $adress = $row2["logradouro"] . " ". $row2["numero"] . " ". $row2["bairro"] . " " . $row2["cidade"] . " - " . $row2["uf"];
                                $endereco[] = $adress;
                                $nome_intituicao[] = $row2["nome"];
                            }
                    }
                
                    $latitude = array();
                    $longitude = array();
                
                    //echo "tipo de doacao escolhida: "; print_r($tipo_doacao);
            
                
                    // Consulta o endereco e pega a latitude e longitude para colocar no marcador (mapa)
                    $u = 0;
                    foreach ($endereco as &$valor){
                        $valor = urlencode($valor);
                        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$valor.'&key=AIzaSyABhih0Q4FRIRmCQTWQq0JJ_a_DiHs9YCo');
                        $output= json_decode($geocode);
                        $latitude[] = $output->results[0]->geometry->location->lat;
                        $longitude[] = $output->results[0]->geometry->location->lng;
                    }
                
                ?>
                
                <script> 
                    var nome = <?php echo json_encode($nome_intituicao); ?>;
                    var lat = <?php echo json_encode($latitude); ?>;
                    var lon = <?php echo json_encode($longitude); ?>;
                </script>

                <script type="text/javascript">
                    
                    // Initialize and add the map
                    function initMap() {
                        const map = new google.maps.Map(document.getElementById("map"), {
                            zoom: 14.08,
                            center: { lat: -7.220877, lng: -35.8836618},
                        });
                        setMarkers(map);
                    }
                    
                    // Data for the markers consisting of a name, a LatLng and a zIndex for the
                    // order in which these markers should display on top of each other.

                    const beaches = [
                        ["",,, 1],
                        ["",,, 2],
                        ["",,, 3],
                        ["",,, 4], 
                        ["", ,  , 5],
                        ["",  , , 6],
                        ["",,, 7],
                        ["",, , 8],
                        ["",, , 9]
                        
                    ]

                   
                    function setMarkers(map) {

                        const image = {
                            url:"https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
                            // This marker is 20 pixels wide by 32 pixels high.
                            size: new google.maps.Size(20, 22),
                            // The origin for this image is (0, 0).
                            origin: new google.maps.Point(0, 0),
                            // The anchor for this image is the base of the flagpole at (0, 32).
                            anchor: new google.maps.Point(0, 32),
                        };
                    
                        const shape = {
                            coords: [1, 1, 1, 20, 18, 20, 18, 1],
                            type: "poly",
                        };

                        for (let i = 0; i < beaches.length; i++) {
                            const beach = beaches[i];

                            new google.maps.Marker({
                            position: { lat: lat[i], lng: lon[i] },
                            map,
                            icon: image,
                            label: {text: "" + beaches[i][3], color: '#013a0b'},
                            shape: shape,
                            title: nome[i],
                            zIndex: beach[3],
                            
                            });
                        
                        }
                    }
                </script>
                 
                <div id="map"></div> 

                <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
                <script async
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCz9B7wcambBl0nq0CmIQLrTYD5Orko_I0&callback=initMap">
                </script>

                <!-- ScrollUp button start -->
                <div class="scrollup">
                    <a href="#">
                        <i class="icon-up-open"></i>
                    </a>
                </div>
            </div>
        </div>
            <!-- ScrollUp button end -->
        <!-- Include javascript -->
        <script src="../js/jquery.js"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <script type="text/javascript" src="../js/jquery.mixitup.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/modernizr.custom.js"></script>
        <script type="text/javascript" src="../js/jquery.bxslider.js"></script>
        <script type="text/javascript" src="../js/jquery.cslider.js"></script>
        <script type="text/javascript" src="../js/jquery.placeholder.js"></script>
        <script type="text/javascript" src="../js/jquery.inview.js"></script>
        <script type="text/javascript" src="../js/app.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABhih0Q4FRIRmCQTWQq0JJ_a_DiHs9YCo&callback=initMap"></script>
        
    </body>
</html>
<?php ?>