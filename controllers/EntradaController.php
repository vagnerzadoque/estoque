<?php
class EntradaController extends ControllersPrivate {
   function __construct($args) {
      parent::__construct($args);
      $this->setRequired(['manager']);
   }
   
   public function index(){

      $itens = new ItensModel();
      $data['user'] = $this->user;
     
      $data['produtos'] = $itens->dadosProduto();
      $data['fornecedor'] = $itens->dadosProduto();
      $data['entradas'] = $itens->dadosEntrada();
      
      $this->loadTemplateView('template','entrada', $data);
   }


   public function entradaProdutos(){



        if(!empty($_POST['Produto'])){

            $cad = new ItensModel();
            $data['user'] = $this->user;
            $tabela = 'entrada';
            
            $dados = $_POST;
            $dados['TotalUnitario'] = $_POST['Quantidade'] * $_POST['QuantX'];
            $dados['movimento'] ="entrada";
            $d = $cad->inserir($dados, $tabela);
           
            header("Location:". uri('entrada'));
        }else{
            header("Location:". uri('entrada'));
        }


   }


}

