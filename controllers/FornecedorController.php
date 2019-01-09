<?php
class FornecedorController extends ControllersPrivate {
   function __construct($args) {
      parent::__construct($args);
      $this->setRequired(['manager']);
   }
   
   public function index(){

      $itens = new ItensModel();
      $data['user'] = $this->user;
      
      $this->loadTemplateView('template','fornecedor', $data);
   }

   
   public function cadastrar(){

    $dados = $_POST;
   
    $cad = new ItensModel();
    $data['user'] = $this->user;
    $tabela = 'fornecedor';
    $d = $cad->inserir($dados, $tabela);
    $this->loadTemplateView('template','fornecedor', $data);
    
 }

}

