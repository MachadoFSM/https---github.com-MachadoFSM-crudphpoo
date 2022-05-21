<?php

namespace App\Entity;

use \App\Db\Database;

class Vaga{

    /*
    Identificador ID
    @var integer
    */
    public $id;

    /*
    Título 
    @var string
    */
    public $titulo;

    /*
    Descrição
    @var string
    */
    public $descricao;

    /*
    Vaga ativa ou não
    @var string
    */
    public $ativo;

    /*
    Data da vaga
    @var string
    */
    public $data;

    /*
    Método que realiza o cadastro de uma nova vaga na base
    @return boolean
    */
    public function cadastrar(){
    //Definir data
    $this->data = date('Y-m-d H:i:s');

    //Inserir a vaga na base e colocar um ID
    $obDatabase = new Database('vagas');
    //echo "<pre>"; print_r($obDatabase); echo "</pre>"; exit;
    $this->id = $obDatabase->insert([
                            'titulo'     => $this->titulo,
                            'descricao'  => $this->descricao,
                            'ativo'      => $this->ativo,
                            'data'       => $this->data
                        ]);
    
    //echo "<pre>"; print_r($this); echo "</pre>"; exit;
    return true;
    //Retornar sucesso
    }

}