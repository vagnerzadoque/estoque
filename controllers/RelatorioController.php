<?php
class RelatorioController extends ControllersPrivate {
   function __construct($args) {
      parent::__construct($args);
      $this->setRequired(['manager']);
   }
   
   public function index(){
      
      $itens = new ItensModel();

     $dados = $itens->pegarDados();

      $this->loadView('relatorio', $dados);
      

      /* $newUser = new User('create', ['name' => 'Vagner', 'familyName' => 'da Silva Barbosa', 'email' => 'vagner@email.com', 'password' => '123', 'profile' => 'manager']);
      var_dump($newUser->getErrors(), $newUser); */
   }


   
   
}