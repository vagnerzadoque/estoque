<?php
defined('BASEPATH') OR exit('Nenhum acesso direto ao script é permitido');

class InstallTableUser extends Models {
   function __construct() {
      parent::__construct('users');
   }
   public function index() {
      if($this->checkTable()) navTo();
      require_once COREPATH.DIRECTORY_SEPARATOR.'installView.php';
   }

   public function api() {
      if(!isset($_GET['i']) && $_GET['i'] !== '07c131ad72c505a33b2db9da7d2f052e') exit();

      $file = file_get_contents(FILEUSERTABLE);
      $file = str_replace ('_database-here_', DB      , $file);
      $file = str_replace ('_prefix-here_'  , DBPREFIX, $file);
      
      $this->query($file);

      echo json_encode(['status' => $this->checkTable()]);
   }
}