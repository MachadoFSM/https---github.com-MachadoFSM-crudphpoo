<?php

require __DIR__.'/vendor/autoload.php';

//Usar a classe vaga
use \App\Entity\Vaga;


//validação do post
if(isset($_POST['titulo'],$_POST['descricao'],$_POST['ativo'])){
    $obVaga = new Vaga;
    $obVaga->titulo = $_POST['titulo'];
    $obVaga->descricao = $_POST['descricao'];
    $obVaga->ativo = $_POST['ativo'];
    $obVaga->cadastrar();
    //echo "<pre>"; print_r($obVaga); echo "</pre>"; exit;

    header('location: inicio.php?status=success');
    exit;
    
}
//debug para testar o form
//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/formulario.php';
include __DIR__.'/includes/footer.php';