<?php
class ItensModel extends Models {


   public function inserir($data, $tabela){

      $dados = $data;
   

      $this->table = $tabela;

      $dad = $this->insert($dados);

      

   }

   public function gravarImagens(){




   }
   


   public function pegarDados(){


      $this->table = 'entrada';

      $d = $this->select(['Produto','group'=> true])['query'];
      if(!empty($d)){
      foreach ($d as $item) {
          $where = [
             0 => [
                'where' => 'Produto',
                'condition' => 'LIKE',
                'value' => $item['Produto']

             ]
          ];
          $prod[$item['Produto']] = $this->select('*', $where)['query'];
      }
    
      
      foreach($prod as $itemName => $data) {
          $sum[$itemName] = $this->createRelatorio($data);
      }
      
      return ['relatorio' => $sum]; 
      //retorno principal relatorio

   }

}
   public function createRelatorio($data) {
      $return = [
          'Quantidade' => 0,
          'TotalUnitario' => 0, 
          'ValorUnitario' => 0,
          'ValorTotal' => 0,
      ];
      $baixas = 0;
      //var_dump($data);
      foreach ($data as $valor) {
         if($valor['ValorUnitario'] != 0) $return['ValorUnitario'] = (float)$valor['ValorUnitario'];
         $return['Unidade_entrada'] = $valor['Unidade_entrada'];
         $return['Fornecedor'] = $valor['Fornecedor'];

         if($valor['movimento'] === 'entrada') {
            $return['Quantidade'] += $valor['Quantidade'];
            $return['TotalUnitario'] += $valor['TotalUnitario'];
         } else {
            if($return['Quantidade'] >= $valor['Quantidade']) $return['Quantidade'] -= $valor['Quantidade'];
            if($return['TotalUnitario'] >= $valor['TotalUnitario']) $return['TotalUnitario'] -= $valor['TotalUnitario'];
            $baixas += $valor['TotalUnitario'];
         }
      }
      
      $return['ValorTotal'] =  $return['ValorUnitario'] * ($return['TotalUnitario'] + $baixas);
    /*   var_dump($baixas); */
      return $return;

 }

         public function dadosFornecedor(){

            $this->table = 'fornecedor';

         $d = $this->select(['nome'])['query'];

         return $d;

         }

         public function dadosProduto(){


            $this->table = 'produto';
            $dadosProduto = $this->select(['*'], ['order' => ['DESC' => 'id']])['query'];
            return $dadosProduto;
         }


         public function dadosEntrada(){

                 
            $this->table = 'entrada';
            $dadosEntradas = $this->select(['*'], ['order' => ['DESC' => 'id_entrada']])['query'];
           /*  var_dump($dadosEntradas);
            exit; */
            return $dadosEntradas;
         }




         public function cropImagen($imagem){

            $arquivo = $imagem['foto']['tmp_name'];
            
            $max_width = 460;
            
            $max_height = 460;
            
            
            list($width_origins, $height_origins) = getimagesize($arquivo);
            
            $ratio = $width_origins / $height_origins;
            
            if($max_width / $max_height > $ratio){
            
                $max_width = $max_height * $ratio;
            
            }else{
                $max_height = $max_width / $ratio;
            }
            
            
            $imagem_final = imagecreatetruecolor($max_width, $max_height);
            
            if($imagem['foto']['type']=== 'image/jpeg'){
               
               $imagem_original = imagecreatefromjpeg($arquivo);
            }else{
               $imagem_original = imagecreatefrompng($arquivo);
            }
            
            imagecopyresampled($imagem_final, $imagem_original, 0,0,0,0, $max_width, $max_height, $width_origins, $height_origins);
            $nomeImagen = md5($imagem['foto']['name']);
            
            $nomeOriginal = $imagem['foto']['name'];
            
            if($imagem['foto']['type'] == 'image/jpeg'){

               imagejpeg($imagem_final, "./assets/imagens/".$nomeImagen.'-'.$nomeOriginal);

            }else{
               imagepng($imagem_final, "./assets/imagens/".$nomeImagen.'-'.$nomeOriginal);
            }

            $imagemNomeFinal = $nomeImagen.'-'.$nomeOriginal;
            

            imagedestroy($imagem_final);
            imagedestroy($imagem_original);
            return $imagemNomeFinal;
            
            }







}// fim da classe
