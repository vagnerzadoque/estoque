<?php
class CadastrarController extends ControllersPrivate {
   function __construct($args) {
      parent::__construct($args);
      $this->setRequired(['manager']);
   }
   
   public function index(){

      $itens = new ItensModel();
      $data['user'] = $this->user;
      $data['fornecedor'] = $itens->dadosFornecedor();
      $data['produtos'] = $itens->dadosProduto();
      
      $this->loadTemplateView('template','cadastrar', $data);
   }

   public function cadastrar(){
     
      $dados = $_POST;
     /*  var_dump($dados, $_FILES);
      exit; */
      if(!empty($_POST['nome']) AND !empty($_FILES['foto']['name']) ){
      $cad = new ItensModel();
      $data['user'] = $this->user;
      $tabela = 'produto';
      $fotoNome = $cad->cropImagen($_FILES);
      $dados['foto'] = $fotoNome;
      
      $d = $cad->inserir($dados, $tabela);
     
      header("Location:". uri().'cadastrar');
   }
   header("Location:". uri().'cadastrar');
   }


}

