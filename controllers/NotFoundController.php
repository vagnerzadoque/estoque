<?php
 defined('BASEPATH') OR exit('Nenhum acesso direto ao script é permitido');
 /**
  *
  */
class NotFoundController extends Controllers { 
   public function index($page = '') {
      $this->loadView('404', 'page:'.$page);
   }//FIM -> index()
}
