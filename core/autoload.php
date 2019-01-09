<?php
defined('BASEPATH') OR exit('Nenhum acesso direto ao script é permitido');
/**
 * Função para carregar automaticamente todas as classes padrão
 * O nome do arquivo deverá ser NomeDaClasse.class.php
 * Por exemplo: para a classe GerenciadorMVC, o arquivo vai chamar GerenciadorMVC.class.php
 * @since 0.1
 */
function esmvcAutoload ($nameClass) {
   switch ($nameClass) {
      case 'ESMVC':
         $file = BASEPATH.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'esmvc.php';
         break;

      case 'Controllers':
         $file = BASEPATH.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'controllers.php';
         break;

      case 'ControllersPrivate':
         $file = BASEPATH.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'private.php';
         break;

      case 'Models':
         $file = BASEPATH.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'crud.php';
         break;

      case 'User':
         $file = BASEPATH.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'user.php';
         break;
      
      case 'InstallTableUser':
         $file = BASEPATH.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'install.php';
         break;

      case strpos($nameClass, CONTROLLERSUFFIX) !== FALSE:
         $file = CONTROLLERSPATH.DIRECTORY_SEPARATOR.$nameClass.'.php';
         $nameClass = str_replace(CONTROLLERSUFFIX, '', $nameClass);
         break;

      case strpos($nameClass, MODELSUFFIX) !== FALSE:
         $file = MODELSPATH.DIRECTORY_SEPARATOR.$nameClass.'.php';
         break;

      default:
         echo 'Não foi possível localizar a classe: '.$nameClass;
         exit(5);
         break;
   }
   
   // Verifica se existe na pasta padrão a classe recebida na função
   if (file_exists($file)) {

      // Inclui o arquivo da classe caso exista
      require_once $file;

      return;
   } else {
      // Inclui o arquivo de 404 caso não exista
      require_once CONTROLLERSPATH.DIRECTORY_SEPARATOR.'NotFoundController.php';
      $not_found = new NotFoundController([]);
      $not_found->index($nameClass);
   }
   exit(5);
}

//Registro da função que carrega automaticamente as classes.
spl_autoload_register("esmvcAutoload");
