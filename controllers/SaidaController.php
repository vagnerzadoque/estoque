<?php
class SaidaController extends ControllersPrivate {
   function __construct($args) {
      parent::__construct($args);
      $this->setRequired(['manager']);
   }
   
   public function index(){

      $itens = new ItensModel();
      $data['user'] = $this->user;
     
      $data['produtos'] = $itens->dadosProduto();
      $data['fornecedor'] = $itens->dadosProduto();
      
      $this->loadTemplateView('template','saida', $data);
   }


   public function saidaProdutos(){


     /*  var_dump($_POST);
      exit; */
        if(!empty($_POST['Produto'])){

            $cad = new ItensModel();
            $data['user'] = $this->user;
            $tabela = 'entrada';
            
            $dados = $_POST;
            $dados['TotalUnitario'] = $retVal = ($_POST['Quantidade'] != 0) ? $_POST['Quantidade'] * $_POST['QuantX'] : $_POST['QuantX'] * 1 ;
            $dados['movimento'] ="saida";
            $d = $cad->inserir($dados, $tabela);
           
            header("Location:". uri().'saida');
        }else{
            header("Location:". uri().'saida');
        }


   }


}

