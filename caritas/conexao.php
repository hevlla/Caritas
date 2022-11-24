<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$bdname = "caritas";

$conexao = mysqli_connect($servidor, $usuario, $senha, $bdname);
if(!$conexao){
    die("Error: ".mysqli_connect_error());
}

?>