<?php
/**
 * 
 * Estrutuda de desenvolvimento MVC
 * @version 1.0.0
 * 
 */

/** Define o caminho do ambiente LOCAL(desenvolvimento) ou WEB(producao) */

/** Versão */
define('VERSION', '1.0.0');

/*
 *---------------------------------------------------------------
 *  Diretório raiz
 *---------------------------------------------------------------
 */
define('BASEPATH', dirname(__FILE__));

/*
 *---------------------------------------------------------------
 *  Diretório onde ficaram os models
 *---------------------------------------------------------------
 */
define('MODELSPATH', BASEPATH.DIRECTORY_SEPARATOR.'models');

/*
 *---------------------------------------------------------------
 *  Diretório onde ficaram as views
 *---------------------------------------------------------------
 */
define('VIEWSPATH', BASEPATH.DIRECTORY_SEPARATOR.'views');

/*
 *---------------------------------------------------------------
 *  Diretório onde ficaram os controllers
 *---------------------------------------------------------------
 */
define('CONTROLLERSPATH', BASEPATH.DIRECTORY_SEPARATOR.'controllers');

/*
 *---------------------------------------------------------------
 *  Diretório onde ficaram os assets
 *---------------------------------------------------------------
 */
define('ASSETSPATH', BASEPATH.DIRECTORY_SEPARATOR.'assets');

/*
 *---------------------------------------------------------------
 *  Diretório onde fica o núcleo da aplicação
 *---------------------------------------------------------------
 */
define('COREPATH', BASEPATH.DIRECTORY_SEPARATOR.'core');

/*
 *---------------------------------------------------------------
 *  Diretório onde ficam os arquivos de fornecedores
 *---------------------------------------------------------------
 */
define('VENDORPATH', BASEPATH.DIRECTORY_SEPARATOR.'vendor');

/*
 *---------------------------------------------------------------
 *  Endereço do arquivo que contém a tabela de usuários
 *---------------------------------------------------------------
 */
define('FILEUSERTABLE', COREPATH.DIRECTORY_SEPARATOR.'tableUser.php');

/*
 * ---------------------------------------------------------------------
 *  Agora que definimos os caminhos das pastas principais iremos
 *  verificar se as pastas existem
 * ---------------------------------------------------------------------
 */
$errors = [];

if (!is_dir(MODELSPATH)) $errors[] = 'ficam os models';
if (!is_dir(VIEWSPATH)) $errors[] = 'ficam as views';
if (!is_dir(CONTROLLERSPATH)) $errors[] = 'ficam os controllers';
if (!is_dir(ASSETSPATH)) $errors[] = 'ficam os assets';
if (!is_dir(COREPATH)) $errors[] = 'fica o núcleo da aplicação';
if (!is_dir(VENDORPATH)) $errors[] = 'ficam os arquivos de fornecedores';

// Caso haja algum problema paramos com uma das pastas, paramos a execução do srcipt
if (!empty($errors)) {
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	
   foreach ($errors as $message) {
		echo 'A pasta onde '.$message.' não parece estar configurado corretamente. <br>';
	}

	echo '<br>Abra o arquivo: '.pathinfo(__FILE__, PATHINFO_BASENAME).' e corrija o(s) erro(s)!';
   exit(3);
}

/*
 * ------------------------------------------------------
 *  Constante dos sufixos
 * ------------------------------------------------------
 */
define('CONTROLLERSUFFIX', 'Controller');
define('MODELSUFFIX', 'Model');

require_once COREPATH.DIRECTORY_SEPARATOR.'globalFunctions.php';

require_once BASEPATH.DIRECTORY_SEPARATOR.'config.php';

/*
 * ------------------------------------------------------
 *  Carrega o autoload
 * ------------------------------------------------------
 */
require_once BASEPATH.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'autoload.php';

//Carrega o mvc
$load = new ESMVC();
