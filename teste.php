<?php 
include('funcoes.php');
try{
    $resposta = retornaImpressoras(12341);
}
catch(Exception  $e){
    echo $e;
}

var_dump($resposta);


?>